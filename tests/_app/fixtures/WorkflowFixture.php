<?php

namespace app\fixtures;

use tecnocen\workflow\models\Workflow;
use yii\test\ActiveFixture;

/**
 * Fixture to load default workflow.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
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