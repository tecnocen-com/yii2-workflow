<?php

namespace tests\unit\fixtures;

use tecnocen\workflow\models\Transition;
use yii\test\ActiveFixture;

/**
 * Fixture to load default transition.
 */
class TransitionFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = Transition::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/transition.php';
}