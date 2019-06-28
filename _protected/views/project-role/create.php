<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProjectRole */

$this->title = 'Create Project Role';
$this->params['breadcrumbs'][] = ['label' => 'Project Role', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
