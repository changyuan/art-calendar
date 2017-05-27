<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Calendar]].
 *
 * @see Calendar
 */
class CalendarQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Calendar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Calendar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
