<?php

namespace tecnocen\workflow\roa\resources;

use tecnocen\roa\controllers\Resource;
use tecnocen\workflow\roa\models\Stage;
use tecnocen\workflow\roa\models\StageSearch;

/**
 * Resource to handle `Stage` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class StageResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = Stage::class;

    /**
     * @inheritdoc
     */
    public $searchClass = StageSearch::class;

    /**
     * @inheritdoc
     */
    public $filterParams = ['workflow_id'];
}
