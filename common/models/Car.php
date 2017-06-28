<?php

namespace common\models;

use common\helpers\TimeZoneHelper;
use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\base\ErrorException;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class Car extends ActiveRecord
{
    const MY_CAR = 1;
    const EX_CAR = 2;
    const WISH_CAR = 3;
    const TEST_DRIVE_CAR = 4;

    protected static $carRelations = [
        self::MY_CAR => 'has_car',
        self::EX_CAR => 'ex_car',
        self::WISH_CAR => 'wished',
        self::TEST_DRIVE_CAR => 'test_drive',
    ];

    public $id;
    public $main_car;
    public $car_type;
    public $brand;// из справочника
    public $car_name;
    public $engine_type; //из справочника
    public $engine_size;
    public $capacity;
    public $drive_type;// из справочника
    public $model; //из справочника
    public $modification; // из справочника
    public $launch_year;// из справочника, пока нет данных
    public $build_date;// из справочника
    public $location; // из справочника
    public $images;
    public $cropped_images;
    public $use_since; // из справочника
    public $used_year_from;
    public $used_year_to; // из справочника
    public $testdrive_date;
    public $score;
    public $about;
    public $car_number;
    public $registered;

    public $journal;
    public $followers;
    public $followersAccs;
    public $favorites;
    public $likes;
    public $comments;
    public $commentEntities;
    public $account;

    public function rules()
    {
        return [
            ['id', 'safe'],
            [['images', 'main_car', 'cropped_images', 'used_year_from','used_year_to','testdrive_date', 'score', 'registered', 'build_date', 'use_since', 'drive_type', 'launch_year'], 'safe'],

            ['car_type', 'default', 'value' => self::MY_CAR],

            [['brand', 'car_name', 'engine_type', 'engine_size', 'model', 'modification',  'location', 'about', 'capacity', 'car_number'], 'string'],

            [['brand', 'car_name', 'engine_type', 'engine_size', 'model', 'modification'], 'required'],
        ];
    }
    public function getAccount($asArray = false)
    {



        $account = Account::find()->match("(c:Car)<-[r:main_car | :has_car | : ex_car | :wished | :test_drive]-(a:Account) WHERE ID(c) = $this->id")
            ->get("a, ID(a) as id")
            ->one();
        if($asArray){
            return $account->asArray();
        }
        return $account;
    }
    public function getJournal($asArray = false, $skips = null)
    {
        /**
         * @var Journal $journal
         */
        try{
            $journal = Journal::find()->match("(c:Car) WHERE ID(c)= $this->id OPTIONAL MATCH (c)-[:has_journal]->(j:Journal)")
                ->get("j, ID(j) as id")
                ->one();
            if($asArray){
                return $journal->asArray($skips);
            }
        } catch (UnknownPropertyException $e){
            $journal = null;
        }


        return $journal;
    }




    public function update($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }


        $images = UploadedFile::getInstances($this, 'images');

        $imagesGQL = '';
        $imageNodes = '';
        $optionalMatch = '';
        $path = \Yii::getAlias('@webroot');

        if (!empty($images)) {
            $optionalMatch = ' OPTIONAL MATCH (n)<-[r:has_image]-(i:Image)  DELETE i, r ';
            $imagesGQL = ' CREATE UNIQUE';
            $length = count($images);

            for ($i = 0; $i < $length; $i++) {
                $src = '/uploads/' . md5($images[$i]->baseName) . '_' . time() . '.' . $images[$i]->extension;
                $imagesGQL .= "(i$i:Image{src:'$src'})-[:has_image]->(n)";
                $imageNodes .= "i$i";
                // Save file to uploads dir
                $images[$i]->saveAs($path . $src);
                if ($i != $length - 1) {
                    $imagesGQL .= ',';
                    $imageNodes .= ',';
                }
            }
        }



        if ($attributeNames == null) {
            $attributeNames = $this->attributes();
        }

        // this is my cool forever

        $mainCar = $attributeNames['main_car'];
        $carType = $attributeNames['car_type'];
        unset($attributeNames['main_car']);
        unset($attributeNames['car_type']);

        $relation = $mainCar == 1 ? 'main_car' : self::$carRelations[$carType];

        $userId = Yii::$app->user->getId();

        if ($mainCar == -1) {
            Car::find()->match("(a:Account{user_id:$userId})-[m:main_car]->(c:Car) WHERE ID(c) = {$this->id} DELETE m CREATE (a)-[:".$relation."]->(c)")->get('c, ID(c) as id')->one();
        } else {
            Car::find()->match("(a:Account{user_id:$userId})-[h:".$relation."]->(c:Car) WHERE ID(c) = {$this->id} DELETE h CREATE (a)-[:main_car]->(c)")->get('c, ID(c) as id')->one();
        }

        $attributesStr = $this->getAttributesForUpdate($attributeNames);

        $labelName = static::labelName();

        if(count($images) == 1) {
            $images = empty($imageNodes) ? '': ", collect($imageNodes) as images";
        } else {
            $images = empty($imageNodes) ? '': ", [$imageNodes] as images";
        }

          $response =  $this->match("(a:Account{user_id: " . Yii::$app->user->getId() . "}), (a)-[:" . $relation . "]->(n:{$labelName}) WHERE ID(n) = {$this->id}  SET $attributesStr$imagesGQL")
                ->get("n, ID(n) as id$images")
                ->one();

        return $response;
    }

    public function insert($runValidation = true, $attributes = null)
    {

        //$this->images = UploadedFile::getInstances($this, 'images');

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
        $path = \Yii::getAlias('@webroot');

        if (isset($attributes['cropped_images'])) {

            $length = count($attributes['cropped_images']);

            for ($i = 0; $i < $length; $i++) {
                $src = $attributes['cropped_images'][$i];
                $imagesGQL .= "(i$i:Image{src:'$src'})-[:has_image]->(n)";
                $imageNodes .= "i$i";
                if ($i != $length - 1) {
                    $imagesGQL .= ',';
                    $imageNodes .= ',';
                }
            }
        }

        $mainCar = $attributes['main_car'];
        unset($attributes['main_car']);


        if ($mainCar == 1) {
            $userId = Yii::$app->user->getId();

            Car::find()->match("(a:Account{user_id:$userId})-[m:main_car]->(c:Car), (c:Car)<-[:has_image]-(i:Image) DELETE m CREATE (a)-[:has_car]->(c), (c)<-[:has_image]-(i)")->execute(true);
        }

        $carType = $attributes['car_type'];
        unset($attributes['car_type']);

        $attributesStr = $this->getAttributesStr($attributes);
        $labelName = static::labelName();
        $relation = $this->main_car == 1 ? 'main_car' : self::$carRelations[$carType];
        $images = empty($imageNodes) ? '': ", [$imageNodes] as images";
        $created_at = (int) time();

        return
            $this->match('(a:Account{user_id: '. Yii::$app->user->getId() .'})')
            ->create("(a)-[:".$relation."]->(n: {$labelName} " . "{" .$attributesStr. "})-[:has_journal]->(j:Journal{created_at:$created_at}), $imagesGQL")
            ->get("n, ID(n) as id$images")
            ->one();
    }



    public function validateImages($attribute, $params){
        $regexp = '/(jpe?g|png|gif)/ig';
        //$validate = true;
        /*foreach ($attribute as $image){*/
            $arr = explode('/', $attribute[0]->type);
            $validate = preg_match($regexp, $arr[1]);
            //if(!$validate) break;

        //}
        if(!$validate) $this->addError($attribute, 'Wrong format. Only JPEG, PNG, GIF.');
    }

    public function asArray($skips = null)
    {

        $identity = $this;
        $response = ArrayHelper::toArray($identity , [
            'common\models\Car' => [
                'id',
                'main_car',
                'car_type',
                'brand',
                'car_name',
                'engine_type',
                'engine_size',
                'capacity',
                'drive_type',
                'model',
                'modification',
                'build_date',
                'location',
                'about',
                'score',
                'use_since',
                'used_year_to',
                'testdrive_date',
                'car_number',
                'registered',
               /* 'comments' => function($identity){
                    return $identity->getComments();
                },*/
                'followers' => function($identity){
                    return $identity->getFollowersCount();
                },
                'followerAccs' => function($identity) {
                     return $identity->getFollowers();
                },
                'favorites' => function($identity){
                    return $identity->getFavorites();
                },
                'likes' => function($identity){
                    return $identity->getLikes();
                },
                'journal' => function($identity){
                    return $identity->getJournal(true, ['car','entries', 'account']);
                },
                'images' => function($identity) {

                    return ArrayHelper::toArray($identity ->images, [
                        'common\models\Image' => [
                            'src',
                            'description'

                        ]
                    ]);

                },
                'account' => function($identity){
                    return $identity->getAccount(true);
                }
            ]
        ]);
        if($skips){
            foreach ($skips as $skip){
                unset($response[$skip]);
            }
        }
        return  $response;
    }

    public function addToFavorite()
    {
        $favorite = Yii::$container->get('favorite');

        return $favorite->add($this->id);
    }

    public function getFavorites()
    {

        return  Favorite::find()->match("(c:Car) WHERE ID(c) = $this->id OPTIONAL MATCH (c)<-[:favorite]-(n)")
            ->get("COUNT(n) as count")
            ->one()->count;
    }

    public function getLikes()
    {
        return Like::find()->match("(c:Car) WHERE ID(c) = $this->id OPTIONAL MATCH (c)<-[:like]-(n)")
            ->get("COUNT(n) as count")
            ->one()->count;
    }

    public function getFollowersCount()
    {
        return Follower::getFollowersCount($this->id);
    }

    public function getFollowers()
    {
        return Follower::getFollowers($this->id, true);
    }

    public function getCommentsCount()
    {
        return Comment::getCount($this->id);
    }

    public function getComments()
    {
        return Comment::getAll($this->id);

    }

    /**
     * Get all cars that users have now (main_car, has_car)
     * @param null $skip
     * @param null $limit
     * @return array
     */
    public static function getAll($skip = null, $limit = null)
    {
        $returnQuery = "c, ID(c) as id, collect(i) as images ORDER BY toInteger(c.registered) DESC";
        $carsArr = [];

        if($skip && $limit && is_int($skip) && is_int($limit)){
            $returnQuery .= " SKIP $skip LIMIT $limit";
        }

        try{
            $cars = self::find()->match("(c:Car)<-[r:has_car | :main_car]-(a) OPTIONAL MATCH (c)<-[:has_image]-(i:Image)")
                ->get($returnQuery)
                ->all();

        } catch (UnknownPropertyException $e) {
            $cars = [];
        }

        if(!empty($cars)){
            foreach ($cars as $car){
                $carsArr[] = $car->asArray();
            }
        }

        return $carsArr;
    }


}