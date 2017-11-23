<?php

return [
    'id' => 'yii2-workflow-test',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@tests' => dirname(dirname(__DIR__)),
        '@tecnocen/workflow' => dirname(dirname(dirname(__DIR__))) . '/src',
        '@tecnocen/oauth2server' => VENDOR_DIR . '/tecnocen/yii2-oauth2-server/src',
    ],
    'components' => [
        'log' => null,
        'cache' => null,
        'db' => require __DIR__ . '/db.php',
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => null,
            'migrationNamespaces' => [],
        ],
    ],
];
