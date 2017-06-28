<?php

namespace backend\controllers;

use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;

abstract class BackendController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ]
        ];
    }
    public function init()
    {
        parent::init();
        $this->setLayout();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    protected function setLayout()
    {
//        $this->layout = 'gentelella';
        $this->layout = \Yii::$app->user->isGuest ? 'login' : 'gentelella';
    }
}