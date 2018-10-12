<?php

namespace app\fixtures;

use app\models\CreditAssignment;
use yii\test\ActiveFixture;

/**
 * Fixture to load default credit.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditAssignmentFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = CreditAssignment::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/credit_assignment.php';

    /**
     * @inheritdoc
     */
    public $depends = ['app\fixtures\CreditFixture'];
}