<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 14.06.17
 * Time: 12:49
 */

namespace common\models;


use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class Catalog extends Model
{
    public $countries;
    public $cities;
    public $cars;

    private $query;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->query = new Query();
    }

    public  function getCountries()
    {

        $rows = $this->query->select("*")->from('countries')->all();

        return $rows;

    }

    public function getCitiesByCountryCode($code)
    {

        $rows = $this->query->select("*")->from('cities')->where(['cc_fips' => $code])->all();

        return $rows;
    }

    public function getCarBrands()
    {
        $rows = $this->query->select('brand')->from('cars')->groupBy('brand')->all();

        return $rows;
    }

    public function getCarModelsByBrand($brand)
    {
        $rows = $this->query->select('model')->from('cars')
            ->where(['brand' => $brand])
            ->groupBy('model')
            ->all();

        return $rows;
    }

    public function getCarModificationsByModel($model, $launchYear)
    {
        $rows = $this->query->select('modification')->from('cars')
            ->where(['model' => $model])
            ->andWhere(['launch_year' =>$launchYear])
            ->groupBy('modification')
            ->all();
        $arr = [];
        $arrOut = [];
        foreach ($rows as $key => $row){
            $arr[] = json_decode($row['modification']);
            $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($arr));
            $arrOut = iterator_to_array($iterator, false);
        }
        return $arrOut;
    }

    public function getCarLaunchYearByModel($model)
    {
        $rows = $this->query->select('launch_year')->from('cars')
            ->where(['model' => $model])
            ->groupBy('launch_year')
            ->all();

        return $rows;

    }

    public function getCarBuildDatesByModelAndLaunchYear($model, $launchYear)
    {
        $rows = $this->query->select('build_date')->from('cars')
            ->where(['model' => $model])
            ->andWhere(['launch_year' =>$launchYear])
            ->groupBy('build_date')
            ->all();

        if(!empty($rows)){
            $buildDatesArr = json_decode($rows[0]['build_date']);
        } else {
            $buildDatesArr = [];
        }


        return $buildDatesArr;

    }

    public function getCarLocationByBrandAndModel($brand, $model)
    {
        $rows = $this->query->select('location')->from('cars')
            ->where(['brand' => $brand])
            ->andWhere(['model' =>$model])
            ->groupBy('location')
            ->all();

        return $rows;

    }

    public function getCarEngineSizeByModelAndLaunchYear($model, $launchYear)
    {
        $rows = $this->query->select('engine_size')->from('cars')
            ->where(['model' => $model])
            ->andWhere(['launch_year' =>$launchYear])
            ->groupBy('engine_size')
            ->all();

        return $rows;
    }

    public function getCarCapacityByModelAndEngineSize($model, $engineSize)
    {
        $rows = $this->query->select('capacity')->from('cars')
            ->where(['model' => $model])
            ->andWhere(['engine_size' =>$engineSize])
            ->groupBy('capacity')
            ->all();

        return $rows;
    }

    public function getCarDriveTypeByModelAndEngineSizeAndCapacity($model, $engineSize, $capacity)
    {
        $rows = $this->query->select('drive_type')->from('cars')
            ->where(['model' => $model])
            ->andWhere(['engine_size' =>$engineSize])
            ->andWhere(['capacity' => $capacity])
            ->groupBy('drive_type')
            ->all();

        $arr = [];
        $arrOut = [];
        foreach ($rows as $key => $row){
            $arr[] = json_decode($row['drive_type']);
            $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($arr));
            $arrOut = iterator_to_array($iterator, false);
        }
        return array_unique($arrOut);



    }

}