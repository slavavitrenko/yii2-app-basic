<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 13.05.17
 * Time: 17:01
 */

return [
    'request' => [
        'cookieValidationKey' => 'cqnasKuLkltNc9Ma2pGZduPzYBfVFOei',
    ],
    'cache' => [
        'class' => YII_DEBUG ? 'yii\caching\DummyCache' : 'yii\caching\FileCache',
    ],
    'user' => [
        'identityClass' => 'app\models\User',
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'mailer' => require(__DIR__ . '/../mailer.php'),
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ],
            [
                'class' => 'app\logtargets\Target',
                'token' => getenv('LOG_TOKEN'),
                'chatId' => getenv('LOG_CHAT_ID'),
                'levels' => ['error'],
                'template' => "{remoteAddr}\n{levelAndRequest}\n{category}\n{user}\n{block}",
                'enabled' => (strlen(getenv('LOG_CHAT_ID') . getenv('LOG_TOKEN')) > 20) && !YII_DEBUG,
            ],
        ],
    ],
    'db' => require(__DIR__ . '/../db.php'),
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        ],
    ],
    'assetManager' => [
        'class' => '\yii\web\AssetManager',
        'linkAssets' => true,
        'basePath' => '@webroot/assets-cache',
        'baseUrl' => '@web/assets-cache',
    ],
    'i18n' => [
        'translations' => [
            'app' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@app/messages',
                'sourceLanguage' => 'en',
                'fileMap' => [
                    'app' => 'app.php',
                ],
            ],
        ],
    ],
];