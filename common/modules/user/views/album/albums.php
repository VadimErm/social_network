<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Url;
?>
<?php $this->title = 'Arba.ae / My photo albums'; ?>
<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">My photo albums</li>
                <li>&rarr;</li>
                <li><a href="<?= Url::to(['/user/account/profile']) ?>">my profile</a></li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->

<!-- wrapper -->
<div class="section photos">
    <div class="container">
        <div class="row">
            <div class="col s12 m8 l9">
                <h5>My Photo Albums <a href="#" class="gray"><?= count($albums) ?></a></h5>
            </div>
            <div class="col s12 m4 l3 addalbum">
                <a href="#newalbum" class="btn-large waves-effect popup-form">add photo album</a>
            </div>
        </div>
        <div class="row">
            <div class="col s12 photos-content">
                <div class="row">
                    <?php if (count($albums) == 2) : ?>
                        <div class="col s12">
                            <div class="alert-box-none">
                                You don't have any photos yet.
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php $countImages = 0; ?>
                    <?php $allPhotosPreviewImage = ''; ?>

                    <?php foreach ($albums as $album) {
                        if (!empty($album->images)) {
                            $allPhotosPreviewImage = $album->images[0]->src;
                        }

                        $countImages += count($album->images);
                    }
                    ?>

                    <?php foreach ($albums as $album) : ?>
                        <div class="col s12 m6 l4" data-id="<?= $album->id ?>">
                        <a href="<?= Url::to(['/user/album/single', 'id' => $album->id]) ?>">
                            <?php $count = count($album->images); ?>
                            <?php if ($countImages > 0 && in_array($album->title, ['All photos'])) : ?>

                            <div class="album-item-wrap" style="background-image:url(<?= $allPhotosPreviewImage ?>);">
                            <?php else : ?>
                            <div class="album-item-wrap" style="<?= $count == 0 ? '' : 'background-image:url('.$album->images[0]->src.');' ?>">
                            <?php endif; ?>
                                <?php if (!in_array($album->title, ['Saved photos', 'All photos'])) : ?>
                                    <div class="p-album-actions clearfix">
                                    <div href="#delete-album" class="remove-album popup-form round" data-id="<?= $album->id ?>">
                                        <span class="ico-close-cross-circular-interface-button" data-id="<?= $album->id ?>"></span>
                                    </div>
                                    <div class="round" onClick="window.open('/user/album/edit?id=<?= $album->id ?>','_top'); return false;">
                                        <span class="ico-edit-pencil-symbol"></span>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="p-album-title clearfix">
                                    <?php if (in_array($album->title, ['All photos'])) : ?>
                                        <div class="p-album-counter"><?= $countImages ?></div>
                                    <?php else : ?>
                                        <div class="p-album-counter"><?= count($album->images) ?></div>
                                    <?php endif; ?>
                                    <div class="p-album-name"><?= $album->title ?></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /wrapper -->
<!-- delete album popup -->
<form id="delete-album" class="white-popup-block dialog-pop mfp-hide">
    <div class="heading">
        <button type="button"><span class="ico-close-cross-circular-interface-button"></span></button>
    </div>
    <div class="dialog-popup center">
        <h6>Delete album</h6>
        <p>Are you sure?</p>
        <a href="#" id="remove-album-confirm" class="btn-large waves-effect">Yes</a>
        <a href="#" id="cancel-photo-delete" class="btn-large btn-gray waves-effect modal-close">cancel</a>
    </div>
</form>
<!-- /Dialog popup -->