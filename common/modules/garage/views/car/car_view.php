<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix truncate">
                <li class="active"><?= $car->car_name ?></li>
                <li>&rarr;</li>
                <li><a href="<?= \yii\helpers\Url::to(['/garage']) ?>">my garage</a></li>
                <li>&rarr;</li>
                <li><a href="<?= \yii\helpers\Url::to(['/user/account/profile']) ?>">my profile</a></li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->
<!-- Confirm wrapper -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col s12 garage-content single-car">
                <h5><?= $car->brand ?> / <?= $car->model ?> / <?= $car->modification ?> / <?= $car->build_date ?> / <span class="gray"><?= $car->car_name ?></span></h5>
                <div class="garage-wrap">
                    <div class="garage-block">
                        <div class="garage-car">
                            <div class="pos-rel">
                                <div class="big-car-rating">
                                    <img src="/images/arba2.png" alt="rating"> 777
                                </div>
                                <ul id="car-slider">
                                    <?php foreach ($car->images as $image) : ?>
                                        <li class="garage-car-wrap" style="background-image:url(<?= $image->src ?>);"></li>
                                    <?php endforeach; ?>
                                </ul>
                                <div id="car-pager">
                                    <?php $length = count($car->images); ?>
                                    <?php for ($i = 0; $i < $length; $i++) : ?>
                                        <a data-slide-index="<?= $i ?>" href=""><img src="<?= $car->images[$i]->src ?>"></a>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="garage-block">
                        <h5>Car's information</h5>
                        <div class="car-info">
                            <h6 class="car-arch">About my car</h6>
                            <p><?= $car->about ?></p>
                            <div class="block-meta">
                                <div class="meta-item"><a href="#"><span class="ico-heart-outline"></span>100</a></div>
                                <div class="meta-item"><a href="#"><span class="ico-user-outline-shape"></span>167 followers</a></div>
                                <div class="meta-item"><a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a></div>
                            </div>
                            <div class="row">
                                <div class="col s12 m6">
                                    <h6 class="car-arch">Basic information</h6>
                                    <ul class="list-sep">
                                        <li>Build date: <?= $car->build_date ?> . Use since: <?= $car->use_since ?></li>
                                        <li>Location: <?= $car->location ?></li>
                                        <li>Engine type: <?= $car->engine_type ?></li>
                                        <li>Engine size: <?= $car->engine_size ?></li>
                                        <li>Capacity: <?= $car->capacity ?></li>
                                        <li>Drive type: <?= $car->drive_type ?></li>
                                        <li>Car’s number: <span class="black"><?= $car->car_number ?></span></li>
                                        <li>Registred on date: <?= $car->registered ?></li>
                                    </ul>
                                </div>
                                <div class="col s12 m6">
                                    <h6 class="car-arch">Car’s achivements</h6>
                                    <ul class="achivements-list">
                                        <li>
                                            <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                            <div class="ach-desc">Most popular blog in <a href="#">December 2017</a></div>
                                        </li>
                                        <li>
                                            <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                            <div class="ach-desc">Nullam posuere sem at justo sodales, in finibus in <a href="#">December 2017</a></div>
                                        </li>
                                        <li>
                                            <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                            <div class="ach-desc">Morbi tristique leo id odio condimentum euismod</div>
                                        </li>
                                        <li>
                                            <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                            <div class="ach-desc">Praesent gravida fringilla velit, ac hendrerit orci</div>
                                        </li>
                                        <li>
                                            <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                            <div class="ach-desc">Duis ultricies pulvinar orci ut sagittis.</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="btns-w clearfix">
                                <a href="#" class="btn-large waves-effect">add new entry</a>
                                <a href="#" class="btn-large btn-liner waves-effect"><span class="ico-heart-outline"></span>like</a>
                                <a href="#" class="btn-large btn-gray waves-effect">move to "ex-cars"</a>
                                <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-edit-pencil-symbol"></span></a>
                                <a class="btn-gray btn-ui waves-effect popup-form" href="#remove-item"><span class="ico-close-cross-circular-interface-button"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="garage-block journal-entries">
                        <div class="row">
                            <div class="col s12 m8 l9">
                                <h5>Car's journal <a href="#" class="gray">10</a></h5>
                            </div>
                            <div class="col s12 m4 l3 input-field">
                                <select name="sort">
                                    <option value="" disabled selected>Sort by name</option>
                                    <option value="">Sort by tags</option>
                                    <option value="">Sort by date</option>
                                </select>
                            </div>
                        </div>
                        <div class="journal-entry clearfix">
                            <div class="jentry-preview hide-on-small-only">
                                <img src="/images/car3.jpg" alt="">
                            </div>
                            <div class="jentry-body">
                                <h6 class="truncate"><a href="#">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a></h6>
                                <a href="#" class="jentry-cat">photos</a>
                                <div class="block-meta">
                                    <div class="meta-item"><span class="ico-empty-daily-calendar-page"></span>12.11.2016</div>
                                    <div class="meta-item"><a href="#"><span class="ico-heart-outline"></span>100</a></div>
                                    <div class="meta-item"><a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="journal-entry clearfix">
                            <div class="jentry-preview hide-on-small-only">
                                <img src="/images/no-image.png" alt="">
                            </div>
                            <div class="jentry-body">
                                <h6 class="truncate"><a href="#">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a></h6>
                                <a href="#" class="jentry-cat">photos</a>
                                <div class="block-meta">
                                    <div class="meta-item"><span class="ico-empty-daily-calendar-page"></span>12.11.2016</div>
                                    <div class="meta-item"><a href="#"><span class="ico-heart-outline"></span>100</a></div>
                                    <div class="meta-item"><a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="journal-entry clearfix">
                            <div class="jentry-preview hide-on-small-only">
                                <img src="/images/car3.jpg" alt="">
                            </div>
                            <div class="jentry-body">
                                <h6 class="truncate"><span class="jentry-type">Expenses</span> <a href="#">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a></h6>
                                <a href="#" class="jentry-cat">photos</a>
                                <div class="block-meta">
                                    <div class="meta-item"><span class="ico-empty-daily-calendar-page"></span>12.11.2016</div>
                                    <div class="meta-item"><a href="#"><span class="ico-heart-outline"></span>100</a></div>
                                    <div class="meta-item"><a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="journal-entry clearfix">
                            <div class="jentry-preview hide-on-small-only">
                                <img src="/images/no-image.png" alt="">
                            </div>
                            <div class="jentry-body">
                                <h6 class="truncate"><a href="#">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a></h6>
                                <a href="#" class="jentry-cat">photos</a>
                                <div class="block-meta">
                                    <div class="meta-item"><span class="ico-empty-daily-calendar-page"></span>12.11.2016</div>
                                    <div class="meta-item"><a href="#"><span class="ico-heart-outline"></span>100</a></div>
                                    <div class="meta-item"><a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="journal-entry clearfix">
                            <div class="jentry-preview hide-on-small-only">
                                <img src="/images/car3.jpg" alt="">
                            </div>
                            <div class="jentry-body">
                                <h6 class="truncate"><span class="jentry-type">mileage</span> <a href="#">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a></h6>
                                <a href="#" class="jentry-cat">photos</a>
                                <div class="block-meta">
                                    <div class="meta-item"><span class="ico-empty-daily-calendar-page"></span>12.11.2016</div>
                                    <div class="meta-item"><a href="#"><span class="ico-heart-outline"></span>100</a></div>
                                    <div class="meta-item"><a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a></div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn-large full btn-gray waves-effect waves more-btn">view all entries</a>
                    </div>
                    <div class="garage-block">
                        <h5>Comments <a href="#" class="gray">22</a></h5>
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
                                        <a href="#" class="waves-effect btn-large">add a comment</a><div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="car-comments">
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
                                        <div class="entry-date">
                                            Posted on 30.11.2016, 09:46 am
                                        </div>
                                    </div>
                                    <p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod. Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                    <div class="comment-footer clearfix">
                                        <div class="answer">answer</div>
                                        <div class="like"><a href="#"><span class="ico-heart-outline"></span>1</a></div>
                                        <div class="c-options">
                                            <a href="#" class="ban">ban</a>
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
                                    <a href="#" class="delete-comment">
                                        <span class="ico-close-cross-circular-interface-button"></span>
                                    </a>
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
                                            <a href="#" class="ban">ban</a>
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
                        <a href="#" class="btn-large full btn-gray waves-effect waves more-btn">view all comments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /wrapper -->