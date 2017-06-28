<?php
namespace frontend\models;

use common\models\Account;
use common\models\Album;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\base\Object;
use yii\helpers\Url;
use yii\rbac\Role;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    const MALE_TYPE = 1;
    const FEMALE_TYPE = 2;
    const SCENARIO_CHANGE = 'change';

    public $username;
    public $email;
    public $phone;
    public $first_name;
    public $last_name;
    public $show_real_name = 3;
    public $gender;
    public $birthday;
    public $show_real_birthday = 3;
    public $languages;
    public $country;
    public $city;
    /**
     * @var $avatar UploadedFile
     */
    public $avatar;
    public $avatarFile;
    public $noAvatar;
    public $summary;
    public $password;
    public $passwordConfirm;
    public $avatarBase64;

    public function attributeLabels()
    {
        return [
            'username' => 'Nickname'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['noAvatar', 'string', 'on' => static::SCENARIO_CHANGE],
            ['gender', 'integer', 'on' => static::SCENARIO_DEFAULT],
            ['gender', 'integer', 'on' => static::SCENARIO_CHANGE],
            ['avatarFile', 'file', 'extensions' => 'gif, jpg, png', 'on' => static::SCENARIO_DEFAULT],
            ['username', 'trim', 'on' => static::SCENARIO_DEFAULT],
            [['show_real_birthday', 'show_real_name', 'phone', 'country'], 'safe', 'on' => static::SCENARIO_DEFAULT],
            [['show_real_birthday', 'show_real_name', 'country', 'phone'], 'safe', 'on' => static::SCENARIO_CHANGE],
            [
                [
                    'username',
//                    'phone',
                    'first_name',
                    'last_name',
                    'gender',
                    'birthday',
                    'languages',
//                    'country',
                    'city',
                ],
                'required',
                'on' => static::SCENARIO_DEFAULT
            ],
            [
                'username',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This username has already been taken.',
                'on' => static::SCENARIO_DEFAULT
            ],
            ['username', 'string', 'min' => 2, 'max' => 255, 'on' => static::SCENARIO_DEFAULT],
            ['avatar', 'string', 'on' => static::SCENARIO_DEFAULT],
            ['summary', 'string', 'on' => static::SCENARIO_DEFAULT],
            ['email', 'trim', 'on' => static::SCENARIO_DEFAULT],
            ['email', 'required', 'on' => static::SCENARIO_DEFAULT],
            ['email', 'email', 'on' => static::SCENARIO_DEFAULT],
            ['email', 'string', 'max' => 255, 'on' => static::SCENARIO_DEFAULT],

            ['password', 'required', 'on' => static::SCENARIO_DEFAULT],
            ['passwordConfirm', 'required', 'on' => static::SCENARIO_DEFAULT],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Confirm password must be equal to password', 'on' => self::SCENARIO_DEFAULT],
            ['password', 'string', 'min' => 6, 'on' => static::SCENARIO_DEFAULT],
            ['avatarBase64', 'string' , 'on' => static::SCENARIO_DEFAULT],
            // change scenario
            ['avatarFile', 'file', 'extensions' => 'gif, jpg, png', 'on' => static::SCENARIO_CHANGE],
            ['username', 'trim', 'on' => static::SCENARIO_DEFAULT],
            [['show_real_birthday', 'show_real_name', 'country'], 'safe', 'on' => static::SCENARIO_CHANGE],
            [
                [
                    'username',
                    'phone',
                    'first_name',
                    'last_name',
                    'gender',
                    'birthday',
                    'languages',
 //                   'country',
                    'city',
                ],
                'required',
                'on' => static::SCENARIO_CHANGE
            ],
            [
                'username',
                'customUnique',
                'on' => static::SCENARIO_CHANGE
            ],
            ['username', 'string', 'min' => 2, 'max' => 255, 'on' => static::SCENARIO_CHANGE],
            ['avatar', 'string', 'on' => static::SCENARIO_CHANGE],
            ['summary', 'string', 'on' => static::SCENARIO_CHANGE],
            ['email', 'trim', 'on' => static::SCENARIO_CHANGE],
            ['email', 'required', 'on' => static::SCENARIO_CHANGE],
            ['email', 'email', 'on' => static::SCENARIO_CHANGE],
            ['email', 'string', 'max' => 255, 'on' => static::SCENARIO_CHANGE],

        ];
    }

    public function customUnique($attribute, $params)
    {
        $identity = \Yii::$app->user->identity;

        // if username changed
        if ($identity->username != $this->username) {
            // check if username in use by another user
            $user = User::findByUsername($this->username);

            if ($user == null) {
                return true;
            }

            $this->addError($attribute, 'Username already in use');
        }
    }

    /**
     * Signs user up.
     * @return bool|User
     * @throws \Exception
     */
    public function signup()
    {
        $this->avatarFile = UploadedFile::getInstance($this, 'avatarFile');

        // Create User in MySQL Data Base
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();


        //Create User Account in Neo4j Data Base
        $account = new Account();


        if ($account->load(['Account' => $this->getAttributes()]) && $account->validate()) {

            if ($this->avatarFile != null) {
                $fileName = md5(time());
                $saved = $this->avatarFile->saveAs(\Yii::getAlias("@webroot/uploads/$fileName.{$this->avatarFile->extension}"));

                if ($saved) {
                    $user->avatar = "/uploads/$fileName.{$this->avatarFile->extension}";
                }
            }

            $transaction = User::getDb()->beginTransaction();

            try {
                if ($user->save()) {
                    $userRole = \Yii::$app->authManager->getRole('user');
                    \Yii::$app->authManager->assign($userRole, $user->id);

                    // Set relation user to account
                    $account->user_id = $user->id;

                    if ($account->save()) {
                        Album::find()
                            ->match("(ac:Account{user_id:{$user->id}})")
                            ->create('(ac)-[:has_album]->(saved:Album{title: "Saved photos", hidden: false}), (ac)-[:has_album]->(all:Album{title: "All photos", hidden: false})')
                            ->execute(true);
                        $transaction->commit();
                        return $user;
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }

    public function change()
    {
//        var_dump($this);exit;
        $this->avatarFile = UploadedFile::getInstance($this, 'avatarFile');

        // Create User in MySQL Data Base
        $user = \Yii::$app->user->getIdentity();
        $user->username = $this->username;

        if ($user->email !== $this->email) {
            // new email
            $user->status = User::STATUS_DELETED;
            $user->auth_key = Yii::$app->security->generateRandomString();

            Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom('do-not-reply@arba.ae')
                ->setSubject('Email verification')
                ->setTextBody('Verification link: ' . Yii::$app->request->hostInfo . Url::to([
                        '/site/verify',
                        'code' => $user->auth_key
                    ]))
                ->send();
        }

        $user->email = $this->email;


        //Create User Account in Neo4j Data Base
        $userId = \Yii::$app->user->getId();

        $account = Account::find()
            ->match('(n:Account)')
            ->where("n.user_id=$userId")
            ->get('n')
            ->one();

        if ($account->load(['Account' => $this->getAttributes()]) && $account->validate()) {
            // remove all account relations
            Account::find()->optionalMatch("(n1:Account)-[nkl:know_language]->(n2), (n1)-[li:live_in]->()-[loc:locate]->(Country)")
                ->where("ID(n1)={$account->id}")
                ->delete('nkl, loc, li')
                ->one();


            if ($this->avatarFile != null) {
                $fileName = md5(time());
                $saved = $this->avatarFile->saveAs(\Yii::getAlias("@webroot/uploads/$fileName.{$this->avatarFile->extension}"));
                if ($saved) $user->avatar = "/uploads/$fileName.{$this->avatarFile->extension}";
            } else {
                // set avatar to default

                if (isset(Yii::$app->request->post('SignupForm')['noAvatar'])) {
                    $user->avatar = '/images/no-avatar.png';
                }
            }


            $transaction = User::getDb()->beginTransaction();

            try {
                if ($user->save()) {

                    // Set relation user to account
                    $account->user_id = $user->id;

                    if ($account->save()) $transaction->commit();

                    return $user;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }
}
