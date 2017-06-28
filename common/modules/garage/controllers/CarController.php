<?php

namespace common\modules\garage\controllers;

use common\models\Car;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CarController extends Controller
{
    public function actionViewCar($id)
    {
        $car = Car::find()
            ->match("(c:Car) WHERE ID(c) = $id OPTIONAL MATCH (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->one();


        return $this->render('car_view', ['car' => $car]);
    }

    public function actionView($id)
    {
        $userId = $id;

        $mainCar = Car::find()
            ->match("(a:Account{user_id:$userId})-[:main_car]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->one();

        $myCars = Car::find()
            ->match("(a:Account{user_id:$userId})-[:has_car]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        $exCars = Car::find()
            ->match("(a:Account{user_id:$userId})-[:ex_car]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        $wishCars = Car::find()
            ->match("(a:Account{user_id:$userId})-[:wished]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        $testdriveCars = Car::find()
            ->match("(a:Account{user_id:$userId})-[:test_drive]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        return $this->render('garage_view', [
            'mainCar' => $mainCar,
            'myCars' => $myCars,
            'exCars' => $exCars,
            'wishCars' => $wishCars,
            'testdriveCars' => $testdriveCars
        ]);
    }

    public function actionIndex()
    {
        $userId = \Yii::$app->user->getId();

        $mainCar = Car::find()
            ->match("(a:Account{user_id:$userId})-[:main_car]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->one();

        $myCars = Car::find()
            ->match("(a:Account{user_id:$userId})-[:has_car]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        $exCars = Car::find()
            ->match("(a:Account{user_id:$userId})-[:ex_car]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        $wishCars = Car::find()
            ->match("(a:Account{user_id:$userId})-[:wished]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        $testdriveCars = Car::find()
            ->match("(a:Account{user_id:$userId})-[:test_drive]->(c:Car), (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->all();

        return $this->render('garage', [
            'mainCar' => $mainCar,
            'myCars' => $myCars,
            'exCars' => $exCars,
            'wishCars' => $wishCars,
            'testdriveCars' => $testdriveCars
        ]);
    }

    public function actionJournal()
    {
        return $this->render('journal');
    }

    public function actionTop()
    {
        return $this->render('top');
    }

    public function actionUserCar()
    {
        return $this->render('user_car');
    }

    public function actionEdit($id)
    {
        return $this->render('edit_car', ['id' => $id]);
    }
}