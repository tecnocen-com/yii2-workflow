<?php

$now = new \yii\db\Expression('NOW()');

return [
    [
        'process_id' => 1,
        'user_id' => 1,
        'created_by' => 1,
        'created_at' => $now,
    ],
];
