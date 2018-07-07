<?php

namespace app\api\modules;

use app\api\resources\CreditResource;
use app\api\resources\CreditWorklogResource;

class Version extends \tecnocen\roa\modules\ApiVersion
{
    const CREDIT_ROUTE = 'credit';
    const WORKLOG_ROUTE = self::CREDIT_ROUTE . '/<process_id:\d+>/worklog';
    const ASSIGNMENT_ROUTE = self::CREDIT_ROUTE . '/<process_id:\d+>/assignment';

    /**
     * @inheritdoc
     */
    public $resources = [
        self::CREDIT_ROUTE => ['class' => CreditResource::class],
        self::WORKLOG_ROUTE => ['class' => CreditWorklogResource::class],
        self::ASSIGNMENT_ROUTE => ['class' => CreditAssignmentResource::class],
    ];
}
