<?php

namespace tecnocen\workflow\roa\resources;

use Yii;
use tecnocen\workflow\roa\models\Stage;

/**
 * Resource to 
 */
class StageResource extends \tecnocen\roa\controllers\OAuth2Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = Stage::class;

    /**
     * @inheritdoc
     */
    public function baseQuery()
    {
        return parent::baseQuery()->andWhere([
            'workflow_id' => Yii::$app->request->getQueryParam('workflow_id'),
        ]);
    }
}
