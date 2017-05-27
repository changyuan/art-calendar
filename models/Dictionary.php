<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%dictionary}}".
 *
 * @property integer $dictionaryid
 * @property string $name
 * @property string $mark
 * @property integer $status
 * @property string $openid
 * @property integer $type
 * @property string $create_time
 * @property string $update_time
 */
class Dictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dictionary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status', 'type'], 'required'],
            [['status', 'type'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['mark'], 'string', 'max' => 200],
            [['openid'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dictionaryid' => 'Dictionaryid',
            'name' => 'Name',
            'mark' => 'Mark',
            'status' => 'Status',
            'openid' => 'Openid',
            'type' => 'Type',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
