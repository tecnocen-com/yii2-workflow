<?php

namespace tecnocen\workflow\roa\resources;

use Yii;
use tecnocen\workflow\roa\models\TransitionPermission;
use tecnocen\workflow\roa\models\TransitionPermissionSearch;

/**
 * Resource to assign permissions to a transition.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class PermissionResource extends \tecnocen\roa\controllers\Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    public $searchClass = TransitionPermissionSearch::class;

    /**
     * @inheritdoc
     */
    public $idAttribute = 'permission';

    /**
     * @inheritdoc
     */
    public $createScenario = TransitionPermission::SCENARIO_CREATE;

    /**
     * @inheritdoc
     */
    public $updateScenario = TransitionPermission::SCENARIO_UPDATE;

    /**
     * @inheritdoc
     */
    public $filterParams = ['source_stage_id', 'target_stage_id'];
}
