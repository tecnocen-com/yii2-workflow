<?php

$now = new \yii\db\Expression('NOW()');

return [
    [
        'process_id' => 1,
        'stage_id' => 4,
        'commentary' => 'stage 4',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 4,
        'stage_id' => 4,
        'commentary' => 'stage 4',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 4,
        'stage_id' => 5,
        'commentary' => 'stage 5',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 4,
        'stage_id' => 6,
        'commentary' => 'stage 6',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 4,
        'stage_id' => 7,
        'commentary' => 'stage 7',
        'created_by' => 1,
        'created_at' => $now,
    ],
];
