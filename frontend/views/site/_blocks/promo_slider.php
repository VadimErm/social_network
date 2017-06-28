<!-- Promo cars block -->
<div class="section promo-cars gray-section">
    <div class="container">
        <div class="row">
            <div class="ajax-load">
                <img src="/images/ajax-loader.gif" alt="preload slider">
            </div>
            <div id="promo-cars-carousel" class="preload-slider">
                <?= \common\modules\promotion\widgets\promotion\PromotionWidget::widget([
                    'items' => [
                        [
                            'title' => 'Muscle car',
                            'description' => 'Aenean porta ipsum eget tortor tincidunt',
                            'url' => '#',
                            'src' => '/images/promo-car2.jpg'
                        ],
                        [
                            'title' => 'Muscle car',
                            'description' => 'Aenean porta ipsum eget tortor tincidunt',
                            'url' => '#',
                            'src' => '/images/promo-car2.jpg'
                        ]
                    ]
                ]) ?>
                <div class="promo-car-item">
                    <div class="promo-car-bg">
                        <div class="promo-car-preview">
                            <a href="#"><img src="/images/promo-car2.jpg" alt="promo car"></a>
                        </div>
                        <div class="promo-car-info center">
                            <h6 class="truncate"><a href="#">Muscle car</a></h6>
                            <p class="truncate">Aenean porta ipsum eget tortor tincidunt</p>
                        </div>
                    </div>
                </div>
                <div class="promo-car-item">
                    <div class="promo-car-bg">
                        <div class="promo-car-preview">
                            <a href="#"><img src="/images/promo-car3.jpg" alt="promo car"></a>
                        </div>
                        <div class="promo-car-info center">
                            <h6 class="truncate"><a href="#">Muscle car</a></h6>
                            <p class="truncate">Aenean porta ipsum eget tortor tincidunt</p>
                        </div>
                    </div>
                </div>
                <div class="promo-car-item">
                    <div class="promo-car-bg">
                        <div class="promo-car-preview">
                            <a href="#"><img src="/images/promo-car4.jpg" alt="promo car"></a>
                        </div>
                        <div class="promo-car-info center">
                            <h6 class="truncate"><a href="#">Muscle car</a></h6>
                            <p class="truncate">Aenean porta ipsum eget tortor tincidunt</p>
                        </div>
                    </div>
                </div>
                <div class="promo-car-item">
                    <div class="promo-car-bg">
                        <div class="promo-car-preview">
                            <a href="#"><img src="/images/promo-car1.jpg" alt="promo car"></a>
                        </div>
                        <div class="promo-car-info center">
                            <h6 class="truncate"><a href="#">Muscle car</a></h6>
                            <p class="truncate">Aenean porta ipsum eget tortor tincidunt</p>
                        </div>
                    </div>
                </div>
                <div class="promo-car-item">
                    <div class="promo-car-bg">
                        <div class="promo-car-preview">
                            <a href="#"><img src="/images/promo-car2.jpg" alt="promo car"></a>
                        </div>
                        <div class="promo-car-info center">
                            <h6 class="truncate"><a href="#">Muscle car</a></h6>
                            <p class="truncate">Aenean porta ipsum eget tortor tincidunt</p>
                        </div>
                    </div>
                </div>
                <div class="promo-car-item">
                    <div class="promo-car-bg">
                        <div class="promo-car-preview">
                            <a href="#"><img src="/images/promo-car1.jpg" alt="promo car"></a>
                        </div>
                        <div class="promo-car-info center">
                            <h6 class="truncate"><a href="#">Muscle car</a></h6>
                            <p class="truncate">Aenean porta ipsum eget tortor tincidunt</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 center">
                <a id="promote" class="btn-large waves-effect" href="#">promote your car</a>
            </div>
        </div>
        <div class="promo-toggle">
            <div class="row">
                <div class="col s12 m12 l3">
                    <div class="p-box bordered-box">
                        <h6>How long to promote?</h6>
                        <div class="input-field">
                            <div class="gender-item">
                                <input class="with-gap" name="ptime" type="radio" id="t1">
                                <label for="t1">30 minutes - <strong>100 A$</strong></label>
                            </div>
                        </div>
                        <div class="input-field">
                            <div class="gender-item">
                                <input class="with-gap" name="ptime" type="radio" id="t2">
                                <label for="t2">1 hour - <strong>200 A$</strong></label>
                            </div>
                        </div>
                        <div class="input-field">
                            <div class="gender-item">
                                <input class="with-gap" name="ptime" type="radio" id="t3">
                                <label for="t3">2 hours - <strong>300 A$</strong></label>
                            </div>
                        </div>
                        <div class="input-field">
                            <div class="gender-item">
                                <input class="with-gap" name="ptime" type="radio" id="t4">
                                <label for="t4">3 houres - <strong>400 A$</strong></label>
                            </div>
                        </div>
                        <div class="input-field">
                            <div class="gender-item">
                                <input class="with-gap" name="ptime" type="radio" id="t5">
                                <label for="t5">24 houres - <strong>500 A$</strong></label>
                            </div>
                        </div>
                        <div class="input-field">
                            <select name="car">
                                <option value="" disabled selected>Select your car</option>
                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                <option value="Toyota Land Cruiser">Toyota Land Cruiser</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="p-box bordered-box">
                        <h6>How does it work?</h6>

                        <p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
                        <div class="input-field">
                            <input id="entry-title" name="entry-title" type="text">
                            <label for="entry-title">Small car's description (max 40 symbols)</label>
                        </div>
                        <button class="waves-effect btn-large full" type="submit" name="send">start promotion</button>
                    </div>
                </div>
                <div class="col s12 m12 l3">
                    <div class="p-box bordered-box">
                        <div class="center">
                            <h6>Your balance</h6>
                        </div>
                        <div class="a-count">0 A$</div>
                        <div class="center">
                            <a href="user-premium-balance.html" class="charge">Charge the balance</a>
                        </div>
                        <div class="pay-separator">
                            <p>If you have any questions or problems, please, let us know via email - <a href="mailto:PremiumSupport@arba.ae">PremiumSupport@arba.ae</a></p>
                            <a href="#" class="charge">Download contract offer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Promo cars block -->