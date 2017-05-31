<?php

namespace tecnocen\workflow\roa\resources;

use Yii;
use tecnocen\workflow\roa\models\Transition;

/**
 * Resource to handle transition records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class TransitionResource extends \tecnocen\roa\controllers\OAuth2Resource
{
    /**
     * @inhertidoc
     */
    public $modelClass = Transition::class;

    /**
     * @inheritdoc
     */
    public $idAttribute = 'target_stage_id';

    /**
     * @inheritdoc
     */
    public $createScenario = Transition::SCENARIO_CREATE;

    /**
     * @inheritdoc
     */
    public $updateScenario = Transition::SCENARIO_UPDATE;

    /**
     * @inheritdoc
     */
    public function baseQuery()
    {
        return parent::baseQuery()->andWhere([
            'source_stage_id' => Yii::$app->request
                ->getQueryParam('source_stage_id')
        ]);
    }
}
