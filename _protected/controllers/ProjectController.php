<?php

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\Expense;
use app\models\Income;
use app\models\User;
use app\models\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends AppController
{
    

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists logged in users Project models.
     * @return mixed
     */
    public function actionMy()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne(['id' => $userId]);
        $searchModel = new ProjectSearch();

        //preparing the data, filtering only the projects that the logged in user is on
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $filteredModels = array_filter($dataProvider->models, function($obj) use(&$user) {
            return $user->isUserManagerOrSupervisor($obj->id);
        });
        $dataProvider->models = $filteredModels;

        return $this->render('my', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerExpense = new \yii\data\ArrayDataProvider([
            'allModels' => $model->expenses,
        ]);
        $providerIncome = new \yii\data\ArrayDataProvider([
            'allModels' => $model->incomes,
        ]);
        $providerObservation = new \yii\data\ArrayDataProvider([
            'allModels' => $model->observations,
        ]);
        $providerParticipant = new \yii\data\ArrayDataProvider([
            'allModels' => $model->participants,
        ]);
        $providerSupervisor = new \yii\data\ArrayDataProvider([
            'allModels' => $model->supervisors,
        ]);
        $providerTask = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tasks,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerExpense' => $providerExpense,
            'providerIncome' => $providerIncome,
            'providerObservation' => $providerObservation,
            'providerParticipant' => $providerParticipant,
            'providerSupervisor' => $providerSupervisor,
            'providerTask' => $providerTask,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionFinance($id){
        $model = $this->findModel($id);

        $user = User::findOne(['id' => Yii::$app->user->id]);
        $role = $user->userRoleOnProject($id);

        $totalIncome = 0;
        foreach($model->incomes as $inc) $totalIncome += $inc->amount;

        $totalOutcome = 0;
        foreach($model->expenses as $ex) $totalOutcome += $ex->amount;

        $providerExpense = new \yii\data\ArrayDataProvider([
            'allModels' => $model->expenses,
        ]);
        $providerIncome = new \yii\data\ArrayDataProvider([
            'allModels' => $model->incomes,
        ]);
        return $this->render('finance', [
            'role' => $role,
            'model' => $model,
            'providerExpense' => $providerExpense,
            'providerIncome' => $providerIncome,
            'totalOutcome' => $totalOutcome,
            'totalIncome' => $totalIncome
        ]);
    }

   

    /**
     * Displays a single Project model, if the logged in user is on the project
     * @param integer $id
     * @return mixed
     */
    public function actionViewmy($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne(['id' => Yii::$app->user->id]);
        //check if user is on the project, if not redirect to projects index page
        if(!$user->isUserManagerOrSupervisor($model->id)){
            return $this->redirect('my');
        }
        $role = $user->userRoleOnProject($model->id);
        $providerExpense = new \yii\data\ArrayDataProvider([
            'allModels' => $model->expenses,
        ]);
        $providerIncome = new \yii\data\ArrayDataProvider([
            'allModels' => $model->incomes,
        ]);
        $providerObservation = new \yii\data\ArrayDataProvider([
            'allModels' => $model->observations,
        ]);
        $providerParticipant = new \yii\data\ArrayDataProvider([
            'allModels' => $model->participants,
        ]);
        $providerSupervisor = new \yii\data\ArrayDataProvider([
            'allModels' => $model->supervisors,
        ]);
        $providerTask = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tasks,
        ]);

        $projectProgress = $this->calculateProjectProgress($model);

        return $this->render('viewmy', [
            'projectProgress' => $projectProgress,
            'role' => $role,
            'model' => $this->findModel($id),
            'providerExpense' => $providerExpense,
            'providerIncome' => $providerIncome,
            'providerObservation' => $providerObservation,
            'providerParticipant' => $providerParticipant,
            'providerSupervisor' => $providerSupervisor,
            'providerTask' => $providerTask,
        ]);
    }

    //Calculating the project progress
    //returns string info of task completition and aprox percentage completititon
    private function calculateProjectProgress($model){
        $tasks = \app\models\base\Task::find()->where(['project_id' => $model->id])->all();
        $totalTasks = 0;
        $totalHours = 0;
        $totalhoursDone = 0;
        $tasksDone = 0;
        foreach($tasks as $task){
            $totalTasks++;
            $taskActivities = \app\models\base\Activity::find()->where(['task_id' => $task->id])->all();
            $man_hours = $task->man_hours;
            $totalHours += $man_hours;
            $sum_of_hours_done = 0;
            foreach($taskActivities as $activity){
                $progress = \app\models\base\ActivityProgress::find()->where(['activity_id' => $activity->id])->all();
                foreach($progress as $singleProgress){
                    $sum_of_hours_done += $singleProgress->hours_done;
                }
            }
            $totalhoursDone += $sum_of_hours_done;
            $result = ($sum_of_hours_done/$man_hours)*100;
            if ($result >= 100) $tasksDone++;
        }
        if($totalTasks == 0) return 'No tasks on this project yet';
        return $tasksDone.'/'.$totalTasks.' tasks done, about '.round(($totalhoursDone/$totalHours)*100, 2).'% activites done';
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Project model.
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

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateFinance($id)
    {
        $model = $this->findModel($id);
        if($model->updateFinance($_POST)){
            return $this->redirect(['finance', 'id' => $id]);
        }
        else return $this->redirect(['/']);

        
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->active = $model->active == 1?0:1;

        if ($model->update()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->redirect(['error', 'id' => $model->id]);
        }
    }

    /**
     * Deletes an existing Project model.
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
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Expense
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddExpense()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Expense');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formExpense', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Income
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddIncome()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Income');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formIncome', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Observation
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddObservation()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Observation');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formObservation', ['row' => $row]);
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
    
    /**
    * Action to load a tabular form grid
    * for Supervisor
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddSupervisor()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Supervisor');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formSupervisor', ['row' => $row]);
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
}
