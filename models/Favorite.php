<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%favorite}}".
 *
 * @property integer $favid
 * @property string $openid
 * @property integer $id
 * @property integer $idtype
 * @property integer $status
 * @property string $create_time
 */
class Favorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favorite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'id', 'status', 'create_time'], 'required'],
            [['id', 'idtype', 'status'], 'integer'],
            [['create_time'], 'safe'],
            [['openid'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'favid' => 'Favid',
            'openid' => 'Openid',
            'id' => 'ID',
            'idtype' => '1 日历 2 演出',
            'status' => '0 正常 -1 删除',
            'create_time' => 'Create Time',
        ];
    }

    public function  getCals()
    {
        return $this->hasMany(Calendar::className(),['id'=>'id']);
    }

    public function getArts()
    {
        return $this->hasMany(Art::className(),['id'=>'id']);
    }
}
