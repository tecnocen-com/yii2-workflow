<?php

use Codeception\Example;
use Codeception\Util\HttpCode;
use app\fixtures\AuthItemFixture;
use app\fixtures\OauthAccessTokensFixture;
use app\fixtures\TransitionPermissionFixture;

/**
 * Cest to transition_permission resource.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class TransitionPermissionCest extends \tecnocen\roa\test\AbstractResourceCest
{
    protected function authToken(ApiTester $I)
    {
        $I->amBearerAuthenticated(OauthAccessTokensFixture::SIMPLE_TOKEN);
    }

    /**
     * @depends TransitionCest:fixtures
     */
    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'auth_item' => AuthItemFixture::class,
            'transition_permission' => [
                'class' => TransitionPermissionFixture::class,
                'depends' => [],
            ],
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
        $I->wantTo('Retrieve list of Transition Permission records.');
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
                    'stage_id' => 1,
                    'target_id' => 2,
                    'expand' => 'sourceStage, transition'
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 1,
                ],
            ],
            'list with target stage' => [
                'urlParams' => [
                    'workflow_id' => 2,
                    'stage_id' => 5,
                    'target_id' => 7    ,
                    'expand' => 'targetStage'
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 1,
                ],
            ],
            'not found workflow' => [
                'urlParams' => [
                    'workflow_id' => 10,
                    'stage_id' => 1,
                    'target_id' => 2
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not found stage' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 10,
                    'target_id' => 2
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not found transition' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1,
                    'target_id' => 10
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'filter by name' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1,
                    'target_id' => 2,
                    'permission' => 'administrator',
                    'expand' => 'transition'
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 1,
                ],
            ],
            'rule created_by' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1,
                    'target_id' => 2,
                    'created_by' => 'per',
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
        $I->wantTo('Retrieve Transition Permission single record.');
        $this->internalView($I, $example);
    }

    /**
     * @return array<string,array<string,string>> data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'not allowed' => [
                'url' => '/w1/workflow/1/stage/1/transition/2/permission/administrator',
                'httpCode' => HttpCode::OK,
            ]
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
        $I->wantTo('Create a Transition Permission record.');
        $this->internalCreate($I, $example);
    }

    /**
     * @return array<string,array> data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create transition permission' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1,
                    'target_id' => 2
                ],
                'data' => [
                    'permission' => 'credit'
                ],
                'httpCode' => HttpCode::CREATED,
            ],
            'required data' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1,
                    'target_id' => 2
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'permission' => 'Permission cannot be blank.'
                ],
            ],
            'workflow not found' => [
                'urlParams' => [
                    'workflow_id' => 10,
                    'stage_id' => 1,
                    'target_id' => 2
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 19,
                    'target_id' => 2
                ],
                'data' => [
                    'permission' => 'administrator',
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'to short' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1,
                    'target_id' => 2
                ],
                'data' => [
                    'permission' => 'ad'
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'permission' => 'Permission should contain at least 6 characters.'
                ],
            ],
            'unique transition permission' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1,
                    'target_id' => 2
                ],
                'data' => [
                    'permission' => 'administrator'
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'permission' => 'Permission already set for the transition.'
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
        $I->wantTo('Update a Transition Permission record.');
        $this->internalUpdate($I, $example);
    }

    /**
     * @return array<string,array<string,string|array<string,string>>> data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'method not allowed' => [
                'url' => '/w1/workflow/1/stage/1/transition/2/permission',
                'data' => ['permission' => 'update transition'],
                'httpCode' => HttpCode::METHOD_NOT_ALLOWED,
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
        $I->wantTo('Delete a Transition Permission record.');
        $this->internalDelete($I, $example);
    }

    /**
     * @return array<string,array<string,string|array<string,string>>> data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'delete permission administrator' => [
                'url' => '/w1/workflow/1/stage/1/transition/2/permission/administrator',
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'cannot be blank' => [
                'url' => '/w1/workflow/1/stage/1/transition/2/permission',
                'httpCode' => HttpCode::METHOD_NOT_ALLOWED,
            ],
            'transition not found' => [
                'url' => '/w1/workflow/1/stage/1/transition/10/permission/admin',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'url' => '/w1/workflow/1/stage/10/transition/2/permission/admin',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'workflow not found' => [
                'url' => '/w1/workflow/10/stage/1/transition/2/permission/admin',
                'httpCode' => HttpCode::NOT_FOUND,
	        ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function recordJsonType()
    {
        return [
            'source_stage_id' => 'integer:>0',
            'target_stage_id' => 'integer:>0',
            'permission' => 'string',

        ];
    }

    /**
     * @inheritdoc
     */
    protected function getRoutePattern()
    {
        return 'w1/workflow/<workflow_id:\d+>/stage/<stage_id:\d+>/transition/<target_id:\d+>/permission';
    }
}
