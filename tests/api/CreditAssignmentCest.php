<?php

use Codeception\Example;
use Codeception\Util\HttpCode;
use app\fixtures\CreditAssignmentFixture;
use app\fixtures\OauthAccessTokensFixture;

/**
 * Cest to stage resource.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditAssignmentCest extends \tecnocen\roa\test\AbstractResourceCest
{
    protected function authToken(ApiTester $I)
    {
        $I->amBearerAuthenticated(OauthAccessTokensFixture::SIMPLE_TOKEN);
    }

    /**
     * @depends CreditCest:fixtures
     */
    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'credit_assignment' => [
                'class' => CreditAssignmentFixture::class,
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
        $I->wantTo('Retrieve list of Credit Assignment records.');
        $this->internalIndex($I, $example);
    }

    /**
     * @return array<string,array> for test `index()`.
     */
    protected function indexDataProvider()
    {
        return [
            'list' => [
                'url' => '/v1/credit/1/assignment',
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
        $I->wantTo('Retrieve Credit Assignment single record.');
        $this->internalView($I, $example);
    }

    /**
     * @return array<string,array<string,string>> data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'single record' => [
                'url' => '/v1/credit/1/assignment/1',
                'httpCode' => HttpCode::OK,
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
        $I->wantTo('Create a Credit Assignment record.');
        $this->internalCreate($I, $example);
    }

    /**
     * @return array<string,array> data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create assignment' => [
                'urlParams' => [
                    'process_id' => 2
                ],
                'data' => [
                    'user_id' => 1
                ],
                'httpCode' => HttpCode::CREATED,
            ],
            'not found process' => [
                'urlParams' => [
                    'process_id' => 10
                ],
                'data' => [
                    'user_id' => 1
                ],
                'httpCode' => HttpCode::NOT_FOUND,
                'validationErrors' => [
                    'message' => 'process not found',
                ],
            ],
            'unprocessable user' => [
                'urlParams' => [
                    'process_id' => 2
                ],
                'data' => [
                    'user_id' => 10
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'user_id' => 'User ID is invalid.',
                ],
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider updateDataProvider
     * @depends create
     * @before authToken
     */
    public function update(ApiTester $I, Example $example)
    {
        $I->wantTo('Update a Credit Assignment record.');
        $this->internalUpdate($I, $example);
    }

    /**
     * @return array<string,array> data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'update credit 1' => [
                'url' => '/v1/credit/1/assignment/1',
                'data' => [
                    'user_id' => 1
                ],
                'httpCode' => HttpCode::OK,
            ],
            'update credit error ' => [
                'url' => '/v1/credit/1/assignment/1',
                'data' => [
                    'user_id' => 2
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'user_id' => 'User ID is invalid.'
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
        $I->wantTo('Delete a Credit Assignment record.');
        $this->internalDelete($I, $example);
    }

    /**
     * @return array[] data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'credit assignment not found' => [
                'url' => '/v1/credit/10/assignment/5',
                'httpCode' => HttpCode::NOT_FOUND,
                'validationErrors' => [
                    'name' => 'The record "10" does not exists.'
                ],
            ],
            'credit assigment' => [
                'url' => '/v1/credit/1/assignment/1',
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'not found' => [
                'url' => '/v1/credit/1/assignment/1',
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
            'process_id' => 'integer:>0|string',
            'user_id' => 'integer:>0|string',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getRoutePattern()
    {
        return 'v1/credit/<process_id:\d+>/assignment';
    }
}
