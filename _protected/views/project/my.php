<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'My Projects';
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
    </h1>
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'label' => 'Name',
            'format' => 'raw',
            'value'=>function ($model) {
                return Html::a(Html::encode($model->name),'viewmy?id='.$model->id);
    },
        ],
        [
            'attribute' => 'description',
            'contentOptions' => ['style'=>'max-width:100px; min-height:100px; overflow: auto;white-space: normal; word-wrap: break-word;'],
          ],
        [
            'label'=> 'Role',
            'value' => function($model){
                if($model->manager_id == Yii::$app->user->id) return 'Manager';
                foreach($model->supervisors as $supervisor){
                    if($supervisor->user_id == Yii::$app->user->id) return 'Supervisor';
                }
                foreach($model->participants as $part){
                    if($part->user_id == Yii::$app->user->id) return $part->projectRole->name;
                }
            }
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
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->select(['id', new \yii\db\Expression("CONCAT(`name`, ' ', `surname`) as nameAndSurname")])->orderBy('nameAndSurname')->asArray()->all(), 'id', 'nameAndSurname'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'User', 'id' => 'grid-project-search-manager_id']
            ]
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
