<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;
use tecnocen\workflow\models as base;

/**
 * ROA contract to handle workflow stage records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Stage extends base\Stage implements Contract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge($this->attributes(), ['totalTransitions']);
    }

    /**
     * @inheritdoc
     */
    protected $workflowClass = Workflow::class;

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
            'resourceName' => 'stage',
            'parentSlugRelation' => 'workflow',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'transitions' => $this->getSelfLink() . '/transition',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'workflow',
            'transitions',
            'detailTransitions',
            'totalTransitions',
        ];
    }
}
