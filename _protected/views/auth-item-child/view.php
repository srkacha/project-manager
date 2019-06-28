<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItemChild */

$this->title = $model->parent;
$this->params['breadcrumbs'][] = ['label' => 'Auth Item Child', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Auth Item Child'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'parent' => $model->parent, 'child' => $model->child], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'parent' => $model->parent, 'child' => $model->child], [
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
        [
            'attribute' => 'parent0.name',
            'label' => 'Parent',
        ],
        [
            'attribute' => 'child0.name',
            'label' => 'Child',
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>AuthItem<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnAuthItem = [
        'name',
        'type',
        'description',
        'rule_name',
        'data',
    ];
    echo DetailView::widget([
        'model' => $model->parent0,
        'attributes' => $gridColumnAuthItem    ]);
    ?>
    <div class="row">
        <h4>AuthItem<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnAuthItem = [
        'name',
        'type',
        'description',
        'rule_name',
        'data',
    ];
    echo DetailView::widget([
        'model' => $model->child0,
        'attributes' => $gridColumnAuthItem    ]);
    ?>
</div>
