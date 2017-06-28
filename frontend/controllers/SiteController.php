<?php
namespace frontend\controllers;

use common\models\Account;
use common\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['user']
//                    ],
//                    [
//                        'actions' => ['signup', 'index', 'login', 'verify'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ]
//        ];
//    }
//
//    /**
//     * @inheritdoc
//     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action) {
        if (in_array($action->id, ['login'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(Url::to('/live/#/home'));
        //return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->user->isGuest) {
            return ['status' => 'fail', 'message' => 'Logined'];
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'fail', 'message' => 'Wrong login or password'];
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
       Yii::$app->user->logout();
		
		return $this->redirect(Url::to('/live/#/signout'));
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success',
                    'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionOffline()
    {
        $this->layout = 'offline';

        return $this->render('offline');
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


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
                // User autologin
                Yii::$app->user->login($user, 1);

                return $this->render('signup_confirm');
            } else {
                return $this->render('error', ['message' => 'Please, try again', 'name' => 'Singup error']);
            }
        }

        return $this->render('signup_new', [
            'model' => $model,
        ]);
    }

    public function actionVerify($code)
    {
        $user = User::findOne([
            'auth_key' => $code,
            'status' => User::STATUS_DELETED
        ]);

        if ($user == null) {
            throw new NotFoundHttpException();
        }

        $user->status = User::STATUS_ACTIVE;

        if ($user->save()) {
            if (Yii::$app->user->login($user, true)) {
                return $this->render('signup_confirm_success');
            }

            return $this->redirect(Url::to(['site/login']));
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
