<?php

namespace app\models;

use Yii;
use \app\models\base\TaskParticipant as BaseTaskParticipant;

/**
 * This is the model class for table "task_participant".
 */
class TaskParticipant extends BaseTaskParticipant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['participant_id', 'task_id'], 'required'],
            [['participant_id', 'task_id'], 'integer']
        ]);
    }
	
}
