<?php

namespace app\models;

use Yii;
use \app\models\base\ActivityParticipant as BaseActivityParticipant;

/**
 * This is the model class for table "activity_participant".
 */
class ActivityParticipant extends BaseActivityParticipant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['task_participant_id', 'activity_id'], 'required'],
            [['task_participant_id', 'activity_id', 'hours_worked'], 'integer']
        ]);
    }
	
}
