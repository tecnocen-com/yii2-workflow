<?php

namespace app\api\resources;

use Yii;
use yii\web\NotFoundHttpException;
use app\api\models\CreditWorklog;

/**
 * CRUD resource for `Credit Worklog` records
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditWorklogResource extends \tecnocen\roa\controllers\OAuth2Resource
{	
    /**
     * @inheritdoc
     */
    public $createScenario = CreditWorklog::SCENARIO_FLOW;

    /**
     * @inheritdoc
     */
    public $modelClass = CreditWorklog::class;

    public $filterParams = ['process_id'];
}
