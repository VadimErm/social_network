<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

class JournalEntry extends ActiveRecord
{
    CONST MILEAGE_TYPE = 1;
    CONST EXPENSES_TYPE = 2;
    //SORT
    CONST SORT_BY_NAME = 1;
    CONST SORT_BY_TAG = 2;
    CONST SORT_BY_DATE = 3;

    public $id;
    public $title;
    public $text;
    public $images = [];
    public $language;
    public $type;
    public $mileage;
    public $expenses;
    public $currency;
    public $hidden = false;
    public $tags = [];
    public $created_at;
    public $journal_id;

    public $views;//view's count
    public $likes; //like's count
    public $comments; //comment's count
    public $favorites; //favorite's count
    public $shared; //shared's count
    public $commentEntries;




    public function rules()
    {
        return [
            [['created_at', 'id', 'images', 'hidden', 'tags', 'currency' ], 'safe'],
            [['title', 'text', 'language', 'type', 'journal_id'],  'required'],
            [['mileage', 'expenses' ], 'string']


        ];
    }

    public function getTags()
    {
        return Tag::find()->match("(j:JournalEntry) WHERE ID(j)= $this->id OPTIONAL MATCH (j)-[:has_tag]->(t:Tag)")
            ->get("t.name as name, ID(t) as id")
            ->all();
    }

    public function getJournal()
    {
        return Journal::find()->match("(je:JournalEntry), (je)<-[:has_journal_entry]-(j) WHERE ID(je) = $this->id")
            ->get("j, ID(j) as id")
            ->one();
    }

    public function getLikes()
    {
        return Like::getCount($this->id);
    }

    public function getCommentsCount()
    {
        return Comment::getCount($this->id);
    }

    public function getFavoritesCount()
    {
        return Favorite::getCount($this->id);
    }

    public function getCommentsEntries()
    {
        return Comment::getAll($this->id);
    }

    public function addViews()
    {
        $userId = Yii::$app->user->identity->getId();

        if($model = $this->match("(je:JournalEntry) WHERE ID(je) = $this->id")
            ->get("je.views as views")
            ->one()){
            if($userId !== $this->getJournal()->getAccount()->user_id){
                $views = (int) $model->views;
                $views +=1;
                JournalEntry::find()->match("(je:JournalEntry) WHERE ID(je) = $this->id")
                    ->set("je.views = $views")
                    ->get('je, ID(je) as id')
                    ->one();
            }

            return true;
        }

        return false;
    }



    public function asArray($skips = null)
    {
        $identity = $this;
        $response = ArrayHelper::toArray($identity, [
            'common\models\JournalEntry' =>[
                'id',
                'title',
                'text',
                'language',
                'type',
                'mileage',
                'expenses',
                'currency',
                'hidden',
                'created_at',
                'journal_id',
                'views',
                'commentsEntries' => function($identity){
                    return $identity->getCommentsEntries();
                },
                'shared' =>function($identity){
                    return 146;
                },
                'likes' =>function($identity){
                    return $identity->getLikes();
                },
                'comments' => function($identity){
                    return $identity->getCommentsCount();
                },
                'favorites' => function($identity){
                    return $identity->getFavoritesCount();
                },
                'images' => function($identity) {

                    return ArrayHelper::toArray($identity ->images, [
                        'common\models\Image' => [
                            'src',
                            'description'

                        ]
                    ]);

                },
                'tags' => function($identity) {

                    return ArrayHelper::toArray($identity->tags, [
                        'common\models\Tag' => [
                            'id',
                            'name'
                        ]
                    ]);

                }


            ]
        ]);
        if($skips){
            foreach ($skips as $skip){
                unset($response[$skip]);
            }
        }
        return $response;
    }





}