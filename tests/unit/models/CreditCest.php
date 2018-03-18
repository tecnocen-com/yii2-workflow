<?php

namespace models;

use app\fixtures\CreditFixture;
use app\models\Credit;
use Codeception\Example;
use UnitTester;

class CreditCest
{
    public function fixtures(UnitTester $I)
    {
        $I->haveFixtures([
            'worklog' => [
                'class' => CreditFixture::class,
	        ],
	    ]);
    }	

    /**
     * @dataprovider failedValidationData
     * @depends fixtures
     */
    public function failedValidation(UnitTester $I, Example $example)
    {
        $credit = new Credit();
        $credit->load($example['data'], '');
        $I->assertFalse($credit->validate());
        foreach ($example['errors'] as $attribute => $message) {
            $I->assertTrue($credit->hasErrors($attribute));
            $I->assertEquals($message, $credit->getFirstError($attribute));
        }
    }

    protected function failedValidationData()
    {
        return [
            [
                'data' => [],
                'errors' => [
                    'workflow_id' => 'Workflow ID cannot be blank.',
                    'initial_stage_id' => 'Initial Stage Id cannot be blank.',
                ],
            ],
            [
                'data' => [
                    'workflow_id' => 10,
                    'initial_stage_id' => 10,
                ],
                'errors' => [
                    'workflow_id' => 'Workflow ID is invalid.',
                    'initial_stage_id' => 'Initial Stage Id is invalid.',
                ],
            ],
        ];
    }

    /**
     * @dataprovider saveData
     */
    public function save(UnitTester $I, Example $example)
    {
        $credit = new Credit();
	    $credit->load($example['data'], '');
	    $credit->save();
	    $I->assertEmpty($credit->getFirstErrors());
        $I->assertTrue($credit->save());
        $I->assertNotEmpty($credit->workLogs);
        $I->assertNotEmpty($credit->activeWorkLog);
        $I->assertNotEmpty(
            $example['data']['initial_stage_id'],
            $credit->activeWorkLog->stage_id
        );
    }

    protected function saveData()
    {
        return [
            [
                'data' => [
                    'workflow_id' => 1,
                    'initial_stage_id' => 1,
                ],
            ],
        ];
    }
}
