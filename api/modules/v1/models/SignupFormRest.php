<?php

namespace api\modules\v1\models;

use common\helpers\Base64ToImageHelper;
use common\models\Account;
use common\models\Album;
use common\models\User;
use frontend\models\SignupForm;
use Yii;
use yii\helpers\Url;

class SignupFormRest extends SignupForm
{

    /**
     * Signs user up.
     * @return bool|User
     * @throws \Exception
     */
    public function signup()
    {

        // Create User in MySQL Data Base
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();


        //Create User Account in Neo4j Data Base
        $account = new Account();


        if ($account->load(['Account' => $this->getAttributes()]) && $account->validate()) {


            if ($this->avatarBase64 != null) {
                $path = \Yii::getAlias('@frontend').'/web';
                $src = Base64ToImageHelper::SaveImage($this->avatarBase64, $path);


                if ($src) {
                    $user->avatar = $src;
                }
            } else{
                if (isset(Yii::$app->request->post('SignupFormRest')['noAvatar']) && Yii::$app->request->post('SignupFormRest')['noAvatar'] == 1) {
                    $user->avatar = '/images/no-avatar.png';
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


            if ($this->avatarBase64 != null) {
                $path = \Yii::getAlias('@frontend').'/web';
                $src = Base64ToImageHelper::SaveImage($this->avatarBase64, $path);
                if ($src) $user->avatar = $src;
            } else {
                // set avatar to default

                if (isset(Yii::$app->request->post('SignupFormRest')['noAvatar'])) {
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