<?php

namespace backend\controllers;

class UserController extends BackendController
{
    public function actionIndex()
    {
        return $this->render('all');
    }
}