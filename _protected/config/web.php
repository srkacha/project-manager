<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'projectmanager',
    'name' => 'Projectory',
    'language' => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\Aliases'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '7OQAFfUMIOfQx_8DFqcBdEjinuTWV-yA',
        ],
        // you can set your theme here - template comes with: 'light' and 'dark'
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@webroot/light/views'],
                'baseUrl' => '@web/themes/light',
            ],
        ],
        'assetManager' => [
            'bundles' => [  
                // we will use bootstrap css from our theme
                'yii\bootstrap\BootstrapAsset' => [
                   // 'sourcePath' => '@webroot',
                    'css' => [] //this will use the custom css hopefully
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<alias:\w+>' => 'site/<alias>',
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/user',
                    'extraPatterns' => [
                        'POST login' => 'login',
                    ]
                ], 
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/project',
                    'extraPatterns' => [
                        'POST get-projects-for-user-id' => 'get-projects-for-user-id',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/activity',
                    'extraPatterns' => [
                        'POST get-activities-for-project-and-user' => 'get-activities-for-project-and-user',
                        'POST add-progress-for-activity' => 'add-progress-for-activity'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/task',
                    'extraPatterns' => [
                        
                    ]
                ]
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'savePath' => '@app/runtime/session'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. 
            // You have to set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
            'useFileTransport' => true,
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

$config['modules']['gridview'] = ['class' => '\kartik\grid\Module'];
$config['modules']['datecontrol'] = ['class' => '\kartik\datecontrol\Module'];
$config['modules']['treemanager'] = ['class' => '\kartik\tree\Module'];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = ['class' => 'yii\debug\Module'];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class' => 'yii\gii\Module'];
}

return $config;
