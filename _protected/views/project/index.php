<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="project-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
            <?= Html::a(Yii::t('app', 'Create Project'), ['create'], ['class' => 'btn btn-danger']) ?>
        </span>         
    </h1>
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'name',
        'description',
        [
            'value'=> function($model){                   
                return $model->active == '1'?'Yes':'No';                   
            },
            'label' => 'Active'
        ],
        'started',
        'deadline',
        [
                'attribute' => 'manager_id',
                'label' => 'Manager',
                'value' => function($model){                   
                    return $model->manager->name.' '.$model->manager->surname;                   
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->asArray()->all(), 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'User', 'id' => 'grid-project-search-manager_id']
            ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Menu',
            'template' => '{view} {update}',
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-project']],
        
        'export' => false,
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_PDF => false
                ]
            ]) ,
        ],
    ]); ?>

</div>
