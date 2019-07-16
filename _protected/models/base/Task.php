<?php

namespace app\models\base; 

use Yii; 
use app\models\TaskParticipant;
use app\models\Activity;

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
            [['project_id', 'name', 'description', 'from', 'to', 'man_hours'], 'required'],
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

    public function updateWhole($post){
        if(!$post) return false;
        $id = $this->id;

        //first we update the task atributes
        $this->name = $post['Task']['name'];
        $this->description = $post['Task']['description'];
        $this->from = $post['Task']['from'];
        $this->to = $post['Task']['to'];
        $this->man_hours = $post['Task']['man_hours'];
        $this->save();

        //now we deal with the participants and activities
        $post_activites = isset($post['Activity'])?$post['Activity']:[];
        $post_participants = isset($post['TaskParticipant'])?$post['TaskParticipant']:[];
        //first we have to remove the ones that are removed
        $task_activities = Activity::find()->where(['task_id' => $id])->all();
        foreach($task_activities as $act){
            $toDelete = true;
            foreach($post_activites as $post_act){
                if($post_act['id'] == $act->id) $toDelete = false;
            }
            if($toDelete){
                $act->delete();
            } 
        }
        $task_participants = TaskParticipant::find()->where(['task_id' => $id])->all();
        foreach($task_participants as $part){
            $toDelete = true;
            foreach($post_participants as $post_part){
                if($post_part['id'] == $part->id) $toDelete = false;
            }
            if($toDelete){
                $part->delete();
            } 
        }
        //then we add the new activities and update the existing ones
        foreach($post_activites as $act){
            if(!$act['id']) {
                $new_act = new Activity();
                $new_act->description = $act['description'];
                $new_act->task_id = $id;
                $new_act->save();
            }else{
                $existing = Activity::findOne($act['id']);
                $existing->description = $act['description'];
                $existing->update();
            }
        }
        //then we add the new participants, and update the existing ones
        foreach($post_participants as $part){
            if(!$part['id']) {
                $new_part = new TaskParticipant();
                $new_part->participant_id = $part['participant_id'];
                $new_part->task_id = $id;
                $new_part->save();
            }else{
                $existing = TaskPArticipant::findOne($part['id']);
                $existing->participant_id = $part['participant_id'];
                $existing->update();
            }
        }

        return true;
    }
} 