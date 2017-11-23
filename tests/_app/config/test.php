<?php

use tecnocen\workflow\roa\modules\Version as WorkflowVersion;
use tecnocen\roa\controllers\ProfileResource;
use tecnocen\roa\hal\JsonResponseFormatter;
use yii\web\Response;

return [
    'id' => 'yii2-formgenerator-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'aliases' => [
        '@tests' => dirname(dirname(__DIR__)),
        '@vendor' => VENDOR_DIR,
        '@bower' => VENDOR_DIR . '/bower',
    ],
    'bootstrap' => ['api'],
    'modules' => [
        'api' => [
            'class' => tecnocen\roa\modules\ApiContainer::class,
            'identityClass' => app\models\User::class,
            'versions' => [
                'w1' => [
                    'class' => WorkflowVersion::class,
                ],
            ],
        ],
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'mailer' => [
            'useFileTransport' => true,
        ],
        'user' => ['identityClass' => app\models\User::class],
        'urlManager' => [
            'showScriptName' => true,
            'enablePrettyUrl' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
        'response' => [
            'formatters' => [
                Response::FORMAT_JSON => [
                    'class' => JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG,
                ],
            ],
        ],
    ],
    'params' => [],
];
