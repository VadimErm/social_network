<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class City extends ActiveRecord
{
    public $id;
    public $title;
    public $usersCount;
    public $image;

    public function rules()
    {
        return [
            [['usersCount', 'image'], 'safe'],
            ['title', 'string']
        ];
    }

    public function getAll()
    {
        $citiesArr = [];

        $cities =  $this::find()->match("(c:City)")
            ->get("c, ID(c) as id")
            ->all();

       if(!empty($cities)){
           foreach ($cities as $city){
               $citiesArr[] = $city->asArray();
           }
       }

       return $citiesArr;
    }

    protected function getUsersCount()
    {
        try{
            $city =  self::find()->match("(c:City)<-[:live_in]-(a) WHERE ID(c) = $this->id")
                ->get("COUNT(a) as usersCount")
                ->one();
        } catch (UnknownPropertyException $e) {

            $city = null;

        }

        if($city){
            return $city->usersCount;
        } else {
            return 0;
        }


    }

    public function asArray()
    {
        $identity = $this;

        return ArrayHelper::toArray($identity,[
            get_class($identity) => [
                'id',
                'title',
                'usersCount' => function($identity){
                    return $identity->getUsersCount();
                },
                'image' => function($identity){
                    return '/images/city3.jpg';
                }
            ]
        ]);
    }


}