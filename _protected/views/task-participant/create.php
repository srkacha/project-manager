<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaskParticipant */

$this->title = 'Create Task Participant';
$this->params['breadcrumbs'][] = ['label' => 'Task Participants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-participant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
