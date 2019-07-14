<?php

namespace tecnocen\workflow\roa\resources;

use tecnocen\roa\controllers\Resource;
use tecnocen\workflow\roa\models\Transition;
use tecnocen\workflow\roa\models\TransitionSearch;

/**
 * Resource to handle `Transition` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class TransitionResource extends Resource
{
    /**
     * @inhertidoc
     */
    public $modelClass = Transition::class;

    /**
     * @inhertidoc
     */
    public $searchClass = TransitionSearch::class;

    /**
     * @inheritdoc
     */
    public $idAttribute = 'target_stage_id';

    /**
     * @inheritdoc
     */
    public $filterParams = ['source_stage_id'];

    /**
     * @inheritdoc
     */
    public $createScenario = Transition::SCENARIO_CREATE;

    /**
     * @inheritdoc
     */
    public $updateScenario = Transition::SCENARIO_UPDATE;
}
