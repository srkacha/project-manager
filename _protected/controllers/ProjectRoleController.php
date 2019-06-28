<?php

namespace app\controllers;

use Yii;
use app\models\ProjectRole;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectRoleController implements the CRUD actions for ProjectRole model.
 */
class ProjectRoleController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProjectRole models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProjectRole::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectRole model.
     * @param integer $id
     * @param string $name
     * @return mixed
     */
    public function actionView($id, $name)
    {
        $model = $this->findModel($id, $name);
        $providerParticipant = new \yii\data\ArrayDataProvider([
            'allModels' => $model->participants,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id, $name),
            'providerParticipant' => $providerParticipant,
        ]);
    }

    /**
     * Creates a new ProjectRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectRole();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id, 'name' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $name
     * @return mixed
     */
    public function actionUpdate($id, $name)
    {
        $model = $this->findModel($id, $name);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id, 'name' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectRole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $name
     * @return mixed
     */
    public function actionDelete($id, $name)
    {
        $this->findModel($id, $name)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the ProjectRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $name
     * @return ProjectRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $name)
    {
        if (($model = ProjectRole::findOne(['id' => $id, 'name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Participant
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddParticipant()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Participant');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formParticipant', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
