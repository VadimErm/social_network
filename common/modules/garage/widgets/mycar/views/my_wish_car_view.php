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
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
