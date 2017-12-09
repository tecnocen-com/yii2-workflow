<?php

namespace app\fixtures;

use app\models\Credit;
use yii\test\ActiveFixture;

/**
 * Fixture to load default credit.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = Credit::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/credit.php';

    /**
     * @inheritdoc
     */
    public $depends = ['app\fixtures\TransitionPermissionFixture'];
}