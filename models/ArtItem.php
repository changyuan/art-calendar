<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%art_item}}".
 *
 * @property integer $artid
 * @property integer $itemid
 * @property integer $dictid
 */
class ArtItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%art_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['artid', 'itemid', 'dictid'], 'required'],
            [['artid', 'itemid', 'dictid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'artid' => 'Artid',
            'itemid' => 'Itemid',
            'dictid' => '2 价格  3 演出类型  4 演出者',
        ];
    }
}
