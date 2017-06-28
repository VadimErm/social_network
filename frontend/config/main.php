<?php


$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'on beforeRequest' => function () {

      if(isset($_GET['back_drop']) && $_GET['back_drop'] == 'akjdgaa8h8AFBAifhaihafhsafiahsifaom'){
          Yii::$app->session->set('back_drop', true);
          Yii::$app->getResponse()->redirect(yii\helpers\Url::to('/live/#/home'));
      }


        if (empty(Yii::$app->session->get('back_drop'))) {
            \Yii::$app->catchAll = [
                'site/offline'
            ];
        }
    },
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'en-EN',
    'bootstrap' => ['log', 'frontend\bootstrap\UserBootstrap'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'message' => [
            'class' => 'common\modules\message\Message'
        ],
        'garage' => [
            'class' => 'common\modules\garage\Garage'
        ],
        'user' => [
            'class' => 'common\modules\user\User'
        ],
        'blog' => [
            'class' => 'common\modules\blog\Blog'
        ],
        'journal' => [
            'class' => 'common\modules\journal\Journal',
        ],
        'feed' => [
            'class' => 'common\modules\feed\Feed'
        ],
        'achievements' => [
            'class' => 'common\modules\achievements\Achievements',
        ],
    ],
    'layout' => 'social_main',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'seotools' => [
            'class' => 'jpunanua\seotools\Component',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /*'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'rules' => [
            ],
        ],*/

    ],
    'params' => $params,
];
