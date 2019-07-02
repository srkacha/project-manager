<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $node app\models\Task */

?>

<div class="task-form">

    

    <?= $form->field($node, 'project_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Project::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Choose Project'],
        'pluginOptions' => [
            'allowClear' => true,
            'style' => 'enabled: false'
        ],
    ]); ?>

    <?= $form->field($node, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Description']) ?>

    <?= $form->field($node, 'from')->textInput(['maxlength' => true, 'placeholder' => 'From']) ?>

    <?= $form->field($node, 'to')->textInput(['maxlength' => true, 'placeholder' => 'To']) ?>

    <?= $form->field($node, 'man_hours')->textInput(['placeholder' => 'Man Hours']) ?>


</div>
