<?php

namespace app\models\base; 

use Yii; 

/** 
 * This is the base model class for table "task". 
 * 
 * @property integer $id
 * @property integer $parent_task_id
 * @property integer $project_id
 * @property string $name
 * @property string $description
 * @property string $from
 * @property string $to
 * @property integer $man_hours
 * @property integer $lvl
 * 
 * @property \app\models\Activity[] $activities
 * @property \app\models\Project $project
 * @property \app\models\Task $parentTask
 * @property \app\models\Task[] $tasks
 * @property \app\models\TaskParticipant[] $taskParticipants
 */ 
class Task extends \yii\db\ActiveRecord
{ 
    use \mootensai\relation\RelationTrait;


    /** 
    * This function helps \mootensai\relation\RelationTrait runs faster 
    * @return array relation names of this model 
    */ 
    public function relationNames() 
    { 
        return [
            'activities',
            'project',
            'parentTask',
            'tasks',
            'taskParticipants'
        ]; 
    } 

    /** 
     * @inheritdoc 
     */ 
    public function rules() 
    { 
        return [
            [['parent_task_id', 'project_id', 'man_hours', 'lvl'], 'integer'],
            [['project_id', 'name', 'description', 'from', 'to', 'man_hours', 'lvl'], 'required'],
            [['name', 'description', 'from', 'to'], 'string', 'max' => 45]
        ]; 
    } 

    /** 
     * @inheritdoc 
     */ 
    public static function tableName() 
    { 
        return 'task'; 
    } 

    /** 
     * @inheritdoc 
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
            'lvl' => 'Lvl',
        ]; 
    } 
     
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getActivities() 
    { 
        return $this->hasMany(\app\models\Activity::className(), ['task_id' => 'id']);
    } 
         
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getProject() 
    { 
        return $this->hasOne(\app\models\Project::className(), ['id' => 'project_id']);
    } 
         
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getParentTask() 
    { 
        return $this->hasOne(\app\models\Task::className(), ['id' => 'parent_task_id']);
    } 
         
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getTasks() 
    { 
        return $this->hasMany(\app\models\Task::className(), ['parent_task_id' => 'id']);
    } 
         
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getTaskParticipants() 
    { 
        return $this->hasMany(\app\models\TaskParticipant::className(), ['task_id' => 'id']);
    } 
    

    /** 
     * @inheritdoc 
     * @return \app\models\TaskQuery the active query used by this AR class. 
     */ 
    public static function find() 
    { 
        return new \app\models\TaskQuery(get_called_class()); 
    } 
} 