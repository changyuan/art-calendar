<?php

namespace app\controllers;

use app\enum\CodeEnum;
use app\enum\FavoriteEnum;
use app\models\Art;
use app\models\Calendar;
use app\models\City;
use app\models\Favorite;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 *  我的接口
 */
class MyController extends ApiController
{

    /**
     * 我创建的日历
     */
    public function actionCal()
    {
        $pagesize = Yii::$app->params['pagesize'];
        $request  = Yii::$app->request;
        $page     = $request->get('page', 1);

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }

        $query = Calendar::find()->where([">=", "status", 0])->andWhere(['ac_calendar.openid' => $openid]);

        $count = $query->count();

        $query->joinWith('member');
        $offset   = ($page - 1) * $pagesize;
        $cal_list = $query->orderBy("create_time desc")->limit($pagesize)->offset($offset)->asArray()->all();

        $cal_list = array_map(function ($item) {
            $item['relation_userinfo'] = isset($item['relation_userinfo']) ? json_decode($item['relation_userinfo'], true) : [];
            return $item;
        }, $cal_list);

        CodeEnum::$success['data'] = [
            'count'    => $count,
            'cal_list' => $cal_list,
        ];
        return $this->response(CodeEnum::$success);
    }

    /**
     * 我创建的演出，按月显示，默认当前月
     */
    public function actionArt()
    {

        $pagesize = Yii::$app->params['pagesize'];
        $request  = Yii::$app->request;
        $page     = $request->get('page', 1);

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }

        $query = Art::find()->where([">=", "status", 0])->andWhere(['openid' => $openid]);

        $count = $query->count();

        $offset   = ($page - 1) * $pagesize;
        $art_list = $query->orderBy("create_time desc")->limit($pagesize)->offset($offset)->asArray()->all();

        $citys     = City::getInfo();
        $citys_map = ArrayHelper::map($citys, 'cityid', 'name');
        $art_list  = array_map(function ($item) use ($citys_map) {
            $item['cityname'] = $citys_map[$item['cityid']];
            return $item;
        }, $art_list);

        CodeEnum::$success['data'] = [
            'count'    => $count,
            'art_list' => $art_list,
        ];
        return $this->response(CodeEnum::$success);
    }

    /**
     * 收藏的日历
     */
    public function actionFavCal()
    {

        $pagesize = Yii::$app->params['pagesize'];
        $request  = Yii::$app->request;
        $page     = $request->get('page', 1);
        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }

        $query = Favorite::find()->select('ac_calendar.*,favid')->where(['ac_favorite.openid' => $openid, 'idtype' => FavoriteEnum::CALENDAR_TYPE])->andWhere(['>=', 'ac_favorite.status', 0]);

        $query->leftJoin('ac_calendar', '`ac_favorite`.`id` = `ac_calendar`.`id`')->andWhere(['>=', 'ac_calendar.status', 0]);

        $count    = $query->count();
        $offset   = ($page - 1) * $pagesize;
        $cal_list = $query->orderBy("create_time desc")->limit($pagesize)->offset($offset)->asArray()->all();

        $cal_list = array_map(function ($item) {
            $item['relation_userinfo'] = isset($item['relation_userinfo']) ? json_decode($item['relation_userinfo'], true) : [];
            return $item;
        }, $cal_list);
        // return $this->render('/site/index');

        CodeEnum::$success['data'] = [
            'count'    => $count,
            'cal_list' => $cal_list,
        ];
        return $this->response(CodeEnum::$success);
    }

    /**
     * 收藏的演出
     */
    public function actionFavArt()
    {

        $pagesize = Yii::$app->params['pagesize'];
        $request  = Yii::$app->request;
        $page     = $request->get('page', 1);

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }

        $query = Favorite::find()->select('ac_art.*,favid')->where(['ac_favorite.openid' => $openid, 'idtype' => FavoriteEnum::ART_TYPE])->andWhere(['>=', 'ac_favorite.status', 0]);

        $query->leftJoin('ac_art', '`ac_favorite`.`id` = `ac_art`.`id`')->andWhere(['>=', 'ac_art.status', 0]);

        $count    = $query->count();
        $offset   = ($page - 1) * $pagesize;
        $art_list = $query->orderBy("create_time desc")->limit($pagesize)->offset($offset)->asArray()->all();

        $citys     = City::getInfo();
        $citys_map = ArrayHelper::map($citys, 'cityid', 'name');
        $art_list  = array_map(function ($item) use ($citys_map) {
            $item['cityname'] = $citys_map[$item['cityid']];
            return $item;
        }, $art_list);

        CodeEnum::$success['data'] = [
            'count'    => $count,
            'art_list' => $art_list,
        ];
        return $this->response(CodeEnum::$success);
    }

    /**
     * 添加日历或者演出收藏
     */
    public function actionAddFav()
    {
        $request = Yii::$app->request;

        $idtype = $request->post('idtype', 0);
        $id     = $request->post('id', 0);

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($openid) || empty($idtype) || empty($id)) {
            return $this->response(CodeEnum::$paramError);
        }

        $count = Favorite::find()->where(['idtype' => $idtype, 'id' => $id, 'openid' => $openid])->count();
        if ($count > 0) {
            return $this->response(CodeEnum::$existName);
        } else {
            $query              = new Favorite();
            $query->id          = $id;
            $query->idtype      = $idtype;
            $query->openid      = $openid;
            $query->status      = 0;
            $query->create_time = date('Y-m-d H:i:s');
            $res                = $query->save();

            if ($res > 0) {
                return $this->response(CodeEnum::$success);
            } else {
                return $this->response(CodeEnum::$optFail);
            }
        }

    }

    /**
     * 删除收藏
     */
    public function actionDelFav()
    {
        $request = Yii::$app->request;
        $favid   = $request->post('favid', 0);
        
        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }
        
        if (empty($openid) || empty($favid)) {
            return $this->response(CodeEnum::$paramError);
        }
        $query = Favorite::findOne($favid);

        if ($openid != $query->openid) {
            return $this->response(CodeEnum::$denyVisit);
        }
        if ($query->status == -1) {
            return $this->response(CodeEnum::$isDelFav);
        }
        $query->status = -1;
        $res           = $query->save();
        if ($res > 0) {
            return $this->response(CodeEnum::$success);
        } else {
            return $this->response(CodeEnum::$optFail);
        }
    }

}
