<?php

namespace app\models;

use Yii;
use \app\models\base\Activity as BaseActivity;

/**
 * This is the model class for table "activity".
 */
class Activity extends BaseActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['task_id', 'description', 'finished'], 'required'],
            [['task_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['finished'], 'string', 'max' => 4],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
