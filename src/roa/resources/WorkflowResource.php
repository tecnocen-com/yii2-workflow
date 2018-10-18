<?php

namespace tecnocen\workflow\roa\resources;

use tecnocen\workflow\roa\models\Workflow;
use tecnocen\workflow\roa\models\WorkflowSearch;

/**
 * CRUD resource for `Workflow` records
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class WorkflowResource extends \tecnocen\roa\controllers\Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = Workflow::class;

    /**
     * @inheritdoc
     */
    public $searchClass = WorkflowSearch::class;
}
