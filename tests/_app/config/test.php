<?php

use app\api\modules\Version as V1;
use tecnocen\workflow\roa\modules\Version as WorkflowVersion;
use tecnocen\roa\controllers\ProfileResource;
use tecnocen\roa\hal\JsonResponseFormatter;
use app\api\modules\Version as CreditResource;
use yii\web\Response;

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common.php',
    [
        'id' => 'yii2-workflow-tests',
        'bootstrap' => ['api'],
        'modules' => [
            'api' => [
                'class' => tecnocen\roa\modules\ApiContainer::class,
                'identityClass' => app\models\User::class,
                'versions' => [
                    'w1' => [
                        'class' => WorkflowVersion::class,
                    ],
                    'v1' => [
                        'class' => V1::class,
                    ],
                ],
            ],
            'rmdb' => [
                'class' => tecnocen\rmdb\Module::class,
            ],
        ],
        'components' => [
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
    ]
);
