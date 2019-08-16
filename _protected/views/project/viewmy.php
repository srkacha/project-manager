<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\tree\TreeView;
use kartik\tree\Module;
use app\models\Task;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Project */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Expense', 
        'relID' => 'expense', 
        'value' => \yii\helpers\Json::encode($model->expenses),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Income', 
        'relID' => 'income', 
        'value' => \yii\helpers\Json::encode($model->incomes),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);

?>
<div class="project-view">
    <div class="row">
        <div class="col-sm-9">
            <h1><?=Html::encode($this->title) ?>
            <span class="pull-right">
            <?= $role !='participant'?Html::a(Yii::t('app', 'Project finance'), ['finance?id='.$model->id], ['class' => 'btn btn-primary']):"" ?>
            <?= Html::a(Yii::t('app', 'Back to all projects'), ['/project/my'], ['class' => 'btn btn-primary'])?>
        </span>  </h1>    
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
        </div>
    </div>

    <div class="row">
<?php 
    $managerNameAndSurname = $model->manager->name .' '. $model->manager->surname;
    $active = $model->active == '1'?'Yes':'No';
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
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
        [
            'label' => 'Progress',
            'value' => $projectProgress
        ]
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
        'pjax' => false,
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
        'pjax' => false,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-supervisor']],
        
        'export' => false,
        'columns' => $gridColumnSupervisor
    ]);
} else echo '<p>No supervisors on this project.</p>'
?>
</div>

<div class="row">
<h2>Tasks</h2>
    <?php echo $role?>
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
                'alwaysDisabled' => $role == 'manager'?false:true,
                'options' => ['title' => 'Add new subtask', 'disabled' => true]
            ],
            TreeView::BTN_CREATE_ROOT => [
                'icon' => 'plus',
                'alwaysDisabled' => $role == 'manager'?false:true,
                'options' => ['title' => 'Add new root task']
            ],
            TreeView::BTN_REMOVE => [
                'icon' => 'trash',
                'alwaysDisabled' => $role == 'manager'?false:true,
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
    ]);
    ?>
</div>

</div>