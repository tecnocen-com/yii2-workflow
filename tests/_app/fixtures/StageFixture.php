<?php

namespace app\fixtures;

use tecnocen\workflow\models\Stage;
use yii\test\ActiveFixture;

/**
 * Fixture to load default stage.
 */
class StageFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = Stage::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/stage.php';
}