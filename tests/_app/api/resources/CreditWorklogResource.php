<?php

namespace app\api\resources;

use app\api\models\CreditWorklog;
use tecnocen\roa\controllers\Resource;

/**
 * CRUD resource for `Credit Worklog` records
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditWorklogResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $createScenario = CreditWorklog::SCENARIO_FLOW;

    /**
     * @inheritdoc
     */
    public $modelClass = CreditWorklog::class;

    /**
     * @inheritdoc
     */
    public $filterParams = ['process_id'];
}
