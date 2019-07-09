<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Activity', 
        'relID' => 'activity', 
        'value' => \yii\helpers\Json::encode($model->activities),
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
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'TaskParticipant', 
        'relID' => 'task-participant', 
        'value' => \yii\helpers\Json::encode($model->taskParticipants),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div>
        <h1>Task update</h1>
</div>
<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Description']) ?>

    <?= $form->field($model, 'from')->widget(\kartik\datecontrol\DateControl::classname(), [ 
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

    <?= $form->field($model, 'to')->widget(\kartik\datecontrol\DateControl::classname(), [ 
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

    <?= $form->field($model, 'man_hours')->textInput(['placeholder' => 'Man Hours']) ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Participants'),
            'content' => $this->render('_formTaskParticipant', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->taskParticipants),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Activities'),
            'content' => $this->render('_formActivity', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->activities),
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
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Back'), ['view?id='.$model->id], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>