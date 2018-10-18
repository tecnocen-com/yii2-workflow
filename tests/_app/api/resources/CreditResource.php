<?php

namespace app\api\resources;

use Yii;
use yii\web\NotFoundHttpException;
use app\api\models\Credit;
use app\api\models\CreditSearch;

/**
 * CRUD resource for `Credit` records
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditResource extends \tecnocen\roa\controllers\Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = Credit::class;

    /**
     * @inheritdoc
     */
    public $searchClass = CreditSearch::class;
}
