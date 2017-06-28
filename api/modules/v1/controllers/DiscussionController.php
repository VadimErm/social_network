<?php
/**
 * Created by PhpStorm.
 * User: tolkin
 * Date: 22.05.17
 * Time: 17:32
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use api\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\Response;

class DiscussionController extends Controller
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
                    'actions' => ['index', 'create', 'view', 'delete', 'add'],
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
                'add'           => ['post']


            ],
        ];

        return $behaviors;
    }

    public function actionIndex($id, $skip, $limit)
    {
        return [
            'status' =>'success',
            'id' => $id,
            'skip' => $skip,
            'limit' => $limit,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }


    /**
     * Create new Discussion
     * @return array
     * @method post
     * /api/v1/discussion
     * Fields:
     * DiscussionRest[title]
     * DiscussionRest[language][]
     * DiscussionRest[text]
     * DiscussionRest[video] - in base64
     * DiscussionRest[image] - in base64
     */
    public function actionCreate()
    {
        return [
            'status' =>'success',
            'title' => $_POST['title'],
            'text' => $_POST['text'],
            'language' => $_POST['language'],
            'video' => $_POST['video'],
            'image' => $_POST['image'],
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
    * View discussion by $id
    * @param $id
    * @return array
    * @method get
    * /api/v1/discussion/view/$id
    */
    public function actionView($id, $limit, $skip)
    {
        return [
            'status' => 'success',
            'discussion' => [],
            'id' => $id,
            'limit' => $limit,
            'skip' => $skip,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Create new post
     * @return array
     * @method post
     * /api/v1/discussion
     * Fields:
     * DiscussionRest[text]
     * DiscussionRest[video]
     * DiscussionRest[image] - in base64
     */
    public function actionAdd()
    {
        return [
            'status' =>'success',
            'text' => $_POST['text'],
            'video' => $_POST['video'],
            'image' => $_POST['image'],
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }
}