<?php

namespace app\api\models;

use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle credit_worklog records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class CreditWorklog extends \app\models\CreditWorklog implements Contract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }
    
    /**
     * @inheritdoc
     */
    protected function processClass()
    {
        return Credit::class;
    }

    /**
     * @inheritdoc
     */
    public function slugBehaviorConfig()
    {
        return [
            'resourceName' => 'worklog',
            'parentSlugRelation' => 'process'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'creditWorklogs' => $this->getSelfLink() . '/worklog',
        ]);
    }
}
