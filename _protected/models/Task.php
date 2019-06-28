<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $parent_task_id
 * @property int $project_id
 * @property string $name
 * @property string $description
 * @property string $from
 * @property string $to
 * @property int $man_hours
 *
 * @property Activity[] $activities
 * @property Project $project
 * @property Task $parentTask
 * @property Task[] $tasks
 * @property TaskParticipant[] $taskParticipants
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_task_id', 'project_id', 'man_hours'], 'integer'],
            [['project_id', 'name', 'description', 'from', 'to', 'man_hours'], 'required'],
            [['name', 'description', 'from', 'to'], 'string', 'max' => 45],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['parent_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['parent_task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_task_id' => 'Parent Task ID',
            'project_id' => 'Project ID',
            'name' => 'Name',
            'description' => 'Description',
            'from' => 'From',
            'to' => 'To',
            'man_hours' => 'Man Hours',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'parent_task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['parent_task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskParticipants()
    {
        return $this->hasMany(TaskParticipant::className(), ['task_id' => 'id']);
    }
}
