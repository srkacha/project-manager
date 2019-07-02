<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ActivityProgress */

$this->title = 'Create Activity Progress';
$this->params['breadcrumbs'][] = ['label' => 'Activity Progresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-progress-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
