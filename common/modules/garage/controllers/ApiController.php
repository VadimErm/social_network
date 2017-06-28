<?php

namespace common\modules\garage\controllers;

use common\models\Car;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class ApiController extends Controller
{


    public function actionAdd()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $car = new Car();

        if ($car->load(\Yii::$app->request->post()) && $savedCar = $car->insert()) {

          return ['status' => 'success', 'car' => json_encode($savedCar)];
        }

        return ['status' => 'fail', 'errors' => $car->getErrors()];
    }

    public function actionRemove($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $car = Car::find()
            ->match("(n) WHERE ID(n) = $id OPTIONAL MATCH (n)-[r]-() WITH n, r OPTIONAL MATCH (n)-[h:has_journal]->(j) DELETE n,r,h,j")
            ->execute(true);

        return ['status' => 'success'];
    }

    public function actionUpdate()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $car = new Car();

        if ($bla = $car->load(\Yii::$app->request->post()) && $savedCar = $car->update()) {
            return ['status' => 'success', 'car' => json_encode($savedCar)];
        }

        return ['status' => 'fail', 'errors' => json_encode($car->getErrors())];
    }

    public function actionToExCars($id, $main = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $relation = ($main !== null) ? 'main_car' : 'has_car';


        $userId = \Yii::$app->user->getId();
        Car::find()->match("(c:Car)<-[r:$relation]-(a:Account {user_id:$userId}) WHERE ID(c)=$id CREATE (c)<-[r2:ex_car]-(a) SET r2=r WITH r DELETE r")->execute(true);

        return ['status' => 'success', 'relation' => $relation, 'main'=> $main];
    }

    public function actionToMyCars($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $userId = \Yii::$app->user->getId();
        Car::find()->match("(c:Car)<-[r:ex_car]-(a:Account {user_id:$userId}) WHERE ID(c)=$id CREATE (c)<-[r2:has_car]-(a) SET r2=r WITH r DELETE r")->execute(true);

        return ['status' => 'success'];
    }
}