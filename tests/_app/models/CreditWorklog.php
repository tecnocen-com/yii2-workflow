<?php

namespace app\models;

class CreditWorkLog extends \tecnocen\workflow\models\WorkLog
{
    public static function processClass()
    {
        return Credit::class;
    }
}
