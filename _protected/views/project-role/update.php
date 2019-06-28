<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectRole */

$this->title = 'Update Project Role: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Project Role', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id, 'name' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
