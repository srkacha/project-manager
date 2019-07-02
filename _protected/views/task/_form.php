<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $node app\models\Task */

?>

<div class="task-form">

    

    <?= $form->field($node, 'project_id')->hiddenInput(['value'=> Yii::$app->session->get('rootProjectId')])->label(false); ?>
    

    <?= $form->field($node, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Description']) ?>

    <?= $form->field($node, 'from')->textInput(['maxlength' => true, 'placeholder' => 'Start'])->label('Start') ?>

    <?= $form->field($node, 'to')->textInput(['maxlength' => true, 'placeholder' => 'Deadline'])->label('Deadline')  ?>

    <?= $form->field($node, 'man_hours')->textInput(['placeholder' => 'Man Hours']) ?>


</div>
