<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Supervisor */

$this->title = 'Update Supervisor: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="supervisor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
