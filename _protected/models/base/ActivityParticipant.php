<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "activity_participant".
 *
 * @property integer $id
 * @property integer $task_participant_id
 * @property integer $activity_id
 * @property integer $hours_worked
 *
 * @property \app\models\Activity $activity
 * @property \app\models\TaskParticipant $taskParticipant
 */
class ActivityParticipant extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'activity',
            'taskParticipant'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_participant_id', 'activity_id'], 'required'],
            [['task_participant_id', 'activity_id', 'hours_worked'], 'integer'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_participant';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock() {
        return 'lock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_participant_id' => 'Task Participant ID',
            'activity_id' => 'Activity ID',
            'hours_worked' => 'Hours Worked',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(\app\models\Activity::className(), ['id' => 'activity_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskParticipant()
    {
        return $this->hasOne(\app\models\TaskParticipant::className(), ['id' => 'task_participant_id']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\ActivityParticipantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ActivityParticipantQuery(get_called_class());
    }
}
