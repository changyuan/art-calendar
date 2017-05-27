<?php

namespace app\controllers;

use app\enum\CodeEnum;
use app\enum\DictEnum;
use app\models\Art;
use app\models\ArtItem;
use app\models\Calendar;
use app\models\City;
use app\models\Remind;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 *  演出接口
 */
class ArtController extends ApiController
{
    /**
     * 创建或者更新演出
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        $artid   = $request->post('artid', 0);

        $name       = urldecode(trim($request->post('name', '')));
        $calid      = $request->post('calid', 0);
        $poster     = $request->post('poster', '');
        $show_time  = $request->post('show_time', 0);
        $cityid     = $request->post('cityid', 0);
        $address    = $request->post('address', '');
        $summary    = urldecode($request->post('summary', ''));
        $group_code = $request->post('group_code', '');
        //价格高低，这里因为有筛选条件，这里想art_item表中插入价格数据
        $price_min  = $request->post('price_min');
        $price_max  = $request->post('price_max');
        $price_link = $request->post('price_link');

        $ext_content = $request->post('ext_content');
        $ext_link    = $request->post('ext_link');

        //两个可选项的类型，这里art_item表中出入两个的分类信息
        $act_catid   = $request->post('act_catid');
        $actor_catid = $request->post('actor_catid');

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($name) || empty($calid) || empty($openid) || empty($poster) || empty($show_time) || empty($cityid) || empty($address) || empty($summary)) {
            return $this->response(CodeEnum::$paramError);
        }
        try {

            //这时候为修改
            if ($artid > 0) {
                $query = Art::findOne($artid);

                if ($openid != $query->openid) {
                    return $this->response(CodeEnum::$denyVisit);
                }
                if ($name) {
                    $query->name = $name;
                }

                if ($calid) {
                    $query->calid = $calid;
                }

                if ($openid) {
                    $query->openid = $openid;
                }

                if ($poster) {
                    $query->poster = $poster;
                }

                if ($show_time) {
                    $query->show_time = $show_time;
                }

                if ($cityid) {
                    $query->cityid = $cityid;
                }

                if ($address) {
                    $query->address = $address;
                }

                if ($summary) {
                    $query->summary = $summary;
                }

            } else {
                $query            = new Art();
                $query->name      = $name;
                $query->calid     = $calid;
                $query->openid    = $openid;
                $query->poster    = $poster;
                $query->show_time = $show_time;
                $query->cityid    = $cityid;
                $query->address   = $address;
                $query->summary   = $summary;
            }
            if ($group_code) {
                $query->group_code = $group_code;
            }

            if ($price_link) {
                $query->price_link = $price_link;
            }

            if ($ext_content) {
                $query->ext_content = $ext_content;
            }

            if ($ext_link) {
                $query->ext_link = $ext_link;
            }

            $res   = $query->save();
            $artid = 0;
            if ($res) {
                $artid = $query->attributes['id'];
                //1.处理价格
                if ($price_min !== null && $price_max !== null && $artid) {

                    $this->processPriceCat($price_min, $price_max, $artid);
                }
                //2.分类
                if ($act_catid !== null && !empty($act_catid) && $artid) {
                    $act_catid = explode(',', $act_catid);
                    $this->processActCat($act_catid, DictEnum::ART_TYPE, $artid);
                }
                //3.处理演员分类
                if ($actor_catid !== null && !empty($actor_catid) && $artid) {
                    $actor_catid = explode(',', $actor_catid);
                    $this->processActCat($actor_catid, DictEnum::ARTOR_TYPE, $artid);
                }
                return $this->response(CodeEnum::$success);
            } else {
                return $this->response(CodeEnum::$optFail);
            }
        } catch (\Exception $e) {
            return $this->response($e->getMessage());
        }

    }

    //处理价格分类的
    private function processPriceCat($min, $max, $artid)
    {
        $price_types = Yii::$app->params['price_sel'];

        $catids = [];
        foreach ($price_types as $key => $value) {
            if ($value[0] < $min && isset($value[1]) && $value[1] >= $min) {
                $catids[] = $key;
            }
            if ($value[0] < $max && isset($value[1]) && $value[1] >= $max) {
                $catids[] = $key;
            }
        }
        if (!empty($catids)) {
            $query1 = new ArtItem();
            $flag   = false;
            foreach ($catids as $key => $catid) {
                // $query->isNewRecord = true;
                $query         = clone $query1;
                $query->artid  = $artid;
                $query->itemid = $catid;
                $query->dictid = DictEnum::PRICE_TYPE;
                $res           = $query->save();
                // var_dump($query->getErrors());exit;
                if (!$res) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    private function processActCat($catid_arr, $type, $artid)
    {
        if (!empty($catid_arr)) {
            $query1 = new ArtItem();
            $flag   = false;
            foreach ($catid_arr as $key => $catid) {
                // $query->isNewRecord = true;
                $query         = clone $query1;
                $query->artid  = $artid;
                $query->itemid = $catid;
                $query->dictid = $type;
                $res           = $query->save();
                if (!$res) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 演出详情
     */
    public function actionView()
    {
        $request = Yii::$app->request;
        $artid   = $request->get('artid');

        if (empty($artid)) {
            return $this->response(CodeEnum::$paramError);
        }
        $query = Art::findOne($artid);
        if (empty($query) || empty($query->calid)) {
            return $this->response(CodeEnum::$paramError);
        }

        //头部日历信息
        $cal_query                     = Calendar::findOne($query->calid);
        $cal_info                      = $cal_query->attributes;
        $cal_info['relation_userinfo'] = isset($cal_info['relation_userinfo']) ? json_decode($cal_info['relation_userinfo'], true) : [];
        $cal_info['member']            = $cal_query->getMember()->asArray()->one();

        //演出信息
        $art_info = $query->attributes;
        //删选字典,城市
        $citys                = City::getInfo();
        $citys_map            = ArrayHelper::map($citys, 'cityid', 'name');
        $art_info['cityname'] = $citys_map[$art_info['cityid']];

        //show_time
        //显示今天的场次信息,必须是同一个日历的
        $show_time  = date('Y-m-d', strtotime($art_info['show_time']));
        $times_info = Art::find()->select('id')->where([">=", "status", 0])->andWhere(['calid'=>$art_info['calid']])->andWhere(['>=', 'show_time', $show_time])->andWhere(['<', 'show_time', date('Y-m-d', strtotime("+1 day", strtotime($show_time)))])->asArray()->all();

        $artids = ArrayHelper::getColumn($times_info, 'id');
        $times  = ['count' => count($artids), 'artids' => $artids];

        CodeEnum::$success['data'] = [
            'cal_info' => $cal_info,
            'art_info' => $art_info,
            'times'    => $times,
        ];
        return $this->response(CodeEnum::$success);
    }

    /**
     * 设置提醒, 定时任务发送模板消息
     * https://mp.weixin.qq.com/debug/wxadoc/dev/api/notice.html#接口说明
     */
    public function actionRemind()
    {
        $request      = Yii::$app->request;
        $artid        = $request->post('artid');
        $form_id       = $request->post('form_id'); // 用于发送模板消息

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $guest_openid = $member_info['openId'];
        }


        if (empty($artid) || empty($guest_openid) || empty($form_id)) {
            return $this->response(CodeEnum::$paramError);
        }

        $query_art = Art::findOne($artid);
        if (empty($query_art)) {
            return $this->response(CodeEnum::$paramError);
        }

        $remind_minute = Yii::$app->params['remind_minute'];
        $remind_time   = strtotime('-' . $remind_minute . ' minutes', strtotime($query_art->show_time));

        if ($remind_time <= time()) {
            return $this->response(CodeEnum::$remindExpire);
        }

        // $subject = $query_art->name . "将于" . $query_art->show_time . " 开始，记得提前观看。";

        $result = Remind::find()->where(["artid" => $artid, "openid" => $guest_openid])->asArray()->one();

        $msg_body = [
            'keyword1'=>[
                'value'=> $query_art->name,
                // 'color'=>''
            ],
            'keyword2'=>[
                'value'=>$query_art->address,
                // 'color'=>''
            ],
            'keyword3'=>[
                'value'=> $query_art->show_time,
                // 'color'=>''
            ],
        ];
        if (empty($result)) {
            $query              = new Remind();
            $query->artid       = $artid;
            $query->msg_body     = json_encode($msg_body);
            $query->remind_time = date('Y-m-d H:i:s', $remind_time);
            $query->openids     = $guest_openid;
            $query->form_id     = $form_id;
            $res                = $query->save();
            if ($res) {
                return $this->response(CodeEnum::$success);
            } else {
                return $this->response(CodeEnum::$optFail);
            }
        } else {
            return $this->response(CodeEnum::$isSetRemind);
        }

    }

    public function actionDel()
    {

        $request = Yii::$app->request;

        $artid  = $request->post('artid', 0);
        
        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($artid) || empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }

        $query = Art::findOne($artid);
        if ($openid != $query->openid) {
            return $this->response(CodeEnum::$denyVisit);
        }
        $query->status = -1;
        $res           = $query->save();
        if ($res) {
            return $this->response(CodeEnum::$success);
        } else {
            return $this->response(CodeEnum::$optFail);
        }
    }

}
