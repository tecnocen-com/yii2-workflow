<?php

namespace app\fixtures;

use app\models\CreditWorklog;
use yii\test\ActiveFixture;

/**
 * Fixture to load default credit.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditWorklogFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = CreditWorklog::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/credit_worklog.php';

    /**
     * @inheritdoc
     */
    public $depends = ['app\fixtures\CreditFixture'];
}