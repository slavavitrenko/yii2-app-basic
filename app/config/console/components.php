<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 13.05.17
 * Time: 17:02
 */

return [
    'cache' => [
        'class' => YII_DEBUG ? 'yii\caching\DummyCache' : 'yii\caching\FileCache',
    ],
    'log' => [
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
    'mailer' => require(__DIR__ . '/../mailer.php'),
    'db' => require(__DIR__ . '/../db.php'),
];