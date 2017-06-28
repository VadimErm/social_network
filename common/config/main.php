<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'container' => [
        'definitions' => [
            'favorite' => 'common\models\Favorite'
        ],
    ],
    'components' => [
        'geoip' => [
            'class' => 'lysenkobv\GeoIP\GeoIP'
        ],

        'authManager' => [
            'class' => '\yii\rbac\DbManager'
        ],
        'db' => require('db.php'),
        'neo4jDb' => require('neo4j-db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'arbamailserver@gmail.com',
                'password' => '123cxzdsaewq',
                'port' => '465', // Port 25 is a very common port too
                'encryption' => 'ssl', // It is often used, check your provider or mail server specs
            ],
        ],
    ],
];
