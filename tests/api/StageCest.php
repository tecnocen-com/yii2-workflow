<?php

use Codeception\Example;
use Codeception\Util\HttpCode;
use app\fixtures\OauthAccessTokensFixture;
use app\fixtures\StageFixture;

/**
 * Cest to stage resource.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class StageCest extends \tecnocen\roa\test\AbstractResourceCest
{
    protected function authToken(ApiTester $I)
    {
        $I->amBearerAuthenticated(OauthAccessTokensFixture::SIMPLE_TOKEN);
    }

    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'access_tokens' => OauthAccessTokensFixture::class,
            'stage' => StageFixture::class,
        ]);
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider indexDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function index(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve list of Stage records.');
        $this->internalIndex($I, $example);
    }

    /**
     * @return array<string,array> for test `index()`.
     */
    protected function indexDataProvider()
    {
        return [
            'list' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'expand' => 'transitions'
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 3,
                ],
            ],
            'not found workflow' => [
                'urlParams' => [
                    'workflow_id' => 10
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'filter by name' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'name' => 'Stage 2 - Wf 1',
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 1,
                ],
            ],
            'filter by author' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'created_by' => 1,
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 3,
                ],
            ],
            'rule created_by' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'created_by' => 'wo',
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider viewDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function view(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve Stage single record.');
        $this->internalView($I, $example);
    }

    /**
     * @return array<string,array<string,string>> data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'single record' => [
                'url' => '/w1/workflow/1/stage/1',
                'httpCode' => HttpCode::OK,
            ],
            'not found stage record' => [
                'url' => '/w1/workflow/1/stage/10',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not found workflow record' => [
                'url' => '/w1/workflow/10/stage/10',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider createDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function create(ApiTester $I, Example $example)
    {
        $I->wantTo('Create a Stage record.');
        $this->internalCreate($I, $example);
    }

    /**
     * @return array<string,array<string,string|array<string,string>>> data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create stage 3' => [
                'urlParams' => [
                    'workflow_id' => 1
                ],
                'data' => ['name' => 'stage 3'],
                'httpCode' => HttpCode::CREATED,
            ],
            'unique' => [
                'urlParams' => [
                    'workflow_id' => 1
                ],
                'data' => ['name' => 'stage 3'],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'The combination "1"-"stage 3" of Workflow ID and Stage name has already been taken.'
                ],
            ],
            'to short' => [
                'urlParams' => [
                    'workflow_id' => 1
                ],
                'data' => ['name' => 'wo'],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Stage name should contain at least 6 characters.'
                ],
            ],
            'not blank' => [
                'urlParams' => [
                    'workflow_id' => 1
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Stage name cannot be blank.'
                ],
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider updateDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function update(ApiTester $I, Example $example)
    {
        $I->wantTo('Update a Stage record.');
        $this->internalUpdate($I, $example);
    }

    /**
     * @return array[] data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'update stage 1' => [
                'url' => '/w1/workflow/1/stage/1',
                'data' => ['name' => 'stage 7'],
                'httpCode' => HttpCode::OK,
            ],
            'to short' => [
                'url' => '/w1/workflow/1/stage/1',
                'data' => ['name' => 'wo'],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Stage name should contain at least 6 characters.'
                ],
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider deleteDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function delete(ApiTester $I, Example $example)
    {
        $I->wantTo('Delete a Stage record.');
        $this->internalDelete($I, $example);
    }

    /**
     * @return array[] data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'workflow not found' => [
                'url' => '/w1/workflow/10/stage/1',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'delete stage 1' => [
                'url' => '/w1/workflow/1/stage/1',
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'not found' => [
                'url' => '/w1/workflow/1/stage/1',
                'httpCode' => HttpCode::NOT_FOUND,
                'validationErrors' => [
                    'name' => 'The record "1" does not exists.'
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    protected function recordJsonType()
    {
        return [
            'id' => 'integer:>0',
            'name' => 'string',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getRoutePattern()
    {
        return 'w1/workflow/<workflow_id:\d+>/stage';
    }
}
