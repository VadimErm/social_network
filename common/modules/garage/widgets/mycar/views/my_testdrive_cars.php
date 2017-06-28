<?php $carsArr = ['Audi', 'BMW', 'Chrysler'] ?>
<?php $carModels = ['model 1', 'model 2', 'model 3'] ?>
<?php $carModifications = ['model 4', 'model 5', 'model 6'] ?>
<?php $carYears = ['model 1', 'model 2', 'model 3'] ?>
<?php $carEngines = ['engine 1', 'engine 2', 'engine 3'] ?>
<?php $carEngineSizes = ['size 1', 'size 2', 'size 3']; ?>
<?php $carScores= ['1', '2', '3','4','5','6','7','8','9','10']; ?>



<?php if(!empty($testdriveCars)): ?>
    <?php foreach ($testdriveCars as $testdriveCar) : ?>
    <div class="garage-car" id="car-id-<?= $testdriveCar->id ?>">
        <div class="row">
            <div class="col s12 m6 l4">
                <div class="garage-item">
                    <div class="garage-car-wrap" onclick="location.href='/live/#/cars/journal/my/<?= $testdriveCar->id ?>'"style="background-image:url(<?= empty($testdriveCar->images) ? '' : $testdriveCar->images[0]->src ?>);">
                        <div class="score">
                            <?= $testdriveCar->score ?>/10
                        </div>
                        <div class="preview-info clearfix">
                            <div class="badge4 date-badge">
                                <span class="ico-empty-daily-calendar-page"></span><?= $testdriveCar->testdrive_date ?>
                            </div>
                            <div class="bookmark">
                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                            </div>
                        </div>
                    </div>
                    <h6 class="car-name truncate"><a href="/live/#/cars/journal/my/<?= $testdriveCar->id ?>"><?= $testdriveCar->car_name ?></a></h6>
                    <div class="car-modification truncate"><?= $testdriveCar->brand ?> / <?= $testdriveCar->model ?> / <?= $testdriveCar->modification ?>/ <?= $testdriveCar->build_date ?></div>
                    <div class="btns-w clearfix">
                        <a href="#" class="btn-large btn-liner waves-effect">learn more</a>
                        <a class="btn-gray btn-ui waves-effect popup-form" data-car-type="4" href="#addcar-id-<?= $testdriveCar->id ?>"><span
                                    class="ico-edit-pencil-symbol"></span></a>
                        <a class="btn-gray btn-ui waves-effect popup-form"
                            onclick="CarActions.remove(<?= $testdriveCar->id ?>)" data-id="<?= $testdriveCar->id ?>"
                            href="#remove-item"><span
                                class="ico-close-cross-circular-interface-button"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- add car popup -->
        <form id="addcar-id-<?= $testdriveCar->id ?>" class="white-popup-block mfp-hide full-btn">
            <input type="hidden" name="Car[id]" value="<?= $testdriveCar->id ?>">
            <input type="hidden" name="Car[car_type]" value="4">
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
                    <div class="btn-large btn-gray waves-effect"><div id="progress-bar"></div><input name="Car[images][]" type="file" data-update="true" data-form-id="addcar-id-<?= $testdriveCar->id ?>" class="car-images"
                                                                                                     multiple=""><span>upload photos</span></div>
                    <div class="cars-preview">
                        <?php foreach ($testdriveCar->images as $image) : ?>
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
                            <?php if ($carBrand == $testdriveCar->brand) : ?>
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
                            <?php if ($carModel == $testdriveCar->brand) : ?>
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
                            <?php if ($carModification == $testdriveCar->modification) : ?>
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
                            <?php if ($carYear == $testdriveCar->build_date) : ?>
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
                            <?php if ($carEngine == $testdriveCar->engine_type) : ?>
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
                            <?php if ($carEngineSize == $testdriveCar->engine_size) : ?>
                                <option value="<?= $carEngineSize ?>" selected><?= $carEngineSize ?></option>
                            <?php else : ?>
                                <option value="<?= $carEngineSize ?>"><?= $carEngineSize ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <input id="capacity" name="Car[capacity]" type="text" value="<?= $testdriveCar->capacity ?>">
                    <label for="capacity">Capacity</label>
                </div>
                <div class="input-field col s12">
                    <input id="car-name" name="Car[car_name]" type="text" value="<?= $testdriveCar->car_name ?>">
                    <label for="carname">Own car name</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="Car[location]" id="location" class="autocomplete" value="<?= $testdriveCar->location ?>" >
                    <label for="city">Car location</label>
                </div>
                <div class='input-field col s12 '>
                    <select id='used_from' name='Car[score]'>
                        <?php foreach ($carScores as $carScore): ?>
                            <?php if($carScore == $testdriveCar->score ): ?>
                                <option value="<?= $carScore ?>"  selected><?= $carScore ?></option>
                            <?php else : ?>
                                <option value="<?= $carScore ?>"><?= $carScore ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </select>

                </div>
                <div class="input-field col s12 test-drive">
                    <input id="testdrive_date" name="Car[testdrive_date]" type="text" value="<?= $testdriveCar->testdrive_date ?>">
                    <label for="testdrive_date">Testdrive date</label>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <button class="waves-effect btn-large update-car" data-car-id="<?= $testdriveCar->id ?>" type="submit" name="action2">update car</button>
                </div>
            </div>
        </form>
        <!-- /add car popup -->
    <?php endforeach; ?>
<?php endif; ?>
