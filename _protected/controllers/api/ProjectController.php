<?php
namespace app\controllers\api;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Participant;
use app\models\Project;
use yii\web\UnauthorizedHttpException;
use Yii;

class ProjectController extends ActiveController{

    public $modelClass = 'app\models\Project';


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

    public function actionGetProjectsForUserId(){
        if(isset($_POST['user_id'])){
            $user_id = $_POST['user_id'];
            $participation_list = Participant::find()->where(['user_id' => $user_id])->all();
            $projects = [];
            foreach($participation_list as $iterator){
                if($iterator->project->active == 1){
                    $projects[] = $iterator->project;
                }
            }
            return $projects;
        }else{
            Yii::$app->response->statusCode = 404;
            throw new UnauthorizedHttpException;
        }
    }
}

?>