<?php

namespace models;

use UnitTester;
use app\fixtures\CreditWorklogFixture;
use app\models\CreditWorklog;

/**
 * Cest to credit worklog model.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditWorklogCest
{

    public function fixtures(UnitTester $I)
    {
        $I->haveFixtures([
            'credit_worklog' => [
                'class' => CreditWorklogFixture::class,
            ],
        ]);
    }   

    public function validate(UnitTester $I)
    {
        $creditWorklog = new CreditWorklog();

        $creditWorklog->process_id = 4;
        $I->assertTrue($creditWorklog->validate(['process_id']));

        $creditWorklog->stage_id = 5;
        $I->assertTrue($creditWorklog->validate(['stage_id']));

    }

    public function save(UnitTester $I)
    {
        $creditWorklog = new CreditWorklog();
        $creditWorklog->process_id = 4;
        $creditWorklog->stage_id   = 4;
        $creditWorklog->save();
    }
}
