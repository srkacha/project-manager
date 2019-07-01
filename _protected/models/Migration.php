<?php

namespace app\models;

use Yii;
use \app\models\base\Migration as BaseMigration;

/**
 * This is the model class for table "migration".
 */
class Migration extends BaseMigration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['version'], 'required'],
            [['apply_time'], 'integer'],
            [['version'], 'string', 'max' => 180],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
