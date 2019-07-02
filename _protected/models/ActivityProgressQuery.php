<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ActivityProgress]].
 *
 * @see ActivityProgress
 */
class ActivityProgressQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ActivityProgress[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ActivityProgress|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
