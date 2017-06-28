<?php $carsArr = ['Audi', 'BMW', 'Chrysler'] ?>
<?php $carModels = ['model 1', 'model 2', 'model 3'] ?>
<?php $carModifications = ['model 4', 'model 5', 'model 6'] ?>
<?php $carYears = ['model 1', 'model 2', 'model 3'] ?>
<?php $carEngines = ['engine 1', 'engine 2', 'engine 3'] ?>
<?php $carEngineSizes = ['size 1', 'size 2', 'size 3']; ?>
<?php $usedFromYears = ['2013', '2014', '2015']; ?>
<?php $usedToYears = ['2014', '2015', '2016']; ?>

<?php if(!empty($exCars)): ?>
    <?php foreach ($exCars as $exCar) : ?>
            <div class="col s12 m6 l4" id="car-id-<?= $exCar->id ?>">
                <div class="garage-item">
                    <div class="garage-car-wrap" onclick="location.href='/live/#/cars/journal/my/<?= $exCar->id ?>'"style="background-image:url(<?= empty($exCar->images) ? '' : $exCar->images[0]->src ?>);">
                        <div class="preview-info clearfix">
                            <div class="bookmark">
                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                            </div>
                            <div class="badge4 car-rating">
                                <span class="ico-favorites-star-outlined-symbol"></span>0
                            </div>
                        </div>
                    </div>
                    <h6 class="car-name truncate"><a href="/live/#/cars/journal/my/<?= $exCar->id ?>"><?= $exCar->car_name ?></a></h6>
                    <div class="car-modification truncate"><?= $exCar->brand ?> / <?= $exCar->model ?> / <?= $exCar->modification ?>/ <?= $exCar->build_date ?></div>
                    <div class="block-meta">
                        <div class="meta-item"><a href="#"><span class="ico-heart-outline"></span>100</a>
                        </div>
                        <div class="meta-item"><a href="#"><span class="ico-user-outline-shape"></span>167
                                followers</a></div>
                    </div>
                    <p class="truncate">Used from <?= $exCar->use_since ?> to <?= $exCar->used_year_to ?>.</p>
                    <div class="btns-w clearfix">
                        <a href="javascript:void(0)" class="btn-large btn-gray waves-effect" onclick="CarActions.toMyCars(<?= $exCar->id ?>)">move to "my cars"</a>
                        <a class="btn-gray btn-ui waves-effect popup-form" data-car-type="2" href="#addcar-id-<?= $exCar->id ?>"><span
                                    class="ico-edit-pencil-symbol"></span></a>
                        <a class="btn-gray btn-ui waves-effect popup-form"
                           onclick="CarActions.remove(<?= $exCar->id ?>)" data-id="<?= $exCar->id ?>"
                           href="#remove-item"><span
                                    class="ico-close-cross-circular-interface-button"></span>
                        </a>
                    </div>
                </div>
            </div>
        <!-- add car popup -->
        <form id="addcar-id-<?= $exCar->id ?>" class="white-popup-block mfp-hide full-btn">
            <input type="hidden" name="Car[id]" value="<?= $exCar->id ?>">
            <input type="hidden" name="Car[car_type]" value="2">
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
                    <div class="btn-large btn-gray waves-effect"><div id="progress-bar"></div><input name="Car[images][]" type="file" data-update="true" data-form-id="addcar-id-<?= $exCar->id ?>" class="car-images"
                                                                                                     multiple=""><span>upload photos</span></div>
                    <div class="cars-preview">
                        <?php foreach ($exCar->images as $image) : ?>
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
                            <?php if ($carBrand == $exCar->brand) : ?>
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
                            <?php if ($carModel == $exCar->brand) : ?>
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
                            <?php if ($carModification == $exCar->modification) : ?>
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
                            <?php if ($carYear == $exCar->build_date) : ?>
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
                            <?php if ($carEngine == $exCar->engine_type) : ?>
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
                            <?php if ($carEngineSize == $exCar->engine_size) : ?>
                                <option value="<?= $carEngineSize ?>" selected><?= $carEngineSize ?></option>
                            <?php else : ?>
                                <option value="<?= $carEngineSize ?>"><?= $carEngineSize ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <input id="capacity" name="Car[capacity]" type="text" value="<?= $exCar->capacity ?>">
                    <label for="capacity">Capacity</label>
                </div>
                <div class="input-field col s12">
                    <input id="car-name" name="Car[car_name]" type="text" value="<?= $exCar->car_name ?>">
                    <label for="carname">Own car name</label>
                </div>
                <div class="input-field col s12">
                    <input id="main-car-number" name="Car[car_number]" type="text" value="<?= $exCar->car_number ?>">
                    <label for="maincarnumber">Car number</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="Car[location]" id="location" class="autocomplete" value="<?= $exCar->location ?>" >
                    <label for="city">Car location</label>
                </div>

                <div class='input-field col s12 used-years'>
                    <select id='used_from' name='Car[use_since]'>
                        <?php foreach ($usedFromYears as $usedFromYear): ?>
                            <?php if($usedFromYear == $exCar->use_since ): ?>
                                    <option value="<?= $usedFromYear ?>"  selected><?= $usedFromYear ?></option>
                            <?php else : ?>
                                    <option value="<?= $usedFromYear ?>"><?= $usedFromYear ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </select>
                    <select id='used_to' name='Car[used_year_to]'>
                        <?php foreach ($usedToYears  as $usedToYear): ?>
                            <?php if($usedToYear == $exCar->used_year_to ): ?>
                                <option value="<?= $usedToYear ?>"  selected><?= $usedToYear ?></option>
                            <?php else : ?>
                                <option value="<?= $usedToYear ?>"><?= $usedToYear ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <button class="waves-effect btn-large update-car" data-car-id="<?= $exCar->id ?>" type="submit" name="action2">update car</button>
                </div>
            </div>
        </form>
        <!-- /add car popup -->
    <?php endforeach; ?>
<?php endif; ?>