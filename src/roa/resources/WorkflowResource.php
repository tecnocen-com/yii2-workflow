<?php

namespace tecnocen\workflow\roa\resources;

use tecnocen\workflow\roa\models\Workflow;

class WorkflowResource extends \tecnocen\roa\controllers\OAuth2Resource
{
    public $modelClass = Workflow::class;
}
