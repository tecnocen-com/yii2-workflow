<?php

namespace app\api\models;

use app\models as base;
use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;

/**
 * ROA contract to handle credit_worklog records.
 */
class CreditWorklog extends base\CreditWorklog implements Contract
{
    use ContractTrait;

    /**
     * @inheritdoc
     */
    protected function processClass(): string
    {
        return Credit::class;
    }

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'resourceName' => 'worklog',
            'parentSlugRelation' => 'process'
        ];
    }
}
