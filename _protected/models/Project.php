<?php

namespace app\models;

use Yii;
use \app\models\base\Project as BaseProject;

/**
 * This is the model class for table "project".
 */
class Project extends BaseProject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'description', 'started', 'deadline', 'manager_id'], 'required'],
            [['started', 'deadline'], 'safe'],
            [['manager_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 511],
            [['active'], 'integer']
        ]);
    }

    /**
     * contains the new finance arrays for updating the model
     * @param array $post 
     * @return bool
     */
    public function updateFinance($post){
        if(!$post) return false;
        $id = $this->id;
        $post_expenses = isset($post['Expense'])?$post['Expense']:[];
        $post_incomes = isset($post['Income'])?$post['Income']:[];
        //first we have to remove the ones that are removed
        $project_expenses = Expense::find()->where(['project_id' => $id])->all();
        foreach($project_expenses as $exp){
            $toDelete = true;
            foreach($post_expenses as $post_exp){
                if($post_exp['id'] == $exp->id) $toDelete = false;
            }
            if($toDelete){
                $exp->delete();
            } 
        }
        $project_incomes = Income::find()->where(['project_id' => $id])->all();
        foreach($project_incomes as $inc){
            $toDelete = true;
            foreach($post_incomes as $post_inc){
                if($post_inc['id'] == $inc->id) $toDelete = false;
            }
            if($toDelete){
                $inc->delete();
            } 
        }
        //then we add the new expenses and update the existing ones
        foreach($post_expenses as $exp){
            if(!$exp['id']) {
                $new_exp = new Expense();
                $new_exp->amount = $exp['amount'];
                $new_exp->project_id = $id;
                $new_exp->date = $exp['date'];
                $new_exp->save();
            }else{
                $existing = Expense::findOne($exp['id']);
                $existing->amount = $exp['amount'];
                $existing->date = $exp['date'];
                $existing->update();
            }
        }
        //then we add the new incomes, and update the existing ones
        foreach($post_incomes as $inc){
            if(!$inc['id']) {
                $new_inc = new Income();
                $new_inc->amount = $inc['amount'];
                $new_inc->project_id = $id;
                $new_inc->date = $inc['date'];
                $new_inc->save();
            }else{
                $existing = Income::findOne($inc['id']);
                $existing->amount = $inc['amount'];
                $existing->date = $inc['date'];
                $existing->update();
            }
        }

        return true;
    }

}
