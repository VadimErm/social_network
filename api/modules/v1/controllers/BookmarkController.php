<?php


namespace api\modules\v1\controllers;

use common\models\Account;
use common\models\Bookmark;
use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
//use yii\rest\Controller;
use yii\web\Response;

class BookmarkController extends Controller
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],

        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [

                [
                    'allow' => true,
                    'actions' => ['index',  'search', 'delete', 'add', 'count'],
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

                'index'         => ['get'],
                'delete'        => ['delete'],
                'search'        => ['get'],
                'add'           => ['put'],
                'count'         => ['get']


            ],
        ];

        return $behaviors;
    }

    /**
     * Get list of bookmarks
     * @return array
     * @method get
     * /api/v1/bookmarks
     */
    public function actionIndex()
    {
        $this->breadcrumbs->addCrumb("My profile", '/api/v1/account/profile');
        $this->breadcrumbs->addCrumb("My bookmarks");

        $bookmarks = Bookmark::getAll(true);


        return [
            'status' => 'success',
            'bookmarks' => $bookmarks,
            'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs(),
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }
    /**
     * Add new bookmark on user/car/blog/car journal/community depending on the $type
     * @param $type integer - type on what user add bookmark
     * @param $id - id of user/car/blog/car journal/community
     * @return array
     * @method put
     * /api/v1/bookmarks/add/$type/$id
     */
    public function actionAdd($type, $id)
    {
        $bookmark = new Bookmark();


        if($bookmark->add($type, $id)){
            return [
                'status' =>'success',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' =>'fail',
            'error' => 'You are bookmarked alredy',
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];


    }

    /**
     * Get bookmarks count
     * @return array
     * @method GET
     * /api/v1/bookmarks/count
     */
    public function actionCount()
    {
        if($count = Bookmark::getCount()){
            return [
                'status' =>'success',
                'bookmark_count' => $count,
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' => 'success',
            'bookmark_count' => 0,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }


    /**
     * Delete bookmark by $id
     * @param $id integer - id of what user was bookmarked
     * @return array
     * @method delete
     * /api/v1/bookmarks/$id
     */
    public function actionDelete($id)
    {

       if(!Bookmark::deleteBookmark($id)){
           return [
               'status' =>'fail',
               'access_token' => Yii::$app->user->identity->getAuthKey()
           ];
       }


        return [
            'status' =>'success',
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Search bookmarks  by $_GET query
     * @return array
     * @method get
     * /api/v1/bookmarks/search?query=xxx
     */
    public function actionSearch()
    {
        if(!empty($_GET)){
            $query = $_GET;

            return [
                'status' => 'success',
                'bookmarks' => [],
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' => 'fail',
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

}