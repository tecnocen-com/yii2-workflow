<?php

namespace app\api\modules;

use app\api\resources\CreditResource;
use app\api\resources\CreditWorklogResource;

class Version extends \tecnocen\roa\modules\ApiVersion
{
    const CREDIT_ROUTE = 'credit';
    const WORKLOG_ROUTE = self::CREDIT_ROUTE . '/<process_id:\d+>/worklog';

    /**
     * @inheritdoc
     */
    public $resources = [
        self::CREDIT_ROUTE => ['class' => CreditResource::class],
        self::WORKLOG_ROUTE => [
            'class' => CreditWorklogResource::class,
        ]
    ];
}
