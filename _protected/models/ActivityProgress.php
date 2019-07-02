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
            [['timestamp', 'comment', 'activity_participant', 'hours_done'], 'required'],
            [['timestamp'], 'safe'],
            [['activity_participant', 'hours_done'], 'integer'],
            [['comment'], 'string', 'max' => 511]
        ]);
    }
	
}
