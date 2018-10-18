<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;
use tecnocen\workflow\models as base;

/**
 * ROA contract to handle workflow transitions records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Transition extends base\Transition implements Contract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }

    /**
     * @inheritdoc
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    protected $permissionClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig()
    {
        return [
            'resourceName' => 'transition',
            'parentSlugRelation' => 'sourceStage',
            'idAttribute' => 'target_stage_id',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'permissions' => $this->getSelfLink() . '/permission',
            'target_stage' => $this->targetStage->getSelfLink(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['sourceStage', 'targetStage', 'permissions'];
    }
}
