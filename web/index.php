<?php

require(__DIR__ . '/../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::create(__DIR__ . "/../");
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', getenv('DEBUG') ? true : false);
defined('YII_ENV') or define('YII_ENV', getenv('ENV') ?: 'prod');
defined('UPLOAD_MAX_FILESIZE') or define('UPLOAD_MAX_FILESIZE', getenv('UPLOAD_MAX_FILESIZE'));


require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

require(__DIR__ . '/../app/functions.php');

$config = require(__DIR__ . '/../app/config/web/web.php');

(new yii\web\Application($config))->run();
