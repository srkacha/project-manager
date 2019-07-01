<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $active
 * @property string $started
 * @property string $deadline
 * @property integer $manager_id
 *
 * @property \app\models\Expense[] $expenses
 * @property \app\models\Income[] $incomes
 * @property \app\models\Observation[] $observations
 * @property \app\models\Participant[] $participants
 * @property \app\models\User $manager
 * @property \app\models\Supervisor[] $supervisors
 * @property \app\models\Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'expenses',
            'incomes',
            'observations',
            'participants',
            'manager',
            'supervisors',
            'tasks'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'active', 'started', 'deadline', 'manager_id'], 'required'],
            [['started', 'deadline'], 'safe'],
            [['manager_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 511],
            [['active'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'active' => 'Active',
            'started' => 'Started',
            'deadline' => 'Deadline',
            'manager_id' => 'Manager ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses()
    {
        return $this->hasMany(\app\models\Expense::className(), ['project_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomes()
    {
        return $this->hasMany(\app\models\Income::className(), ['project_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservations()
    {
        return $this->hasMany(\app\models\Observation::className(), ['project_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(\app\models\Participant::className(), ['project_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'manager_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisors()
    {
        return $this->hasMany(\app\models\Supervisor::className(), ['project_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(\app\models\Task::className(), ['project_id' => 'id']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ProjectQuery(get_called_class());
    }
}
