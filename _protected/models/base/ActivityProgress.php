<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "activity_progress".
 *
 * @property integer $id
 * @property string $timestamp
 * @property string $comment
 * @property integer $activity_participant_id
 * @property integer $hours_done
 * @property integer $activity_id
 *
 * @property \app\models\ActivityParticipant $activityParticipant
 */
class ActivityProgress extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'activityParticipant'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timestamp', 'activity_participant_id', 'hours_done', 'activity_id'], 'required'],
            [['timestamp'], 'safe'],
            [['activity_participant_id', 'hours_done', 'activity_id'], 'integer'],
            [['comment'], 'string', 'max' => 511]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_progress';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timestamp' => 'Timestamp',
            'comment' => 'Comment',
            'activity_participant_id' => 'Activity Participant ID',
            'hours_done' => 'Hours Done',
            'activity_id' => 'Activity ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityParticipant()
    {
        return $this->hasOne(\app\models\ActivityParticipant::className(), ['id' => 'activity_participant_id']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\ActivityProgressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ActivityProgressQuery(get_called_class());
    }
}
