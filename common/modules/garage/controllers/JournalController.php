<?php

namespace common\modules\garage\controllers;

use yii\web\Controller;

class JournalController extends Controller
{
    /**
     * user car id
     * @param $id
     */
    public function actionIndex()
    {
        return $this->render('journals', [
            //'car_id' => $id
        ]);
    }
}