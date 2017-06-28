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
                    <div class="garage-car-wrap" onclick="location.href='/live/#/cars/journal/my/<?= $testdriveCar->id ?>'" style="background-image:url(<?= empty($testdriveCar->images) ? '' : $testdriveCar->images[0]->src ?>);">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
