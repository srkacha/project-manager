<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\Task;
use kartik\tree\TreeView;
use kartik\tree\Module;
use yii\web\View;


$this->title = 'Task';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?=Html::encode($this->title) ?></h1>

    <?php
    echo TreeView::widget([
        'query' => Task::find()->addOrderBy('root, lft'),
        'headingOptions' => ['label' => 'Task'],
        'rootOptions' => ['label' => '<span class="text-primary">Root</span>'],
        'fontAwesome' => false,
        'isAdmin' => true, // @TODO : put your isAdmin getter here
        'displayValue' => 0,
        'cacheSettings' => ['enableCache' => true],
        'nodeAddlViews' => [
            Module::VIEW_PART_2 => '@app/views/task/_form'
        ]
    ]);
    ?>

</div>
