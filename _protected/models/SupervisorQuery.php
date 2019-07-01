<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Supervisor]].
 *
 * @see Supervisor
 */
class SupervisorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Supervisor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Supervisor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
