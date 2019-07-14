<?php

namespace app\api\resources;

use app\api\models\Credit;
use app\api\models\CreditSearch;
use tecnocen\roa\controllers\Resource;

/**
 * CRUD resource for `Credit` records
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditResource extends Resource
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
