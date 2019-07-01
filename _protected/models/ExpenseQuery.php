<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Expense]].
 *
 * @see Expense
 */
class ExpenseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Expense[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Expense|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
