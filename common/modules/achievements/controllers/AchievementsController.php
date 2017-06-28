<?php

namespace common\modules\achievements\controllers;

use yii\web\Controller;


class AchievementsController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('achievements');
    }
}
