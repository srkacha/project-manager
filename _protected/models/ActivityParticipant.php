<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_participant".
 *
 * @property int $id
 * @property int $task_participant_id
 * @property int $activity_id
 * @property int $hours_worked
 *
 * @property Activity $activity
 * @property TaskParticipant $taskParticipant
 */
class ActivityParticipant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_participant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_participant_id', 'activity_id'], 'required'],
            [['task_participant_id', 'activity_id', 'hours_worked'], 'integer'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['task_participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskParticipant::className(), 'targetAttribute' => ['task_participant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
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
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskParticipant()
    {
        return $this->hasOne(TaskParticipant::className(), ['id' => 'task_participant_id']);
    }
}
