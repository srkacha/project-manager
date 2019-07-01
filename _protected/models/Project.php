<?php

namespace app\models;

use Yii;
use \app\models\base\Project as BaseProject;

/**
 * This is the model class for table "project".
 */
class Project extends BaseProject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'description', 'active', 'started', 'deadline', 'manager_id'], 'required'],
            [['started', 'deadline'], 'safe'],
            [['manager_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 511],
            [['active'], 'string', 'max' => 4],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
