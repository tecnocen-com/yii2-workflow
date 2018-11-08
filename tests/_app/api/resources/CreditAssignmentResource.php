<?php

namespace app\api\resources;

use app\api\models\CreditAssignment;
use tecnocen\roa\controllers\Resource;

/**
 * CRUD resource for `Credit Assignment` records
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditAssignmentResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = CreditAssignment::class;

    public $filterParams = ['process_id'];
}
