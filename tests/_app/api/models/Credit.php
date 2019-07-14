<?php

namespace app\api\models;

use app\models as base;
use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;

/**
 * ROA contract to handle credit records.
 */
class Credit extends base\Credit implements Contract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }

    /**
     * @inheritdoc
     */
    protected function assignmentClass(): string
    {
        return CreditAssignment::class;
    }

    /**
     * @inheritdoc
     */
    protected function workLogClass(): string
    {
        return CreditWorklog::class;
    }

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'resourceName' => 'credit',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'worklog' => $this->getSelfLink() . '/worklog',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'workLogs',
            'activeWorkLog',
        ];
    }
}
