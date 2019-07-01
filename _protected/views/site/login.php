<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="row justify-content-center">
    <div class="col-md-6 well bs-component">

        

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?php //-- use email or username field depending on model scenario --// ?>
        <?php if ($model->scenario === 'lwe'): ?>

            <?= $form->field($model, 'email')->input('email', 
                ['placeholder' => Yii::t('app', 'Enter your e-mail'), 'autofocus' => true]) ?>

        <?php else: ?>

            <?= $form->field($model, 'username')->textInput(
                ['placeholder' => Yii::t('app', 'Enter your username'), 'autofocus' => true]) ?>

        <?php endif ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Enter your password')]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    
    </div>
</div>
