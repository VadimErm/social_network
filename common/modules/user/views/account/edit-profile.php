<?php
$options = [
    'depends' => \frontend\assets\SocialAsset::className(),
    'position' => \yii\web\View::POS_END
];

$this->registerJsFile('/js/upload.preview.js', $options);
$this->registerJsFile('/js/change.password.js', $options);
$this->registerJsFile('/js/delete.avatar.js', $options);
?>

<!-- Edit wrapper -->
<div class="section sticky-wrap">
    <div class="container">
        <div class="row">
            <div class="col hide-on-med-and-down l3">
                <aside>
                    <a class="btn-large waves-effect" href="<?= \yii\helpers\Url::to(['/user/account/profile']) ?>">back
                        to profile</a>
                    <div class="sticky-item">
                        <div class="bordered-box edit-menu">
                            <div class="profile-info-row">
                                <a href="#basic">Basic information</a>
                            </div>
                            <div class="profile-info-row">
                                <a href="#about">about me</a>
                            </div>
                            <div class="profile-info-row">
                                <a href="#password">edit password</a>
                            </div>
                            <div class="profile-info-row">
                                <a href="#location">location</a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="col s12 m12 l9 profile-content">
                <form action="<?= \yii\helpers\Url::to(['/user/account/change']) ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->getCsrfToken() ?>">
                    <div class="profile-wrap">
                        <div class="bordered-box edit-box">
                            <div class="bordered-box-top" id="basic">
                                <h6>Basic information</h6>
                            </div>
                            <div class="bordered-box-content">
                                <div class="upload-photo valign-wrapper">
                                    <div class="u-avatar uploaded round">
                                        <img src="<?= $avatar ?>" id="avatar" alt="avatar">
                                    </div>
                                    <a class="btn-gray btn-ui waves-effect" href="javascript:void(0)" id="delete-avatar"><span
                                            class="ico-close-cross-circular-interface-button"></span></a>
                                    <div class="btn-large btn-gray waves-effect"><input id='avatar-file' type="file"
                                                                                        name="SignupForm[avatarFile]"
                                                                                        ><span>update photo</span>
                                    </div>
                                    <span class="l-tooltip">We recommend to use JPEG image 256x256px</span>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <input id="login" name="SignupForm[username]" type="text" class="validate"
                                               value="<?= $user->username ?>">
                                        <label for="login">Nickname</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="email" name="SignupForm[email]" type="email" class="validate"
                                               value="<?= $user->email ?>">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <input id="fname" name="SignupForm[first_name]" type="text" class="validate"
                                               value="<?= $account->first_name ?>">
                                        <label for="fname">First name</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="lname" name="SignupForm[last_name]" type="text" class="validate"
                                               value="<?= $account->last_name ?>">
                                        <label for="lname">Last name</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <input type="checkbox" class="filled-in" id="hide-name"
                                               name="SignupForm[show_real_name]" <?= $account->show_real_name == 1 ? 'checked' : '' ?>
                                               value="1">
                                        <label for="hide-name" class="hide-name">Don’t show my real name</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <div class="gender-item">
                                            <input class="with-gap" type="radio" name="SignupForm[gender]"
                                                   id="male" <?= $account->gender == 1 ? 'checked' : '' ?> value="1">
                                            <label for="male">Male</label>
                                        </div>
                                        <div class="gender-item">
                                            <input class="with-gap" type="radio" name="SignupForm[gender]"
                                                   id="female" <?= $account->gender == 2 ? 'checked' : '' ?> value="2">
                                            <label for="female">Female</label>
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="phone" name="SignupForm[phone]" type="tel" class="validate"
                                               value="<?= $account->phone ?>">
                                        <label for="phone">Phone number</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="datepick" name="SignupForm[birthday]" type="text" class="ddate"
                                               value="<?= $account->birthday ?>">
                                        <label for="datepick">Birthdate</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="checkbox" class="filled-in" id="hide-date"
                                               name="SignupForm[show_real_birthday]" <?= $account->show_real_birthday == 1 ? 'checked' : '' ?>
                                               value="1">
                                        <label for="hide-date">Don’t show my real birth day</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <?php $accountLanguage = []; ?>
                                        <select name="SignupForm[languages][]" multiple>
                                            <option value="0" disabled>Choose your language</option>
                                            <?php foreach ($account->languages as $language) : ?>
                                                <?php
                                                    $accountLanguages[] = $language->title;
                                                ?>
                                            <?php endforeach; ?>

                                            <?php foreach ($languages as $language) : ?>
                                                <?php if (in_array($language, $accountLanguages)) : ?>
                                                    <option selected value="<?= $language ?>"><?= $language ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $language ?>"><?= $language ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bordered-box edit-box">
                            <div class="bordered-box-top" id="about">
                                <h6>About me</h6>
                            </div>
                            <div class="bordered-box-content">
                                <div class="row">
                                    <div class="input-field col s12">
                                    <textarea name="SignupForm[summary]" id="ab-text" class="materialize-textarea"
                                              length="400"><?= $account->summary ?></textarea>
                                        <label for="ab-text">About me</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bordered-box edit-box">
                            <div class="bordered-box-top" id="password">
                                <h6>Edit password</h6>
                            </div>
                            <div class="bordered-box-content">
                                <div class="row">
                                    <div class="input-field col s12 m12 l4">
                                        <input id="password-field" type="password" class="validate">
                                        <label for="pass">Password</label>
                                    </div>
                                    <div class="input-field col s12 m6 l4">
                                        <input id="new-password-field" type="password" class="validate">
                                        <label for="npass">New password</label>
                                    </div>
                                    <div class="input-field col s12 m6 l4">
                                        <input id="confirm-password-field" type="password" class="validate">
                                        <label for="repnpass">Confirm new password</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <a id="change-password" class="btn-large waves-effect" href="#">Change
                                            password</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bordered-box edit-box last">
                            <div class="bordered-box-top" id="location">
                                <h6>Location</h6>
                            </div>
                            <div class="bordered-box-content">
                                <div class="row">
                                    <div class="input-field col s12 m6 l6">
                                        <select name="SignupForm[country]">
                                            <?php $selected = ''; ?>
                                            <?php foreach ($countries as $country) : ?>
                                                <?php if ($country == $account->country->title) : ?>
                                                    <?php $selected = 'selected'; ?>
                                                <?php else : ?>
                                                    <?php $selected = ''; ?>
                                                <?php endif; ?>
                                                <option
                                                    value="<?= $country ?>" <?= $selected ?>><?= $country ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m6 l6">
                                        <input type="text" id="city" name="SignupForm[city]" class="autocomplete"
                                               value="<?= $account->city->title ?>">
                                        <label for="city">City</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style>i input[type="submit"] { width: 100%; height: 100%; }</style>
                        <input type="submit" class="btn-large waves-effect full" value="update profile" >
                        <!--                    <a class="" href="#">update profile</a>-->

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit wrapper -->