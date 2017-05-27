<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%dictionary_item}}".
 *
 * @property integer $itemid
 * @property integer $dictionaryid
 * @property string $name
 * @property string $mark
 * @property integer $status
 * @property integer $type
 * @property integer $ctype
 * @property integer $calid
 * @property string $create_time
 * @property string $update_time
 */
class DictionaryItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dictionary_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dictionaryid', 'name'], 'required'],
            [['dictionaryid', 'status', 'type', 'ctype', 'calid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['mark'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemid' => 'Itemid',
            'dictionaryid' => 'Dictionaryid',
            'name' => 'Name',
            'mark' => 'Mark',
            'status' => 'Status',
            'type' => 'Type',
            'ctype' => 'Ctype',
            'calid' => 'Calid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public static function getInfo($type,$calid=0)
    {
        $query = self::find()->select(['itemid as catid','name'])->where(['dictionaryid'=>$type])->andWhere(['>','status',0]);

        if ($calid) {
            $query->andWhere(['calid'=>$calid]);
        }
        
        $dicts = $query->asArray()->all();
        if (!empty($dicts)) {
            $dicts =  ArrayHelper::map($dicts,'catid','name');
        } else {
            $dicts = [];
        }
        return $dicts;
    }
}
