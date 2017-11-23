<?php

return [
    [
        'client_id' => 'testclient',
        'client_secret'  => 'testpass',
        'redirect_uri' => 'http://fake/',
        'grant_types' => 'client_credentials authorization_code '
            . 'password implicit'
    ],
];
