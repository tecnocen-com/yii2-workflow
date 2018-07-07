<?php

use yii\rbac\Item;

$now = new yii\db\Expression('unix_timestamp()');

return [
    [
        'name' => 'admin',
        'type' => Item::TYPE_ROLE,
        'created_at' => $now,
        'updated_at' => $now,
    ],
];
