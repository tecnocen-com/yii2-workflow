<?php

namespace app\models;

class CreditWorkLog extends \tecnocen\workflow\models\WorkLog
{
    public static function tableName()
    {
        return '{{%credit_worklog}}';
    }

    protected function processClass(): string
    {
        return Credit::class;
    }
}
