<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "participant".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 * @property integer $project_role_id
 *
 * @property \app\models\ProjectRole $projectRole
 * @property \app\models\Project $project
 * @property \app\models\User $user
 * @property \app\models\TaskParticipant[] $taskParticipants
 */
class Participant extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'projectRole',
            'project',
            'user',
            'taskParticipants'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'project_role_id'], 'required'],
            [['project_id', 'user_id', 'project_role_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participant';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'project_role_id' => 'Project Role ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectRole()
    {
        return $this->hasOne(\app\models\ProjectRole::className(), ['id' => 'project_role_id']);
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
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskParticipants()
    {
        return $this->hasMany(\app\models\TaskParticipant::className(), ['participant_id' => 'id']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\ParticipantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ParticipantQuery(get_called_class());
    }
}
