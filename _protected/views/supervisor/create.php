<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Supervisor */

$this->title = 'Create Supervisor';
$this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supervisor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
