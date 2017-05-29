<?php

namespace tecnocen\workflow\roa\modules;

use tecnocen\workflow\roa\resources\WorkflowResource;
use tecnocen\workflow\roa\resources\StageResource;
use tecnocen\workflow\roa\resources\TransitionResource;

class Version extends \tecnocen\roa\modules\ApiVersion
{
    const WORKFLOW_ROUTE = 'workflow';
    const STAGE_ROUTE = self::WORKFLOW_ROUTE . '/<workflow_id:\d+>/stage';
    const TRANSITION_ROUTE = self::STAGE_ROUTE . '/<stage_id:\d+>/transition';
    const PERMISSION_ROUTE = self::TRANSITION_ROUTE . '/<target_id:\d+>/permission';

    /**
     * @inheritdoc
     */
    public $resources = [
        self::WORKFLOW_ROUTE => ['class' => WorkflowResource::class],
        self::STAGE_ROUTE => ['class' => StageResource::class],
        self::TRANSITION_ROUTE => ['class' => TransitionResource::class],
        self::PERMISSION_ROUTE => [
            'class' => PermissionResource::class,
            'urlRule' => ['patterns' => ['id' => '<id:\w+>']],
        ],
    ];
}
