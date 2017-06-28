<?php
namespace api\controllers;

use common\models\LoginForm;
use common\models\User;
use frontend\models\SignupForm;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    /*public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className()
        ];

        return $behaviors;
    }*/

    public function actionLogin()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if(Yii::$app->request->isPost) {

            $model = new LoginForm();
            if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
                return ['access_token' => Yii::$app->user->identity->getAuthKey()];
            } else {

                return ['status' => 'error', 'message' => 'Wrong username or password'];;
            }

        }


        return ['status' => 'wrong', 'message' => 'Wrong HTTP method, POST needed'];
    }

    public function actionChange()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $signupForm = new SignupForm();

        if (Yii::$app->request->isPatch && $signupForm->load(Yii::$app->request->post())) {
            $signupForm->change();

            return ['status' => 'success'];
        }

        return ['status' => 'error', 'message' => 'Wrong HTTP method, POST needed'];
    }

    public function actionSignup()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new SignupForm();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {
            /**
             * @var $user User
             */
            if ($user = $model->signup()) {
                $text = $this->renderPartial('confirm_email_text', [
                    'link' => Yii::$app->request->hostInfo . Url::to([
                            '/site/verify',
                            'code' => $user->auth_key
                        ]),
                    'username' => $user->username,
                    'firstname' => Yii::$app->request->post('SignupForm')['first_name']
                ]);

                Yii::$app->mailer->compose()
                    ->setTo($user->email)
                    ->setFrom('do-not-reply@arba.ae')
                    ->setSubject("Subject: {$user->username} , confirm your account at arba.ae")
                    ->setTextBody($text)
                    ->send();

                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => 'Please, try again', 'name' => 'Singup error'];
            }
        }
    }

    public function actionChangePassword()
    {
        $password = \Yii::$app->request->post('password');
        $passwordHash = \Yii::$app->user->identity->password_hash;
        $newPassword = \Yii::$app->request->post('new_password');
        $confirmPassword = \Yii::$app->request->post('confirm_password');
        $security = \Yii::$app->security;

        if ($security->validatePassword($password, $passwordHash)) {
            // all ok
            if ($password == $confirmPassword) {
                return ['status' => 0, 'msg' => 'Password must not be the same NewPassword'];
            }

            if ($newPassword == $confirmPassword) {
                // Change password
                $identity = \Yii::$app->user->identity;
                $passwordHash = $security->generatePasswordHash($newPassword);
                $identity->password_hash = $passwordHash;

                if ($identity->update()) {
                    return ['status' => 1, 'msg' => 'Password changed success'];
                }
            } else {
                return ['status' => 0, 'msg' => 'New password not compare with confirm password'];
            }
        } else {
            return ['status' => 0, 'msg' => 'Wrong password'];
        }
    }
}
