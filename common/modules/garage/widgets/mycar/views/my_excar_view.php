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
        <div class="garage-car" id="car-id-<?= $exCar->id ?>">
            <div class="col s12 m6 l4">
                <div class="garage-item">
                    <div class="garage-car-wrap" onclick="location.href='/live/#/cars/journal/my/<?= $exCar->id ?>'" style="background-image:url(<?= empty($exCar->images) ? '' : $exCar->images[0]->src ?>);">
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
                    <p class="truncate">Used from <?= $exCar->used_year_from ?> to <?= $exCar->used_year_to ?>.</p>
                    <div class="btns-w clearfix">
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>