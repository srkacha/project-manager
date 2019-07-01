<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Migration */

$this->title = 'Create Migration';
$this->params['breadcrumbs'][] = ['label' => 'Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
