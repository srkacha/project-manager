<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "supervisor".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 *
 * @property \app\models\Observation[] $observations
 * @property \app\models\Project $project
 * @property \app\models\User $user
 */
class Supervisor extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'observations',
            'project',
            'user'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id'], 'required'],
            [['project_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supervisor';
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
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservations()
    {
        return $this->hasMany(\app\models\Observation::className(), ['supervisor_id' => 'id']);
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
     * @inheritdoc
     * @return \app\models\SupervisorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\SupervisorQuery(get_called_class());
    }
}
