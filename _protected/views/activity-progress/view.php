<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivityProgress */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Progresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-progress-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Activity Progress'.' '. Html::encode($this->title) ?></h2>
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
        'timestamp',
        'comment',
        [
            'attribute' => 'activityParticipant.id',
            'label' => 'Activity Participant',
        ],
        'hours_done',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>ActivityParticipant<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnActivityParticipant = [
        ['attribute' => 'id', 'visible' => false],
        'task_participant_id',
        'activity_id',
        'hours_worked',
    ];
    echo DetailView::widget([
        'model' => $model->activityParticipant,
        'attributes' => $gridColumnActivityParticipant    ]);
    ?>
</div>
