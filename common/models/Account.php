<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class Account extends ActiveRecord
{
    CONST MAN = 1;
    CONST WOMEN = 2;

    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $user_id;
    public $show_real_name;
    public $gender;
    public $birthday;
    public $show_real_birthday;
    public $languages;
    public $country;
    public $city;
    public $phone;
    public $summary;
    public $blog;
    public $isFollowed;
    public $followers;
    public $avatar;

    public $cars;
    public $blacklist;
    public $isOnline;

    public function rules()
    {
        return [
            ['id', 'integer'],
            [['show_real_name', 'languages', 'blog', 'show_real_birthday', 'gender', 'isFollowed', 'followers', 'isOnline'], 'safe'],
            [['user_id'], 'integer'],
            [[
                'username',
                'first_name',
                'last_name',
                'birthday',
                'country',
                'city',
                'phone',
                'summary'
            ], 'string']
        ];
    }



    public function insert($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        $city = $this->city;
        $country = $this->country;
        if ($attributes == null) {
            $attributes = $this->attributes();
        }

        unset($attributes['country']);
        unset($attributes['city']);

        $attributesStr = $this->getAttributesStr($attributes);
        $labelName = static::labelName();

        $languagesGql = '';

        if (!empty($this->languages)) {
            if (is_array($this->languages)) {
                $length = count($this->languages);
                for ($i = 0; $i < $length; $i++) {
                    $languagesGql .= "MERGE (l$i:Language{title: '{$this->languages[$i]}'}) CREATE (n)-[:know_language]->(l$i)";
                }
            } elseif (is_string($this->languages)) {
                $languagesGql = "MERGE (l:Language{title: '{$this->languages}'}) CREATE (n)-[:know_language]->(l)";
            }
        }
        $merge = "(country:Country{title:'{$country}'}) MERGE (city:City{title:'{$city}'}) MERGE (city)-[:locate]->(country) CREATE (n)-[:live_in]->(city)";

        $query = $this->create("(n: {$labelName} " . "{" .$attributesStr. "}), (b:Blog), (n)-[rb:has_blog]->(b) MERGE $merge $languagesGql")
            ->get('n');

        return $query->one();
    }

    public function update($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            return false;
        }

        $city = $this->city;
        $country = $this->country;

        if ($attributeNames == null) {
            $attributeNames = $this->attributes();
        }
        unset($attributeNames['country']);
        unset($attributeNames['city']);

        $attributesStr = $this->getAttributesForUpdate($attributeNames);
        $labelName = static::labelName();

        $languagesGql = '';

        if (!empty($this->languages)) {
            if (is_array($this->languages)) {
                $length = count($this->languages);
                for ($i = 0; $i < $length; $i++) {
                    $languagesGql .= " MERGE (l$i:Language{title: '{$this->languages[$i]}'}) CREATE (n)-[:know_language]->(l$i)";
                }
            } elseif (is_string($this->languages)) {
                $languagesGql = "MERGE (l:Language{title: '{$this->languages}'}) CREATE (n)-[:know_language]->(l)";
            }
        }
        $merge = "(country:Country{title:'{$country}'}) MERGE (city:City{title:'{$city}'}) MERGE (city)-[:locate]->(country) CREATE (n)-[:live_in]->(city)";

        $query = $this->match("(n: {$labelName}) WHERE ID(n)={$this->id} SET $attributesStr MERGE $merge $languagesGql")
            ->get('n');

        return $query
            ->one();
    }

    public function getCars($asArray = false)
    {
        try{
            $cars = Car::find()->match("(a:Account{user_id: $this->user_id}) OPTIONAL MATCH (a)-[r:has_car | :main_car | :ex_car | :wished | :test_drive]->(c:Car)")
                ->get("c, ID(c) as id")
                ->all();
        } catch (UnknownPropertyException $e) {
            $cars = [];
        }

        if($asArray){
            foreach ($cars as $key => $car){
                $cars[$key] = $car->asArray();
            }
        }

        return $cars;

    }


    public function asArray($skips = [], $withoutBlacklist = false)
    {
        $identity = $this;
        $response = ArrayHelper::toArray($identity, [
            'common\models\Account' => [
                'id',
                'username' => function($identity){
                    return User::findIdentity($identity->user_id)->username;
                },
                'first_name',
                'last_name',
                'user_id',
                'show_real_name',
                'gender',
                'birthday',
                'show_real_birthday',
                'languages' => function($identity) {

                    return  ArrayHelper::toArray($identity->languages, [
                        'common\models\Language' => [
                            'title'

                        ]
                    ]);

                },
                'country' =>function($identity) {
                     if($identity->getCountry()){
                         return $identity->getCountry()->title;
                     } else {
                         return '';
                     }

                },
                'city' => function($identity) {
                    if($identity->getCity()){
                        return $identity->getCity()->title;
                    } else {
                        return '';
                    }

                },
                'cars' => function($identity){

                    $cars = [];
                    if(!empty($identity->cars)){
                       $cars = $identity->getCars(true);
                    }
                    return $cars;

                },
                'phone',
                'summary',
                'isOnline',
                'blog',
                'isFollowed',
                'favorites' => function($identity){
                      return Favorite::getCount($identity->id);
                },

                'avatar' => function($identity) {
                    return $avatar = (User::findIdentity($identity->user_id)->avatar) ? User::findIdentity($identity->user_id)->avatar : '/images/no-avatar.png' ;
                },

                'blacklist' => function($identity) use ($withoutBlacklist){
                    if(!$withoutBlacklist){
                        return Blacklist::getBlockedNodes($identity->user_id);
                    } else {
                        return [];
                    }

                }

            ],
        ]);

        if(!empty($skips)){
            foreach ($skips as $skip){
                unset($response[$skip]);
            }
        }

        return $response;
    }

    /**
     * Get list of accounts searching by first_name and last_name
     * @param $query string
     * @param bool $asArray - if true return each account as array, else return each account as object
     * @return array of accounts
     */
    public static function search($query, $asArray = false)
    {


        $accounts = self::find()->match(" (a:Account)-[:live_in]->(c:City)-[:locate]->(ct:Country) WHERE toLower(a.first_name) CONTAINS '$query' OR toLower(a.last_name) CONTAINS '$query'" )
            ->get("a, ID(a) as id, c as city, ct as country")
            ->all();

       if($asArray){
           if(!empty($accounts)){
               foreach ($accounts as $key => $account){
                   $accounts[$key] = $account->asArray();
               }
           } else{
               $accounts = [];
           }

       }

        return $accounts;

    }

    public function getMyFollowers()
    {

    }

    public function getCountry()
    {
        try{
            $country = Country::find()->match("(a:Account{user_id: $this->user_id}) OPTIONAL MATCH (a)-[:live_in]->(:City)-[:locate]->(c:Country)")
                ->get("c, ID(c) as id")
                ->one();
        } catch (UnknownPropertyException $e){
            $country = null;
        }
        return $country;
    }

    public function getCity()
    {
        try{
            $city = City::find()->match("(a:Account{user_id: $this->user_id}) OPTIONAL MATCH (a)-[:live_in]->(c:City)")
                ->get("c, ID(c) as id")
                ->one();
        } catch (UnknownPropertyException $e){
            $city = null;
        }

        return $city;
    }

    public function findByUserId($user_id)
    {
        return $this->match("(n:Account{user_id:$user_id})")
            ->get('n, ID(n) as id')
            ->one();

    }

    public static function changeOnlineStatus($userId, $isOnline)
    {
        $status = (int) $isOnline;
        try{
            $account =  self::find()->match("(a:Account{user_id:$userId}) SET a.isOnline = $status")
                ->get("a, ID(a) as id")
                ->one();

        } catch (UnknownPropertyException $e) {
            $account = null;
        }


        return (bool) $account;
    }

}