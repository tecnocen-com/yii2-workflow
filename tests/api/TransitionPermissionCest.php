<?php

use Codeception\Example;
use Codeception\Util\HttpCode;
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

    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'access_tokens' => OauthAccessTokensFixture::class,
            'transition' => TransitionPermissionFixture::class,
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
     * @return array[] for test `index()`.
     */
    protected function indexDataProvider()
    {
        return [
            'list' => [
                'url' => '/workflow/1/stage/1/transition/2/permission',
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 1,
                ],
            ],
            'not found workflow' => [
                'url' => '/workflow/10/stage/1/transition/2/permission',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not found stage' => [
                'url' => '/workflow/1/stage/10/transition/2/permission',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not found transition' => [
                'url' => '/workflow/1/stage/1/transition/10/permission',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'filter by name' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1,
                    'target_id' => 2,
                    'permission' => 'administrator'
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 1,
                ],
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
     * @return array[] data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'not allowed' => [
                'url' => '/workflow/1/stage/1/transition/2/permission/administrator',
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
     * @return array[] data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create transition permission' => [
                'url' => '/workflow/1/stage/1/transition/2/permission',
                'data' => [
                    'permission' => 'credit'
                ],
                'httpCode' => HttpCode::CREATED,
            ],
            'required data' => [
                'url' => '/workflow/1/stage/1/transition/2/permission',
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'permission' => 'Permission cannot be blank.'
                ],
            ],
            'workflow not found' => [
                'url' => '/workflow/10/stage/1/transition/2/permission',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'url' => '/workflow/1/stage/19/transition/2/permission',
                'data' => [
                    'permission' => 'administrator',
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],            
            'to short' => [
                'url' => '/workflow/1/stage/1/transition/2/permission',
                'data' => [
                    'permission' => 'ad'
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'permission' => 'Permission should contain at least 6 characters.'
                ],
            ],
            'unique transition permission' => [
                'url' => '/workflow/1/stage/1/transition/2/permission',
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
     * @return array[] data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'method not allowed' => [
                'url' => '/workflow/1/stage/1/transition/2/permission',
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
     * @return array[] data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'delete permission administrator' => [
                'url' => '/workflow/1/stage/1/transition/2/permission/administrator',
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'cannot be blank' => [
                'url' => '/workflow/1/stage/1/transition/2/permission',
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'permission' => 'Permission cannot be blank.',
                ],
            ],
            'transition not found' => [
                'url' => '/workflow/1/stage/1/transition/10/permission',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'url' => '/workflow/1/stage/10/transition/2/permission',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'workflow not found' => [
                'url' => '/workflow/10/stage/1/transition/2/permission',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'transition with permission not found' => [
                'url' => '/workflow/1/stage/1/transition/10/permission/administrator',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage with permission not found' => [
                'url' => '/workflow/1/stage/10/transition/2/permission/administrator',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'workflow with permission not found' => [
                'url' => '/workflow/10/stage/1/transition/2/permission/administrator',
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
        return 'workflow/<workflow_id:\d+>/stage/<stage_id:\d+>/transition/<target_id:\d+>/permission';
    }
}
