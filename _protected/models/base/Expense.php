<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "expense".
 *
 * @property integer $id
 * @property string $amount
 * @property string $date
 * @property integer $project_id
 *
 * @property \app\models\Project $project
 */
class Expense extends \yii\db\ActiveRecord
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
            [['project_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expense';
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
     * @return \app\models\ExpenseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ExpenseQuery(get_called_class());
    }
}
