<?php
use yii\helpers\Url;
?>
<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">My messages</li>
                <li>&rarr;</li>
                <li><a href="<?= Url::to(['/user/profile/account']) ?>">my profile</a></li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->

<!-- wrapper -->
<div class="section messages">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>My messages</h5>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l3">
                <aside class="htabs-wrap">
                    <a class="btn-large waves-effect full" href="<?= Url::to(['/user/account/profile']) ?>">back to profile</a>
                    <ul class="bordered-box edit-menu htabs">
                        <li class="tab profile-info-row">
                            <a class="active" href="#messages">All messages</a>
                        </li>
                        <li class="tab profile-info-row">
                            <a href="#umessages">Unread messages (0)</a>
                        </li>
                        <li class="tab profile-info-row">
                            <a href="#blist">Blacklist (0)</a>
                        </li>
                    </ul>
                    <a class="btn-large btn-liner waves-effect full popup-form" href="#delete">delete all dialogs</a>
                </aside>
            </div>
            <div class="col s12 m12 l9 messages-content">
                <div class="row">
                    <div class="col input-field s12">
                        <input id="susers" type="text" placeholder="Search">
                        <span class="ico-magnifier"></span>
                    </div>
                </div>
                <div id="messages">
                    <div class="alert-box-none">
                        You don't have any dialogs yet.
                    </div>
                </div>
                <div id="umessages">
                    <div class="alert-box-none">
                        You don't have any unread messages yet.
                    </div>
                </div>
                <div id="blist">
                    <div class="alert-box-none">
                        You don't have any users in your blacklist.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /wrapper -->