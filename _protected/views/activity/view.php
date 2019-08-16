<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= $role == 'manager'?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):"" ?>
            <?= Html::a(Yii::t('app', 'Back to task'), ['/task/view?id='.$model->task_id], ['class' => 'btn btn-primary'])?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'task.name',
            'label' => 'Task',
        ],
        'description',
        [
            'label' => 'Finshed',
            'value' => function($model){
                return $model->finished?'Yes':'No';
            }
        ]
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
    <h2>Activity participants </h2>
<?php
if($providerActivityParticipant->totalCount){
    $gridColumnActivityParticipant = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'taskParticipant.id',
                'label' => 'Participant',
                'value' => function($model){
                    $tpart = app\models\TaskParticipant::findOne(['id' => $model->task_participant_id]);
                    $part = app\models\Participant::findOne(['id' => $tpart->participant_id]);
                    $emp = app\models\User::findOne(['id' => $part->user_id]);
                    return $emp->name.' '.$emp->surname;
                }
            ],
                        'hours_worked',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerActivityParticipant,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-activity-participant']],
        'summary' => '',
        'export' => false,
        'columns' => $gridColumnActivityParticipant
    ]);
}else echo "This activity has no participants"
?>

</div>

<div class="row">
    <h2>Activity progress </h2>
<?php
if($providerActivityProgress->totalCount){
    $gridColumnActivityProgress = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'label' => 'Participant',
                'value' => function($model){
                    $apart = app\models\ActivityParticipant::findOne(['id' => $model->activity_participant_id]);
                    $tpart = app\models\TaskParticipant::findOne(['id' => $apart->task_participant_id]);
                    $part = app\models\Participant::findOne(['id' => $tpart->participant_id]);
                    $emp = app\models\User::findOne(['id' => $part->user_id]);
                    return $emp->name.' '.$emp->surname;
                }
            ],
            [
                'label' => 'Timestamp',
                'value' => function($model){
                    return $model->timestamp;
                }
            ],
            'comment',
            'hours_done'
    ];
    echo Gridview::widget([
        'dataProvider' => $providerActivityProgress,
        'pjax' => false,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-activity-participant']],
        'summary' => '',
        'export' => false,
        'columns' => $gridColumnActivityProgress
    ]);
}else echo "This activity has no progress"
?>

</div>


</div>
