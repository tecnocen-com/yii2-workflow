<?php

use app\fixtures\OauthAccessTokensFixture;
use Codeception\Example;
use Codeception\Util\HttpCode;
use tecnocen\workflow\fixtures\WorkflowFixture;

class WorkflowCest extends \tecnocen\roa\test\AbstractResourceCest
{
    protected function authToken(ApiTester $I)
    {
        $I->amBearerAuthenticated(OauthAccessTokensFixture::SIMPLE_TOKEN);
    }

    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'access_tokens' => OauthAccessTokensFixture::class,
            'workflow' => WorkflowFixture::class,
        ]);
    }

    /**
     * @dataprovider indexData
     * @depends fixtures
     * @before authToken
     */
    public function index(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve list of Workflow records.');
        $this->internalIndex($I, $example);
    }

    protected function indexData()
    {
        return [
            [
                'httpCode' => HttpCode::OK,
            ],
        ];
    }

    protected function recordJsonType()
    {
        return [
            'id' => 'integer:>0',
            'name' => 'string',
        ];
    }

    protected function getRoutePattern()
    {
        return 'workflow';
    }
}
