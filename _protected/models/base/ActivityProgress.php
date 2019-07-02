<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "activity_progress".
 *
 * @property integer $id
 * @property string $timestamp
 * @property string $comment
 * @property integer $activity_participant
 * @property integer $hours_done
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
            [['timestamp', 'comment', 'activity_participant', 'hours_done'], 'required'],
            [['timestamp'], 'safe'],
            [['activity_participant', 'hours_done'], 'integer'],
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
            'activity_participant' => 'Activity Participant',
            'hours_done' => 'Hours Done',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityParticipant()
    {
        return $this->hasOne(\app\models\ActivityParticipant::className(), ['id' => 'activity_participant']);
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
