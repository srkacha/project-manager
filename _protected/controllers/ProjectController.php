<?php

namespace app\controllers;

use Yii;
use app\models\Project;
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
        $searchModel = new ProjectSearch();

        //preparing the data, filtering only the projects that the logged in user is on
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $filteredModels = array_filter($dataProvider->models, function($obj){
            return $this->isUserOnProject(Yii::$app->user->id, $obj);
        });
        $dataProvider->models = $filteredModels;


        return $this->render('my', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //helper function to check if the user is one of the participants on the project
    private function isUserParticipant($userId, $participants){
        foreach($participants as $part){
            if($part->user_id == $userId) return true;
        }
        return false;
    }

    //helper function to check if the user is one of the supervisors on the project
    private function isUserSupervisor($userId, $supervisors){
        foreach($supervisors as $supervisor){
            if($supervisor->user_id == $userId) return true;
        }
        return false;
    }

    private function isUserOnProject($userId, $project){
        if($project->manager_id == $userId) return true;
        if($this->isUserParticipant($userId, $project->participants)) return true;
        if($this->isUserSupervisor($userId, $project->supervisors)) return true;
        return false;
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

    private function userRoleOnProject($userId, $project){
        if($project->manager_id == $userId) return 'manager';
        if($this->isUserSupervisor($userId, $project->supervisors)) return 'supervisor';
        if($this->isUserParticipant($userId, $project->participants)) return 'participant';
        return 'none';
    }

    /**
     * Displays a single Project model, if the logged in user is on the project
     * @param integer $id
     * @return mixed
     */
    public function actionViewmy($id)
    {
        $model = $this->findModel($id);
        //check if user is on the project, if not redirect to projects index page
        if(!$this->isUserOnProject(Yii::$app->user->id, $model)){
            return $this->redirect('my');
        }
        $role = $this->userRoleOnProject(Yii::$app->user->id, $model);
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
        return $this->render('viewmy', [
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
