<?php


namespace api\modules\v1\models;

use common\helpers\Base64ToImageHelper;
use common\helpers\TimeZoneHelper;
use common\models\Car;
use Yii;
use yii\helpers\ArrayHelper;

class CarRest extends Car
{


    public function insert($runValidation = true, $attributes = null)
    {

        $this->registered = time();

        if ($attributes == null) {
            $attributes = $this->attributes();
        }

        if ($runValidation && !$this->validate()) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        $imagesGQL = '';
        $imageNodes = '';
        $path = \Yii::getAlias('@frontend').'/web';

        if (!empty($attributes['images'])) {
            $images = $attributes['images'];
            $length = count($attributes['images']);

            for ($i = 0; $i < $length; $i++) {
                $src = Base64ToImageHelper::SaveImage($images[$i], $path);
                $imagesGQL .= "(i$i:Image{src:'$src'})-[:has_image]->(n)";
                $imageNodes .= "i$i";
                if ($i != $length - 1) {
                    $imagesGQL .= ',';
                    $imageNodes .= ',';
                }
            }
        }

        $mainCar = $attributes['main_car'];
        //unset($attributes['main_car']);

        if ($mainCar == 1) {
            $userId = Yii::$app->user->getId();

            Car::find()->match("(a:Account{user_id:$userId})-[m:main_car]->(c:Car), (c:Car)<-[:has_image]-(i:Image) DELETE m CREATE (a)-[:has_car]->(c), (c)<-[:has_image]-(i)")->execute(true);
        }

        $carType = $attributes['car_type'];
        //unset($attributes['car_type']);

        $attributesStr = $this->getAttributesStr($attributes);

        $labelName = static::labelName();
        $relation = $this->main_car == 1 ? 'main_car' : static::$carRelations[$carType];
        $images = empty($imageNodes) ? '': ", [$imageNodes] as images";
        $created_at = (int) time();

        return
            $this->match('(a:Account{user_id: '. Yii::$app->user->getId() .'})')
                ->create("(a)-[:".$relation."]->(n: {$labelName} " . "{" .$attributesStr. "})-[:has_journal]->(j:Journal{created_at:$created_at}), $imagesGQL")
                ->get("n, ID(n) as id$images")
                ->one();
    }

    public function update($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        if ($attributeNames == null) {
            $attributeNames = $this->attributes();
        }
        $images = $attributeNames['images'];
        $imagesGQL = '';
        $imageNodes = '';
        $optionalMatch = '';
        $path = \Yii::getAlias('@frontend').'/web';

        if (!empty($images)) {
            $optionalMatch = ' OPTIONAL MATCH (n)<-[r:has_image]-(i:Image)  DELETE i, r ';
            $imagesGQL = ' CREATE UNIQUE ';
            $length = count($images);

            for ($i = 0; $i < $length; $i++) {
                $src = Base64ToImageHelper::SaveImage($images[$i], $path);
                $imagesGQL .= "(i$i:Image{src:'$src'})-[:has_image]->(n)";
                $imageNodes .= "i$i";

                if ($i != $length - 1) {
                    $imagesGQL .= ',';
                    $imageNodes .= ',';
                }
            }
        }

        // this is my cool forever

        $mainCar = $attributeNames['main_car'];
        $carType = $attributeNames['car_type'];
        unset($attributeNames['main_car']);
        unset($attributeNames['car_type']);

        //$relation = $mainCar == 1 ? 'main_car' : self::$carRelations[$carType];
        $relation =  self::$carRelations[$carType];
        $userId = Yii::$app->user->getId();

        if ($mainCar == -1) {
            Car::find()->match("(a:Account{user_id:$userId})-[m:main_car]->(c:Car) WHERE ID(c) = {$this->id} DELETE m CREATE (a)-[:".$relation."]->(c)")->get('c, ID(c) as id')->one();
        } elseif($mainCar == 1) {
            Car::find()->match("(a:Account{user_id:$userId})-[h:".$relation."]->(c:Car) WHERE ID(c) = {$this->id} DELETE h CREATE (a)-[:main_car]->(c)")->get('c, ID(c) as id')->one();
            $relation = 'main_car';
        }

        $attributesStr = $this->getAttributesForUpdate($attributeNames);

        $labelName = static::labelName();

        if(count($images) == 1) {
            $images = empty($imageNodes) ? '': ", collect($imageNodes) as images";
        } else {
            $images = empty($imageNodes) ? '': ", [$imageNodes] as images";
        }

        $response =  Car::find()->match("(a:Account{user_id: ".Yii::$app->user->getId()."}), (a)-[:".$relation."]->(n:{$labelName}) WHERE ID(n) = {$this->id}  SET $attributesStr$imagesGQL")
            ->get("n, ID(n) as id$images")
            ->one();

        return $response;
    }

    public static function labelName()
    {
        return 'Car';
    }

    public function asArray($skips = null)
    {

        $identity = $this;

        return  ArrayHelper::toArray($identity , [
            'api\modules\v1\models\CarRest' => [
                'id',
                'brand',
                'car_name',
                'engine_type',
                'engine_size',
                'capacity',
                'model',
                'drive_type',
                'modification',
                'build_date',
                'location',
                'score',
                'use_since',
                'used_year_from',
                'used_year_to',
                'testdrive_date',
                'car_number',
                'about',
                'favorites',
                'registered',
                'comments' => function($identity){
                    return $identity->getCommentsCount();
                },
                'images' => function($identity) {

                   return ArrayHelper::toArray($identity ->images, [
                       '\stdClass' => [
                           'src',


                       ]
                   ]);


                }
            ]
        ]);
    }

}