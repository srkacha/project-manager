<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\User */
$this->title = 'My account';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?= Html::a(Yii::t('app', 'Update'), ['editme', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            
        </div>
    </h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'surname',
            'username',
            'email:email',
            //'password_hash',
            [
                'attribute'=>'status',
                'value' => '<span class="'.CssHelper::userStatusCss($model->status).'">
                                '.$model->getStatusName($model->status).'
                            </span>',
                'format' => 'raw'
            ],
            [
                'attribute'=>'item_name',
                'value' => '<span class="'.CssHelper::roleCss($model->getRoleName()).'">
                                '.$model->getRoleName().'
                            </span>',
                'format' => 'raw'
            ],
            //'auth_key',
            //'password_reset_token',
            //'account_activation_token',
           
        ],
    ]) ?>

</div>