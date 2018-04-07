<?php

return [
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'aliases' => [
        '@tests' => dirname(dirname(__DIR__)),
        '@tecnocen/workflow' => dirname(dirname(dirname(__DIR__))) . '/src',
        '@tecnocen/oauth2server' => VENDOR_DIR . '/tecnocen/yii2-oauth2-server/src',
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'authManager' => [
             'class' => yii\rbac\DbManager::class,
        ],
    ],
];
