<?php

namespace tests\unit\fixtures;

use tecnocen\workflow\models\Workflow;
use yii\test\ActiveFixture;

/**
 * Fixture to load default workflow.
 */
class WorkflowFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = Workflow::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/workflow.php';
}