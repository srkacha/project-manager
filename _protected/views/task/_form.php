<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $node app\models\Task */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Activity', 
        'relID' => 'activity', 
        'value' => \yii\helpers\Json::encode($node->activities),
        'isNewRecord' => ($node->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'TaskParticipant', 
        'relID' => 'task-participant', 
        'value' => \yii\helpers\Json::encode($node->taskParticipants),
        'isNewRecord' => ($node->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="task-form">

    <?= $form->field($node, 'id')->hiddenInput(['value'=> $node->id])->label(false); ?>

    <?= $form->field($node, 'project_id')->hiddenInput(['value'=> Yii::$app->session->get('rootProjectId')])->label(false); ?>
    

    <?= $form->field($node, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Description']) ?>

    <?= $form->field($node, 'from')->widget(\kartik\datecontrol\DateControl::classname(), [ 
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME, 
        'saveFormat' => 'php:Y-m-d H:i:s', 
        'ajaxConversion' => true, 
        'options' => [ 
            'pluginOptions' => [ 
                'placeholder' => 'Choose From', 
                'autoclose' => true, 
            ] 
        ], 
    ]); ?>

    <?= $form->field($node, 'to')->widget(\kartik\datecontrol\DateControl::classname(), [ 
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME, 
        'saveFormat' => 'php:Y-m-d H:i:s', 
        'ajaxConversion' => true, 
        'options' => [ 
            'pluginOptions' => [ 
                'placeholder' => 'Choose To', 
                'autoclose' => true, 
            ] 
        ], 
    ]); ?>

    <?= $form->field($node, 'man_hours')->textInput(['placeholder' => 'Man Hours']) ?>

    <?php
    $forms = [
        [
            'label' =>  Html::encode('Activities'),
            'content' => $this->render('_formActivity', [
                'row' => \yii\helpers\ArrayHelper::toArray($node->activities),
            ]),
        ],
        [
            'label' =>  Html::encode('Participants'),
            'content' => $this->render('_formTaskParticipant', [
                'row' => \yii\helpers\ArrayHelper::toArray($node->taskParticipants),
            ]),
        ],
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
    echo $formAction;
    ?>

    <div class="form-group">
        <?= Html::submitButton($node->isNewRecord ? 'Create task' : 'Update task', ['class' => $node->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
</div>
