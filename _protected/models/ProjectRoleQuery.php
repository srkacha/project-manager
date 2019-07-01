<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProjectRole]].
 *
 * @see ProjectRole
 */
class ProjectRoleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ProjectRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
