<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $percentageDone = $this->calculatePercentageDone($model);
        $user = User::findOne(['id' => Yii::$app->user->id]);
        $role = $user->userRoleOnProject($model->project_id);
        $providerActivity = new \yii\data\ArrayDataProvider([
            'allModels' => $model->activities,
        ]);
        $subtasks = \app\models\base\Task::find()->where(['>', 'lft', $model->lft])->andWhere(['<', 'rgt', $model->rgt])->andWhere(['lvl' => $model->lvl + 1])->andWhere(['root' => $model->root])->all();
        
        $providerTask = new \yii\data\ArrayDataProvider([
            'allModels' => $subtasks,
        ]);
        $providerTaskParticipant = new \yii\data\ArrayDataProvider([
            'allModels' => $model->taskParticipants,
        ]);
        return $this->render('view', [
            'percentageDone' => $percentageDone,
            'role' => $role,
            'model' => $this->findModel($id),
            'providerActivity' => $providerActivity,
            'providerTask' => $providerTask,
            'providerTaskParticipant' => $providerTaskParticipant,
        ]);
    }

    //Calculates the percentage done on a task
    private function calculatePercentageDone($model){
        if($model->man_hours <= 0) return 0;
        $taskActivities = \app\models\base\Activity::find()->where(['task_id' => $model->id])->all();
        $man_hours = $model->man_hours;
        $sum_of_hours_done = 0;
        $activites_done = 0;
        $total_activities = sizeof($model->activities);
        foreach($taskActivities as $activity){
            if($activity->finished) $activites_done++;
            $progress = \app\models\base\ActivityProgress::find()->where(['activity_id' => $activity->id])->all();
            foreach($progress as $singleProgress){
                $sum_of_hours_done += $singleProgress->hours_done;
            }
        }
        $result = ($sum_of_hours_done/$man_hours)*100;
        if ($result > 100) $result = 100;
        $result = round($result, 2);
        return $result.', '.$activites_done.'/'.$total_activities.' activities finished';
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();
        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionUpdate()
    {
        
        $model = $this->findModel(Yii::$app->request->post('Task')['id']);
        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('sdff', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateDetails($id){
        $model = $this->findModel($id);
        if($model->updateWhole($_POST)){
            return $this->redirect(['view', 'id' => $id]);
        }
        else return $this->render('details', [
            'model' => $model
        ]);
    }


    /**
     * Deletes an existing Task model.
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
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Activity
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddActivity()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Activity');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formActivity', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Task
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddTask()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Task');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTask', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for TaskParticipant
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddTaskParticipant($project_id=0)
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TaskParticipant');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTaskParticipant', ['row' => $row, 'project_id'=>$project_id]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}