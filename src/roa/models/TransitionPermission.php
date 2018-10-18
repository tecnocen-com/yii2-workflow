<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;
use tecnocen\workflow\models as base;

/**
 * ROA contract to handle workflow transition permissions records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class TransitionPermission extends base\TransitionPermission implements Contract
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
    protected $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    public function slugBehaviorConfig()
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
    public function getLinks()
    {
        return array_merge($this->getContractLinks());
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['sourceStage', 'targetStage', 'transition'];
    }
}
