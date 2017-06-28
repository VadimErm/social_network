<?php
/**
 * @var $model \frontend\models\SignupForm
 * @var $this \yii\web\View
 * @var $exception Exception
 */
use \common\helpers\ValidationHelper;
$this->title = 'Arba.ae / Registration';
$options = [
    'depends' => \frontend\assets\SocialAsset::className(),
    'position' => \yii\web\View::POS_END
];
$this->registerJsFile('/js/jquery.validate.min.js', $options);
$this->registerJsFile('/js/register.js', $options);
$this->registerCssFile('/css/materialize.validation.fix.css');
$this->registerJsFile('/js/upload.preview.js', $options);
?>
<?= $this->render('_blocks/breadcrums', [
    'category' => 'registration',
    'page' => 'main',
    'url' => '/'
]) ?>
<!-- Registration wrapper -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="bordered-box register">
                    <div class="row">
                        <div class="col s12">
                            <div class="bordered-box-top">
                                <h6>Registration</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l10 offset-l1">
                            <div class="bordered-box-content">

                                <?php if (isset($exception)) : ?>
                                    <span style="color: red;"><?= $exception->getMessage() ?></span>
                                <?php endif; ?>
                                <form action="<?= \yii\helpers\Url::to(['site/signup']) ?>" id="registration"
                                      method="post" enctype="multipart/form-data">
                                    <input type="text" name="<?= Yii::$app->request->csrfParam ?>" style="display: none;"
                                           value="<?= Yii::$app->request->csrfToken; ?>">
                                    <div class="upload-photo valign-wrapper">
                                        <div class="u-avatar round">
                                            <img id="avatar" src="/images/no-avatar.png" alt="no avatar">
                                        </div>
                                        <div class="btn-large btn-gray waves-effect"><div id="progress-bar"></div>
                                            <input id="avatar-file" type="file" name="SignupForm[avatarFile]" multiple=""><span>upload photo</span>
                                        </div>
                                        <span class="l-tooltip">We recommend to use JPEG image 256x256px</span>
                                    </div>
                                    <div class="form-wrapper">
                                        <div class="row">
                                            <div class="input-field col s12 m6">
                                                <input id="login" name="SignupForm[username]" type="text"
                                                       class="validate <?= ValidationHelper::isInvalid($model,
                                                           'username') ?>" value="<?= $model->username ?>">
                                                <label id="login-label" for="login" data-error="<?= ValidationHelper::getError($model,
                                                    'username') ?>" data-success="right" class="active">
                                                    Nickname
                                                </label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="email" name="SignupForm[email]" type="email"
                                                       class="validate <?= ValidationHelper::isInvalid($model,
                                                           'email') ?>" value="<?= $model->email ?>">
                                                <label for="email"
                                                       data-error="<?= ValidationHelper::getError($model, 'email') ?>"
                                                       data-success="right">Email</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="pass" name="SignupForm[password]" type="password"
                                                       class="validate <?= ValidationHelper::isInvalid($model,
                                                           'password') ?>" value="<?= $model->password ?>">
                                                <label id="password-label" for="pass" data-error="<?= ValidationHelper::getError($model,
                                                    'password') ?>" data-success="right">Password</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="confirm-password" name="SignupForm[passwordConfirm]" type="password"
                                                       class="validate <?= ValidationHelper::isInvalid($model,
                                                           'passwordConfirm') ?>" value="<?= $model->passwordConfirm ?>">
                                                <label for="pass" data-error="<?= ValidationHelper::getError($model,
                                                    'passwordConfirm') ?>" data-success="right">Confirm password</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input id="phone" name="SignupForm[phone]" type="tel"
                                                       class="validate <?= ValidationHelper::isInvalid($model,
                                                           'phone') ?>" value="<?= $model->phone ?>">
                                                <label id="phone-label" for="phone"
                                                       data-error="<?= ValidationHelper::getError($model, 'phone') ?>"
                                                       data-success="">Phone number</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="fname" name="SignupForm[first_name]" type="text"
                                                       class="validate <?= ValidationHelper::isInvalid($model,
                                                           'first_name') ?>" value="<?= $model->first_name ?>">
                                                <label id="fname-label" for="fname" data-error="<?= ValidationHelper::getError($model,
                                                    'first_name') ?>" data-success="right">First name</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="lname" name="SignupForm[last_name]" type="text"
                                                       class="validate <?= ValidationHelper::isInvalid($model,
                                                           'last_name') ?>" value="<?= $model->first_name ?>">
                                                <label id="lname-label" for="lname" data-error="<?= ValidationHelper::getError($model,
                                                    'last_name') ?>" data-success="right">Last name</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input type="checkbox" name="SignupForm[show_real_name]"
                                                       class="filled-in" value="1"
                                                       id="hide-name">
                                                <label for="hide-name" class="hide-name">Don’t show my real name</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <div class="gender-item">
                                                    <input class="with-gap" name="SignupForm[gender]" checked
                                                           type="radio" id="male" value="1">
                                                    <label for="male">Male</label>
                                                </div>
                                                <div class="gender-item">
                                                    <input class="with-gap" name="SignupForm[gender]" type="radio"
                                                           id="female" value="2">
                                                    <label for="female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="datepick" name="SignupForm[birthday]" type="text"
                                                       class="ddate validate" value="<?= $model->birthday ?>">
                                                <label id="datepick-label" for="datepick" data-error="wrong" data-success="right">Birthdate</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="checkbox" name="SignupForm[show_real_birthday]"
                                                       class="filled-in" id="hide-date" value="1">
                                                <label for="hide-date">Don’t show my real birth day</label>
                                            </div>
                                            <div id="language-block" class="input-field col s12">
                                                <select id="languages" name="SignupForm[languages][]" multiple>
                                                    <option value="" disabled selected>Choose your language</option>
                                                    <option value="English">English</option>
                                                    <option value="Arabic">Arabic</option>
                                                    <option value="French">French</option>
                                                    <option value="German">German</option>
                                                    <option value="Italian">Italian</option>
                                                    <option value="Russian">Russian</option>
                                                </select>
                                                <span style="color:red;"><?= ValidationHelper::getSelectError($model, 'languages') ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="country-block" class="input-field col s12 m6">
                                                <select id="country" name="SignupForm[country]">
                                                    <option value="" disabled selected>Country</option>
                                                    <option value="Russian Federation">Russian Federation</option>
                                                    <option value="USA">USA</option>
                                                    <option value="UAE">UAE</option>
                                                </select>
                                                <span style="color:red;"><?= ValidationHelper::getSelectError($model, 'country') ?></span>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input type="text" id="city" name="SignupForm[city]" value="<?= $model->city ?>"
                                                       class="autocomplete <?= ValidationHelper::isInvalid($model,
                                                           'city') ?>">
                                                <label for="city" data-error="<?= ValidationHelper::getError($model, 'city') ?>" data-success="right">City</label>
                                            </div>
                                        </div>
                                        <div class="row marg">
                                            <div class="input-field col s12">
                                                <textarea id="ab-text" name="SignupForm[summary]"
                                                          class="materialize-textarea validate"
                                                          data-length="400" style="resize: none;"><?= $model->summary ?></textarea>
                                                <label for="ab-text" data-error="wrong" data-success="right">About
                                                    me</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s12">
                                                <button id="submit-form" class="waves-effect btn-large" type="submit">submit</button>
                                                <span class="text-notice">You must confirm your e-mail after registration. All activation instructions will be send to your e-mail.</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Registration wrapper -->