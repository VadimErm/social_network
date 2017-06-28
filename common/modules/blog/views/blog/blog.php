<?php
use common\models\Post;
use common\widgets\comment\CommentWidget;
?>

<div class="entries-wrap">
    <h5>My blog</h5>
    <?php if(Yii::$app->user->id == $account->user_id):?>
        <?= $this->render('_forms/post') ?>
    <?php endif; ?>
    <div id="blog-posts">
        <?php if (!empty($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
                <?php $post_videos = Post::find()
                    ->match("(p) WHERE ID(p) = {$post->id}
                                             OPTIONAL MATCH (p)-[:has_video]->(v)
                                    ")
                    ->get('collect(v) as videos')
                    ->one();
                ?>
                <div class="entry bordered-box" id="post-id-<?= $post->id ?>"  >

                    <?php if(Yii::$app->user->id == $account->user_id): ?>
                        <div class="c-menu-wrap pos-post">
                            <span class="c-menu round"></span>
                        </div>
                        <ul class="c-menu-actions pos-post2 hide">
                            <li class="ed-post"><a href="#">Edit post</a></li>
                            <li><a href="#delete-post" class="popup-form" onclick="Post.removePost(<?= $post->id ?>)">Delete
                                    post</a></li>
                        </ul>
                    <?php endif; ?>
                    <div class="preview-info clearfix">
                        <!--<div class="delete-entry">
                            <a href="#delete-post" class="popup-form" onclick="Post.removePost(<?= $post->id ?>)"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>-->
                        <div class="bookmark">
                            <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                        </div>
                    </div>
                    <div class="top-entry clearfix">
                        <div class="u-avatar round">

                            <?= \common\widgets\avatar\AvatarWidget::widget([
                                    'user_id' => $account->user_id
                            ]);?>
                        </div>
                        <div class="top-entry-info">
                            <div class="top-entry-meta">
                                <a href="#"><?= $account->first_name, ' ', $account->last_name ?></a>
                                <div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>0</div>
                                <span class="badge green online">online</span>
                            </div>
                            <div class="user-main-car">
                                <?php if ($mainCar != null) : ?>
                                    <strong>Car:</strong> <a href="#"><?= $mainCar->brand ?> / <?= $mainCar->model ?>
                                        / <?= $mainCar->modification ?> / <?= $mainCar->build_date ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="entry-date">

                                <?php if ($post->created_at != null) : ?>


                                    Posted on <?= date('d.m.Y', $post->created_at) ?>, <?= \common\helpers\TimeZoneHelper::getTime('h:i a', $post->created_at); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="entry-content">
                        <div class="edit-entry-wrap hide">
                            <form id="edit-post-<?= $post->id ?>">

                                <div class="row">
                                    <div class="col s12">
                                        <div class="row">
                                            <div class="input-field col s12">

                                                <input  name="Post[title]" type="text" class="validate edit-title"
                                                       required="required" value="<?= $post->title ?>" data-post-id="<?= $post->id ?>">
                                                <label for="Post[title]">Entry title</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">

                                               <textarea  name="Post[message]" class="materialize-textarea validate edit-text" required="required"  data-post-id="<?= $post->id ?>"><?= $post->message ?></textarea>
                                                <label for="Post[message]">Entry text</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="if-has-img">
                                                    <h6><span>Images in post</span></h6>
                                                    <ul class="clearfix image-preview" >
                                                        <?php if (!empty($post->images)) : ?>
                                                            <?php for ($i = 0; $i < count($post->images); $i++) : ?>
                                                                <li>
                                                                    <a href="#" class="image-edit-delete" ><span
                                                                                class="ico-close-cross-circular-interface-button"></span></a>
                                                                    <img src="<?= $post->images[$i]->src ?>" alt="image">
                                                                    <input type="hidden" name="old_images[<?= $i ?>]" value="<?= $post->images[$i]->src ?>">
                                                                </li>
                                                            <?php endfor; ?>
                                                        <?php endif; ?>


                                                    </ul>
                                                </div>
                                                <div class="if-has-video clearfix">
                                                    <h6><span>Videos in post</span></h6>
                                                    <?php if (!empty($post_videos->videos)) : ?>

                                                        <?php foreach ($post_videos->videos as $video) : ?>
                                                            <div class="post-vid-item">
                                                                <a href="#" class="image-edit-delete"><span
                                                                            class="ico-close-cross-circular-interface-button"></span></a>
                                                                <iframe width="204" height="150"
                                                                        src="<?= $video->src ?>"
                                                                        frameborder="0" allowfullscreen></iframe>
                                                                <input type="hidden" name="Post[videos][]" value="<?= $video->src ?>">
                                                            </div>

                                                        <?php endforeach; ?>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s12 m6">
                                                <button class="waves-effect btn-large full update-post" type="submit" data-post-id="<?= $post->id ?>" name="send">
                                                    submit
                                                </button>
                                            </div>
                                            <div class="col s12 m6">
                                                <div class="btn-gray btn-ui waves-effect">
                                                    <input data-post-id="<?= $post->id ?>" class="image-edit-file" name="Post[images][]" type="file" multiple="multiple" accept="gif|jpg|jpeg|png">
                                                    <span class="ico-photo-camera-outlined-interface-symbol"></span>
                                                </div>
                                                <div class="btn-gray btn-ui waves-effect ">
                                                    <a href="#newblogvideo" class="popup-form edit-video"  data-post-id="<?= $post->id ?>"><span class="ico-video-camera" ></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="deleted-images-count" value="0">
                            </form>
                        </div>
                        <div class="edit-entry-content">
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
                                                            <span class="gallery-item-more img-back">
															<span class="show-all item-label">+<?= count($post->images) + count($post_videos->videos) - $i - 1 ?> </span>
														</span>
                                                            <img src="<?= $post->images[$i]->src ?>" alt="image">
                                                        <?php else : ?>
                                                            <a href="#video_modal" class="popup-form">
                                                                <img class="image-popup"
                                                                     src="<?= $post->images[$i]->src ?>" alt="image">
                                                            </a>
                                                        <?php endif; ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($post_videos->videos)) : ?>

                                        <?php foreach ($post_videos->videos as $video) : ?>
                                            <div class="gallery-item-preview" <?php if (count($post->images) > 4) : ?> style="display: none;" <?php endif; ?>>
                                                <div class="gallery-item-inner">
                                                    <a href="#">
                                                        <?php $src = substr($video->src, strpos($video->src, 'embed/') + 6) ?>
                                                        <a href="#video_modal" class="popup-form">
                                                            <img class="video-popup" width="150" height="100"
                                                                 src="https://img.youtube.com/vi/<?= $src ?>/0.jpg"
                                                                 data-video-src="<?= $video->src ?>">
                                                        </a>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <h6><?= $post->title ?></h6>
                            <div class="preview-post"><?= $post->message ?></div>
                        </div>

                        <div class="entry-info">
                            <div class="share-block">
                                <div class="share-item">
                                    <a href="#"><span class="ico-heart-outline"></span>0</a>
                                </div>
                                <div class="share-item">
                                    <?php $comments = $post->getComments(); ?>

                                    <a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>
                                        <div class="comment-count"
                                             style="display: inline;"><?= count($comments) ?></div>
                                    </a>
                                </div>
                                <div class="share-item">
                                    <a href="#"><span class="ico-upload-symbol"></span>0</a>
                                </div>
                            </div>
                        </div>
                        <div id="comments-<?= $post->id ?>" class="entry-comments">
                            <?php if (count($comments) > 2) : ?>
                                <a href="javascript:void(0)" class="btn-large btn-gray waves more-btn show-comments">show
                                    more comments</a>
                            <?php endif; ?>
                            <?php if (!empty($comments)) : ?>
                                <?php $length = count($comments); ?>
                                <?php for ($i = 0; $i < $length; $i++) : ?>
                                    <?php $style = $i > 1 ? 'display: none' : ''; ?>
                                    <div class="entry-comment" <?= $i > 1 ? 'data-is-hidden' : '' ?>
                                         id="comment-id-<?= $comments[$i]->id ?>" style="<?= $style ?>">
                                        <?= CommentWidget::widget([
                                                'comment' => $comments[$i],
                                                'post' => $post
                                        ]); ?>

                                    </div>
                                <?php endfor; ?>
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
                                    <textarea id="comment-<?= $post->id ?>"
                                              class="entry-text materialize-textarea comment-textarea"
                                              data-length="400"></textarea>
                                    <label for="entry-text">Add a comment</label>
                                </div>
                                <div class="col s12">
                                    <a href="javascript:void(0)" onclick="Post.addComment(<?= $post->id ?>)"
                                       class="waves-effect btn-large">add a comment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert-box-none">
                You don't have any entries yet.
            </div>
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
<!-- edit video popup -->
<!--<form id="editblogvideo" class="white-popup-block mfp-hide full-btn">
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
            <input id="video-source-edit" name='video-source' type="text" class="validate" onblur="Post.validateVideo()">
            <label id="video-label" for="video-source" data-error="wrong" data-success="right">Video source</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <button  id="edit-video-add" class="waves-effect btn-large" data-post-id="" type="submit" name="action2">add video</button>
        </div>
    </div>
</form>-->

<!-- /video popup -->
<form id="video_modal" class="white-popup-block dialog-pop mfp-hide">
    <div class="heading">
        <button type="button"><span class="ico-close-cross-circular-interface-button"></span></button>
    </div>
    <div class="dialog-popup center">
        <div id="video-container"></div>
    </div>
</form>
<div class="carousel carousel-slider center" data-indicators="true">
    <div class="carousel-fixed-item center">
        <a class="btn waves-effect white grey-text darken-text-2">button</a>
    </div>
    <div class="carousel-item red white-text" href="#one!">
        <h2>First Panel</h2>
        <p class="white-text">This is your first panel</p>
    </div>
    <div class="carousel-item amber white-text" href="#two!">
        <h2>Second Panel</h2>
        <p class="white-text">This is your second panel</p>
    </div>
    <div class="carousel-item green white-text" href="#three!">
        <h2>Third Panel</h2>
        <p class="white-text">This is your third panel</p>
    </div>
    <div class="carousel-item blue white-text" href="#four!">
        <h2>Fourth Panel</h2>
        <p class="white-text">This is your fourth panel</p>
    </div>
</div>

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
                <div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span> 0</div>
            </div>
            <p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod.
                Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at
                pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus
                et netus et malesuada fames ac turpis egestas.</p>
        </div>
    </div>
</template>
