<div class="entries-wrap">
    <h5>My blog</h5>
    <?php use common\models\Post; ?>

    <div id="blog-posts">
    <?php if (!empty($posts)) : ?>
        <?php foreach ($posts as $post) : ?>
                <div class="entry bordered-box" id="post-id-<?= $post->id ?>">
                    <div class="preview-info clearfix">
                        <div class="bookmark">
                            <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                        </div>
                    </div>
                    <div class="top-entry clearfix">
                        <div class="u-avatar round">
                            <img src="<?= $avatar; ?>" alt="user avatar">
                        </div>
                        <div class="top-entry-info">
                            <div class="top-entry-meta">
                                <a href="#"><?= $account->first_name, ' ', $account->last_name  ?></a>
                                <div class="u-rating"><img src="/images/arba2.png" alt="rating">0</div>
                                <span class="badge green online">online</span>
                            </div>
                            <div class="user-main-car">
                                <?php if ($mainCar != null) : ?>
                                    <strong>Car:</strong> <a href="#"><?= $mainCar->brand ?> / <?= $mainCar->model ?> / <?= $mainCar->modification ?> / <?= $mainCar->year ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="entry-date">
                                <?php if ($post->created_at != null) : ?>
                                    Posted on <?= date('d.m.Y', $post->created_at) ?>, <?= date('h:i a', $post->created_at) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="entry-content">
                        <div class="gallery-preview-block">
                            <?php if (!empty($post->images)) : ?>
                                <?php for ($i = 0; $i < 2; $i++) : ?>
                                    <?php if ($i == 0) : ?>
                                        <div class="main-preview-img">
                                            <a href="#">
                                                <img src="<?= $post->images[$i]->src ?>" alt="image">
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                <?php endfor; ?>
                            <?php endif; ?>

                            <div class="gallery-items-wrap clearfix">
                                <?php if (!empty($post->images)) : ?>
                                    <?php for ($i = 1; $i < count($post->images); $i++) : ?>
                                        <div class="gallery-item-preview" <?php if ($i > 4) : ?> style="display: none;" <?php endif; ?>>
                                            <div class="gallery-item-inner">
                                                <a href="#">
                                                    <?php if ($i == 4) : ?>
                                                    <!-- Last image -->
                                                        <span class="gallery-item-more">
															<span class="show-all item-label">+<?= count($post->images) - $i - 1 ?> </span>
														</span>
                                                        <img src="<?= $post->images[$i]->src ?>" alt="image">
                                                    <?php else : ?>
                                                        <img src="<?= $post->images[$i]->src ?>" alt="image">
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                <?php endif; ?>

                                <?php $post_videos = Post::find()
                                    ->match("(p) WHERE ID(p) = {$post->id}
                                             OPTIONAL MATCH (p)-[:has_video]->(v)
                                    ")
                                    ->get('collect(v) as videos')
                                    ->one();
                                ?>
                                <?php if (!empty($post_videos->videos)) : ?>

                                    <?php foreach ($post_videos->videos as $video) : ?>
                                        <div class="gallery-item-preview" <?php if (count($post->images) > 4) : ?> style="display: none;" <?php endif; ?>>
                                            <div class="gallery-item-inner">
                                                <a href="#">
                                                    <iframe width="150" height="100" src="<?= $video->src ?>" frameborder="0" allowFullScreen='allowFullScreen'></iframe>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <h6><?= $post->title ?></h6>
                        <div class="preview-post"><?= $post->message ?></div>
                        <div class="entry-info">
                            <div class="share-block">
                                <div class="share-item">
                                    <a href="#"><span class="ico-heart-outline"></span>0</a>
                                </div>
                                <div class="share-item">
                                    <a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>0</a>
                                </div>
                                <div class="share-item">
                                    <a href="#"><span class="ico-upload-symbol"></span>0</a>
                                </div>
                            </div>
                        </div>
                        <div id="comments-<?= $post->id ?>" class="entry-comments">
                            <?php if (!empty($comments = $post->getComments())) : ?>
                            <?php foreach ($post->getComments() as $comment) : ?>
                                <div class="entry-comment" id="comment-id-<?= $comment->id ?>">
                                    <div class="u-avatar round small">
                                        <img src="<?= $avatar; ?>" alt="user avatar">
                                    </div>
                                    <div class="comment-body">
                                        <a href="javascript:void(0)" class="delete-comment">
                                            <span class="ico-close-cross-circular-interface-button" onclick="Post.removeComment(<?= $comment->id ?>)"></span>
                                        </a>
                                        <div class="top-entry-meta">
                                            <a href="#"><?= $account->first_name ?> <?= $account->last_name ?></a>
                                            <div class="u-rating"><img src="/images/arba2.png" alt="rating">0</div>
                                        </div>
                                        <p><?= $comment->message ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="bottom-entry">
                        <div class="u-avatar round small">
                            <img src="<?= Yii::$app->user->identity->avatar; ?>" alt="user avatar">
                        </div>
                        <div class="comment-body">
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="comment-<?= $post->id ?>" name="Comment[message]" class="entry-text materialize-textarea"></textarea>
                                    <label for="entry-text">Add a comment</label>
                                </div>
                                <div class="col s12">
                                    <a href="javascript:void(0)" onclick="Post.addComment(<?= $post->id ?>)" class="waves-effect btn-large">add a comment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<!--    <a href="#" class="btn-large btn-gray waves-effect waves more-btn">load more</a>-->
</div>
<!-- add popup -->
<form id="newblogvideo" class="white-popup-block mfp-hide full-btn">
    <div class="row">
        <div class="col s12 marg">
            <div class="heading center">
                <h4>Add video</h4>
                <div class="heading-separator">
                    <img src="/images/arba.png" alt="separator">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="video-source" name="Blog[title]" type="text" class="validate">
            <label id="video-label" for="video-source" data-error="wrong" data-success="right">Video source</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <button id="add-blog-video" class="waves-effect btn-large" type="submit" name="action2">add video</button>
        </div>
    </div>
</form>
<!-- /add popup -->

<?= $this->render('@blog_module/views/blog/templates/blog_post') ?>
<template id="comment-tpl">
    <div class="entry-comment">
        <div class="u-avatar round small">
            <img src="/images/u-avatar1.jpg" alt="user avatar">
        </div>
        <div class="comment-body">
            <a href="#" class="delete-comment">
                <span class="ico-close-cross-circular-interface-button"></span>
            </a>
            <div class="top-entry-meta">
                <a href="#">Aahil Asad</a>
                <div class="u-rating"><img src="/images/arba2.png" alt="rating">0</div>
            </div>
            <p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod. Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
        </div>
    </div>
</template>
