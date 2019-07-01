<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivityParticipant */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Participants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-participant-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Activity Participant'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'taskParticipant.id',
            'label' => 'Task Participant',
        ],
        [
            'attribute' => 'activity.id',
            'label' => 'Activity',
        ],
        'hours_worked',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>Activity<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnActivity = [
        ['attribute' => 'id', 'visible' => false],
        'task_id',
        'description',
        'finished',
    ];
    echo DetailView::widget([
        'model' => $model->activity,
        'attributes' => $gridColumnActivity    ]);
    ?>
    <div class="row">
        <h4>TaskParticipant<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnTaskParticipant = [
        ['attribute' => 'id', 'visible' => false],
        'participant_id',
        'task_id',
    ];
    echo DetailView::widget([
        'model' => $model->taskParticipant,
        'attributes' => $gridColumnTaskParticipant    ]);
    ?>
</div>
