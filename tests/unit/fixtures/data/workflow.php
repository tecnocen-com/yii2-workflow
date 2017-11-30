<?php

$now = new \yii\db\Expression('NOW()');

return [
    [
        'name' => 'workflow 1',
        'created_by' => 1,
        'created_at' => $now,
        'updated_by' => 1,
        'updated_at' => $now,
    ],
    [
        'name' => 'workflow 2',
        'created_by' => 1,
        'created_at' => $now,
        'updated_by' => 1,
        'updated_at' => $now,
    ],
];
