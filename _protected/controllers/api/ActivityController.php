<?php
namespace app\controllers\api;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Participant;
use app\models\Project;
use app\models\Activity;
use app\models\TaskParticipant;
use app\models\ActivityParticipant;
use app\models\ActivityProgress;
use yii\web\UnauthorizedHttpException;
use Yii;

class ActivityController extends ActiveController{

    public $modelClass = 'app\models\Activity';


    ///added to make the response format json by default
    public function behaviors()
    {
      return ArrayHelper::merge(parent::behaviors(), [
          [
              'class' => 'yii\filters\ContentNegotiator',
              'only' => ['view', 'index'],  // in a controller
              // if in a module, use the following IDs for user actions
              // 'only' => ['user/view', 'user/index']
              'formats' => [
                  'application/json' => Response::FORMAT_JSON,
              ],
              'languages' => [
                  'en',
                  'de',
              ],
          ],
      ]);
    }

    public function actionGetActivitiesForProjectAndUser(){
        if(isset($_POST['user_id']) && isset($_POST['project_id'])){
            $project_id = $_POST['project_id'];
            $user_id = $_POST['user_id'];
            $activities = [];
            $participant = Participant::findOne(['user_id' => $user_id, 'project_id' => $project_id]);
            if($participant == null) return null;
            $taskParticipants = TaskParticipant::find()->where(['participant_id' => $participant->id])->all();
            $activities = [];
            foreach($taskParticipants as $taskParticipant){
                $taskActivityParticipants = ActivityParticipant::find()->where(['task_participant_id' => $taskParticipant->id])->all();
                foreach($taskActivityParticipants as $tap){
                    $activities[] = $tap->activity;
                }
            }
            return $activities;
        }else{
            Yii::$app->response->statusCode = 404;
            throw new UnauthorizedHttpException;
        }
    }

    public function actionAddProgressForActivity(){

    }
}

?>