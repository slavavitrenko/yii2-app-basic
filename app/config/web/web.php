<?php

//Event::on(ActiveRecord::class, ActiveRecord::EVENT_BEFORE_UPDATE, $toDbFormat);
//Event::on(ActiveRecord::class, ActiveRecord::EVENT_BEFORE_INSERT, $toDbFormat);
//Event::on(ActiveRecord::class, ActiveRecord::EVENT_AFTER_FIND, $toHumanFormat);

$params = require(__DIR__ . '/../params.php');

$basePath = dirname(__DIR__);
$webroot = dirname($basePath);

$config = [
    'id' => 'cbd3',
    'name' => 'CBD3',
    'language' => 'uk-UA',
    'defaultRoute' => 'site/index',
    'basePath' => dirname(__DIR__) . '/../',
    'runtimePath' => $webroot . '/../runtime',
    'vendorPath' => $webroot . '/../vendor',
    'bootstrap' => ['log'],
    'components' => require(__DIR__ . '/components.php'),
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => $params,
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '93.78.238.18', '93.78.206.29'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '93.78.238.18', '93.78.206.29'],
    ];
}

return $config;
