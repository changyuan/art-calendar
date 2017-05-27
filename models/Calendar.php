<?php

namespace app\models;

use Yii;
use app\models\Member;

/**
 * This is the model class for table "{{%calendar}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $catid
 * @property string $openid
 * @property integer $view_count
 * @property string $relation_userinfo
 * @property integer $status
 * @property string $create_time
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%calendar}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'catid', 'openid', 'create_time'], 'required'],
            [['catid', 'view_count', 'status'], 'integer'],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['openid', 'relation_userinfo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'catid' => 'Catid',
            'openid' => 'Openid',
            'view_count' => 'View Count',
            'relation_userinfo' => '关联用户信息json',
            'status' => '0 正常 -1 删除',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @inheritdoc
     * @return CalendarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CalendarQuery(get_called_class());
    }

    public function getMember()
    {
        return $this->hasOne(Member::className(),['openid'=>'openid'])->select(['openid','nickname','avatar','gender']);
    }
}
