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
            [['task_id', 'description'], 'required'],
            [['task_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['finished'], 'integer', 'max' => 4]
        ]);
    }
	
}
