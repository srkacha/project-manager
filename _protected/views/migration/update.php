<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Migration */

$this->title = 'Update Migration: ' . ' ' . $model->version;
$this->params['breadcrumbs'][] = ['label' => 'Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->version, 'url' => ['view', 'id' => $model->version]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="migration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
