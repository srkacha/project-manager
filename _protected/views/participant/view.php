<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Participant */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Participant', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Participant'.' '. Html::encode($this->title) ?></h2>
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
            'attribute' => 'project.name',
            'label' => 'Project',
        ],
        [
            'attribute' => 'user.name',
            'label' => 'User',
        ],
        [
            'attribute' => 'projectRole.name',
            'label' => 'Project Role',
        ],
        'project_role_name',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>ProjectRole<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnProjectRole = [
        ['attribute' => 'id', 'visible' => false],
        'name',
    ];
    echo DetailView::widget([
        'model' => $model->projectRole,
        'attributes' => $gridColumnProjectRole    ]);
    ?>
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
    ];
    echo DetailView::widget([
        'model' => $model->project,
        'attributes' => $gridColumnProject    ]);
    ?>
    <div class="row">
        <h4>User<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnUser = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'surname',
        'username',
        'email',
        'password_hash',
        'status',
        'auth_key',
        'password_reset_token',
        'account_activation_token',
    ];
    echo DetailView::widget([
        'model' => $model->user,
        'attributes' => $gridColumnUser    ]);
    ?>
    
    <div class="row">
<?php
if($providerTaskParticipant->totalCount){
    $gridColumnTaskParticipant = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'task.name',
                'label' => 'Task'
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
