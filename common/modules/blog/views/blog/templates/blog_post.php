<template id="blog-post-tpl">
    <div id="blog-posts">
        <div class="entry bordered-box">
            <div class="preview-info clearfix">
                <div class="delete-entry">
                    <a href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                </div>
                <div class="bookmark">
                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                </div>
            </div>
            <div class="top-entry clearfix">
                <div class="u-avatar round">
                    <img src="<?= Yii::$app->user->getIdentity()->avatar ?>" alt="user avatar"/>
                </div>
                <div class="top-entry-info">
                    <div class="top-entry-meta">
                        <a href="#">{{account.first_name}} {{account.last_name}}</a>
                        <div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>0</div>
                        <span class="badge green online">online</span>
                    </div>
                    <div class="user-main-car">
                        <strong>Car:</strong> <a href="#">Mercedes-Benz / W211 / Classic / 2014</a>
                    </div>
                    <div class="entry-date">
                        Posted on 30.11.2016, 09:46 am
                    </div>
                </div>
            </div>
            <div class="entry-content">
                {{#if post.images}}
                <div class="gallery-preview-block">
                    <div class="main-preview-img">
                        <a href="#">
                            <img class="main-image" data-src="{{ post.images.[0].src }}" alt="image" />
                        </a>
                    </div>
                    <div class="gallery-items-wrap clearfix">
                        <div class="gallery-item-preview">
                            <div class="gallery-item-inner">
                                <a href="#">
                                    <span class="gallery-item-more">
															<span class="item-label">+4</span>
														</span>
                                    <img src="" alt="image">
                                    <img src="" alt="image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{/if}}
                <h6>{{post.title}}</h6>
                <div class="preview-post">{{post.message}}</div>
                <div class="entry-info">
                    <div class="share-block">
                        <div class="share-item">
                            <a href="#"><span class="ico-heart-outline"></span>144</a>
                        </div>
                        <div class="share-item">
                            <a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>23</a>
                        </div>
                        <div class="share-item">
                            <a href="#"><span class="ico-upload-symbol"></span>144</a>
                        </div>
                    </div>
                </div>
                <div class="entry-comments">
                    <a href="#" class="btn-large btn-gray waves more-btn">show more comments</a>
                    <div class="entry-comment">
                        <div class="u-avatar round small">
                            <img src="/images/u-avatar1.jpg" alt="user avatar">
                        </div>
                        <div class="comment-body">
                            <a href="#" class="delete-comment">
                                <span class="ico-close-cross-circular-interface-button"></span>
                            </a>
                            <div class="top-entry-meta">
                                <a href="#">{{account.first_name}} {{account.last_name}}</a>
                                <div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>0</div>
                            </div>
                            <div class="more">answer</div>
                        </div>
                    </div>
                    <div class="entry-comment">
                        <div class="u-avatar round small">
                            <img src="/images/u-avatar2.jpg" alt="user avatar">
                        </div>
                        <div class="comment-body">
                            <a href="#" class="delete-comment">
                                <span class="ico-close-cross-circular-interface-button"></span>
                            </a>
                            <div class="top-entry-meta">
                                <a href="#">Amira</a>
                                <div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>0</div>
                                <span class="answer-label">answered to Aahil</span>
                            </div>

                            <div class="more">answer</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-entry">
                <div class="u-avatar round small">
                    <img src="/images/user.png" alt="user avatar">
                </div>
                <div class="comment-body">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
                            <label for="entry-text">Add a comment</label>
                        </div>
                        <div class="col s12">
                            <a href="#" class="waves-effect btn-large">add a comment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>