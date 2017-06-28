<?php


namespace api\modules\v1\controllers;

use api\modules\v1\models\SignupFormRest;

use common\models\Account;
use common\models\Album;
use common\models\Bookmark;
use common\models\Car;
use common\models\Follower;
use common\models\Journal;
use common\models\Notification;
use common\models\Post;
use Creitive\Breadcrumbs\Breadcrumbs;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\helpers\ArrayHelper;
//use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\User;

class AccountController extends Controller
{
    public $enableCsrfValidation = false;

    public $modelClass = 'Account';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
       /* return array_merge(parent::behaviors(),[
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           =>'http://arba.loc',
                    'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,

                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    HttpBearerAuth::className(),
                ],

            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'allow' => true,
                        'actions' => ['profile', 'index', 'change', 'change-password'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'bootstrap' => [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]

            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'profile'  => ['get'],
                    'index'    => ['get'],
                    'change'   => ['post'],
                    'change-password' => ['put']


                ],
            ]

        ]);*/


        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),

            'authMethods' => [
                HttpBearerAuth::className(),

            ],


        ];

        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['authenticator'] = $auth;
        $behaviors['authenticator']['except'] = ['options'];
        $behaviors['authenticator']['except'] = ['change-online-status'];

        $behaviors['access'] = [
            'class' => AccessControl::className(),

            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['change-online-status'],
                    'roles' => ['?'],
                ],
                [
                    'allow' => true,
                    'actions' => ['profile',  'change', 'change-password'],
                    'roles' => ['@'],
                ],

            ],
        ];

        $behaviors['bootstrap'] = [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
            ]

        ];

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'profile'  => ['get'],
                'index'    => ['get'],
                'change'   => ['post'],
                'change-password' => ['put'],
                'change-online-status' => ['put']


            ],
        ];

        return $behaviors;
    }




    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        return ['status' => 'success', 'user' => $user->username, 'access_token' => $user->getAuthKey()];

    }

    /**Get profile data
     *
     * @param  id
     * @return array
     * @throws NotFoundHttpException
     * @method get
     * /api/v1/account/profile?id = xxx
     */
    public function actionProfile()
    {
        $id = Yii::$app->request->get('id');

       if ($id == null) {
            $id = Yii::$app->user->getId();
            $avatar = Yii::$app->user->identity->avatar;
        } else {
            $avatar = User::findOne($id);

            if ($avatar == null) {
                throw new NotFoundHttpException('User not found');
            }

            $avatar = $avatar->avatar;
        }

        if (empty($avatar)) {
            $avatar = '/images/no-avatar.png';
        }

        $account = $this->getAccount($id);


        try {
            $account = $account->one();
        } catch (\Exception $e) {
            echo 'Neo4j error';
//            throw $e;
            // TODO remove throw, change to pretty error page)
        }

        //Breadcrumbs
        $this->breadcrumbs->addCrumb("My profile");

        $registered = date('d.m.Y', Yii::$app->user->identity->created_at);

        $posts = Post::find()
            ->match("(a:Account{user_id:$id})-[:has_blog]->(b)-[:has_post]->(p) 
                OPTIONAL MATCH (a)-[:has_blog]->(b)-[:has_post]->(p)-[:has_image]->(i) WITH p, a, collect(i) as images
                OPTIONAL MATCH (a)-[:has_blog]->(b)-[:has_post]->(p)-[:has_comment]->(c) WITH p, a, images, collect(c) as comments
                OPTIONAL MATCH (a)-[:has_blog]->(b)-[:has_post]->(p)-[:has_video]->(v) WITH p, a, images, comments,  collect(v) as videos
            ")
            ->get('p,  ID(p) as id, images,  comments,  videos ORDER BY ID(p) DESC ')
            ->all();



        $mainCar = Car::find()
            ->match("(n:Account{user_id:$id})-[:main_car]->(c:Car),  (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, i as images')
            ->one();

        $cars = Car::find()
            ->match("(n:Account{user_id:$id})-[:has_car]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();


        $followers = Follower::getMyFolowersCount();
        $followerAccs = Follower::getFollowers($account->id, true);
        $journals = Journal::getCount();
        $journalsPosts = Journal::getCountOfAllEntries();
        $photos = Album::getPhotoCount();
        $bookmarks = Bookmark::getCount();
        $notifications = Notification::getAll(true);

        $carsArr = [];
        $postsArr = [];
        if(!empty($cars)){
            foreach ($cars as $car) {
                $carsArr[] = $car->asArray();
            }
        }

        if(!empty($posts)){
            foreach ($posts as $post){

                $postsArr[] = $post->asArray();
            }
        }





        $params = [
            'cars' => $carsArr,
            'mainCar' => (!is_null($mainCar)) ? $mainCar->asArray() : null,
            'posts' => $postsArr,
            'account' => (!is_null($account)) ? $account->asArray() : null,
            'followers' => $followers,
            'followerAccs' =>$followerAccs,
            'registered' => $registered,
            //'user' => Yii::$app->user->identity->asArray(),
            'is_premium' => Yii::$app->user->identity->is_premium,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
            'messages' => '',
            'notifications' => $notifications,
            'favorites' => '',
            'journals' => $journals,
            'journals_likes' => '',
            'photos' =>$photos,
            'achievements' =>'',
            'achievements_likes' =>'',
            'bookmarks' => $bookmarks,
            'journals_posts' =>$journalsPosts,

            'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs()

        ];



        return $params ;

    }

    /**
     * @param null|integer $userId
     * @return Account
     */
    protected function getAccount($userId = null)
    {
        if ($userId == null) {
            $userId = Yii::$app->user->getId();
        }

        $myId = Yii::$app->user->getId();

        return Account::find()
            ->match("(n:Account)-[live_in]->(city:City)-[locate]->(country:Country), (n:Account)-[know_language]->(languages:Language) WHERE n.user_id = $userId OPTIONAL MATCH (b:Account)-[r:follow]->(n) WHERE b.user_id =$myId" )

            ->get('n, city, country, r IS NOT NULL as isFollowed, collect(languages) as languages');
    }

    /**
     * Change user's profile
     * @return array
     * @method post
     * /api/v1/account/change
     * Fields:
     * SignupFormRest[username]
     * SignupFormRest[email]
     * SignupFormRest[phone]
     * SignupFormRest[first_name]
     * SignupFormRest[last_name]
     * SignupFormRest[show_real_name]
     * SignupFormRest[gender]
     * SignupFormRest[birthday]
     * SignupFormRest[show_real_birthday]
     * SignupFormRest[languages][]
     * SignupFormRest[country]
     * SignupFormRest[city]
     * SignupFormRest[summary]
     * SignupFormRest[avatarBase64] - in base64
     * SignupFormRest[noAvatar] - set 1  if no avatar
     */
    public function actionChange()
    {


        $signupForm = new SignupFormRest();

        if ($signupForm->load(Yii::$app->request->post()) && $signupForm->change()) {

            return ['status' => 'success', 'access_token' => \Yii::$app->user->identity->getAuthKey()];
        }

        return ['status' => 'fail',  'access_token' => \Yii::$app->user->identity->getAuthKey()];
    }

    /**
     * Change user's password
     * @return array
     * @method put
     * /api/v1/accounts/change-password
     * Fields:
     * password
     * new_password
     * confirm_password
     */
    public function actionChangePassword()
    {

        $password = Yii::$app->getRequest()->getBodyParam('password');
        $passwordHash = \Yii::$app->user->identity->password_hash;
        $newPassword = Yii::$app->getRequest()->getBodyParam('new_password');
        $confirmPassword = Yii::$app->getRequest()->getBodyParam('confirm_password');
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
                    return ['status' => 'success', 'message' => 'Password changed success', 'access_token' => \Yii::$app->user->identity->getAuthKey()];
                }
            } else {
                return ['status' => 'fail', 'message' => 'New password not compare with confirm password', 'access_token' => \Yii::$app->user->identity->getAuthKey()];
            }
        } else {
            return ['status' => 'fail', 'message' => 'Wrong password', 'access_token' => \Yii::$app->user->identity->getAuthKey()];
        }
    }

    /**
     * Change online status
     * @return bool
     * @method PUT
     * @link /api/v1/accounts/change-online-status
     * @param user_id
     * @param is_online - 0 or 1
     */
    public function actionChangeOnlineStatus()
    {
        $userId = Yii::$app->getRequest()->getBodyParam('user_id');
        $isOnline = Yii::$app->getRequest()->getBodyParam('is_online');

        if(Account::changeOnlineStatus($userId, $isOnline)){
            return true;
        } else {
            return false;
        }

    }
}