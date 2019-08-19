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

class TaskController extends ActiveController{

    public $modelClass = 'app\models\Task';


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
}

?>