<?php
/**
 * @var $this \yii\web\View
 */

use yii\helpers\Url;
?>
<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>

<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">Car's journal</li>
                <li>&rarr;</li>
                <li><a href="user-car.html">My favorite car Mercedes-Benz</a></li>
                <li>&rarr;</li>
                <li><a href="<?= Url::to(['/garage']) ?>">Ahmed's garage</a></li>
                <li>&rarr;</li>
                <li><a href="<?= Url::to(['/user/account/profile']) ?>">Ahmed's profile</a></li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->

<!-- wrapper -->
<div class="section car-journal-wrap">
    <div class="container">
        <div class="row new-entry-row">
            <div class="col s12 m8 l9">
                <div class="btn-large btn-liner waves-effect">follow car</div>
            </div>
            <div class="col s12 m4 l3 input-field">
                <select name="sort">
                    <option value="" disabled selected>Sort by name</option>
                    <option value="">Sort by tags</option>
                    <option value="">Sort by date</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="entries-wrap">
                    <div class="entry bordered-box">
                        <div class="preview-info clearfix">
                            <div class="bookmark">
                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                            </div>
                        </div>
                        <div class="top-entry clearfix">
                            <div class="u-avatar round">
                                <img src="/images/user.png" alt="user avatar">
                            </div>
                            <div class="top-entry-info">
                                <div class="top-entry-meta">
                                    <a href="#">Aahil Asad</a>
                                    <div class="u-rating"><img src="/images/arba2.png" alt="rating">777</div>
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
                            <div class="gallery-preview-block clearfix">
                                <div class="main-preview-img">
                                    <a href="#">
                                        <img src="/images/post-preview5.jpg" alt="image">
                                    </a>
                                </div>
                                <div class="gallery-items-wrap">
                                    <div class="gallery-item-preview">
                                        <div class="gallery-item-inner">
                                            <a href="#">
                                                <img src="/images/post-preview1.jpg" alt="image">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="gallery-item-preview">
                                        <div class="gallery-item-inner">
                                            <a href="#">
                                                <img src="/images/post-preview2.jpg" alt="image">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="gallery-item-preview">
                                        <div class="gallery-item-inner">
                                            <a href="#">
                                                <img src="/images/post-preview3.jpg" alt="image">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="gallery-item-preview">
                                        <div class="gallery-item-inner">
                                            <a href="#">
														<span class="gallery-item-more">
															<span class="item-label">+4</span>
														</span>
                                                <img src="/images/post-preview4.jpg" alt="image">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
                            <div class="preview-post">
                                <p>Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia. Ut hendrerit ante nec posuere egestas. Ut condimentum id justo non Suspendisse hendrerit gravida mollis. Praesent ac mauris ut tellus ultrices molestie.</p>
                                <p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
                            </div>
                            <div class="full-post">
                                <p>Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia. Ut hendrerit ante nec posuere egestas. Ut condimentum id justo non Suspendisse hendrerit gravida mollis. Praesent ac mauris ut tellus ultrices molestie.</p>
                                <img src="/images/post-preview5.jpg" alt="image">
                                <p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
                            </div>
                            <div class="more">read more</div>
                            <div class="t-entry">Mileage: 120000 km </div>
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
                                        <div class="top-entry-meta">
                                            <a href="#">Aahil Asad</a>
                                            <div class="u-rating"><img src="/images/arba2.png" alt="rating">777</div>
                                            <div class="entry-date">
                                                Posted on 30.11.2016, 09:46 am
                                            </div>
                                        </div>
                                        <p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod. Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                        <div class="comment-footer clearfix">
                                            <div class="answer">answer</div>
                                            <div class="like"><a href="#"><span class="ico-heart-outline"></span>1</a></div>
                                            <div class="c-options">
                                                <a href="#" class="spam">spam</a>
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
                                                        <a href="#" class="waves-effect btn-large">answer</a><div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="entry-comment">
                                    <div class="u-avatar round small">
                                        <img src="/images/u-avatar2.jpg" alt="user avatar">
                                    </div>
                                    <div class="comment-body">
                                        <div class="top-entry-meta">
                                            <a href="#">Amira</a>
                                            <div class="u-rating"><img src="/images/arba2.png" alt="rating">777</div>
                                            <span class="answer-label">answered to Aahil</span>
                                            <div class="entry-date">
                                                Posted on 30.11.2016, 09:46 am
                                            </div>
                                        </div>
                                        <p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod. Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                        <div class="comment-footer clearfix">
                                            <div class="answer">answer</div>
                                            <div class="like"><a href="#"><span class="ico-heart-outline"></span>1</a></div>
                                            <div class="c-options">
                                                <a href="#" class="spam">spam</a>
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
                                                        <a href="#" class="waves-effect btn-large">answer</a><div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                    <div class="entry bordered-box">
                        <div class="preview-info clearfix">
                            <div class="bookmark">
                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                            </div>
                        </div>
                        <div class="top-entry clearfix">
                            <div class="u-avatar round">
                                <img src="/images/user.png" alt="user avatar">
                            </div>
                            <div class="top-entry-info">
                                <div class="top-entry-meta">
                                    <a href="#">Aahil Asad</a>
                                    <div class="u-rating"><img src="/images/arba2.png" alt="rating">777</div>
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
                            <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
                            <div class="preview-post">
                                <p>Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia. Ut hendrerit ante nec posuere egestas. Ut condimentum id justo non Suspendisse hendrerit gravida mollis. Praesent ac mauris ut tellus ultrices molestie.</p>
                                <p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
                            </div>
                            <div class="full-post">
                                <p>Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia. Ut hendrerit ante nec posuere egestas. Ut condimentum id justo non Suspendisse hendrerit gravida mollis. Praesent ac mauris ut tellus ultrices molestie.</p>
                                <p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
                            </div>
                            <div class="more">read more</div>
                            <div class="t-entry">Expenses: 400$ (7000 AED)</div>
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
                    <a href="#" class="btn-large btn-gray waves-effect waves more-btn">load more</a>
                </div>
            </div>
        </div>
    </div>
</div>
