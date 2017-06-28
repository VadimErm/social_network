<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Url;
?>
<?php $this->title = 'Arba.ae / My photo albums / All photos'; ?>

<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active"><?= $album_title ?></li>
                <li>&rarr;</li>
                <li><a href="<?= Url::to(['/user/album']) ?>">my photoalbums</a></li>
                <li>&rarr;</li>
                <li><a href="<?= Url::to(['/user/account/profile']) ?>">my profile</a></li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->
<div style="display:none;">
    <div id="photoalbum-gallery">
        <div class="slider-inner">
            <ul>
                <?php $i = 0; ?>
                <?php foreach ($images as $image) : ?>
                    <li data-src="<?= $image->src ?>">
                        <div class="ns-img" style="background-image:url(<?= $image->src ?>);">
                            <div class="album-actions">
                                <div class="clearfix">
                                    <?php if (!$all_photos) : ?>
                                    <div><a href="#move-album" class="popup-form move-album-single" data-album-id="<?= $id ?>" data-src="<?= $image->src ?>">Move</a></div>
                                    <div><a href="#" class="edit-image-description" data-id="<?= $i ?>">Edit</a></div>
                                    <div><a href="#delete" class="popup-form remove" data-src="<?= $image->src ?>">Delete</a></div>
                                    <div><a href="#" class="save-image-desc" data-src="<?= $image->src ?>" data-id="<?= $i ?>">Save</a></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="caption">
                            <p id="image-description-text-<?= $i ?>"><?= $image->description ?></p>
                            <div class="input-field col s12" id="desc-field-<?= $i ?>" style="display: none;">
                                                <textarea id="image-description-textarea-<?= $i ?>" name="SignupForm[summary]"
                                                          class="materialize-textarea"
                                                          length="400"><?= $image->description ?></textarea>
                                <label for="ab-text" data-error="wrong" data-success="right">Description</label>
                            </div>
                            <?php $i++; ?>
                            <div class="a-source"><a href="<?= $image->src ?>">go to source</a></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div id="cl-gallery" class="close-gallery" title="Close"><img src="/images/close.svg" alt="close"></div>
        </div>
    </div>
</div>

<!-- wrapper -->
<div class="section photos">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l6">
                <h5 class="truncate"><?= $album_title ?> <a href="#" class="gray"><?= count($images) ?></a></h5>
            </div>
            <?php if (!$all_photos) : ?>
            <div class="col s12 m12 l6 album-btn">
                <div class="btn-large waves-effect">
                    <form id="new-photos" enctype="multipart/form-data">
                        <input type="hidden" name="album_id" value="<?= $id ?>">
                        <div id="single-progress"></div>
                        <input id="new-photos-input" name="UploadImage[imageFile][]" type="file" multiple="">
                        upload photos
                    </form>
                </div>
                <a class="btn-large btn-gray waves-effect" href="<?= Url::to(['/user/album/edit', 'id' => $id]) ?>">edit album</a>
            </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col s12 photos-content gallery-content">
                <div class="row">
                    <?php $length = count($images); ?>
                    <?php for ($i = 0; $i < $length; $i++) : ?>
                        <div class="col s12 m6 l3" data-src="<?= $images[$i]->src ?>">
                            <div onclick="lightbox(<?= $i ?>)" disabled class="album-item-wrap" style="background-image:url(<?= $images[$i]->src ?>);"></div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /wrapper -->

<script>
    function lightbox(idx) {
        saveAfterConfirm = true;

        var ninjaSldr = document.getElementById('photoalbum-gallery');
        ninjaSldr.parentNode.style.display = 'block';

        nslider.init(idx);

        var clgal = document.getElementById('cl-gallery');
        clgal.click();
    }

    function clgalClick(isFullscreen) {
        if (isFullscreen) {
            var ninjaSldr = document.getElementById('photoalbum-gallery');
            ninjaSldr.parentNode.style.display = 'none';
        }
    }
</script>

<!-- /wrapper --><!-- move to album popup -->
<form id="move-album" class="white-popup-block mfp-hide full-btn">
    <div class="row">
        <div class="col s12 marg">
            <div class="heading center">
                <h4>Move photos to album</h4>
                <div class="heading-separator">
                    <img src="/images/arba.png" alt="separator">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input type="hidden" id="album-id" name="Album[id]" value="<?= $id ?>">
            <select id="choosed-album" class="validate">
                <option value="0">Choose album</option>
                <?php foreach ($albums as $album) : ?>
                    <?php if ($album->id != $id) : ?>
                        <?php if ($album->title != 'All photos') : ?>
                            <option value="<?= $album->id ?>"><?= $album->title ?></option>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <label id="album-label" for="album-title" data-error="wrong" data-success="right">Photo album title</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <button id="move-album-confirm" class="waves-effect btn-large" type="submit" name="action2">Move to album</button>
        </div>
    </div>
</form>
<!-- /add popup -->