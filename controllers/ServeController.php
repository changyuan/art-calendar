<?php

namespace app\controllers;

use app\enum\CodeEnum;
use app\logics\ChatTunnelHandler;
use app\models\Member;
use app\services\UtilTrait;
use app\services\WebHelper;
use QCloud_WeApp_SDK\Auth\LoginService;
use QCloud_WeApp_SDK\Tunnel\TunnelService;
use Yii;
use yii\web\Response;

/**
 *  服务
 */
class ServeController extends ApiController
{
    use UtilTrait;

    /**
     * 登陆回话
     */
    public function actionLogin()
    {
        $result = LoginService::login();

        // error_log(var_export($result,true),3,Yii::$app->getRuntimePath().DIRECTORY_SEPARATOR.'test.log');
        if ($result['code'] === 0) {
            $userInfo = $result['data']['userInfo'];
            $query    = Member::findOne(["openid" => $userInfo['openId']]);
            if (empty($query)) {
                $query              = new Member();
                $query->openid      = $userInfo['openId'];
                $query->nickname    = $userInfo['nickName'];
                $query->avatar      = $userInfo['avatarUrl'];
                $query->gender      = $userInfo['gender'];
                $query->create_time = date("Y-m-d H:i:s");
            } else {
                $query->nickname = $userInfo['nickName'];
                $query->avatar   = $userInfo['avatarUrl'];
                $query->gender   = $userInfo['gender'];
            }
            $query->save();
        }
        exit;
    }

    /**
     * 信道服务
     */
    public function actionTunnel()
    {
        $handler = new ChatTunnelHandler();
        TunnelService::handle($handler, array('checkLogin' => true));
    }

    /**
     * 用户检测
     */
    public function actionUserCheck()
    {
        $result = $this->userCheck();

        if (!$result) {
            return;
        } else {
            $response = array(
                'code'    => 0,
                'message' => 'ok',
                'data'    => array(
                    'userInfo' => $result,
                ),
            );

            return json_encode($response, JSON_FORCE_OBJECT);
        }
    }

    /**
     * 上传图片
     */
    public function actionUploadImg()
    {
        if (!isset($_FILES['image'])) {
            return $this->response(CodeEnum::$paramError);
        }
        $target_path = Yii::getAlias("@webroot") . "/upload/" . date("Y") . "/" . date("m") . "/";
        $visit_path  = Yii::$app->params['PIC_HOST_URL'] . "/upload/" . date("Y") . "/" . date("m") . "/";

        $res = $this->uploadPicForMe($_FILES['image'], $target_path, $visit_path);
        return $this->response($res);
    }

    /**
     * 获取access_token
     */
    public function actionGetAccessToken()
    {
        $request = Yii::$app->request;
        $force   = $request->get('force', 0);

        $cache       = Yii::$app->cache;
        $accessToken = $cache->get("accessToken");
        if ($accessToken === false || $force == 1) {
            $appid       = Yii::$app->params['appid'];
            $appsecret   = Yii::$app->params['appsecret'];
            $url         = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            $res         = file_get_contents($url);
            $res         = json_decode($res);
            $accessToken = $res['access_token'];
            if (isset($res['access_token'])) {
                $cache->set("accessToken", $accessToken, 7200);
            }
        }
        CodeEnum::$success['data'] = ['access_token' => $accessToken];
        return $this->response(CodeEnum::$success);
    }

    /**
     * 推送模板消息
     */
    public function actionRemind()
    {

        $ac           = $this->actionGetAccessToken();
        $ac           = json_decode($ac, true);
        $access_token = $ac['data']['access_token'];

        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;

        //提前五分钟开始推送
        $time = date("Y-m-d H:i:s", time() - 300);

        $list = Remind::find()->where(['is_push' => 0])->andWhere([">=", 'remind_time', $time])->asArray()->all();
        if (!empty($list)) {
            $pushids = [];
            foreach ($list as $key => $value) {
                $params = [
                    'touser'      => $value['openid'],
                    'template_id' => Yii::$app->params['template_id'],
                    'page'        => Yii::$app->params['remind_url'],
                    'form_id'     => $value['form_id'],
                    'data'        => json_decode($value['msg_body'], true),
                ];
                $res = WebHelper::postData($url, $params);
                $res = json_decode($res, true);
                if ($res['errcode'] === 0) {
                    $pushids[] = $value['id'];
                }
            }

            //设置推送状态
            if (!empty($pushids)) {
                $res = Remind::updateAllCounters(['is_push' => 1, 'push_time' => date('Y-m-d H:i:s')], ['in', 'id', $pushids]);
            }
            return $this->response(CodeEnum::$success);
        } else {
            return $this->response(CodeEnum::$noPushData);
        }

    }
}
