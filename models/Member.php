<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property integer $id
 * @property string $openid
 * @property string $nickname
 * @property string $avatar
 * @property integer $gender
 * @property string $authKey
 * @property string $accessToken
 * @property integer $is_admin
 * @property string $create_time
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'nickname', 'avatar', 'create_time'], 'required'],
            [['gender', 'is_admin'], 'integer'],
            [['create_time'], 'safe'],
            [['openid'], 'string', 'max' => 255],
            [['nickname', 'authKey', 'accessToken'], 'string', 'max' => 50],
            [['avatar'], 'string', 'max' => 150],
            [['openid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'nickname' => 'Nickname',
            'avatar' => 'Avatar',
            'gender' => '性别 0：未知、1：男、2：女',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'is_admin' => 'Is Admin',
            'create_time' => 'Create Time',
        ];
    }
}
