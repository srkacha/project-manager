<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Expense', 
        'relID' => 'expense', 
        'value' => \yii\helpers\Json::encode($model->expenses),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Income', 
        'relID' => 'income', 
        'value' => \yii\helpers\Json::encode($model->incomes),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Observation', 
        'relID' => 'observation', 
        'value' => \yii\helpers\Json::encode($model->observations),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Participant', 
        'relID' => 'participant', 
        'value' => \yii\helpers\Json::encode($model->participants),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Supervisor', 
        'relID' => 'supervisor', 
        'value' => \yii\helpers\Json::encode($model->supervisors),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Task', 
        'relID' => 'task', 
        'value' => \yii\helpers\Json::encode($model->tasks),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="project-form">
    <h1>Finance</h1>

    <?php 
    $managerNameAndSurname = $model->manager->name .' '. $model->manager->surname;
    $active = $model->active == '1'?'Yes':'No';
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
          'label' => 'Project name',
          'value' => $model->name  
        ],
        [
            'value' => $managerNameAndSurname,
            'label' => 'Manager',
        ],
        [
            'label' => 'Total income',
            'value' => $totalIncome
        ],
        [
            'label' => 'Total expenses',
            'value' => $totalOutcome,
            
        ],
        [
            'label' => 'Difference',
            'value' => $totalIncome - $totalOutcome,
            'contentOptions' => ['class' => $totalIncome - $totalOutcome >=0?'text-success':'text-danger'], 
        ]
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>

    <?php $form = ActiveForm::begin(); ?>
    
    <h1>
    <span class="pull-right m-3">
        <?= Html::submitButton('Update finance data', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </span>
    </h1>

    <?= $form->errorSummary($model); ?>

    

    <?php
    $forms = [
        [
            'label' =>  Html::encode('Incomes'),
            'content' => $this->render('_formIncome', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->incomes),
            ])
        ],
        [
            'label' =>  Html::encode('Expenses'),
            'content' => $this->render('_formExpense', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->expenses),
            ])
        ]
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    

    <?php ActiveForm::end(); ?>

</div>
