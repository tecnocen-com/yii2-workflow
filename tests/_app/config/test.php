<?php

use tecnocen\roa\modules\ApiContainer;
use tecnocen\workflow\roa\modules\Version as WorkflowVersion;

return [
    'id' => 'yii2-user-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'bootstrap' => ['api'],
    'aliases' => [
        '@tests' => dirname(dirname(__DIR__)),
        '@vendor' => VENDOR_DIR,
        '@bower' => VENDOR_DIR . '/bower',
    ],
    'modules' => [
        'oauth2' => [
            'class' => OAuth2Module::class,
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => ApiUser::class,
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => UserCredentials::class,
                ],
                'refresh_token' => [
                    'class' => RefreshToken::class,
                    'always_issue_new_refresh_token' => true,
                ],
            ],
        ],
        'api' => [
            'class' => ApiContainer::class,
            'identityClass' => models\User::class,
            'versions' => [
                'w1' => [
                    'class' => WorkflowVersion::class,
                ],
            ],
        ],
    ],
    'components' => [
        'assetManager' => [
            'basePath' => dirname(__DIR__) . '/assets',
        ],
        'db' => require __DIR__ . '/db.php',
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
            'enablePrettyUrl' => true,
        ],
        'user' => [
            'identityClass' => models\User::class,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
    ],
    'params' => [],
];
