<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 13.05.17
 * Time: 17:06
 */


return [
    'class' => 'yii\swiftmailer\Mailer',
    'viewPath' => '@app/mailer',
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
        'username' => getenv('SMTP_LOGIN') ?: 'setssptest@gmail.com',
        'password' => getenv('SMTP_PASS') ?: 'neiron22',
        'port' => getenv('SMTP_PORT') ?: 587,
        'encryption' => getenv('SMTP_ENC') ?: 'tls',
    ],
];