<?php

$now = new \yii\db\Expression('NOW()');

return [
    [
        'process_id' => 4,
        'stage_id' => 5,
        'commentary' => 'worklog 1',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 5,
        'stage_id' => 5,
        'commentary' => 'worklog 2',
        'created_by' => 1,
        'created_at' => $now,
    ],
];
