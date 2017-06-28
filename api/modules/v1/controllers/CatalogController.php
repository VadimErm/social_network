<?php


namespace api\modules\v1\controllers;

use common\models\Catalog;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class CatalogController extends Controller
{
    public function behaviors()
    {
       /* $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],

        ];*/

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [

                [
                    'allow' => true,
                    'actions' => ['get-countries',
                                  'get-cities',
                                  'get-car-brands',
                                  'get-car-models-by-brand',
                                  'get-car-modifications-and-build-dates',
                                  'get-car-launch-year-by-model',
                                  'get-car-location',
                                  'get-car-engine-size',
                                  'get-car-capacity',
                                  'get-car-drive-type'
                                ],
                    'roles' => ['?'],
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

                'get-countries'    => ['get'],
                'get-cities'       => ['get'],
                'get-car-brands'   => ['get'],
                'get-car-models-by-brand' => ['get'],
                'get-car-modifications-and-build-dates' => ['get'],
                'get-car-launch-year-by-model' => ['get'],
                'get-car-location' =>  ['get'],
                'get-car-engine-size' => ['get'],
                'get-car-capacity'    => ['get'],
                'get-car-drive-type'  => ['get']

            ],
        ];

        return $behaviors;
    }

    private $catalog;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->catalog= new Catalog();
    }

    /**
     * Get list of all countries
     * @return array
     * @path /api/v1/catalogs/get-countries
     */
    public function actionGetCountries()
    {

        $countries = $this->catalog->getCountries();

        return [
            'countries' => $countries
        ];

    }

    /**
     * Get list of cities by cc_fips code
     * @param $code - string cc_fips code
     * @return array
     * @path /api/v1/catalogs/get-cities/<code>
     */
    public function actionGetCities($code)
    {

        $cities = $this->catalog->getCitiesByCountryCode($code);

        return [
            'cities' => $cities
        ];
    }

    /**
     * Get list of car's brands
     * @return array
     * @path /api/v1/catalogs/get-car-brands
     */
    public function actionGetCarBrands()
    {

        $brands = $this->catalog->getCarBrands();

        return [
            'brands' => $brands
        ];
    }

    /**
     * Get list of car's models by brand
     * @return array
     * @param brand - car's brand
     * @path /api/v1/catalogs/get-car-models-by-brand?brand=xxx
     */
    public function actionGetCarModelsByBrand()
    {
        $brand = Yii::$app->request->get('brand');

        $models = $this->catalog->getCarModelsByBrand($brand);

        return [
            'models' => $models
        ];

    }

    /**
     * Get list of car's modifications and build dates by model and launch year
     * @return array
     * @param  model - car's model
     * @param launch_year - car's launch year
     * @path /api/v1/catalogs/get-car-modifications-and-build-dates?model=xxx&launch_year=xxx
     */
    public function actionGetCarModificationsAndBuildDates()
    {
        $model = Yii::$app->request->get('model');
        $launchYear = Yii::$app->request->get('launch_year');

        $modifications = $this->catalog->getCarModificationsByModel($model, $launchYear);
        $buildDates = $this->catalog->getCarBuildDatesByModelAndLaunchYear($model, $launchYear);


        return [
            'modifications' => $modifications,
            'build_dates'   => $buildDates
        ];

    }

    /**
     * Get list of launch years by model
     * @return array
     * @param model
     * @path /api/v1/catalogs/get-car-launch-year-by-model?model=xxx
     */
    public function actionGetCarLaunchYearByModel()
    {
        $model = Yii::$app->request->get('model');

        $launchYears = $this->catalog->getCarLaunchYearByModel($model);


        return [
            'launchYears' => $launchYears
        ];
    }

    /**
     * Get car location by brand and model
     * @return array
     * @path /api/v1/catalogs/get-car-location?brand=xxx&model=xxx
     */
    public function actionGetCarLocation()
    {
        $brand = Yii::$app->request->get('brand');
        $model = Yii::$app->request->get('model');

        $location = $this->catalog->getCarLocationByBrandAndModel($brand, $model);

        return [
            'location' => $location
        ];


    }

    /**
     * Get list of car's engine size
     * @return array
     * @param model
     * @param launch_year
     * @path /api/v1/catalogs/get-car-engine-size?model=xxx&launch_year=xxx
     */
    public function actionGetCarEngineSize()
    {
        $model = Yii::$app->request->get('model');
        $launchYear = Yii::$app->request->get('launch_year');

        $engineSize = $this->catalog->getCarEngineSizeByModelAndLaunchYear($model, $launchYear);

        return [
            'engine_size' => $engineSize
        ];

    }

    /**
     * Get list of car's capacity by model adn engine size
     * @return array
     * @param  model - string car's model
     * @param  engine_size - string car's engine size
     * /api/v1/catalogs/get-car-capacity?model=xxx&engine_size=xxx
     */
    public function actionGetCarCapacity()
    {
        $model = Yii::$app->request->get('model');
        $engineSize = Yii::$app->request->get('engine_size');

        $capacity = $this->catalog->getCarCapacityByModelAndEngineSize($model, $engineSize);

        return [
            'capacity' => $capacity
        ];

    }

    /**
     * Get list of car's drive type by model, engine size, capacity
     * @return array
     * @param model - string car's model
     * @param engine_size - string car's engine size
     * @param capacity - integer car's capacity
     * @path /api/v1/catalogs/get-car-drive-type?model=xxx&engine_size=xxx&capacity=xxx
     */
    public function actionGetCarDriveType()
    {
        $model = Yii::$app->request->get('model');
        $engineSize = Yii::$app->request->get('engine_size');
        $capacity = Yii::$app->request->get('capacity');

        $driveType = $this->catalog->getCarDriveTypeByModelAndEngineSizeAndCapacity($model, $engineSize, $capacity);



        return [
            'drive_type' => $driveType
        ];

    }



}