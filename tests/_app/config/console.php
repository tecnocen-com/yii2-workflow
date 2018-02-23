<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common.php',
    [
        'id' => 'yii2-test-console',
        'components' => [
            'log' => null,
            'cache' => null,
        ],
        'controllerMap' => [
            'migrate' => [
                'class' => yii\console\controllers\MigrateController::class,
                'migrationPath' => null,
                'migrationNamespaces' => [],
            ],
        ],
    ]
);
