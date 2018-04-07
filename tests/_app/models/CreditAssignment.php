<?php

namespace app\models;

class CreditAssignment extends \tecnocen\workflow\models\Assignment
{
    public static function tableName()
    {
        return '{{%credit_assignment}}';
    }
    protected function processClass()
    {
        return Credit::class;
    }
}
