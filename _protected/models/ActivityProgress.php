<?php

namespace app\models;

use Yii;
use \app\models\base\ActivityProgress as BaseActivityProgress;

/**
 * This is the model class for table "activity_progress".
 */
class ActivityProgress extends BaseActivityProgress
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['timestamp', 'activity_participant_id', 'hours_done', 'activity_id'], 'required'],
            [['timestamp'], 'safe'],
            [['activity_participant_id', 'hours_done', 'activity_id'], 'integer'],
            [['comment'], 'string', 'max' => 511]
        ]);
    }
	
}
