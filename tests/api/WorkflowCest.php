<?php

use Codeception\Example;
use Codeception\Util\HttpCode;
use app\fixtures\OauthAccessTokensFixture;
use app\fixtures\WorkflowFixture;

/**
 * Cest to workflow resource.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
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
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider indexDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function index(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve list of Workflow records.');
        $this->internalIndex($I, $example);
    }

    /**
     * @return array<string,array> for test `index()`.
     */
    protected function indexDataProvider()
    {
        return [
            'list' => [
                'httpCode' => HttpCode::OK,
            ],
            'filter by name' => [
                'urlParams' => [
                    'name' => 'workflow 2',
                    'expand' => 'stages'
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 1,
                ],
            ],
            'filter by author' => [
                'urlParams' => ['created_by' => 1],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 2,
                ],
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider viewDataProvider
     * @depends StageCest:fixtures
     * @before authToken
     */
    public function view(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve Workflow single record.');
        $this->internalView($I, $example);
        if (isset($example['response'])) {
            $I->seeResponseContainsJson($example['response']);
        }
    }

    /**
     * @return array[] data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'expand stages' => [
                'urlParams' => [
                    'id' => '1',
                    'expand' => 'stages, totalStages, detailStages'
                ],
                'httpCode' => HttpCode::OK,
                'response' => [
                    '_embedded' => [
                        'stages' => [
                            ['id' => 1],
                        ],
                    ],
                ],
            ],
            'field total stages' => [
                'urlParams' => [
                    'id' => '1',
                    'fields' => 'id,name,totalStages'
                ],
                'httpCode' => HttpCode::OK,
                'response' => [
                    'totalStages' => 3,
                ]
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
        $I->wantTo('Create a Workflow record.');
        $this->internalCreate($I, $example);
    }

    /**
     * @return array<string,array<string,array<string,string>>> data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create workflow 3' => [
                'data' => ['name' => 'workflow 3'],
                'httpCode' => HttpCode::CREATED,
            ],
            'unique' => [
                'data' => ['name' => 'workflow 3'],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Workflow name "workflow 3" has already been taken.'
                ],
            ],
            'to short' => [
                'data' => ['name' => 'wo'],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Workflow name should contain at least 6 characters.'
                ],
            ],
            'not blank' => [
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Workflow name cannot be blank.'
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
        $I->wantTo('Update a Workflow record.');
        $this->internalUpdate($I, $example);
    }

    /**
     * @return array[] data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'update workflow 1' => [
                'urlParams' => ['id' => '1'],
                'data' => ['name' => 'workflow 7'],
                'httpCode' => HttpCode::OK,
            ],
            'to short' => [
                'urlParams' => ['id' => '1'],
                'data' => ['name' => 'wo'],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Workflow name should contain at least 6 characters.'
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
        $I->wantTo('Delete a Workflow record.');
        $this->internalDelete($I, $example);
    }

    /**
     * @return array[] data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'delete workflow 1' => [
                'urlParams' => ['id' => '1'],
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'not found' => [
                'urlParams' => ['id' => '1'],
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
        return 'w1/workflow';
    }
}
