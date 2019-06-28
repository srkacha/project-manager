<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\AuthRule */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Rule', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Auth Rule'.' '. Html::encode($this->title) ?></h2>
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
if($providerAuthItem->totalCount){
    $gridColumnAuthItem = [
        ['class' => 'yii\grid\SerialColumn'],
            'name',
            'type',
            'description:ntext',
                        'data:ntext',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAuthItem,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-auth-item']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Auth Item'),
        ],
        'export' => false,
        'columns' => $gridColumnAuthItem
    ]);
}
?>

    </div>
</div>
