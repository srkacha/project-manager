<?php

namespace app\models;

use Yii;
use \app\models\base\Observation as BaseObservation;

/**
 * This is the model class for table "observation".
 */
class Observation extends BaseObservation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['supervisor_id', 'project_id', 'comment', 'timestamp'], 'required'],
            [['supervisor_id', 'project_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['comment', 'file'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
