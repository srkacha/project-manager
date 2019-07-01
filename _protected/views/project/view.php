<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?=Html::encode($this->title) ?></h2>
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
    $managerNameAndSurname = $model->manager->name .' '. $model->manager->surname;
    $active = $model->active == '1'?'Yes':'No';
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'description',
        [
            'value'=> $active,
            'label' => 'Active'
        ],
        'started',
        'deadline',
        [
            'value' => $managerNameAndSurname,
            'label' => 'Manager',
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
 
    
    <div class="row">
<h2>Participants</h2>
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
            
    ];
    echo Gridview::widget([
        'dataProvider' => $providerParticipant,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-participant']],
        
        'export' => false,
        'columns' => $gridColumnParticipant
    ]);
}  else echo '<p>No supervisors on this project.</p>'
?>
</div>
    
    <div class="row">
<h2>Supervisors</h2>
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
        
        'export' => false,
        'columns' => $gridColumnSupervisor
    ]);
} else echo '<p>No supervisors on this project.</p>'
?>
</div>
    
   