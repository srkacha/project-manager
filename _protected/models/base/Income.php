<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "income".
 *
 * @property integer $id
 * @property string $amount
 * @property string $date
 * @property integer $project_id
 *
 * @property \app\models\Project $project
 */
class Income extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'project'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'date', 'project_id'], 'required'],
            [['amount'], 'number'],
            [['date'], 'safe'],
            [['project_id'], 'integer'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income';
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
            'amount' => 'Amount',
            'date' => 'Date',
            'project_id' => 'Project ID',
        ];
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
     * @return \app\models\IncomeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\IncomeQuery(get_called_class());
    }
}
