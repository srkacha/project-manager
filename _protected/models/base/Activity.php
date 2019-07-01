<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "activity".
 *
 * @property integer $id
 * @property integer $task_id
 * @property string $description
 * @property integer $finished
 *
 * @property \app\models\Task $task
 * @property \app\models\ActivityParticipant[] $activityParticipants
 */
class Activity extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'task',
            'activityParticipants'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'description', 'finished'], 'required'],
            [['task_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['finished'], 'string', 'max' => 4],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
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
            'task_id' => 'Task ID',
            'description' => 'Description',
            'finished' => 'Finished',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(\app\models\Task::className(), ['id' => 'task_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityParticipants()
    {
        return $this->hasMany(\app\models\ActivityParticipant::className(), ['activity_id' => 'id']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\ActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ActivityQuery(get_called_class());
    }
}
