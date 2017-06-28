<?php

namespace common\modules\user\controllers;

use common\models\Account;
use common\models\Car;
use common\models\Country;
use common\models\Language;
use common\models\Post;
use common\models\User;
use frontend\models\SignupForm;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AccountController extends Controller
{
    public function actionAll()
    {
        $userId = Yii::$app->user->getId();

        $profiles = User::find()->where("id != $userId")->all();

        return $this->render('all', ['profiles' => $profiles]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param null|integer $userId
     * @return Account
     */
    protected function getAccount($userId = null)
    {
        if ($userId == null) {
            $userId = Yii::$app->user->getId();
        }

        $myId = Yii::$app->user->getId();

        return Account::find()
            ->match("(n:Account)-[live_in]->(city:City)-[locate]->(country:Country), (n:Account)-[know_language]->(languages:Language) WHERE n.user_id = $userId OPTIONAL MATCH (b:Account)-[r:follow]->(n) WHERE b.user_id =$myId" )

            ->get('n, city, country, r IS NOT NULL as isFollowed, collect(languages) as languages');
    }

    public function actionView($id)
    {
       
        return $this->render('profile_view', $this->getProfile([], $id));
    }

    protected function getProfile($additionalParams = [], $id = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }
        if ($id == null) {
            $id = Yii::$app->user->getId();
            $avatar = Yii::$app->user->identity->avatar;
        } else {
            $avatar = User::findOne($id);

            if ($avatar == null) {
                throw new NotFoundHttpException('User not found');
            }

            $avatar = $avatar->avatar;
        }

        if (empty($avatar)) {
            $avatar = '/images/no-avatar.png';
        }

        $account = $this->getAccount($id);

        try {
            $account = $account->one();
       } catch (\Exception $e) {
            echo 'Neo4j error';
//            throw $e;
            // TODO remove throw, change to pretty error page)
        }




        $registered = date('d.m.Y', Yii::$app->user->identity->created_at);

        $posts = Post::find()
            ->match("(a:Account{user_id:$id})-[:has_blog]->(b)-[:has_post]->(p) 
            OPTIONAL MATCH (p)-[:has_image]->(i) 
            ")
            ->get('p, ID(p) as id, collect(i) as images ORDER BY ID(p) DESC')
            ->all();



        $mainCar = Car::find()
            ->match("(n:Account{user_id:$id})-[:main_car]->(c:Car),  (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, i as images')
            ->one();

        $cars = Car::find()
            ->match("(n:Account{user_id:$id})-[:has_car]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        $followers = Account::find()->match("(b:Account)-[follow]->(a:Account{user_id:$id})")->get('b')->all();

        $params = [
            'cars' => $cars,
            'mainCar' => $mainCar,
            'posts' => $posts,
            'account' => $account,
            'followers' => $followers,
            'avatar' => $avatar,
            'registered' => $registered,
            'user' => Yii::$app->user->identity,
            'is_premium' => Yii::$app->user->identity->is_premium
        ];


        return $params + $additionalParams;
    }

    public function actionProfile()
    {


        return $this->render('profile', $this->getProfile());
    }

    public function actionChange()
    {
        $signupForm = new SignupForm();

        if ($signupForm->load(Yii::$app->request->post())) {
//            var_dump($signupForm);exit;
            $signupForm->change();
        }


        $languages = ['English', 'Arabic', 'French', 'German', 'Italian', 'Russian'];
        $countries = ['Russian Federation', 'USA', 'UAE'];



        return $this->render('edit-profile', $this->getProfile([
            'languages' => $languages,
            'countries' => $countries,
        ]));
    }

    public function actionMyFollowers()
    {
        return $this->render('my_followers', $this->getProfile());
    }



    public function actionIFollow()
    {
        return $this->render('i_follow');
    }

}