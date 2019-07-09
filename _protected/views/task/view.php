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
        <h1><?=Html::encode($this->title) ?>
            <span class="pull-right">
            <?= $role !='participant'?Html::a(Yii::t('app', 'Project finance'), ['finance?id='.$model->id], ['class' => 'btn btn-primary']):"" ?>
        </span>  </h1>
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
    <h2>Task particpants</h2>
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
        'summary' => '',
        'dataProvider' => $providerTaskParticipant,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-task-participant']],
        'export' => false,
        'columns' => $gridColumnTaskParticipant
    ]);
}else echo '<p>No task participants on this task</p>';
?>

    </div>
    
    <div class="row">
    <h2>Activities</h2>
<?php
if($providerActivity->totalCount){
    $gridColumnActivity = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'description',
            'finished',
    ];
    echo Gridview::widget([
        'summary' => '',
        'dataProvider' => $providerActivity,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-activity']],
        'export' => false,
        'columns' => $gridColumnActivity
    ]);
}else echo '<p>No activities for this task</p>';
?>

    </div>
    
    
    <div class="row">
    <h2>Subtasks</h2>
<?php
if($providerTask->totalCount){
    $gridColumnTask = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Name',
            'format' => 'raw',
            'value'=>function ($model) {
                return Html::a(Html::encode($model->name),'view?id='.$model->id);
            },
        ],
            'description',
            'from',
            'to',
            'man_hours',
    ];
    echo Gridview::widget([
        'summary' => '',
        'dataProvider' => $providerTask,
        'pjax' => false,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-task']],
        'export' => false,
        'columns' => $gridColumnTask
    ]);
}else echo "<p>This task has no subtasks</p>";
?>

    </div>
    
    
</div>
