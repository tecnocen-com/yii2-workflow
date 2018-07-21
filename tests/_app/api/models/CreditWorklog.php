<?php

namespace app\api\models;

use tecnocen\roa\behaviors\Slug;
use yii\web\Linkable;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle credit_worklog records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class CreditWorklog extends \app\models\CreditWorklog implements Linkable
{
    protected function processClass()
    {
        return Credit::class;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'workflog',
                'parentSlugRelation' => 'process'
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), [
            'creditWorklogs' => $this->getSelfLink() . '/worklog',
        ]);
    }
}
