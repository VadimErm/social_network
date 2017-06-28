<?php
namespace api\controllers;

use common\models\User;
use yii\rest\Controller;
use yii\web\Response;

class ValidateController extends Controller
{
    public function actionLogin($username)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $user = User::findByUsername(addslashes($username));

        return $user == null ? ['status' => 'success'] : ['status' => 'fail'];
    }
}
