<?php $carsArr = ['Audi', 'BMW', 'Chrysler'] ?>
<?php $carModels = ['model 1', 'model 2', 'model 3'] ?>
<?php $carModifications = ['model 4', 'model 5', 'model 6'] ?>
<?php $carYears = ['model 1', 'model 2', 'model 3'] ?>
<?php $carEngines = ['engine 1', 'engine 2', 'engine 3'] ?>
<?php $carEngineSizes = ['size 1', 'size 2', 'size 3']; ?>

<?php if (!empty($main)) : ?>
    <div class="garage-car" id="car-id-<?= $main->id ?>">
        <div class="row">
            <div class="col s12 m12 l6">
                <div class="garage-item big-car">
                    <div class="garage-car-wrap" onclick="location.href='/live/#/cars/journal/my/<?= $main->id ?>'"
                         style="background-image:url(<?= empty($main->images) ? '' : $main->images[0]->src ?>);">
                        <div class="preview-info clearfix">
                            <div class="badge1 award-badge">
                                main car
                            </div>
                            <div class="bookmark">
                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l6">
                <div class="car-info">
                    <h6 class="car-name"><a href="<?= \yii\helpers\Url::to([
                            '/garage/car/view-car',
                            'id' => $main->id
                        ]) ?>"><?= $main->car_name ?></a></h6>
                    <div class="car-modification"><?= $main->brand ?> / <?= $main->model ?> / <?= $main->modification ?>
                        / <?= $main->build_date ?></div>
                    <div class="block-meta">
                        <div class="meta-item"><a href="#"><span
                                    class="ico-heart-outline"></span>100</a></div>
                        <div class="meta-item"><a href="#"><span class="ico-user-outline-shape"></span>167
                                followers</a></div>
                        <div class="meta-item"><a href="#"><span
                                    class="ico-maps-placeholder-outlined-tool"></span><?= $main->location ?></a></div>
                        <div class="meta-item"><a href="#"><span
                                    class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a>
                        </div>
                    </div>
                    <ul class="list-sep">
                        <li>Year of production: <?= $main->build_date ?>. Use since: <?= $main->use_since ?></li>
                        <li>Engine: <?= $main->engine_type ?></li>
                        <li>Engine size: <?= $main->engine_size ?></li>
                        <li>Capacity: <?= $main->capacity ?> Hp</li>
                    </ul>
                    <h6 class="car-arch">Car’s achivements</h6>
<!--                    <ul class="achivements-list">-->
<!--                        <li>-->
<!--                            <div class="icon-left"><span-->
<!--                                    class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                            <div class="ach-desc">Most popular blog in <a href="#">December 2017</a>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="icon-left"><span-->
<!--                                    class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                            <div class="ach-desc">Nullam posuere sem at justo sodales, in finibus in <a-->
<!--                                    href="#">December 2017</a></div>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                    <ul class="achivements-list full hide">-->
<!--                        <li>-->
<!--                            <div class="icon-left"><span-->
<!--                                    class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                            <div class="ach-desc">Morbi tristique leo id odio condimentum euismod</div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="icon-left"><span-->
<!--                                    class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                            <div class="ach-desc">Praesent gravida fringilla velit, ac hendrerit orci-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="icon-left"><span-->
<!--                                    class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                            <div class="ach-desc">Duis ultricies pulvinar orci ut sagittis.</div>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                    <div class="see-all">see all &rarr;</div>-->
                    <div class="btns-w clearfix">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (!empty($cars)): ?>
    <?php foreach ($cars as $car) : ?>
        <div class="garage-car" id="car-id-<?= $car->id ?>">
            <div class="row">
                <div class="col s12 m12 l6">
                    <div class="garage-item big-car">
                        <div class="garage-car-wrap" onclick="location.href='/garage/car/view-car?id=<?= $main->id ?>'"
                             style="background-image:url(<?= empty($car->images) ? '' : $car->images[0]->src ?>);">
                            <div class="preview-info clearfix">
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="car-info">
                        <h6 class="car-name"><a href="/live/#/cars/journal/my/<?= $car->id ?>"><?= $car->car_name ?></a></h6>
                        <div class="car-modification"><?= $car->brand ?> / <?= $car->model ?>/ <?= $car->modification ?>
                            / <?= $car->build_date ?></div>
                        <div class="block-meta">
                            <div class="meta-item"><a href="#"><span
                                        class="ico-heart-outline"></span>100</a></div>
                            <div class="meta-item"><a href="#"><span class="ico-user-outline-shape"></span>167
                                    followers</a></div>
                            <div class="meta-item"><a href="#"><span
                                        class="ico-maps-placeholder-outlined-tool"></span><?= $car->location ?></a>
                            </div>
                            <div class="meta-item"><a href="#"><span
                                        class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a>
                            </div>
                        </div>
                        <ul class="list-sep">
                            <li>Year of production:<?= $car->build_date ?>. Use since: <?= $car->use_since ?></li>
                            <li>Engine: <?= $car->engine_type ?></li>
                            <li>Engine size: <?= $car->engine_size ?></li>
                            <li>Capacity: <?= $car->capacity ?> Hp</li>
                        </ul>
                        <h6 class="car-arch">Car’s achivements</h6>
<!--                        <ul class="achivements-list">-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span-->
<!--                                        class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Most popular blog in <a href="#">December 2017</a>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span-->
<!--                                        class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Nullam posuere sem at justo sodales, in finibus in <a-->
<!--                                        href="#">December 2017</a></div>-->
<!--                            </li>-->
<!--<!--                        </ul>-->-->
<!--<!--                        <ul class="achivements-list full hide">-->-->
<!--<!--                            <li>-->-->
<!--<!--                                <div class="icon-left"><span-->-->
<!--<!--                                        class="ico-sports-or-education-trophy-cup"></span></div>-->-->
<!--<!--                                <div class="ach-desc">Morbi tristique leo id odio condimentum euismod</div>-->-->
<!--<!--                            </li>-->-->
<!--<!--                            <li>-->-->
<!--<!--                                <div class="icon-left"><span-->-->
<!--<!--                                        class="ico-sports-or-education-trophy-cup"></span></div>-->-->
<!--<!--                                <div class="ach-desc">Praesent gravida fringilla velit, ac hendrerit orci-->-->
<!--<!--                                </div>-->-->
<!--<!--                            </li>-->-->
<!--<!--                            <li>-->-->
<!--<!--                                <div class="icon-left"><span-->-->
<!--<!--                                        class="ico-sports-or-education-trophy-cup"></span></div>-->-->
<!--<!--                                <div class="ach-desc">Duis ultricies pulvinar orci ut sagittis.</div>-->-->
<!--<!--                            </li>-->-->
<!--<!--                        </ul>-->-->
<!--                        <div class="see-all">see all &rarr;</div>-->
<!--                        <div class="btns-w clearfix">-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>