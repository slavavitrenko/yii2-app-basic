<?php

$config = [
    'id' => 'cbd3',
    'name' => 'CBD3',
    'language' => 'uk-UA',
    'basePath' => dirname(__DIR__) . '/../../app/',
    'runtimePath' => dirname(__DIR__) . '/../../runtime',
    'vendorPath' => dirname(__DIR__) . '/../../vendor',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => require(__DIR__ . '/components.php'),
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => require(__DIR__ . '/../params.php'),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
