<?php

namespace common\widgets\comment;

use common\models\Account;
use common\models\Comment;
use yii\base\Widget;

class CommentWidget extends Widget
{
    public $comment;
    public $post;

    public function run()
    {
        $account =Account::find()->match('(n:Account) WHERE n.user_id='.$this->comment->user_id)->get('n')->one();

        if(!empty($this->comment->answer_comment_id)){
            $answerComment = Comment::find()->match('(c:Comment) WHERE ID(c)='.$this->comment->answer_comment_id)->get('c')->one();
            $answerUserId = $answerComment->user_id;
            $answerAccount = Account::find()->match('(n:Account) WHERE n.user_id='.$answerUserId)->get('n')->one();
        } else {
            $answerAccount = null;
        }


        return $this->render('comment', [
            'account' => $account,
            'comment' => $this->comment,
            'post' => $this->post,
            'answerAccount' => $answerAccount
        ]);
    }

}