<?php


namespace api\modules\v1\models;

use common\stanislavdev\db\ActiveRecord;

class AchievementRest extends ActiveRecord
{

    CONST CAR_OF_DAY = 1;
    CONST EDITORS_CHOISE = 2;
    CONST POPULAR_JOURNALS = 3;
    CONST TOP_JOURNALS = 4;
    CONST POPULAR_BLOGS = 5;
    CONST TOP_BLOGS = 6;
    CONST POPULAR_POSTS = 7;

    public $entities = [];

}