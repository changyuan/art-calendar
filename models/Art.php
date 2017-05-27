<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%art}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $calid
 * @property string $openid
 * @property string $poster
 * @property string $show_time
 * @property integer $cityid
 * @property string $address
 * @property string $summary
 * @property string $group_code
 * @property integer $price_min
 * @property integer $price_max
 * @property string $price_link
 * @property string $ext_content
 * @property string $ext_link
 * @property integer $status
 * @property string $create_time
 */
class Art extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%art}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'calid', 'openid', 'poster', 'show_time', 'cityid', 'address'], 'required'],
            [['calid', 'cityid', 'price_min', 'price_max', 'status'], 'integer'],
            [['show_time', 'create_time'], 'safe'],
            [['name', 'group_code'], 'string', 'max' => 150],
            [['openid', 'poster'], 'string', 'max' => 200],
            [['address'], 'string', 'max' => 20],
            [['summary', 'price_link', 'ext_content'], 'string', 'max' => 255],
            [['ext_link'], 'string', 'max' => 125],
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
            'calid' => 'Calid',
            'openid' => 'Openid',
            'poster' => 'Poster',
            'show_time' => 'Show Time',
            'cityid' => 'Cityid',
            'address' => 'Address',
            'summary' => 'Summary',
            'group_code' => 'Group Code',
            'price_min' => 'Price Min',
            'price_max' => 'Price Max',
            'price_link' => 'Price Link',
            'ext_content' => '扩展内容json，图文，链接等',
            'ext_link' => 'Ext Link',
            'status' => '0 正常 -1 删除',
            'create_time' => 'Create Time',
        ];
    }

    public function getArtItem()
    {
        return $this->hasMany(ArtItem::className(),['artid'=>'id']);
    }

    public function getMember()
    {
        return $this->hasOne(Member::className(),['openid'=>'openid'])->select(['openid','nickname','avatar','gender']);
    }
}
