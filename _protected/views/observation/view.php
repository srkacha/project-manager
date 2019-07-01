<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Observation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Observation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="observation-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Observation'.' '. Html::encode($this->title) ?></h2>
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
            'attribute' => 'supervisor.id',
            'label' => 'Supervisor',
        ],
        [
            'attribute' => 'project.name',
            'label' => 'Project',
        ],
        'comment',
        'file',
        'timestamp',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>Supervisor<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnSupervisor = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'project.name',
            'label' => 'Project',
        ],
        'user_id',
    ];
    echo DetailView::widget([
        'model' => $model->supervisor,
        'attributes' => $gridColumnSupervisor    ]);
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
        'manager_id',
    ];
    echo DetailView::widget([
        'model' => $model->project,
        'attributes' => $gridColumnProject    ]);
    ?>
</div>
