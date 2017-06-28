<?php
use \yii\helpers\Url;
use \common\widgets\avatar\AvatarWidget;
?>

<div class="c-menu-wrap">
    <span class="c-menu round"></span>
</div>

<ul class="c-menu-actions hide">
    <?php if(Yii::$app->user->id == $post->user_id && Yii::$app->user->id !== $account->user_id ): ?>
        <li><a href="#">Add to blacklist</a></li>
    <?php endif; ?>
    <?php if(Yii::$app->user->id == $account->user_id || Yii::$app->user->id == $post->user_id): ?>
        <li><a href="javascript:void(0)"
               onclick="Post.removeComment(<?= $comment->id ?>)">Delete
                comment</a></li>
    <?php endif; ?>
</ul>
<div class="u-avatar round small">

    <?= AvatarWidget::widget([
        'user_id' => $comment->user_id
    ]); ?>

</div>

<div class="comment-body" >


    <div class="top-entry-meta">


        <a href="<?= Url::to(['account/view', 'id'=>$account->user_id])?>"><?= $account->first_name ?> <?= $account->last_name ?></a>
        <?php if($answerAccount):?>
            <span class="answer-comment">answer</span> <a href="<?= Url::to(['account/view', 'id'=>$answerAccount->user_id])?>" class="answer-comment"><?= $answerAccount->first_name ?> <?= $answerAccount->last_name ?></a>
        <?php endif; ?>
        <div class="u-rating"><span
                class="ico-favorites-star-outlined-symbol"></span>0
        </div>
        <div class="entry-date">
            <?php if ($comment->created_at != null) : ?>
                Comment on <?= date('d.m.Y', $comment->created_at) ?>, <?= \common\helpers\TimeZoneHelper::getTime('h:i a', $comment->created_at); ?>
            <?php endif; ?>
        </div>
    </div>
    <p><?= $comment->message ?></p>
    <div class="comment-footer clearfix">
        <?php if(Yii::$app->user->id !== $comment->user_id): ?>
            <div class="answer">answer</div>
        <?php endif; ?>
        <div class="like"><a href="#"><span
                    class="ico-heart-outline"></span>0</a></div>
        <div class="c-options">
            <a href="#" class="spam">spam</a>
        </div>
    </div>
    <div class="bottom-entry" id="comment-<?= $comment->id ?>" style="display: none;">
        <div class="u-avatar round small">
            <img src="<?= Yii::$app->user->identity->avatar; ?>" alt="user avatar">
        </div>
        <div class="comment-body">
            <div class="row">
                <div class="input-field col s12">
                    <textarea  name="entry-text" class="entry-text materialize-textarea"></textarea>
                    <label for="entry-text">Add a comment</label>
                </div>
                <div class="col s12">
                    <a href="javascript:void(0)" onclick="Post.addComment(<?= $post->id ?>,<?= $comment->id ?>)" class="waves-effect btn-large"  >answer</a><div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
                </div>
            </div>
        </div>
    </div>

</div>