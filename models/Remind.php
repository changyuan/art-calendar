<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%remind}}".
 *
 * @property integer $id
 * @property integer $artid
 * @property string $msg_body
 * @property string $remind_time
 * @property string $openid
 * @property string $create_time
 * @property integer $is_push
 * @property string $push_time
 * @property string $form_id
 */
class Remind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%remind}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['artid', 'msg_body', 'remind_time', 'openid'], 'required'],
            [['artid', 'is_push'], 'integer'],
            [['remind_time', 'create_time', 'push_time'], 'safe'],
            [['msg_body', 'openid', 'form_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'artid' => 'Artid',
            'msg_body' => 'Msg Body',
            'remind_time' => 'Remind Time',
            'openid' => '客户的openids集合',
            'create_time' => 'Create Time',
            'is_push' => '1 已经提醒 0 未提醒',
            'push_time' => 'Push Time',
            'form_id' => '用户发送模版消息',
        ];
    }
}
