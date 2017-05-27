<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Art]].
 *
 * @see Art
 */
class ArtQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Art[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Art|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
