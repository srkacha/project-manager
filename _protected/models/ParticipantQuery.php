<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Participant]].
 *
 * @see Participant
 */
class ParticipantQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Participant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Participant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
