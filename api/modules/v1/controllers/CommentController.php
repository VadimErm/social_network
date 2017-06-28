<?php


namespace api\modules\v1\controllers;

use common\helpers\TimeZoneHelper;
use common\models\Account;
use common\models\Comment;
use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class CommentController extends Controller
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
                    'actions' => ['index', 'create', 'update', 'delete', 'spam'],
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

                'index'    => ['get'],
                'create'   => ['post'],
                'delete'   => ['delete'],
                'update'   => ['patch'],
                'spam'     => ['put']



            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return ['status' =>'success'];
    }

    /**
     * Create new comment
     * @return array
     * @method post
     * /api/v1/comments
     * Fields:
     * Comment[node_id]
     * Comment[message]
     * Comment[answer_comment_id] - if user answer in comments to another user's comment
     *
     */

    public function actionCreate()
    {
        $userId = \Yii::$app->user->id;
        $comment = new Comment();
        $time = time();

        $comment->created_at = $time;
        $comment->user_id = $userId;


        if ($comment->load(\Yii::$app->request->post()) && $newComment = $comment->insert()) {

            if(!empty($comment->answer_comment_id)){
                $answerComment = Comment::find()->match('(c:Comment) WHERE ID(c)='.$comment->answer_comment_id)->get('c')->one();
                $answerUserId = $answerComment->user_id;
                $answerAccount = Account::find()->match('(n:Account) WHERE n.user_id='.$answerUserId)->get('n')->one();
            } else {
                $answerAccount = null;
            }

           // $newComment->created_at = TimeZoneHelper::getTime('d.m.Y, h:i a', $newComment->created_at);
            $newComment->account = $newComment->getAccount();

            return [
                'status' => 'success',
                'comment' => $newComment->asArray(),

                'answerAccount' => (!is_null($answerAccount)) ? $answerAccount->asArray() : null,

                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];

        }

        return [
            'status' =>'fail',
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Mark comment as spam
     * @return array
     * @method PUT
     * @param comment_id
     * @link /api/v1/comments/spam
     */
    public function actionSpam()
    {
        $commentId = Yii::$app->getRequest()->getBodyParam('comment_id');

        if(Comment::spam($commentId)){

            return [
                'status' =>'success',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            return [
                'status' =>'fail',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }
    }

}