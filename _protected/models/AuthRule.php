<?php

namespace app\models;

use Yii;
use \app\models\base\AuthRule as BaseAuthRule;

/**
 * This is the model class for table "auth_rule".
 */
class AuthRule extends BaseAuthRule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64]
        ]);
    }
	
}
