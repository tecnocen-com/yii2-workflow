<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;
use tecnocen\workflow\models as base;

/**
 * ROA contract to handle workflow transition permissions records.
 */
class TransitionPermission extends base\TransitionPermission implements Contract
{
    use ContractTrait;

    /**
     * @inheritdoc
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    protected $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'idAttribute' => 'permission',
            'resourceName' => 'permission',
            'parentSlugRelation' => 'transition',
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['sourceStage', 'targetStage', 'transition'];
    }
}
