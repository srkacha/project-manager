<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participant".
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property int $project_role_id
 * @property string $project_role_name
 *
 * @property ProjectRole $projectRole
 * @property Project $project
 * @property User $user
 * @property TaskParticipant[] $taskParticipants
 */
class Participant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'project_role_id', 'project_role_name'], 'required'],
            [['project_id', 'user_id', 'project_role_id'], 'integer'],
            [['project_role_name'], 'string', 'max' => 255],
            [['project_role_id', 'project_role_name'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectRole::className(), 'targetAttribute' => ['project_role_id' => 'id', 'project_role_name' => 'name']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'project_role_id' => 'Project Role ID',
            'project_role_name' => 'Project Role Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectRole()
    {
        return $this->hasOne(ProjectRole::className(), ['id' => 'project_role_id', 'name' => 'project_role_name']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskParticipants()
    {
        return $this->hasMany(TaskParticipant::className(), ['participant_id' => 'id']);
    }
}
