<?php

use Codeception\Example;
use Codeception\Util\HttpCode;
use app\fixtures\OauthAccessTokensFixture;
use app\fixtures\TransitionFixture;

class TransitionCest extends \tecnocen\roa\test\AbstractResourceCest
{
    protected function authToken(ApiTester $I)
    {
        $I->amBearerAuthenticated(OauthAccessTokensFixture::SIMPLE_TOKEN);
    }

    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'access_tokens' => OauthAccessTokensFixture::class,
            'transition' => TransitionFixture::class,
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
        $I->wantTo('Retrieve list of Transition records.');
        $this->internalIndex($I, $example);
    }

    /**
     * @return array[] for test `index()`.
     */
    protected function indexDataProvider()
    {
        return [
            'list' => [
                'url' => '/workflow/2/stage/5/transition',
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 2,
                ],
            ],
            'not found workflow' => [
                'url' => '/workflow/1/stage/5/transition',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not found stage' => [
                'url' => '/workflow/2/stage/10/transition',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'filter by name' => [
                'url' => '/workflow/2/stage/5/transition',
                'urlParams' => ['name' => 'Stage 2 to Stage 3'],
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
        $I->wantTo('Retrieve Transition single record.');
        $this->internalView($I, $example);
    }

    /**
     * @return array[] data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'single record' => [
                'url' => '/workflow/1/stage/1/transition/2',
                'httpCode' => HttpCode::OK,
            ],
            'transition not found' => [
                'url' => '/workflow/1/stage/2/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'url' => '/workflow/1/stage/10/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'workflow not found' => [
                'url' => '/workflow/10/stage/1/transition/2',
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
        $I->wantTo('Create a Transition record.');
        $this->internalCreate($I, $example);
    }

    /**
     * @return array[] data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create transition' => [
                'url' => '/workflow/1/stage/1/transition',
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 3,
                    'name' => 'new Transition'
                ],
                'httpCode' => HttpCode::CREATED,
            ],
            'required data' => [
                'url' => '/workflow/1/stage/1/transition',
                'data' => [
                    'source_stage_id' => 2,
                    'target_stage_id' => 3,
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Transition Name cannot be blank.'
                ],
            ],
            'required data 2' => [
                'url' => '/workflow/1/stage/1/transition',
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 4
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Transition Name cannot be blank.',
                    'target_stage_id' => 'The stages are not associated to the same workflow.'
                ],
            ],
            'workflow not found' => [
                'url' => '/workflow/10/stage/1/transition',
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 4
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'url' => '/workflow/1/stage/19/transition',
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 4
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],            
            'unique source target' => [
                'url' => '/workflow/1/stage/1/transition',
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 2,
                    'name' => 'not unique'
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'target_stage_id' => 'Target already in use for the source stage.'
                ],
            ],
            'unique source name' => [
                'url' => '/workflow/1/stage/1/transition',
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 3,
                    'name' => 'Transition 1 Stage 1 to Stage 2 Wf 1'
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Name already used for the source stage.'
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
        $I->wantTo('Update a Transition record.');
        $this->internalUpdate($I, $example);
    }

    /**
     * @return array[] data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'update transition' => [
                'url' => '/workflow/1/stage/1/transition/2',
                'data' => ['name' => 'update transition'],
                'httpCode' => HttpCode::OK,
            ],
            'to short' => [
                'url' => '/workflow/1/stage/1/transition/2',
                'data' => ['name' => 'tr'],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'name' => 'Transition Name should contain at least 6 characters.'
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
        $I->wantTo('Delete a Transition record.');
        $this->internalDelete($I, $example);
    }

    /**
     * @return array[] data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'workflow not found' => [
                'url' => '/workflow/10/stage/1/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'url' => '/workflow/1/stage/10/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'transition not found' => [
                'url' => '/workflow/1/stage/1/transition/10',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'delete stage 1' => [
                'url' => '/workflow/1/stage/1/transition/2',
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'not found' => [
                'url' => '/workflow/1/stage/1/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
                'validationErrors' => [
                    'name' => 'The record "2" does not exists.'
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
            'source_stage_id' => 'integer:>0',
            'target_stage_id' => 'integer:>0',
            'name' => 'string',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getRoutePattern()
    {
        return 'transition';
    }
}
