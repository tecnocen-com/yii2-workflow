<?php

namespace tecnocen\workflow\roa\resources;

use Yii;
use tecnocen\workflow\roa\models\Transition;

class TransitionResource extends \tecnocen\roa\controllers\OAuth2Resource
{
    public $modelClass = Transition::class;

    public $idAttribute = 'target_source_id';

    /**
     * @return Transition
     */
    public function baseQuery()
    {
        return parent::baseQuery()->andWhere([
            'source_stage_id' => Yii::$app->request->getQueryParam('stage_id')
        ]);
    }
}
