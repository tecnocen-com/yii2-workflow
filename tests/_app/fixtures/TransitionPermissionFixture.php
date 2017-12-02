<?php

namespace app\fixtures;

use tecnocen\workflow\models\TransitionPermission;
use yii\test\ActiveFixture;

/**
 * Fixture to load default transition_permission.
 */
class TransitionPermissionFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/transition_permission.php';
}