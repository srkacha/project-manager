<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "task_participant".
 *
 * @property integer $id
 * @property integer $participant_id
 * @property integer $task_id
 *
 * @property \app\models\ActivityParticipant[] $activityParticipants
 * @property \app\models\Participant $participant
 * @property \app\models\Task $task
 */
class TaskParticipant extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'activityParticipants',
            'participant',
            'task'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['participant_id', 'task_id'], 'required'],
            [['participant_id', 'task_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_participant';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'participant_id' => 'Participant ID',
            'task_id' => 'Task ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityParticipants()
    {
        return $this->hasMany(\app\models\ActivityParticipant::className(), ['task_participant_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(\app\models\Participant::className(), ['id' => 'participant_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(\app\models\Task::className(), ['id' => 'task_id']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\TaskParticipantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\TaskParticipantQuery(get_called_class());
    }
}
