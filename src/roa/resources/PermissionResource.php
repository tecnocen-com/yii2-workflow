<?php

namespace tecnocen\workflow\roa\resources;

use Yii;
use tecnocen\workflow\roa\models\TransitionPermission;

class PermissionResource extends \tecnocen\roa\controllers\OAuth2Resource
{
    public $modelClass = TransitionPermission::class;

    public $idAttribute = 'permission';

    /**
     * @return Transition
     */
    public function baseQuery()
    {
        return parent::baseQuery()->andWhere([
            'source_stage_id' => Yii::$app->request->getQueryParam('stage_id')
            'target_stage_id' => Yii::$app->request->getQueryParam('target_id')
        ]);
    }
}
