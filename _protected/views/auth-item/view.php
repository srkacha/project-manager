<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Auth Item'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->name], [
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
        'name',
        'type',
        'description:ntext',
        [
            'attribute' => 'ruleName.name',
            'label' => 'Rule Name',
        ],
        'data:ntext',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerAuthAssignment->totalCount){
    $gridColumnAuthAssignment = [
        ['class' => 'yii\grid\SerialColumn'],
                        'user_id',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAuthAssignment,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-auth-assignment']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Auth Assignment'),
        ],
        'export' => false,
        'columns' => $gridColumnAuthAssignment
    ]);
}
?>

    </div>
    <div class="row">
        <h4>AuthRule<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnAuthRule = [
        'name',
        'data:ntext',
    ];
    echo DetailView::widget([
        'model' => $model->ruleName,
        'attributes' => $gridColumnAuthRule    ]);
    ?>
    
    <div class="row">
<?php
if($providerAuthItemChild->totalCount){
    $gridColumnAuthItemChild = [
        ['class' => 'yii\grid\SerialColumn'],
                            ];
    echo Gridview::widget([
        'dataProvider' => $providerAuthItemChild,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-auth-item-child']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Auth Item Child'),
        ],
        'export' => false,
        'columns' => $gridColumnAuthItemChild
    ]);
}
?>

    </div>
</div>
