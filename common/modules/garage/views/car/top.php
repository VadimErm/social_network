<?php
use yii\helpers\Url;
?>
<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">Top cars</li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->

<!-- wrapper -->
<div class="section top-cars-wrap">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>Top cars filter</h5>
            </div>
        </div>
        <div class="row t-car-filter">
            <div class="input-field col s12 m6 l3">
                <select name="country">
                    <option value="" disabled>Country</option>
                    <option value="Russian Federation">Russian Federation</option>
                    <option value="USA">USA</option>
                    <option value="UAE" selected>UAE</option>
                </select>
            </div>
            <div class="input-field col s12 m6 l3">
                <input type="text" id="city" class="autocomplete" placeholder="City" value="Dubai">
            </div>
            <div class="input-field col s12 m6 l3">
                <input type="text" id="brand" class="autocomplete" placeholder="Car's brand" value="Mercedes-Benz">
            </div>
            <div class="input-field col s12 m6 l3">
                <select name="pagination">
                    <option value="10" disabled selected>Show on page: 10</option>
                    <option value="25">Show on page: 25</option>
                    <option value="50">Show on page: 50</option>
                    <option value="100">Show on page: 100</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l4">
                <div class="t-car-col">
                    <h6 class="bheader">Top cars</h6>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/garage-car1.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">777
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/top-car.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">500
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/post-preview5.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">450
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="t-car-col colored">
                    <h6 class="bheader">Top cars in Dubai</h6>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/community2.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">777
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/blog5.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">500
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/candidat2.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">450
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="t-car-col">
                    <h6 class="bheader">Top cars of Mercedes-Benz</h6>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/community4.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">777
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/blog8.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">500
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                    <div class="tcar-item">
                        <div class="tcar-item-wrap" style="background-image:url(/images/candidat1.jpg);">
                            <div class="preview-info clearfix">
                                <div class="badge4 car-rating">
                                    <img src="/images/arba2.png" alt="rating">450
                                </div>
                                <div class="bookmark">
                                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                </div>
                            </div>
                            <div class="t-car-user clearfix">
                                <div class="avatar round" style="background-image:url(/images/u-avatar1.jpg);"></div>
                                <p class="truncate"><a href="#">Aahil Asad</a></p>
                            </div>
                        </div>
                        <h6 class="car-name truncate"><a href="<?= Url::to(['/garage/car/user-car']) ?>">My favorite car Mercedes-Benz</a></h6>
                        <div class="car-modification truncate">Mercedes-Benz / W211 / Classic / 2014</div>
                        <p class="truncate">Sed nec dui ex. Fusce sollicitudin in ipsum eget lacinia.  Ut con...</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <a href="#" class="btn-large btn-gray waves-effect waves full">load more</a>
            </div>
        </div>
    </div>
</div>
<!-- /wrapper -->