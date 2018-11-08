<?php

namespace tecnocen\workflow\roa\resources;

use tecnocen\roa\controllers\Resource;
use tecnocen\workflow\roa\models\Workflow;
use tecnocen\workflow\roa\models\WorkflowSearch;

/**
 * Resource to handle `Workflow` records
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class WorkflowResource extends Resource
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
