<?php

use Codeception\Example;
use Codeception\Util\HttpCode;
use app\fixtures\OauthAccessTokensFixture;
use app\fixtures\TransitionFixture;

/**
 * Cest to transition resource.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class TransitionCest extends \tecnocen\roa\test\AbstractResourceCest
{
    protected function authToken(ApiTester $I)
    {
        $I->amBearerAuthenticated(OauthAccessTokensFixture::SIMPLE_TOKEN);
    }

    /**
     * @depends StageCest:fixtures
     */
    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'transition' => [
                'class' => TransitionFixture::class,
                'depends' => [],
            ]
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
     * @return array<string,array> for test `index()`.
     */
    protected function indexDataProvider()
    {
        return [
            'list' => [
                'urlParams' => [
                    'workflow_id' => 2,
                    'stage_id' => 5,
                    'expand' => 'sourceStage, targetStage, permissions'
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 2,
                ],
            ],
            'not found workflow' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 5
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not found stage' => [
                'urlParams' => [
                    'workflow_id' => 2,
                    'stage_id' => 10
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not found transition' => [
                'url' => '/w1/workflow/2/stage/5/transition/1',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'filter by name' => [
                'urlParams' => [
                    'workflow_id' => 2,
                    'stage_id' => 5,
                    'name' => 'Stage 2 to Stage 3'
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 1,
                ],
            ],
            'rule created_by' => [
                'urlParams' => [
                    'workflow_id' => 2,
                    'stage_id' => 5,
                    'created_by' => 'tra',
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
        $I->wantTo('Retrieve Transition single record.');
        $this->internalView($I, $example);
    }

    /**
     * @return array<string,array<string,string>> data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'single record' => [
                'url' => '/w1/workflow/1/stage/1/transition/2',
                'httpCode' => HttpCode::OK,
            ],
            'transition not found' => [
                'url' => '/w1/workflow/1/stage/2/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'url' => '/w1/workflow/1/stage/10/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'workflow not found' => [
                'url' => '/w1/workflow/10/stage/1/transition/2',
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
     * @return array<string,array> data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create transition' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1
                ],
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 3,
                    'name' => 'new Transition'
                ],
                'httpCode' => HttpCode::CREATED,
            ],
            'required data' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1
                ],
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
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1
                ],
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
                'urlParams' => [
                    'workflow_id' => 10,
                    'stage_id' => 1
                ],
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 4
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 19
                ],
                'data' => [
                    'source_stage_id' => 1,
                    'target_stage_id' => 4
                ],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'unique source target' => [
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1
                ],
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
                'urlParams' => [
                    'workflow_id' => 1,
                    'stage_id' => 1
                ],
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
     * @return array<string,array<string,string|array<string,string>>> data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'update transition' => [
                'url' => '/w1/workflow/1/stage/1/transition/2',
                'data' => ['name' => 'update transition'],
                'httpCode' => HttpCode::OK,
            ],
            'to short' => [
                'url' => '/w1/workflow/1/stage/1/transition/2',
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
     * @return array<string,array<string,string|array<string,string>>> data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'workflow not found' => [
                'url' => '/w1/workflow/10/stage/1/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'stage not found' => [
                'url' => '/w1/workflow/1/stage/10/transition/2',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'transition not found' => [
                'url' => '/w1/workflow/1/stage/1/transition/10',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'delete transition 1-3' => [
                'url' => '/w1/workflow/1/stage/1/transition/3',
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'not found' => [
                'url' => '/w1/workflow/1/stage/1/transition/3',
                'httpCode' => HttpCode::NOT_FOUND,
                'validationErrors' => [
                    'name' => 'The record "3" does not exists.'
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
        return 'w1/workflow/<workflow_id:\d+>/stage/<stage_id:\d+>/transition';
    }
}
