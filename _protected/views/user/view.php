<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'User'.' '. Html::encode($this->title) ?></h2>
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
        'surname',
        'username',
        'email:email',
        'password_hash',
        'status',
        'auth_key',
        'password_reset_token',
        'account_activation_token',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerParticipant->totalCount){
    $gridColumnParticipant = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'project.name',
                'label' => 'Project'
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
if($providerProject->totalCount){
    $gridColumnProject = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            'name',
            'description',
            'active',
            'started',
            'deadline',
                ];
    echo Gridview::widget([
        'dataProvider' => $providerProject,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-project']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Project'),
        ],
        'export' => false,
        'columns' => $gridColumnProject
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
                'attribute' => 'project.name',
                'label' => 'Project'
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
</div>
