<?php $carsArr = ['Audi', 'BMW', 'Chrysler'] ?>
<?php $carModels = ['model 1', 'model 2', 'model 3'] ?>
<?php $carModifications = ['model 4', 'model 5', 'model 6'] ?>
<?php $carYears = ['model 1', 'model 2', 'model 3'] ?>
<?php $carEngines = ['engine 1', 'engine 2', 'engine 3'] ?>
<?php $carEngineSizes = ['size 1', 'size 2', 'size 3']; ?>

<?php if(!empty($wishCars)): ?>
    <?php foreach ($wishCars as $wishCar) : ?>
        <div class="garage-car" id="car-id-<?= $wishCar->id ?>">
            <div class="col s12 m6 l6">
                <div class="garage-item big-car">
                    <div class="garage-car-wrap" onclick="location.href='/live/#/cars/journal/my/<?= $wishCar->id ?>'" style="background-image:url(<?= empty($wishCar->images) ? '' : $wishCar->images[0]->src ?>);">
                        <div class="preview-info clearfix">
                            <div class="bookmark">
                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                            </div>
                        </div>
                    </div>
                    <h6 class="car-name"><a href="/live/#/cars/journal/my/<?= $wishCar->id ?>"><?= $wishCar->car_name ?></a></h6>
                    <div class="car-modification"><?= $wishCar->brand ?> / <?= $wishCar->model ?> / <?= $wishCar->modification ?>/ <?= $wishCar->build_date ?></div>
                    <div class="btns-w marg clearfix">
                        <a href="/live/#/cars/journal/my/<?= $wishCar->id ?>" class="btn-large btn-liner waves-effect">view car's photos</a>
                        <a class="btn-gray btn-ui waves-effect popup-form" data-car-type="3" href="#addcar-id-<?= $wishCar->id ?>"><span
                                    class="ico-edit-pencil-symbol"></span></a>
                        <a class="btn-gray btn-ui waves-effect popup-form"
                            onclick="CarActions.remove(<?= $wishCar->id ?>)" data-id="<?= $wishCar->id ?>"
                            href="#remove-item"><span
                                class="ico-close-cross-circular-interface-button"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- add car popup -->
        <form id="addcar-id-<?= $wishCar->id ?>" class="white-popup-block mfp-hide full-btn">
            <input type="hidden" name="Car[id]" value="<?= $wishCar->id ?>">
            <input type="hidden" name="Car[car_type]" value="3">
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
                    <div class="btn-large btn-gray waves-effect"><div id="progress-bar"></div><input name="Car[images][]" type="file" data-update="true" data-form-id="addcar-id-<?= $wishCar->id ?>" class="car-images"
                                                                                                     multiple=""><span>upload photos</span></div>
                    <div class="cars-preview">
                        <?php foreach ($wishCar->images as $image) : ?>
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
                            <?php if ($carBrand == $wishCar->brand) : ?>
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
                            <?php if ($carModel == $wishCar->brand) : ?>
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
                            <?php if ($carModification == $wishCar->modification) : ?>
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
                            <?php if ($carYear == $wishCar->build_date) : ?>
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
                            <?php if ($carEngine == $wishCar->engine_type) : ?>
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
                            <?php if ($carEngineSize == $wishCar->engine_size) : ?>
                                <option value="<?= $carEngineSize ?>" selected><?= $carEngineSize ?></option>
                            <?php else : ?>
                                <option value="<?= $carEngineSize ?>"><?= $carEngineSize ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <input id="capacity" name="Car[capacity]" type="text" value="<?= $wishCar->capacity ?>">
                    <label for="capacity">Capacity</label>
                </div>
                <div class="input-field col s12">
                    <input id="car-name" name="Car[car_name]" type="text" value="<?= $wishCar->car_name ?>">
                    <label for="carname">Own car name</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="Car[location]" id="location" class="autocomplete" value="<?= $wishCar->location ?>" >
                    <label for="city">Car location</label>
                </div>


            </div>
            <div class="row">
                <div class="col s12">
                    <button class="waves-effect btn-large update-car" data-car-id="<?= $wishCar->id ?>" type="submit" name="action2">update car</button>
                </div>
            </div>
        </form>
        <!-- /add car popup -->
    <?php endforeach; ?>
<?php endif; ?>
