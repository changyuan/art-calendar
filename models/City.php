<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $cityid
 * @property string $name
 * @property string $offical_name
 * @property integer $isshow
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityid', 'name', 'offical_name'], 'required'],
            [['cityid', 'isshow'], 'integer'],
            [['name', 'offical_name'], 'string', 'max' => 255],
            [['cityid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cityid' => 'Cityid',
            'name' => 'Name',
            'offical_name' => 'Offical Name',
            'isshow' => 'Isshow',
        ];
    }

    public static function getInfo()
    {
        //删选字典,城市
        $citys = City::find()->select(['cityid', 'name'])->where(['>', 'isshow', 0])->orderBy('sort asc')->asArray()->all();
        return $citys;
    }
}
