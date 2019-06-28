<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observation".
 *
 * @property int $id
 * @property int $supervisor_id
 * @property int $project_id
 * @property string $comment
 * @property string $file
 * @property string $timestamp
 *
 * @property Supervisor $supervisor
 * @property Project $project
 */
class Observation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'observation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supervisor_id', 'project_id', 'comment', 'timestamp'], 'required'],
            [['supervisor_id', 'project_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['comment', 'file'], 'string', 'max' => 255],
            [['supervisor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supervisor::className(), 'targetAttribute' => ['supervisor_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supervisor_id' => 'Supervisor ID',
            'project_id' => 'Project ID',
            'comment' => 'Comment',
            'file' => 'File',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor()
    {
        return $this->hasOne(Supervisor::className(), ['id' => 'supervisor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}
