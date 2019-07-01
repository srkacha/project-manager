<?php

namespace app\models;

use Yii;
use \app\models\base\Participant as BaseParticipant;

/**
 * This is the model class for table "participant".
 */
class Participant extends BaseParticipant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['project_id', 'user_id', 'project_role_id'], 'required'],
            [['project_id', 'user_id', 'project_role_id'], 'integer']
        ]);
    }
	
}
