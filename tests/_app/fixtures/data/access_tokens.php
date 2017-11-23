<?php

use app\fixtures\OauthAccessTokensFixture;
use yii\db\Expression as DbExpression;

return [
    [
        'access_token' => OauthAccessTokensFixture::SIMPLE_TOKEN,
        'client_id' => 'testclient',
        'user_id' => 1,
        'expires' => new DbExpression('NOW() + INTERVAL 1 HOUR'),
    ],
];
