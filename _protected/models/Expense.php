<?php

namespace app\models;

use Yii;
use \app\models\base\Expense as BaseExpense;

/**
 * This is the model class for table "expense".
 */
class Expense extends BaseExpense
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['amount', 'date', 'project_id'], 'required'],
            [['amount'], 'number'],
            [['date'], 'safe'],
            [['project_id'], 'integer']
        ]);
    }
	
}
