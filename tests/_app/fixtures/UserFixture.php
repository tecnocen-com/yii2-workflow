<?php

namespace app\fixtures;

use app\models\User;

class UserFixture extends \yii\test\ActiveFixture
{
    public $modelClass = User::class;
    public $dataFile = __DIR__ . '/data/user.php';
}
