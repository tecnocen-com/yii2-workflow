<?php

$now = new \yii\db\Expression('NOW()');

return [
    [
        'process_id' => 1,
        'stage_id' => 2,
        'commentary' => 'hola mundo 1',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 2,
        'stage_id' => 3,
        'commentary' => 'hola mundo 2',
        'created_by' => 1,
        'created_at' => $now,
    ],
];
