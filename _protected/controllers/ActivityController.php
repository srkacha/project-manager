<?php

namespace app\controllers;

use Yii;
use app\models\Activity;
use app\models\User;
use app\models\ActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
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
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Activity model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerActivityParticipant = new \yii\data\ArrayDataProvider([
            'allModels' => $model->activityParticipants,
        ]);

        $user = User::findOne(['id' => Yii::$app->user->id]);
        $task = \app\models\Task::findOne(['id' => $model->task_id]);
        $role = $user->userRoleOnProject($task->project_id);
        $providerActivityProgress = new \yii\data\ArrayDataProvider([
            'allModels' => \app\models\ActivityProgress::find()->where(['activity_id' => $id])->all()
        ]);
        return $this->render('view', [
            'role' => $role,
            'model' => $this->findModel($id),
            'providerActivityParticipant' => $providerActivityParticipant,
            'providerActivityProgress' => $providerActivityProgress,
        ]);
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionFinished($id)
    {
        $model = $this->findModel($id);
        $model->finished = $model->finished == 1?0:1;

        if ($model->update()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->redirect(['error', 'id' => $model->id]);
        }
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for ActivityParticipant
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddActivityParticipant()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ActivityParticipant');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formActivityParticipant', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
