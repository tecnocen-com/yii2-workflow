<?php

use app\fixtures\TransitionFixture;
use app\models\CreditWorklog;

/**
 * Cest to credit worklog model.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditWorklogCest
{

    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'transition' => TransitionFixture::class,
        ]);
    }

    public function credit()
    {
        $creditWorklog = CreditWorklog::create();

        $creditWorklog->process_id = 1;
        $this->assertTrue($creditWorklog->validate(['process_id']));

        $creditWorklog->stage_id = 2;
        $this->assertTrue($creditWorklog->validate(['stage_id']));

    }

    public function save()
    {
        $creditWorklog = new CreditWorklog();
        $creditWorklog->process_id = 1;
        $creditWorklog->stage_id   = 2;
        $creditWorklog->save();
        $this->tester->seeInDatabase('credit_worklog', 
            ['process_id' => 1, 'stage_id' => 2]);
    }
}