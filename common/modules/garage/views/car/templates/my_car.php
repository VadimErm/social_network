<template id="my-car-tpl">
    <div class="garage-car">
        <div class="row">
            <div class="col s12 m12 l6">
                <div class="garage-item big-car">
                    <div class="garage-car-wrap" style="background-image:url({{images.[0].src}}?v=<?php echo time() ?>);">
                        <div class="preview-info clearfix">
                            {{#if main_car}}
                            <div class="badge1 award-badge">
                                main car
                            </div>
                            {{/if}}
                            <div class="bookmark">
                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l6">
                <div class="car-info">
                    <?php /*<h6 class="car-name"><a href="/garage/car/view/{{id}}">{{car_name}}</a></h6>*/ ?>
                    <h6 class="car-name"><a href="/live/#/cars/journal/my/{{id}}">{{car_name}}</a></h6>
                    <div class="car-modification">{{brand}} / {{model}} / {{modification}} / {{year}}</div>
                    <div class="block-meta">
                        <div class="meta-item"><a href="#"><span
                                    class="ico-heart-outline"></span>100</a></div>
                        <div class="meta-item"><a href="#"><span class="ico-user-outline-shape"></span>167
                                followers</a></div>
                        <div class="meta-item"><a href="#"><span
                                    class="ico-maps-placeholder-outlined-tool"></span>{{location}}</a></div>
                        <div class="meta-item"><a href="#"><span
                                    class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a>
                        </div>
                    </div>
                    <ul class="list-sep">
                        <li>Year of production: 2015. Use since: 2016</li>
                        <li>Engine: {{engine}}</li>
                        <li>Engine size: {{engine_size}}</li>
                        <li>Capacity: 240 Hp</li>
                    </ul>
                    <h6 class="car-arch">Car’s achivements</h6>
                    <ul class="achivements-list">
                        <li>
                            <div class="icon-left"><span
                                    class="ico-sports-or-education-trophy-cup"></span></div>
                            <div class="ach-desc">Most popular blog in <a href="#">December 2017</a>
                            </div>
                        </li>
                        <li>
                            <div class="icon-left"><span
                                    class="ico-sports-or-education-trophy-cup"></span></div>
                            <div class="ach-desc">Nullam posuere sem at justo sodales, in finibus in <a
                                    href="#">December 2017</a></div>
                        </li>
                    </ul>
                    <ul class="achivements-list full hide">
                        <li>
                            <div class="icon-left"><span
                                    class="ico-sports-or-education-trophy-cup"></span></div>
                            <div class="ach-desc">Morbi tristique leo id odio condimentum euismod</div>
                        </li>
                        <li>
                            <div class="icon-left"><span
                                    class="ico-sports-or-education-trophy-cup"></span></div>
                            <div class="ach-desc">Praesent gravida fringilla velit, ac hendrerit orci
                            </div>
                        </li>
                        <li>
                            <div class="icon-left"><span
                                    class="ico-sports-or-education-trophy-cup"></span></div>
                            <div class="ach-desc">Duis ultricies pulvinar orci ut sagittis.</div>
                        </li>
                    </ul>
                    <div class="see-all">see all &rarr;</div>
                    <div class="btns-w clearfix">
                        <a href="#" class="btn-large btn-gray waves-effect" >move to "ex-cars"</a>
                        <a class="btn-gray btn-ui waves-effect" href="#"><span
                                class="ico-edit-pencil-symbol"></span></a>
                        <a class="btn-gray btn-ui waves-effect popup-form" href="#remove-item"><span
                                class="ico-close-cross-circular-interface-button"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>