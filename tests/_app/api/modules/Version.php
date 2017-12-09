<?php

namespace app\api\modules;

use app\api\resources\CreditResource;

class Version extends \tecnocen\roa\modules\ApiVersion
{
    const CREDIT_ROUTE = 'credit';
    /**
     * @inheritdoc
     */
    public $resources = [
        self::CREDIT_ROUTE => ['class' => CreditResource::class],
    ];
}
