<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Project'.' '. Html::encode($this->title) ?></h2>
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
        'name',
        'description',
        'active',
        'started',
        'deadline',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerExpense->totalCount){
    $gridColumnExpense = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            'amount',
            'date',
                ];
    echo Gridview::widget([
        'dataProvider' => $providerExpense,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-expense']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Expense'),
        ],
        'export' => false,
        'columns' => $gridColumnExpense
    ]);
}
?>

    </div>
    
    <div class="row">
<?php
if($providerIncome->totalCount){
    $gridColumnIncome = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            'amount',
            'date',
                ];
    echo Gridview::widget([
        'dataProvider' => $providerIncome,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-income']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Income'),
        ],
        'export' => false,
        'columns' => $gridColumnIncome
    ]);
}
?>

    </div>
    
    <div class="row">
<?php
if($providerObservation->totalCount){
    $gridColumnObservation = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'supervisor.id',
                'label' => 'Supervisor'
            ],
                        'comment',
            'file',
            'timestamp',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerObservation,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-observation']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Observation'),
        ],
        'export' => false,
        'columns' => $gridColumnObservation
    ]);
}
?>

    </div>
    
    <div class="row">
<?php
if($providerParticipant->totalCount){
    $gridColumnParticipant = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'user.name',
                'label' => 'User'
            ],
            [
                'attribute' => 'projectRole.name',
                'label' => 'Project Role'
            ],
            'project_role_name',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerParticipant,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-participant']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Participant'),
        ],
        'export' => false,
        'columns' => $gridColumnParticipant
    ]);
}
?>

    </div>
    
    <div class="row">
<?php
if($providerSupervisor->totalCount){
    $gridColumnSupervisor = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'user.name',
                'label' => 'User'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerSupervisor,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-supervisor']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Supervisor'),
        ],
        'export' => false,
        'columns' => $gridColumnSupervisor
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
                'attribute' => 'parentTask.name',
                'label' => 'Parent Task'
            ],
                        'name',
            'description',
            'from',
            'to',
            'man_hours',
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
</div>
