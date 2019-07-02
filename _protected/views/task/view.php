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
            <h2><?=Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        
        [
            'attribute' => 'project.name',
            'label' => 'Project',
        ],
        'name',
        'description',
        'from',
        'to',
        'man_hours'
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
