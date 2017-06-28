<?php


namespace api\modules\v1\controllers;

use api\modules\v1\models\CarRest;
use common\models\Account;
use common\models\Car;
use common\models\Comment;
use common\models\User;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
//use yii\rest\Controller;
use yii\web\Response;

class CarController extends  Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],

        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [

                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'update', 'delete', 'view', 'edit', 'new-cars', 'add-to-favorite', 'get-all-cars'],
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['bootstrap'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]

        ];

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [

                'index'    => ['get'],
                'create'   => ['post'],
                'delete'   => ['delete'],
                'update'   => ['patch'],
                'view'     => ['get'],
                'new-cars' => ['get'],
                'add-to-favorite' => ['put'],
                'get-all-cars' => ['get']

            ],
        ];

        return $behaviors;
    }



    /**
     * Get all user's cars
     * @return array
     * @method get
     * /api/v1/cars?user=xxx
     * @param user - id of another user
     *
     */
    public function actionIndex()
    {
        $userId = \Yii::$app->user->getId();
        if(isset($_GET['user']) ){
            if( User::findIdentity($_GET['user'])){
                $userId = $_GET['user'];
            } else{
                return [
                    'status' => 'fail',
                    'error' => "User not found",
                    'access_token' => Yii::$app->user->identity->getAuthKey(),
                ];
            }

        }


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



        $myCarsArr = [];
        $exCarsArr = [];
        $wishCarsArr = [];
        $testdriveCarsArr = [];

        $model = new Account();
        $account = $model->findByUserId($userId);

        if(!empty($myCars)){
            foreach ($myCars as $myCar) {
                $myCarsArr[] = $myCar->asArray();
            }
        }
        if(!empty($exCars)){
            foreach ($exCars as $exCar) {
                $exCarsArr[] = $exCar->asArray();
            }
        }
        if(!empty($wishCars)){
            foreach ($wishCars as $wishCar) {
                $wishCarsArr[] = $wishCar->asArray();
            }
        }
        if(!empty($testdriveCars)){
            foreach ($testdriveCars as $testdriveCar) {
                $testdriveCarsArr[] = $testdriveCar->asArray();
            }
        }

        //Breadcrumbs

        $this->breadcrumbs->addCrumb("My profile", '/user/account/profile');
        $this->breadcrumbs->addCrumb("My garage");


        return  [
            'status' => 'success',
            'mainCar' => (!is_null($mainCar)) ? $mainCar->asArray() : [],
            'myCars' => $myCarsArr,
            'exCars' => $exCarsArr,
            'wishCars' => $wishCarsArr,
            'testdriveCars' => $testdriveCarsArr,
            'account' => $account->asArray(),
            'access_token' => Yii::$app->user->identity->getAuthKey(),
            'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs()

        ];
    }

    /**
     * Create new car
     * @return array
     * @method post
     * /api/v1/cars
     * Fields:
     * CarRest[images][] - in base64
     * CarRest[brand]
     * CarRest[model]
     * CarRest[modification]
     * CarRest[build_date]
     * CarRest[engine_type]
     * CarRest[engine_size]
     * CarRest[car_name]
     * CarRest[location]
     * CarRest[about]
     * CarRest[car_type]
     * CarRest[capacity]
     * CarRest[car_number]
     * CarRest[drive_type]
     * CarRest[use_since]
     * CarRest[main_car] - add this field and set it 1 if user add main car
     * CarRest[used_year_from] - add this field if user add ex-car
     * CarRest[used_year_to] - add this field if user add ex-car
     * CarRest[score] - add this field if user add test-drive car
     * CarRest[testdrive_date] - add this field if user add test-drive car
     */
    public function actionCreate()
    {

        $car = new CarRest();

        //Дефолтные значения, убрать когда будут подключены справочники

        $car->brand = "Mercedes-Benz";
        $car->engine_type = 'gasoline';
        $car->drive_type = "Full wheel drive";
        $car->model = "W211";
        $car->modification = "CLASSIC";
        $car->build_date = "2016";
        $car->location = "Dubai";
        $car->use_since = "2017";


        if ($car->load(\Yii::$app->request->post()) && $savedCar = $car->insert()) {

            return ['status' => 'success', 'car' => $savedCar->asArray(), 'access_token' => Yii::$app->user->identity->getAuthKey()];
        }

        return ['status' => 'fail', 'errors' => $car->getErrors()];
    }

    /**
     * Delete car
     * @param $id
     * @return array
     * @method delete
     * /api/v1/cars/<id>
     */
    public function actionDelete($id)
    {


        if($car = Car::find()
            ->match("(n) WHERE ID(n) = $id OPTIONAL MATCH (n)-[r]-() DELETE n,r")
            ->get('ID(n) as id')
            ->one())
        {
            return [
                'status' => 'success',

                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return ['status' => 'fail', 'access_token' => Yii::$app->user->identity->getAuthKey()];
    }

    /**
     * Update user's car
     * @param $id
     * @return array
     * @method PATCH
     * api/v1/cars/<id>
     * Fields:
     * CarRest[images][] - in base64
     * CarRest[brand]
     * CarRest[model]
     * CarRest[modification]
     * CarRest[year]
     * CarRest[engine_type]
     * CarRest[engine_size]
     * CarRest[car_name]
     * CarRest[location]
     * CarRest[car_type]
     * CarRest[main_car] - add this field, if editing car is in 'My cars' and set it 1 if user changed status to main car,
     *                      set it -1 if car was 'main car' and changed to 'my car'
     * CarRest[used_year_from] - add this field if user add ex-car
     * CarRest[used_year_to] - add this field if user add ex-car
     * CarRest[score] - add this field if user add test-drive car
     * CarRest[testdrive_date] - add this field if user add test-drive car
     */
    public function actionUpdate($id)
    {

        $car = new CarRest();
        $car->id = $id;

        $car->brand = "Mercedes-Benz";
        $car->engine_type = 'gasoline';
        $car->drive_type = "Full wheel drive";
        $car->model = "W211";
        $car->modification = "CLASSIC";
        $car->build_date = "2016";
        $car->location = "Dubai";
        $car->use_since = "2017";

        if ($car->load(\Yii::$app->request->post()) && $savedCar = $car->update()) {

            return ['status' => 'success', 'car' =>$savedCar->asArray(), 'access_token' => Yii::$app->user->identity->getAuthKey()];
        }

        return ['status' => 'fail', 'errors' => $car->getErrors()];
    }

    /**
     * Get user's car bay $id
     * @param $id
     * @return array
     * @method get
     * /api/v1/cars/$id
     */
    public function actionView($id)
    {

        if($car = Car::find()
            ->match("(c:Car) WHERE ID(c) = $id OPTIONAL MATCH (c)<-[:has_image]-(i)")
            ->get('c, ID(c) as id, collect(i) as images')
            ->one())
        {
            //Breadcrumbs
			
            $this->breadcrumbs->addCrumb("My profile", '/user/account/profile');
            $this->breadcrumbs->addCrumb("My garage", '/garage');
            $this->breadcrumbs->addCrumb($car->car_name);
            $comments = Comment::getAll($id);
            return [
                'status' => 'success',
                'car' => $car->asArray(['journal']),
                'journal' => $car->getJournal(true, ['car', 'account']),
                'comments' => $comments,
                'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs(),
                'user_id' => $car->getAccount()->user_id,
                'access_token' => Yii::$app->user->identity->getAuthKey(),

            ];
        }

        return ['status' =>'fail', 'access_token' => Yii::$app->user->identity->getAuthKey() ];

    }

    /**
     * Get list of new cars, filtering by country, city, brand, language, skip, limit
     * @return array
     * @method get
     * /api/v1/cars/new-cars?country=xxx&city=xxx&brand=xxx&lang=xxx&skip=xxx&limit=xxx
     */
    public function actionNewCars()
    {
        return [
            'status' =>'success',
            'cars' => [],

            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Add car to favorites
     * @return array
     * @method PUT
     * /api/v1/cars/add-to-favorite
     * @Fields
     * car_id - integer
     */
   /* public function actionAddToFavorite()

    {
        $carId = Yii::$app->getRequest()->getBodyParam('car_id');
        $model = new Car();
        $car = $model->findById($carId);

        if(!$car->addToFavorite()){
            return [
                'status' => 'fail',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' => 'success',
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }*/

    /**
     * Get list of all users cars order by desc
     * @return array
     * @method GET
     * @link /api/v1/cars/get-all-cars?skip=xxx&limit=xxx
     */
    public function actionGetAllCars()
    {
        $skip = null;
        $limit = null;
        if(isset($_GET['skip']) && isset($_GET['limit'])){
            $skip = (int) $_GET['skip'];
            $limit = (int) $_GET['limit'];
        }

        $cars = Car::getAll($skip, $limit);

        return [
            'status' => 'success',
            'cars' => $cars,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];


    }

}