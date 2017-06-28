<?php

namespace common\modules\garage\widgets\carofday;

use yii\base\Widget;

class CarOfDay extends Widget
{
    public $src;
    public $title;
    public $url;
    public $rating;
    public $date;
    public $location;
    public $selectCarUrl;
    public $candidates;

    public function run()
    {
        return $this->render('car_of_day', [
            'src' => $this->src,
            'title' => $this->title,
            'url' => $this->url,
            'rating' => $this->rating,
            'date' => $this->date,
            'location' => $this->location,
            'selectCarUrl' => $this->selectCarUrl,
            'candidates' => $this->candidates,
        ]);
    }
}