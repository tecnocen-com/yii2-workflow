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
class CreditAssignment extends \app\models\CreditAssignment implements Contract
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
    protected function slugBehaviorConfig()
    {
        return [
            'resourceName' => 'assignment',
            'parentSlugRelation' => 'process',
            'idAttribute' => 'user_id'
        ];
    }
    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return $this->getSlugLinks();
    }
}
