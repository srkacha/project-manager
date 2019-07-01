<?php

namespace app\models;

use Yii;
use \app\models\base\ProjectRole as BaseProjectRole;

/**
 * This is the model class for table "project_role".
 */
class ProjectRole extends BaseProjectRole
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
