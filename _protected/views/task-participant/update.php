<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskParticipant */

$this->title = 'Update Task Participant: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Participants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-participant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
