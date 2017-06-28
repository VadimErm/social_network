<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 03.06.17
 * Time: 15:25
 */

namespace common\modules\user\controllers;

use yii\web\Controller;

class BookmarkController extends Controller
{
    public function actionIndex(){

        return $this->render('bookmarks');
    }
}