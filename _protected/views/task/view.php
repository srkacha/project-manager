<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Task'.' '. Html::encode($this->title) ?></h2>
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
            'attribute' => 'parentTask.name',
            'label' => 'Parent Task',
        ],
        [
            'attribute' => 'project.name',
            'label' => 'Project',
        ],
        'name',
        'description',
        'from',
        'to',
        'man_hours',
        'lvl',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerActivity->totalCount){
    $gridColumnActivity = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'description',
            'finished',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerActivity,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-activity']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Activity'),
        ],
        'export' => false,
        'columns' => $gridColumnActivity
    ]);
}
?>

    </div>
    <div class="row">
        <h4>Project<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnProject = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'description',
        'active',
        'started',
        'deadline',
        'manager_id',
    ];
    echo DetailView::widget([
        'model' => $model->project,
        'attributes' => $gridColumnProject    ]);
    ?>
    <div class="row">
        <h4>Task<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnTask = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'project.name',
            'label' => 'Project',
        ],
        'name',
        'description',
        'from',
        'to',
        'man_hours',
        'lvl',
    ];
    echo DetailView::widget([
        'model' => $model->parentTask,
        'attributes' => $gridColumnTask    ]);
    ?>
    
    <div class="row">
<?php
if($providerTask->totalCount){
    $gridColumnTask = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'project.name',
                'label' => 'Project'
            ],
            'name',
            'description',
            'from',
            'to',
            'man_hours',
            'lvl',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerTask,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-task']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Task'),
        ],
        'export' => false,
        'columns' => $gridColumnTask
    ]);
}
?>

    </div>
    
    <div class="row">
<?php
if($providerTaskParticipant->totalCount){
    $gridColumnTaskParticipant = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'participant.id',
                'label' => 'Participant'
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerTaskParticipant,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-task-participant']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Task Participant'),
        ],
        'export' => false,
        'columns' => $gridColumnTaskParticipant
    ]);
}
?>

    </div>
</div>
