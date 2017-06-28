<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">My messages</li>
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
<div class="section messages dialog-single">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>My messages</h5>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l3">
                <aside class="htabs-wrap">
                    <a class="btn-large waves-effect full" href="<?= \yii\helpers\Url::to(['/message']) ?>">back to dialogs</a>
                    <ul class="bordered-box edit-menu">
                        <li class="profile-info-row">
                            <a href="#del-user" class="popup-form">Block user</a>
                        </li>
                        <li class="profile-info-row">
                            <a href="#clear" class="popup-form">Clear history</a>
                        </li>
                        <li class="profile-info-row">
                            <a href="#deldialog" class="popup-form">Delete dialog</a>
                        </li>
                    </ul>
                </aside>
            </div>
            <div class="col s12 m12 l9 messages-content">
                <div class="row">
                    <div class="col input-field s12">
                        <input id="susers" type="text" placeholder="Search">
                        <span class="ico-magnifier"></span>
                    </div>
                </div>
                <div class="alert-box bordered-box clearfix">
                    <span class="line-p"><span class="alert-info"><span class="bolder">2 messages</span></span><a href="#">Forward</a><a href="#">Delete</a></span>
                </div>
                <div class="dialogs-outer">
                    <div class="dialogs-inner">
                        <ul class="dialogs-wrap">
                            <li class="fuser-row clearfix">
                                <div class="sel-message active"></div>
                                <div class="u-avatar round small">
                                    <img src="/images/u-avatar1.jpg" alt="user avatar">
                                </div>
                                <div class="u-body">
                                    <a href="#" class="bolder">Aahil Asad</a>
                                    <div class="entry-date">Posted on 30.11.2016, 09:46 am</div>
                                    <p class="sub-title">
                                        Hi, Bob! How are you?
                                    </p>
                                </div>
                            </li>
                            <li class="fuser-row clearfix">
                                <div class="sel-message"></div>
                                <div class="u-avatar round small">
                                    <img src="/images/u-avatar2.jpg" alt="user avatar">
                                </div>
                                <div class="u-body">
                                    <a href="#" class="bolder">Samira mamira</a>
                                    <div class="entry-date">Posted on 30.11.2016, 09:46 am</div>
                                    <p class="sub-title">
                                        Hi, I’m fine!
                                    </p>
                                </div>
                            </li>
                            <li class="fuser-row clearfix">
                                <div class="sel-message active"></div>
                                <div class="u-avatar round small">
                                    <img src="/images/u-avatar1.jpg" alt="user avatar">
                                </div>
                                <div class="u-body">
                                    <a href="#" class="bolder">Aahil Asad</a>
                                    <div class="entry-date">Posted on 30.11.2016, 09:46 am</div>
                                    <p class="sub-title">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dignissim diam nec lacus sodales lacinia. Duis imperdiet urna id laoreet ullamcorper. Nulla eleifend rutrum odio non dictum. Donec elementum massa est, sit amet scelerisque ante lobortis ac. Sed consequat consequat elit sit amet laoreet. Suspendisse a viverra urna. Nulla nec fringilla dolor.
                                    </p>
                                </div>
                            </li>
                            <li class="fuser-row clearfix">
                                <div class="sel-message"></div>
                                <div class="u-avatar round small">
                                    <img src="/images/u-avatar2.jpg" alt="user avatar">
                                </div>
                                <div class="u-body">
                                    <a href="#" class="bolder">Samira mamira</a>
                                    <div class="entry-date">Posted on 30.11.2016, 09:46 am</div>
                                    <p class="sub-title">
                                        Mauris posuere, neque nec vehicula pretium, massa mi pretium nisl, sed posuere arcu risus ac augue.
                                    </p>
                                </div>
                            </li>
                            <li class="fuser-row clearfix">
                                <div class="sel-message"></div>
                                <div class="u-avatar round small">
                                    <img src="/images/u-avatar1.jpg" alt="user avatar">
                                </div>
                                <div class="u-body">
                                    <a href="#" class="bolder">Aahil Asad</a>
                                    <div class="entry-date">Posted on 30.11.2016, 09:46 am</div>
                                    <p class="sub-title">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dignissim diam nec lacus sodales lacinia. Duis imperdiet urna id laoreet ullamcorper. Nulla eleifend rutrum odio non dictum. Donec elementum massa est, sit amet scelerisque ante lobortis ac. Sed consequat consequat elit sit amet laoreet. Suspendisse a viverra urna. Nulla nec fringilla dolor.
                                    </p>
                                </div>
                            </li>
                            <li class="fuser-row clearfix">
                                <div class="sel-message"></div>
                                <div class="u-avatar round small">
                                    <img src="/images/u-avatar2.jpg" alt="user avatar">
                                </div>
                                <div class="u-body">
                                    <a href="#" class="bolder">Samira mamira</a>
                                    <div class="entry-date">Posted on 30.11.2016, 09:46 am</div>
                                    <p class="sub-title">
                                        Mauris posuere, neque nec vehicula pretium, massa mi pretium nisl, sed posuere arcu risus ac augue.
                                    </p>
                                </div>
                            </li>
                            <li class="fuser-row clearfix">
                                <div class="sel-message"></div>
                                <div class="u-avatar round small">
                                    <img src="/images/u-avatar1.jpg" alt="user avatar">
                                </div>
                                <div class="u-body">
                                    <a href="#" class="bolder">Aahil Asad</a>
                                    <div class="entry-date">Posted on 30.11.2016, 09:46 am</div>
                                    <p class="sub-title">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dignissim diam nec lacus sodales lacinia. Duis imperdiet urna id laoreet ullamcorper. Nulla eleifend rutrum odio non dictum. Donec elementum massa est, sit amet scelerisque ante lobortis ac. Sed consequat consequat elit sit amet laoreet. Suspendisse a viverra urna. Nulla nec fringilla dolor.
                                    </p>
                                </div>
                            </li>
                            <li class="fuser-row clearfix">
                                <div class="sel-message"></div>
                                <div class="u-avatar round small">
                                    <img src="/images/u-avatar2.jpg" alt="user avatar">
                                </div>
                                <div class="u-body">
                                    <a href="#" class="bolder">Samira mamira</a>
                                    <div class="entry-date">Posted on 30.11.2016, 09:46 am</div>
                                    <p class="sub-title">
                                        Mauris posuere, neque nec vehicula pretium, massa mi pretium nisl, sed posuere arcu risus ac augue.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pos-rel">
                    <div class="bordered-box add-post">
                        <div class="bordered-box-content">
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="entry-text" class="materialize-textarea"></textarea>
                                    <label for="entry-text">Message</label>
                                </div>
                                <div class="col s12">
                                    <a href="#" class="waves-effect btn-large">submit</a>
                                    <div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
                                    <a class="btn-gray btn-ui waves-effect popup-form" href="#addvideo"><span class="ico-video-camera"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /wrapper -->

<!-- Dialog popup -->
<form id="clear" class="white-popup-block dialog-pop mfp-hide">
    <div class="heading">
        <button type="button"><span class="ico-close-cross-circular-interface-button"></span></button>
    </div>
    <div class="dialog-popup center">
        <h6>Clear history</h6>
        <p>Are you sure? All messages will be removed.</p>
        <a href="#" class="btn-large waves-effect">Yes</a><a href="#" class="btn-large btn-gray waves-effect">cancel</a>
    </div>
</form>
<!-- /Dialog popup -->

<!-- Dialog popup -->
<form id="deldialog" class="white-popup-block dialog-pop mfp-hide">
    <div class="heading">
        <button type="button"><span class="ico-close-cross-circular-interface-button"></span></button>
    </div>
    <div class="dialog-popup center">
        <h6>Delete dialog</h6>
        <p>Are you sure? All messages will be removed too.</p>
        <a href="#" class="btn-large waves-effect">Yes</a><a href="#" class="btn-large btn-gray waves-effect">cancel</a>
    </div>
</form>
<!-- /Dialog popup -->

<!-- Dialog popup -->
<form id="del-user" class="white-popup-block dialog-pop mfp-hide">
    <div class="heading">
        <button type="button"><span class="ico-close-cross-circular-interface-button"></span></button>
    </div>
    <div class="dialog-popup center">
        <h6>Block Aahil Asad</h6>
        <p>Are you sure?</p>
        <a href="#" class="btn-large waves-effect">Yes</a><a href="#" class="btn-large btn-gray waves-effect">cancel</a>
    </div>
</form>
<!-- /Dialog popup -->