<?php

namespace app\api\models;

use app\models as base;
use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;

/**
 * ROA contract to handle credit_assignment records.
 */
class CreditAssignment extends base\CreditAssignment implements Contract
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
            'resourceName' => 'assignment',
            'parentSlugRelation' => 'process',
            'idAttribute' => 'user_id'
        ];
    }
}
