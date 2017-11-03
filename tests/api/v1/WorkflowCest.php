<?php

namespace v1;

use ApiTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class WorkflowCest extends \tecnocen\roa\test\AbstractResourceCest
{
    /**
     * @dataprovider indexData
     */
    public function index(ApiTester $I, Example $example)
    {
        $I->wantTo('Test GET request for a list of workflows.');
        $this->internalIndex($I, $example);
    }

    protected function indexData()
    {
        return [
            [
                 'urlParams' => [],
                 'httpCode' => HttpCode::OK,
            ],
        ];
    }

    protected function recordJsonType()
    {
        return [
            'id' => 'integer',
            'name' => 'string',
        ];
    }

    protected function getRoutePattern()
    {
        return 'w1/workflow';
    }
}
