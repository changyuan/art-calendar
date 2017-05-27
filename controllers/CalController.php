<?php

namespace app\controllers;

use app\enum\CodeEnum;
use app\enum\DictEnum;
use app\models\Art;
use app\models\Calendar;
use app\models\City;
use app\models\DictionaryItem;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * 日历接口
 */
class CalController extends ApiController
{

    /**
     *  日历列表
     */
    public function actionIndex()
    {

        //查询分类，仅仅显示有数据的分类

        $pagesize = Yii::$app->params['pagesize'];
        $request  = Yii::$app->request;
        $page     = $request->get('page', 1);
        $catid    = $request->get('catid', 0);

        //读取分类
        $dicts = DictionaryItem::getInfo(DictEnum::CALENDAR_TYPE);

        if (1 == $page) {

            $cat_infos = Calendar::find()->select(['catid', 'count(1) as count'])->where([">=", "status", 0])->groupBy('catid')->asArray()->all();

            if (!empty($cat_infos)) {
                $count = array_reduce($cat_infos, function ($a, $b) {
                    $a += $b['count'];
                    return strval($a);
                });
                $cat_info[] = ['catid' => 0, 'name' => '全部', 'count' => $count];
                $temp       = array_map(function ($item) use ($dicts) {
                    return ['catid' => $item['catid'], 'name' => $dicts[$item['catid']], 'count' => $item['count']];
                }, $cat_infos);
                $cat_info = array_merge($cat_info, $temp);
            }

        }

        $query = Calendar::find()->where([">=", "status", 0]);
        if (!empty($catid)) {
            $query->andWhere(['catid' => $catid]);
        }
        $query->joinWith('member');
        $offset   = ($page - 1) * $pagesize;
        $cal_list = $query->orderBy("view_count desc")->limit($pagesize)->offset($offset)->asArray()->all();

        if (1 == $page) {
            CodeEnum::$success['data'] = [
                'cat_info' => $cat_info,
            ];
        }

        $cal_list = array_map(function ($item) {
            $item['relation_userinfo'] = isset($item['relation_userinfo']) ? json_decode($item['relation_userinfo'], true) : [];
            return $item;
        }, $cal_list);
        CodeEnum::$success['data'] = [
            'cal_list' => $cal_list,
        ];
        return $this->response(CodeEnum::$success);
    }

    public function actionIsExistCal()
    {
        $request = Yii::$app->request;
        $name    = $request->get('name', '');
        if (empty($name)) {
            return $this->response(CodeEnum::$paramError);
        }
        $count = Calendar::find()->where(['name' => $name])->count();

        if ($count > 0) {
            return $this->response(CodeEnum::$existName);
        } else {
            return $this->response(CodeEnum::$success);
        }
    }

    /**
     * 添加日历 post
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $name    = $request->post('name', '');
        $catid   = $request->post('catid', 0);

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($name) || empty($catid) || empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }
        $count = Calendar::find()->where(['name' => $name])->count();

        if ($count > 0) {
            return $this->response(CodeEnum::$existName);
        } else {

            $relation_num      = $request->post('relation_num', 0);
            $relation_nickname = $request->post('relation_nickname', '');
            $relation_avatar   = $request->post('relation_avatar', '');

            $relation_userinfo = [];
            if (!empty($relation_num) && !empty($relation_nickname) && !empty($relation_avatar)) {
                $relation_userinfo = [
                    'relation_num'      => $relation_num,
                    'relation_nickname' => $relation_nickname,
                    'relation_avatar'   => $relation_avatar,
                ];
            }
            $model                    = new Calendar();
            $model->name              = $name;
            $model->catid             = $catid;
            $model->openid            = $openid;
            $model->relation_userinfo = empty($relation_userinfo) ? "" : json_encode($relation_userinfo);
            $model->create_time       = date("Y-m-d H:i:s");
            $res                      = $model->save();
            if ($res > 0) {
                return $this->response(CodeEnum::$success);
            } else {
                return $this->response(CodeEnum::$optFail);
            }
        }
    }

    /**
     * 编辑日历 put
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        $calid   = $request->post('calid', 0);
        $name    = $request->post('name', '');
        $catid   = $request->post('itemid', 0);

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($calid) || empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }
        $query = Calendar::findOne($calid);

        if (empty($query)) {
            return $this->response(CodeEnum::$denyVisit);
        }
        //是不是本人
        if ($openid != $query->openid) {
            return $this->response(CodeEnum::$denyVisit);
        }
        //检测名称
        if (!empty($name)) {
            $count = Calendar::find()->where("name='" . $name . "' and id != " . $calid)->count();
            if ($count > 0) {
                return $this->response(CodeEnum::$existName);
            } else {
                $query->name = $name;
            }
        }

        if (!empty($catid)) {
            $query->catid = $catid;
        }

        $relation_num      = $request->post('relation_num', 0);
        $relation_nickname = $request->post('relation_nickname', '');
        $relation_avatar   = $request->post('relation_avatar', '');

        $relation_userinfo = empty($query->relation_userinfo) ? "" : json_decode($query->relation_userinfo, true);
        if (!empty($relation_num)) {
            $relation_userinfo['relation_num'] = $relation_num;
        }

        if (!empty($relation_nickname)) {
            $relation_userinfo['relation_nickname'] = $relation_nickname;
        }

        if (!empty($relation_avatar)) {
            $relation_userinfo['relation_avatar'] = $relation_avatar;
        }

        if (!empty($relation_userinfo)) {
            $query->relation_userinfo = json_encode($relation_userinfo);
        }

        $res = $query->save();
        if ($res > 0) {
            return $this->response(CodeEnum::$success);
        } else {
            return $this->response(CodeEnum::$optFail);
        }
    }
    /**
     * 增加日历游览数
     */
    public function actionInsViewCount()
    {
        $request = Yii::$app->request;
        $calid   = $request->post('calid', 0);

        if (empty($calid)) {
            return $this->response(CodeEnum::$paramError);
        }

        $res = Calendar::updateAllCounters(['view_count' => 1], ['id' => $calid]);
        if ($res > 0) {
            return $this->response(CodeEnum::$success);
        } else {
            return $this->response(CodeEnum::$optFail);
        }
    }

    /**
     * 日历详情
     */
    public function actionView()
    {

        $request = Yii::$app->request;
        $page    = $request->get('page', 1);

        $calid = $request->get('calid', 0);

        if (empty($calid)) {
            return $this->response(CodeEnum::$paramError);
        }

        //删选字典,城市
        $citys    = City::getInfo();
        $ret_data = [];
        if (1 == $page) {

            // 日历信息
            $cal_query                     = Calendar::findOne($calid);
            $cal_info                      = $cal_query->attributes;
            $cal_info['relation_userinfo'] = isset($cal_info['relation_userinfo']) ? json_decode($cal_info['relation_userinfo'], true) : [];
            $cal_info['member']            = $cal_query->getMember()->asArray()->one();

            // 价格
            $price_types = DictionaryItem::getInfo(DictEnum::PRICE_TYPE);
            // $price_types = Yii::$app->params['price_sel'];
            // 演出类型
            $act_types = DictionaryItem::getInfo(DictEnum::ART_TYPE, $calid);
            //演员类型
            $actor_types = DictionaryItem::getInfo(DictEnum::ARTOR_TYPE, $calid);

            //本月有的演出,日历背景色的
            $cal_info_count = Art::find()->select(['DATE_FORMAT(show_time,"%Y-%m-%d") as date', 'count(1) as count'])->where([">=", "status", 0])->andWhere(["calid" => $calid])->groupBy('date')->asArray()->all();

            $ret_data = [
                'citys'          => $citys,
                'price_types'    => $price_types,
                'act_types'      => $act_types,
                'actor_types'    => $actor_types,
                'cal_info_count' => $cal_info_count,
            ];
        }

        $query = Art::find()->where([">=", "status", 0]);
        //查询今天，查询本月,筛选更多条件，d m y 自定义月，城市，价格，类型1，类型2
        $date = $request->get('date');
        if ($date !== null) {
            $date = strtolower($date);
            if ("m" == $date) {
                $query->andWhere(['>=', 'show_time', date('Y-m')])->andWhere(['<', 'show_time', date('Y-m', strtotime("+1 month"))]);
            } elseif ("y" == $date) {

                $query->andWhere(['>=', 'show_time', date('Y')])->andWhere(['<', 'show_time', date('Y', strtotime("+1 year"))]);
            } elseif (strlen($date) > 1) {
                $query->andWhere(['>=', 'show_time', $date])->andWhere(['<', 'show_time', date('Y-m', strtotime("+1 month", strtotime($date)))]);
            } else {
                $query->andWhere(['>=', 'show_time', date('Y-m-d')])->andWhere(['<', 'show_time', date('Y-m-d', strtotime("+1 day"))]);
            }
        }

        // -1 为全部
        $cityid = $request->get('cityid');
        if ($cityid !== null && $cityid != -1) {
            $query->andWhere(['cityid' => $cityid]);
        }

        // 合并
        //价格
        $price_catid = $request->get('price_catid');
        if (!empty($price_catid) && $price_catid != -1) {
            $price_catid = explode(',', $price_catid);
            if (!empty($price_catid)) {
                $query->joinWith('artItem as a')->andWhere(["in", 'a.itemid', $price_catid]);
            }
        }
        //演出类型
        $act_catid = $request->get('act_catid');
        if (!empty($act_catid) && $act_catid != -1) {
            $act_catid = explode(',', $act_catid);
            if (!empty($act_catid)) {
                $query->joinWith('artItem as b')->andWhere(["in", 'b.itemid', $act_catid]);
            }
        }
        // 演出者
        $actor_catid = $request->get('actor_catid');
        if (!empty($actor_catid) && $actor_catid != -1) {
            $actor_catid = explode(',', $actor_catid);
            if (!empty($actor_catid)) {
                $query->joinWith('artItem as c')->andWhere(["in", 'c.itemid', $actor_catid]);
            }
        }
        $pagesize = Yii::$app->params['pagesize'];
        $offset   = ($page - 1) * $pagesize;
        // $art_list = $query->orderBy("show_time desc")->limit($pagesize)->offset($offset)->asArray()->all();
        $art_list = $query->distinct()->orderBy("show_time desc")->limit($pagesize)->offset($offset)->asArray()->all();

        $citys_map = ArrayHelper::map($citys, 'cityid', 'name');
        $art_list  = array_map(function ($item) use ($citys_map) {
            if (isset($item['artItem'])) {
                unset($item['artItem']);
            }
            if (isset($item['cityid'])) {
                $item['cityname'] = $citys_map[$item['cityid']];
            }
            return $item;
        }, $art_list);


        $ret_data['art_list']      = $art_list;
        CodeEnum::$success['data'] = $ret_data;
        return $this->response(CodeEnum::$success);
    }

    /**
     * 修改自定义的日历分类
     */
    public function actionUpdDictType()
    {

        $request = Yii::$app->request;
        $calid   = $request->post('calid', 0);
        $dicid   = $request->post('dicid', 0); //3,4

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($calid) || empty($dicid) || empty($openid) || !in_array($dicid,[DictEnum::ART_TYPE,DictEnum::ARTOR_TYPE])) {
            return $this->response(CodeEnum::$paramError);
        }

        $dicts = DictionaryItem::find()->select(['itemid as catid', 'name'])->where(['dictionaryid' => $dicid, 'calid' => $calid])->asArray()->all();
        if (empty($dicts)) {
            $dicts_values = [];
        } else {
            $dicts        = ArrayHelper::map($dicts, 'catid', 'name');
            $dicts_keys   = array_keys($dicts);
            $dicts_values = array_values($dicts);
        }

        //修改,之后返回勾选的那些分类

        $cat_names = $request->post('cat_names', '');
        $cat_names = explode(',', urldecode($cat_names));
        if (empty($cat_names)) {
            return $this->response(CodeEnum::$paramError);
        }

        $dicts_end           = [];
        $intersect_cat_names = array_intersect($cat_names, $dicts_values);
        foreach ($dicts as $key => $value) {
            if (in_array($value, $intersect_cat_names)) {
                $dicts_end[] = ['catid' => $key, 'name' => $value];
            }
        }

        $diff_cat_names = array_diff($cat_names, $dicts_values);

        $query1 = new DictionaryItem();
        foreach ($diff_cat_names as $key => $value) {
            $query               = clone $query1;
            $query->dictionaryid = $dicid;
            $query->name         = $value;
            $query->mark         = $value;
            $query->status       = 1;
            $query->type         = 1;
            $query->ctype        = 0;
            $query->calid        = $calid;
            $temp                = $query->save();

            if ($temp) {
                $dicts_end[] = ['catid' => $query->itemid, 'name' => $value];
            }
        }

        // 默认读取这个日历所有的这个分类
        CodeEnum::$success['data'] = [
            'dicts' => $dicts_end,
        ];
        return $this->response(CodeEnum::$success);
    }
    /**
     * 删除自定义的日历分类
     */
    public function actionDelDictType()
    {
        $request = Yii::$app->request;
        $itemid  = $request->post('catid');
        $calid   = $request->post('calid');

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        $itemid = explode(',', $itemid);
        if (empty($itemid) || empty($calid) || empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }
        $res = DictionaryItem::deleteAll(['and', 'calid= :calid', ['in', 'itemid', $itemid]], [':calid' => $calid]);
        if ($res > 0) {
            return $this->response(CodeEnum::$success);
        } else {
            return $this->response(CodeEnum::$optFail);
        }
    }

    /**
     * 读取自定义的字典类型
     */
    public function actionGetDictType()
    {
        $request = Yii::$app->request;

        $dicid = $request->get('dicid', 0); //1,2,3,4

        if (empty($dicid)) {
            return $this->response(CodeEnum::$paramError);
        }

        $dicts = DictionaryItem::find()->select(['itemid as catid', 'name', 'status', 'calid'])->where(['dictionaryid' => $dicid])->asArray()->all();

        // 默认读取这个日历所有的这个分类
        CodeEnum::$success['data'] = [
            'dicts' => $dicts,
        ];
        return $this->response(CodeEnum::$success);
    }

    public function actionCityInfo()
    {
        $citys = City::getInfo();

        CodeEnum::$success['data'] = [
            'citys' => $citys,
        ];
        return $this->response(CodeEnum::$success);
    }

    public function actionDel()
    {

        $request = Yii::$app->request;

        $calid  = $request->post('calid', 0);

        $member_info = $this->userCheck();
        if (!$member_info) {
            return $this->response(CodeEnum::$sessionError);
        } else {
            $openid = $member_info['openId'];
        }

        if (empty($calid) || empty($openid)) {
            return $this->response(CodeEnum::$paramError);
        }

        $query = Calendar::findOne($calid);
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
