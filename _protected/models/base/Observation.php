<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "observation".
 *
 * @property integer $id
 * @property integer $supervisor_id
 * @property integer $project_id
 * @property string $comment
 * @property string $file
 * @property string $timestamp
 *
 * @property \app\models\Supervisor $supervisor
 * @property \app\models\Project $project
 */
class Observation extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'supervisor',
            'project'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supervisor_id', 'project_id', 'comment', 'timestamp'], 'required'],
            [['supervisor_id', 'project_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['comment', 'file'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observation';
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
        return $this->hasOne(\app\models\Supervisor::className(), ['id' => 'supervisor_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(\app\models\Project::className(), ['id' => 'project_id']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\ObservationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ObservationQuery(get_called_class());
    }
}
