<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    //'defaultRoute' => 'auth',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]

    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => null,
            'enableSession' => false
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-api',
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/account',
                    'extraPatterns' => [
                        'POST change'           => 'change',
                        'PUT change-password'   => 'change-password',
                        'PUT change-online-status' => 'change-online-status'

                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/blog'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/comment',
                     'extraPatterns' => [
                            "PUT spam" =>"spam"

                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/album',
                    'extraPatterns' => [
                        'POST upload-photos'    => 'upload-photos',
                        'PATCH edit'            => 'edit',
                        'GET photo-count'       => 'photo-count'

                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/message',
                    'extraPatterns' => [

                        'GET count'                     => 'count',
                        'PUT spam'                      => 'spam',
                        'PUT readed'                    => 'readed',
                        'DELETE clear-history'          => 'clear-history',
                        'GET search'                    => 'search',
                        'GET unreaded-count'            => 'unreaded-count',
                        'DELETE delete-dialog'          => 'delete-dialog',
                        'DELETE delete-messages'        => 'delete-messages',
                        'PUT block'                     => 'block',
                        'DELETE delete-all-dialogs'     => 'delete-all-dialogs',
                        'GET view-dialogs-by-type/<type:\d+>' => 'view-dialogs-by-type',
                        'GET blacklist'                 => 'blacklist',
                        'PUT unblock'                   => 'unblock',
                        'GET view-dialog/<dialog_id:\d+>'   => 'view-dialog',
                        'PUT join-user'                 => 'join-user'
                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/car',
                    'extraPatterns' => [
                        'GET new-cars'       => 'new-cars',
                        'PUT add-to-favorite' => 'add-to-favorite',
                        'GET get-all-cars'    => 'get-all-cars'


]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/journal',
                    'extraPatterns' => [
                        'GET user-journals/<user_id:\d+>'       => 'user-journals',
                        'PUT add-views/<id:\d+>'                => 'add-views',
                        'GET count'                             => 'count',
                        'PUT add-views-to-journal'              => 'add-views-to-journal'

                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/subscription',
                    'extraPatterns' => [
                        'GET view-by-type/<type:\d+>'   => 'view-by-type',
                        'PUT subscribe/<type:\d+>/<id:\d+>' => 'subscribe',
                        'PUT unsubscribe/<id:\d+>'      => 'unsubscribe',
                        'GET search'                => 'search',
                        'GET count'                 => 'count'

                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/bookmark',
                    'extraPatterns' => [
                        'GET view-by-type/<type:\d+>'   => 'view-by-type',
                        'GET search'                => 'search',
                        'PUT add/<type:\d+>/<id:\d+>'       => 'add',
                        'GET count'                         => 'count'

                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/follower',
                    'extraPatterns' => [
                        'PUT follow'        => 'follow',
                        'PUT unfollow'      => 'unfollow',
                        'PUT follow-car'    => 'follow-car',
                        'PUT unfollow-car'  => 'unfollow-car',
                        'GET search/<query:\w+>' => 'search'



                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/top-car'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/achievement'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/community',
                    'extraPatterns' => [
                        'GET members' => 'members',
                        'GET add-to-blacklist' => 'add-to-blacklist',
                        'GET remove-from-moderators' => 'remove-from-moderators',
                        'GET remove-from-community' => 'remove-from-community'
                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/discussion',
                    'extraPatterns' => [

                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/like'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/notification',
                    'extraPatterns' => [
                        "PUT read" =>"read"

                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/node',
                    'extraPatterns' => [
                        'GET get-node/<id:\d+>/<node_type:\d+>' =>"get-node",
                        'DELETE delete-node/<id:\d+>/<node_type:\d+>' => 'delete-node'

                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/favorite',
                    'extraPatterns' => [
                        "PUT add" =>"add"

                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/security',
                    'extraPatterns' => [
                        "GET get-csrf-token" =>"get-csrf-token"

                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/catalog',
                    'extraPatterns' => [
                        "GET get-countries" =>"get-countries",
                        'GET get-cities/<code:\w+>' => 'get-cities',
                        'GET get-car-brands'        => 'get-car-brands',
                        'GET get-car-models-by-brand' => 'get-car-models-by-brand',
                        'GET get-car-modifications-and-build-dates' => 'get-car-modifications-and-build-dates',
                        'GET get-car-launch-year-by-model' => 'get-car-launch-year-by-model',
                        'GET get-car-location'             => 'get-car-location',
                        'GET get-car-engine-size'          => 'get-car-engine-size',
                        'GET get-car-capacity'             => 'get-car-capacity',
                        'GET get-car-drive-type'           => 'get-car-drive-type'

                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/blacklist',
                    'extraPatterns' => [
                        "POST add"   => "add"

                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/home',

                ],

            ],
        ],

        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            /*'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],*/
        ],

    ],
    'params' => $params,
];
