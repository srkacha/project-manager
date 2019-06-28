<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\TaskParticipant */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Participant', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-participant-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Task Participant'.' '. Html::encode($this->title) ?></h2>
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
            'attribute' => 'participant.id',
            'label' => 'Participant',
        ],
        [
            'attribute' => 'task.name',
            'label' => 'Task',
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerActivityParticipant->totalCount){
    $gridColumnActivityParticipant = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'activity.id',
                'label' => 'Activity'
            ],
            'hours_worked',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerActivityParticipant,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-activity-participant']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Activity Participant'),
        ],
        'export' => false,
        'columns' => $gridColumnActivityParticipant
    ]);
}
?>

    </div>
    <div class="row">
        <h4>Participant<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnParticipant = [
        ['attribute' => 'id', 'visible' => false],
        'project_id',
        'user_id',
        'project_role_id',
        'project_role_name',
    ];
    echo DetailView::widget([
        'model' => $model->participant,
        'attributes' => $gridColumnParticipant    ]);
    ?>
    <div class="row">
        <h4>Task<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnTask = [
        ['attribute' => 'id', 'visible' => false],
        'parent_task_id',
        'project_id',
        'name',
        'description',
        'from',
        'to',
        'man_hours',
    ];
    echo DetailView::widget([
        'model' => $model->task,
        'attributes' => $gridColumnTask    ]);
    ?>
</div>
