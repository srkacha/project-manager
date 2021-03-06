<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Description']) ?>

    <?= $form->field($model, 'started')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Started',
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'deadline')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Deadline',
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'manager_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->select(['id', new \yii\db\Expression("CONCAT(`name`, ' ', `surname`) as nameAndSurname")])->orderBy('nameAndSurname')->asArray()->all(), 'id', 'nameAndSurname'),
        'options' => ['placeholder' => 'Choose User'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php
    $forms = [
       
        [
            'label' =>  Html::encode('Participants'),
            'content' => $this->render('_formParticipant', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->participants),
            ]),
        ],
        [
            'label' =>  Html::encode('Supervisors'),
            'content' => $this->render('_formSupervisor', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->supervisors),
            ]),
        ],
        [
            'label' =>  Html::encode('Incomes'),
            'content' => $this->render('_formIncome', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->incomes),
            ]),
            'headerOptions' => ['class'=>'disabled']
        ],
        [
            'label' =>  Html::encode('Expenses'),
            'content' => $this->render('_formExpense', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->expenses),
            ]),
            'headerOptions' => ['class'=>'disabled']
        ],
        [
            'label' =>  Html::encode('Tasks'),
            'content' => $this->render('_formTask', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->tasks),
                
            ]),
            'headerOptions' => ['class'=>'disabled']
        ],
        [
            'label' =>  Html::encode('Observations'),
            'content' => $this->render('_formObservation', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->observations),
            ]),
            'headerOptions' => ['class'=>'disabled']
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
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
