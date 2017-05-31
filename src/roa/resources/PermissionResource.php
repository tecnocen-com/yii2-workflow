<?php

namespace tecnocen\workflow\roa\resources;

use Yii;
use tecnocen\workflow\roa\models\TransitionPermission;

/**
 * Resource to assign permissions to a transition.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class PermissionResource extends \tecnocen\roa\controllers\OAuth2Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    public $idAttribute = 'permission';

    /**
     * @inheritdoc
     */
    public $createScenario = TransitionPermission::SCENARIO_CREATE;

    /**
     * @inheritdoc
     */
    public $updateScenario = TransitionPermission::SCENARIO_UPDATE;

    /**
     * @return Transition
     */
    public function baseQuery()
    {
        $req = Yii::$app->getRequest();
        return parent::baseQuery()->andWhere([
            'source_stage_id' => $req->getQueryParam('source_stage_id'),
            'target_stage_id' => $req->getQueryParam('target_stage_id'),
        ]);
    }
}
