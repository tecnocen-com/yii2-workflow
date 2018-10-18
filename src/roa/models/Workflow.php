<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;
use tecnocen\workflow\models as base;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle workflow records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Workflow extends base\Workflow implements Contract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge($this->attributes(), ['totalStages']);
    }

    /**
     * @inheritdoc
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    public function slugBehaviorConfig()
    {
        return [
            'resourceName' => 'workflow',
            'checkAccess' => function ($params) {
                if (isset($params['workflow_id'])
                    && $this->id != $params['workflow_id']
                ) {
                    throw new NotFoundHttpException(
                       'Workflow not associated to element.'
                    );
                }
            }
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'stages' => $this->getSelfLink() . '/stage',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['stages', 'detailStages', 'totalStages'];
    }
}
