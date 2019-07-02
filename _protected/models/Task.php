<?php

namespace app\models;

use Yii; 
use \app\models\base\Task as BaseTask; 

/** 
 * This is the model class for table "task". 
 */ 
class Task extends BaseTask
{ 
    /** 
     * @inheritdoc 
     */ 
    public function rules() 
    { 
        return array_replace_recursive(parent::rules(), 
        [
            [['parent_task_id', 'project_id', 'man_hours', 'lvl'], 'integer'],
            [['project_id', 'name', 'description', 'from', 'to', 'man_hours', 'lvl'], 'required'],
            [['name', 'description', 'from', 'to'], 'string', 'max' => 45]
        ]); 
    } 

    use \kartik\tree\models\TreeTrait {
        isDisabled as parentIsDisabled; // note the alias
    }
 
    /**
     * @var string the classname for the TreeQuery that implements the NestedSetQueryBehavior.
     * If not set this will default to `kartik	ree\models\TreeQuery`.
     */
    public static $treeQueryClass; // change if you need to set your own TreeQuery
 
    /**
     * @var bool whether to HTML encode the tree node names. Defaults to `true`.
     */
    public $encodeNodeNames = true;
 
    /**
     * @var bool whether to HTML purify the tree node icon content before saving.
     * Defaults to `true`.
     */
    public $purifyNodeIcons = true;
 
    /**
     * @var array activation errors for the node
     */
    public $nodeActivationErrors = [];
 
    /**
     * @var array node removal errors
     */
    public $nodeRemovalErrors = [];
 
    /**
     * @var bool attribute to cache the `active` state before a model update. Defaults to `true`.
     */
    public $activeOrig = true;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }
    
    /**
     * Note overriding isDisabled method is slightly different when
     * using the trait. It uses the alias.
     */
    public function isDisabled()
    {
        if (Yii::$app->user->username !== 'admin') {
            return true;
        }
        return $this->parentIsDisabled();
    }
	
	
}
