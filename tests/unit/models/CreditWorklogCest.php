<?php

namespace models;

use UnitTester;
use app\fixtures\CreditWorklogFixture;
use app\models\CreditWorklog;
use app\models\User;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Cest to credit worklog model.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditWorklogCest
{
    /**
     * @depends models\CreditCest:save
     */
    public function validate(UnitTester $I)
    {
        $creditWorklog = new CreditWorklog();

        $creditWorklog->process_id = 4;
        $I->assertTrue($creditWorklog->validate(['process_id']));

        $creditWorklog->stage_id = 5;
        $I->assertTrue($creditWorklog->validate(['stage_id']));

    }

    /**
     * @depends models\CreditCest:save
     */
    public function save(UnitTester $I)
    {
        $creditWorklog = new CreditWorklog();
        $creditWorklog->process_id = 4; // current stage_id = 7
        $creditWorklog->stage_id = 4;
        $I->expectException(
            ForbiddenHttpException::class,
            function () use ($creditWorklog) {
                $creditWorklog->save();
            }
        );

        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');
        $auth->assign($adminRole, 1);
        Yii::$app->user->login(User::findOne(1));

        $I->assertTrue($creditWorklog->save());
        $auth->revoke($adminRole, 1);
    }
}
