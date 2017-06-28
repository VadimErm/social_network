<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<?php $this->title = 'Arba.ae / My photo albums / Edit photos'; ?>
<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">Edit photos</li>
                <li>&rarr;</li>
                <li><a href="<?= \yii\helpers\Url::to(['/user/album/single', 'id' => $all_albums_id]) ?>">all photos</a></li>
                <li>&rarr;</li>
                <li><a href="<?= \yii\helpers\Url::to(['/user/album']) ?>">my photoalbums</a></li>
                <li>&rarr;</li>
                <li><a href="<?= \yii\helpers\Url::to(['/user/account/profile']) ?>">my profile</a></li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->
<!-- wrapper -->
<div class="section photos edit-photos">
    <div class="container">
        <div class="row">
            <div class="col s12 m6 l6">
                <h5 class="truncate">Edit photos</h5>
            </div>
            <div class="col s12 m6 l6 album-btn">
                <a id="save-photo-changes" class="btn-large waves-effect" href="#">save changes</a>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="alert-box bordered-box clearfix">
                    <span class="line-p"><span class="alert-info">Selected <span class="bolder"
                                                                                 id="selected-items">0</span> of <span
                                class="bolder" id="items-count"><?= count($images) ?></span> photos</span><a href="#"
                                                                                                             id="select-all">Select all</a><a
                            href="#" id="deselect">Deselect</a></span>
                    <span class="alert-actions">
								<a href="#move-album" class="move-album popup-form">Move</a>
								<a href="#delete" class="popup-form">Delete</a>
							</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 photos-content">
                <div class="row">
                    <?php foreach ($images as $image) : ?>
                        <div class="col s12 m6 l3">
                            <div class="album-item-wrap" style="background-image:url(<?= $image->src ?>);">
                                <div class="sel-photo" data-src="<?= $image->src ?>"></div>
                                <div class="p-album-actions clearfix">
                                    <div href="#delete" class="popup-form round remove" data-src="<?= $image->src ?>">
                                        <span class="ico-close-cross-circular-interface-button"
                                              data-src="<?= $image->src ?>"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-field">
                                <input name="desc" class="description" type="text" data-src="<?= $image->src ?>"
                                       value="<?= $image->description ?>">
                                <label for="desc">Add description</label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
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
                    <?php if ($album->id != $_GET['id']) : ?>
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