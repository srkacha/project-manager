<div class="form-group" id="add-participant">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Participant',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'user_id' => [
            'label' => 'User',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->select(['id', new \yii\db\Expression("CONCAT(`name`, ' ', `surname`) as nameAndSurname")])->orderBy('nameAndSurname')->asArray()->all(), 'id', 'nameAndSurname'),
                'options' => ['placeholder' => 'Choose User'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'project_role_id' => [
            'label' => 'Project role',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\ProjectRole::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Choose Project role'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowParticipant(' . $key . '); return false;', 'id' => 'participant-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Participant', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowParticipant()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

