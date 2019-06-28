<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Migration */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="migration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true, 'placeholder' => 'Version']) ?>

    <?= $form->field($model, 'apply_time')->textInput(['placeholder' => 'Apply Time']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
