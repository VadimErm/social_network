<?php

namespace common\modules\blog\controllers;

use common\helpers\TimeZoneHelper;
use common\models\Comment;
use common\models\Account;
use common\models\Post;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function actionAddComment()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

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

            $newComment->created_at = TimeZoneHelper::getTime('d.m.Y, h:i a', $newComment->created_at);

            return ['status' => 'success',
                'comment' => json_encode($newComment),
                'account' => json_encode(Account::find()
                    ->match('(n:Account{user_id:'.\Yii::$app->user->getId().'})')
                    ->get('n')
                    ->one()),
                'answerAccount' => json_encode($answerAccount),
                'avatar' => \Yii::$app->user->getIdentity()->avatar];
        }
    }

    public function actionRemoveComment($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $comment = Comment::find()
            ->match("(n) WHERE ID(n) = $id OPTIONAL MATCH (n)-[r]-() DELETE n,r")
            ->one();

        return ['status' => 'success'];
    }

    public function actionRemovePost($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Post::find()
            ->match("(n) WHERE ID(n) = $id OPTIONAL MATCH (n)-[r]-() DELETE n,r")
            ->one();

        return ['status' => 'success'];
    }


}