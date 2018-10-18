<?php

namespace app\api\models;

use tecnocen\roa\hal\Contract;
use tecnocen\roa\hal\ContractTrait;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle credit records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Credit extends \app\models\Credit implements Contract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }

    protected function assignmentClass()
    {
        return CreditAssignment::class;
    }

    protected function workLogClass()
    {
        return CreditWorklog::class;
    }

    /**
     * @inheritdoc
     */
    public function slugBehaviorConfig()
    {
        return [
            'resourceName' => 'credit',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'worklog' => $this->getSelfLink() . '/worklog',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'workLogs',
            'activeWorkLog',
        ];
    }
}
