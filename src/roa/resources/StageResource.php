<?php

namespace tecnocen\workflow\roa\resources;

use Yii;
use tecnocen\workflow\roa\models\Stage;

class StageResource extends \tecnocen\roa\controllers\OAuth2Resource
{
    public $modelClass = Stage::class;

    public function baseQuery()
    {
        return parent::baseQuery()->andWhere([
            'workflow_id' => Yii::$app->request->getQueryParam('workflow_id'),
        ]);
    }
}
