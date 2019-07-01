<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ActivityParticipant]].
 *
 * @see ActivityParticipant
 */
class ActivityParticipantQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ActivityParticipant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ActivityParticipant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
