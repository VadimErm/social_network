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
                    <h6 class="car-name"><a href="/live/#/cars/journal/my/<?= $main->id ?>"><?= $main->car_name ?></a></h6>
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
                        <li>Year of production: 2015. Use since: 2016</li>
                        <li>Engine: <?= $main->engine_type ?></li>
                        <li>Engine size: <?= $main->engine_size ?></li>
                        <li>Capacity: 240 Hp</li>
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
                        <a href="javascript:void(0);" class="btn-large btn-gray waves-effect" onclick="CarActions.toExCars(<?= $main->id ?>, <?= 1 ?>)">move to "ex-cars"</a>
                        <a class="btn-gray btn-ui waves-effect popup-form" href="#addcar-id-<?= $main->id ?>"><span
                                class="ico-edit-pencil-symbol"></span></a>
                        <a class="btn-gray btn-ui waves-effect popup-form" onclick="CarActions.remove(<?= $main->id ?>)"
                           data-id="<?= $main->id ?>" href="#remove-item"><span
                                class="ico-close-cross-circular-interface-button"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- add car popup -->
    <form id="addcar-id-<?= $main->id ?>" class="white-popup-block mfp-hide full-btn">
        <input type="hidden" name="Car[id]" value="<?= $main->id ?>">
        <div class="row">
            <div class="col s12 marg">
                <div class="heading center">
                    <h4>Add car</h4>
                    <div class="heading-separator">
                        <img src="/images/arba.png" alt="separator">
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="btn-large btn-gray waves-effect"><div id="progress-bar"></div><input name="Car[images][]" type="file" data-update="true" data-form-id="addcar-id-<?= $main->id ?>" class="car-images"
                                                                                                 multiple=""><span>upload photos</span></div>
                <div class="cars-preview">
                    <?php foreach ($main->images as $image) : ?>
                        <img src="<?= $image->src ?>" width="180" >
                    <?php endforeach; ?>
                </div>
                <p>File format — JPEG.<br>
                    Size — any (but not less than 640×480 pixels).<br>
                    Dragging the image, you can specify the output order of pictures on the page. The first image is the
                    main.</p>
            </div>

        </div>
        <div class="row">
            <div class="input-field col s12">
                <select id="brand" name="Car[brand]">


                    <?php foreach ($carsArr as $lCar) : ?>
                        <?php if ($lCar == $main->brand) : ?>
                            <option value="<?= $lCar ?>" selected><?= $lCar ?></option>
                        <?php else : ?>
                            <option value="<?= $lCar ?>"><?= $lCar ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-field col s12">
                <select id="model" name="Car[model]">


                    <?php foreach ($carModels as $carModel) : ?>
                        <?php if ($carModel == $main->model) : ?>
                            <option value="<?= $carModel ?>" selected><?= $carModel ?></option>
                        <?php else : ?>
                            <option value="<?= $carModel ?>"><?= $carModel ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-field col s12">
                <select id="modification" name="Car[modification]">

                    <?php foreach ($carModifications as $carModification) : ?>
                        <?php if ($carModification == $main->modification) : ?>
                            <option value="<?= $carModification ?>" selected><?= $carModification ?></option>
                        <?php else : ?>
                            <option value="<?= $carModification ?>"><?= $carModification ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-field col s12">
                <select id="modelYear" name="Car[build_date]">

                    <?php foreach ($carYears as $carYear) : ?>
                        <?php if ($carYear == $main->modification) : ?>
                            <option value="<?= $carYear ?>" selected><?= $carYear ?></option>
                        <?php else : ?>
                            <option value="<?= $carYear ?>"><?= $carYear ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-field col s12">
                <select id="engine" name="Car[engine_type]">

                    <?php foreach ($carEngines as $carEngine) : ?>
                        <?php if ($carEngine == $main->engine_type) : ?>
                            <option value="<?= $carEngine ?>" selected><?= $carEngine ?></option>
                        <?php else : ?>
                            <option value="<?= $carEngine ?>"><?= $carEngine ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-field col s12">
                <select id="engine-size" name="Car[engine_size]">

                    <?php foreach ($carEngineSizes as $carEngineSize) : ?>
                        <?php if ($carEngineSize == $main->engine_size) : ?>
                            <option value="<?= $carEngineSize ?>" selected><?= $carEngineSize ?></option>
                        <?php else : ?>
                            <option value="<?= $carEngineSize ?>"><?= $carEngineSize ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-field col s12">
                <input id="capacity" name="Car[capacity]" type="text" value="<?= $main->capacity ?>">
                <label for="capacity">Capacity</label>
            </div>
            <div class="input-field col s12">
                <input id="car-name" name="Car[car_name]" type="text" value="<?= $main->car_name ?>">
                <label for="carname">Own car name</label>
            </div>
            <div class="input-field col s12">
                <input id="car-number" name="Car[car_number]" type="text" value="<?= $main->car_number ?>">
                <label for="carnumber">Own car name</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="Car[location]" id="location" class="autocomplete" value="<?= $main->location ?>">
                <label for="city">Car location</label>
            </div>
            <div class="input-field col s12 marg">
                <input type="checkbox" name="Car[main_car]" checked class="filled-in" id="maincar">
                <label for="maincar">Main car</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <button class="waves-effect btn-large update-car" data-car-id="<?= $main->id ?>" type="submit" name="action2">update car</button>
            </div>
        </div>
    </form>
    <!-- /add car popup -->
<?php endif; ?>
<?php if (!empty($cars)): ?>
    <?php foreach ($cars as $car) : ?>
        <div class="garage-car" id="car-id-<?= $car->id ?>">
            <div class="row">
                <div class="col s12 m12 l6">
                    <div class="garage-item big-car">
                        <div class="garage-car-wrap" onclick="location.href='/live/#/cars/journal/my/<?= $car->id ?>'"
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
                            <li>Year of production: <?= $car->build_date ?>. Use since: <?= $car->use_since ?></li>
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
<!--                        </ul>-->
<!--                        <ul class="achivements-list full hide">-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span-->
<!--                                        class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Morbi tristique leo id odio condimentum euismod</div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span-->
<!--                                        class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Praesent gravida fringilla velit, ac hendrerit orci-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span-->
<!--                                        class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Duis ultricies pulvinar orci ut sagittis.</div>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                        <div class="see-all">see all &rarr;</div>-->
                        <div class="btns-w clearfix">
                            <a href="javascript:void(0)" class="btn-large btn-gray waves-effect" onclick="CarActions.toExCars(<?= $car->id ?>)">move to "ex-cars"</a>
                            <a class="btn-gray btn-ui waves-effect popup-form" data-car-type="1" href="#addcar-id-<?= $car->id ?>"><span
                                    class="ico-edit-pencil-symbol"></span></a>
                            <a class="btn-gray btn-ui waves-effect popup-form"
                               onclick="CarActions.remove(<?= $car->id ?>)" data-id="<?= $car->id ?>"
                               href="#remove-item"><span
                                    class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- add car popup -->
        <form id="addcar-id-<?= $car->id ?>" class="white-popup-block mfp-hide full-btn">
            <input type="hidden" name="Car[id]" value="<?= $car->id ?>">
            <input type="hidden" name="Car[car_type]" value="1">
            <div class="row">
                <div class="col s12 marg">
                    <div class="heading center">
                        <h4>Add car</h4>
                        <div class="heading-separator">
                            <img src="/images/arba.png" alt="separator">
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <div class="btn-large btn-gray waves-effect"><div id="progress-bar"></div><input name="Car[images][]" type="file" data-update="true" data-form-id="addcar-id-<?= $car->id ?>" class="car-images"
                                                                        multiple=""><span>upload photos</span></div>
                    <div class="cars-preview">
                        <?php foreach ($car->images as $image) : ?>
                            <img src="<?= $image->src ?>" width="180">
                        <?php endforeach; ?>
                    </div>
                    <p>File format — JPEG.<br>
                        Size — any (but not less than 640×480 pixels).<br>
                        Dragging the image, you can specify the output order of pictures on the page. The first image is
                        the main.</p>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <select id="brand" name="Car[brand]">

                        <?php foreach ($carsArr as $carBrand) : ?>
                            <?php if ($carBrand == $car->brand) : ?>
                                <option value="<?= $carBrand ?>" selected><?= $carBrand ?></option>
                            <?php else : ?>
                                <option value="<?= $carBrand ?>"><?= $carBrand ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <select id="model" name="Car[model]">
                        <?php foreach ($carModels as $carModel) : ?>
                            <?php if ($carModel == $car->brand) : ?>
                                <option value="<?= $carModel ?>" selected><?= $carModel ?></option>
                            <?php else : ?>
                                <option value="<?= $carModel ?>"><?= $carModel ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <select id="modification" name="Car[modification]">
                        <?php foreach ($carModifications as $carModification) : ?>
                            <?php if ($carModification == $car->modification) : ?>
                                <option value="<?= $carModification ?>" selected><?= $carModification ?></option>
                            <?php else : ?>
                                <option value="<?= $carModification ?>"><?= $carModification ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <select id="modelYear" name="Car[build_date]">
                        <?php foreach ($carYears as $carYear) : ?>
                            <?php if ($carYear == $car->build_date) : ?>
                                <option value="<?= $carYear ?>" selected><?= $carYear ?></option>
                            <?php else : ?>
                                <option value="<?= $carYear ?>"><?= $carYear ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <select id="engine" name="Car[engine_type]">
                        <?php foreach ($carEngines as $carEngine) : ?>
                            <?php if ($carEngine == $car->engine_type) : ?>
                                <option value="<?= $carEngine ?>" selected><?= $carEngine ?></option>
                            <?php else : ?>
                                <option value="<?= $carEngine ?>"><?= $carEngine ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <select id="engine-size" name="Car[engine_size]">
                        <?php foreach ($carEngineSizes as $carEngineSize) : ?>
                            <?php if ($carEngineSize == $car->engine_size) : ?>
                                <option value="<?= $carEngineSize ?>" selected><?= $carEngineSize ?></option>
                            <?php else : ?>
                                <option value="<?= $carEngineSize ?>"><?= $carEngineSize ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <input id="capacity" name="Car[capacity]" type="text" value="<?= $car->capacity ?>">
                    <label for="capacity">Capacity</label>
                </div>
                <div class="input-field col s12">
                    <input id="car-name" name="Car[car_name]" type="text" value="<?= $car->car_name ?>">
                    <label for="carname">Own car name</label>
                </div>
                <div class="input-field col s12">
                    <input id="main-car-number" name="Car[car_number]" type="text" value="<?= $car->car_number ?>">
                    <label for="maincarnumber">Car number</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="Car[location]" id="location" class="autocomplete" value="<?= $car->location ?>" >
                    <label for="city">Car location</label>
                </div>
                <div class="input-field col s12 marg">
                    <input type="checkbox" id="maincar<?= $car->id ?>" name="Car[main_car]" class="filled-in">
                    <label for="maincar<?= $car->id ?>">Main car</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <button class="waves-effect btn-large update-car" data-car-id="<?= $car->id ?>" type="submit" name="action2">update car</button>
                </div>
            </div>
        </form>
        <!-- /add car popup -->
    <?php endforeach; ?>

<?php endif; ?>