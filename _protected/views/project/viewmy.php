<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\tree\TreeView;
use kartik\tree\Module;
use app\models\Task;
use yii\web\View;

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
            <?php 
                $active = $model->active;
            ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a($active?"Deactivate":"Activate", ['active', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    
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
                'value' => function($model){                   
                    return $model->user->name.' '.$model->user->surname;
                },    
                'label' => 'User'
            ],
            [
                'attribute' => 'projectRole.name',
                'label' => 'Project Role'
            ],
            
    ];
    echo Gridview::widget([
        'summary' => '',
        'dataProvider' => $providerParticipant,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-participant']],
        
        'export' => false,
        'columns' => $gridColumnParticipant
    ]);
}  else echo '<p>No participants on this project.</p>'
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
                            'value' => function($model){                   
                                return $model->user->name.' '.$model->user->surname;
                            },    
                'label' => 'User'
            ],
    ];
    echo Gridview::widget([
        'summary' => '',
        'dataProvider' => $providerSupervisor,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-supervisor']],
        
        'export' => false,
        'columns' => $gridColumnSupervisor
    ]);
} else echo '<p>No supervisors on this project.</p>'
?>
</div>

<div class="row">
<h2>Tasks</h2>
    <?php
        Yii::$app->session->set('rootProjectId', $model->id);
       echo TreeView::widget([
        'query' => Task::find()->where(['project_id' => $model->id])->addOrderBy('root, lft'),
        'headingOptions' => ['label' => 'Tasks'],
        'showIDAttribute' => false,
        'showTooltips' => false,
        'rootOptions' => ['label' => '<span class="text-primary"></span>'],
        'fontAwesome' => false,
        'isAdmin' => false, // @TODO : put your isAdmin getter here
        'displayValue' => 0,
        'cacheSettings' => ['enableCache' => true],
        'nodeAddlViews' => [
            Module::VIEW_PART_2 => '@app/views/task/_form'
        ],
        'iconEditSettings' => ['show' => 'none'],  // to hide the icons list
        'toolbar' => [
            TreeView::BTN_CREATE => [
                'icon' => 'plus',
                'alwaysDisabled' => false,
                'options' => ['title' => 'Add new subtask', 'disabled' => true]
            ],
            TreeView::BTN_CREATE_ROOT => [
                'icon' => 'plus',
                'alwaysDisabled' => false,
                'options' => ['title' => 'Add new root task']
            ],
            TreeView::BTN_REMOVE => [
                'icon' => 'trash',
                'alwaysDisabled' => false,
                'options' => ['title' => 'Delete task', 'disabled' => true]
            ],
            TreeView::BTN_SEPARATOR,
            TreeView::BTN_MOVE_UP => false,
            TreeView::BTN_MOVE_DOWN => false,
            TreeView::BTN_MOVE_LEFT => false,
            TreeView::BTN_MOVE_RIGHT => false,
            TreeView::BTN_REFRESH => false,
        ],
        'i18n' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@kvtree/messages',
            'forceTranslation' => false
        ],
        'options' => ['id' => 'treeID']
    ]);
    ?>
</div>

</div>