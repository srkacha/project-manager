<?php

namespace app\models;

use Yii;
use \app\models\base\Supervisor as BaseSupervisor;

/**
 * This is the model class for table "supervisor".
 */
class Supervisor extends BaseSupervisor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['project_id', 'user_id'], 'required'],
            [['project_id', 'user_id'], 'integer']
        ]);
    }
	
}
