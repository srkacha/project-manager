<?php

namespace app\models;

use Yii;
use \app\models\base\AuthAssignment as BaseAuthAssignment;

/**
 * This is the model class for table "auth_assignment".
 */
class AuthAssignment extends BaseAuthAssignment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['item_name', 'user_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['item_name'], 'string', 'max' => 64],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
