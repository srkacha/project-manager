<?php
namespace app\controllers\api;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\LoginForm;
use yii\web\UnauthorizedHttpException;
use Yii;

class UserController extends ActiveController{

    public $modelClass = 'app\models\User';


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

    public function actionJova(){
        return ['jova' => 'pero'];
    }

    public function actionLogin(){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $login = new LoginForm();
            $login->username = $_POST['username'];
            $login->password = $_POST['password'];
            $success = true;

            //we try to login
            if (!$login->login()) {
                $success = false;
            }

            if($success){
                //we return the logged in user data
                return $login->getUser();
            }else return new UnauthorizedHttpException;

        }else{
            //we are throwing the error because the request doesnt have the requested params
            Yii::$app->response->statusCode = 404;
            throw new UnauthorizedHttpException;
        }
    }
}

?>