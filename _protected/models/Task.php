<?php

namespace app\models;

use Yii;
use \app\models\base\Task as BaseTask;

/**
 * This is the model class for table "task".
 */
class Task extends BaseTask
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['parent_task_id', 'project_id', 'man_hours'], 'integer'],
            [['project_id', 'name', 'description', 'from', 'to', 'man_hours'], 'required'],
            [['name', 'description', 'from', 'to'], 'string', 'max' => 45]
        ]);
    }
	
}
