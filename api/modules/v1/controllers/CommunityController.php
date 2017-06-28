<?php
/**
 * Created by PhpStorm.
 * User: tolkin
 * Date: 19.05.17
 * Time: 15:59
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class CommunityController extends Controller
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
                    'actions' => [
                        'index',
                        'create',
                        'update',
                        'view',
                        'delete',
                        'user-journals',
                        'members',
                        'remove-from-community',
                        'remove-from-moderators',
                        'add-to-blacklist'
                    ],
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

                'index' => ['get'],
                'create' => ['post'],
                'update' => ['patch'],
                'view' => ['get'],
                'delete' => ['delete'],
                'user-journals' => ['get']


            ],
        ];

        return $behaviors;
    }

    /**
     * Get list of communities with filtering by get parameter sort, skip, limit, country, city, title
     * @return array
     * @method get
     * /api/v1/community?sort=xxx&skip=xxx&limit=xxx&city=xxx&country=xxx&title=xxx
     *
     */
    public function actionIndex()
    {
        return [
            'status' => 'success',
            'communities' => [],
            'sort' => $_GET['sort'],
            'title' => $_GET['title'],
            'country' => $_GET['country'],
            'city' => $_GET['city'],
            'skip' => $_GET['skip'],
            'limit' => $_GET['limit'],
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Create new community
     * @return array
     * @method post
     * /api/v1/communities
     * Fields:
     * CommunityRest[title]
     * CommunityRest[type]
     * CommunityRest[website]
     * CommunityRest[language][]
     * CommunityRest[country]
     * CommunityRest[city]
     * CommunityRest[about]
     * CommunityRest[avatar] - in base64
     * CommunityRest[cover] - in base64
     * /api/v1/community/create
     */
    public function actionCreate()
    {
        return [
            'status' => 'success',
            'community' => [],
            'title' => $_POST['title'],
            'type' => $_POST['type'],
            'website' => $_POST['website'],
            'language' => $_POST['language'],
            'country' => $_POST['country'],
            'city' => $_POST['city'],
            'about' => $_POST['about'],
            'avatar' => $_POST['avatar'],
            'cover' => $_POST['cover'],
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }


    /**
     * View community by $id
     * @param $id
     * @return array
     * @method get
     * /api/v1/communities/$id
     */
    public function actionView($id)
    {
        return [
            'status' => 'success',
            'community' => [],
            'id' => $id,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Update community
     * @return array
     * @method patch
     * /api/v1/communities
     * Fields:
     * CommunityRest[title]
     * CommunityRest[type]
     * CommunityRest[website]
     * CommunityRest[language][]
     * CommunityRest[country]
     * CommunityRest[city]
     * CommunityRest[about]
     * CommunityRest[images] - in base64
     * CommunityRest[cover] - in base64
     */
    public function actionUpdate()
    {

        return [
            'status' => 'success',
            'id' => Yii::$app->getRequest()->getBodyParam('id'),
            'community' => [],
            'title' => Yii::$app->getRequest()->getBodyParam('title'),
            'type' => Yii::$app->getRequest()->getBodyParam('type'),
            'website' => Yii::$app->getRequest()->getBodyParam('type'),
            'language' => Yii::$app->getRequest()->getBodyParam('language'),
            'country' => Yii::$app->getRequest()->getBodyParam('country'),
            'city' => Yii::$app->getRequest()->getBodyParam('city'),
            'about' => Yii::$app->getRequest()->getBodyParam('about'),
            'images' => Yii::$app->getRequest()->getBodyParam('images'),
            'cover' => Yii::$app->getRequest()->getBodyParam('cover'),
            'rules' => Yii::$app->getRequest()->getBodyParam('rules'),
            'users' => Yii::$app->getRequest()->getBodyParam('users'),
            'blacklist' => Yii::$app->getRequest()->getBodyParam('blacklist'),
            'moderators' => Yii::$app->getRequest()->getBodyParam('moderators'),
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Delete community by $id
     * @param $id
     * @return array
     * @method delete
     * /api/v1/communities/$id
     */
    public function actionDelete($id)
    {
        return [
            'status' => 'success',
            'id' => Yii::$app->getRequest()->getBodyParam($id),
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * View community members
     * @param $id , $query
     * @return array
     * @method get
     * /api/v1/community/members/$id
     */
    public function actionMembers($id, $query, $limit, $skip)
    {
        if (!empty($query)) {
            $queryReturn = $_GET['query'];
        } else {
            $queryReturn = null;
        }

        return [
            'status' => 'success',
            'skip' => $skip,
            'limit' => $limit,
            'id' => $id,
            'query' => $queryReturn,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Add user to community blacklist
     *
     * @param $id
     * @return array
     * /api/v1/add-to-blacklist/$id
     */
    public function actionAddToBlacklist($id)
    {
        return [
            'status' => 'success',
            'id' => $id,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Remove user from moderators
     *
     * @param $id
     * @return array
     * /api/v1/remove-from-moderators/$id
     */
    public function actionRemoveFromModerators($id)
    {
        return [
            'status' => 'success',
            'id' => $id,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Remove user from community
     *
     * @param $id
     * @return array
     * /api/v1/remove-from-community/$id
     */
    public function actionRemoveFromCommunity($id)
    {
        return [
            'status' => 'success',
            'id' => $id,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

}