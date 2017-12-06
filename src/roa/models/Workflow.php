<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Slug;
use yii\web\Linkable;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle workflow records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Workflow extends \tecnocen\workflow\models\Workflow
    implements Linkable
{
    /**
     * @inheritdoc
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'workflow',
                'checkAccess' => function ($params) {
                    if (isset($params['workflow_id'])
                        && $this->id != $params['workflow_id']
                    ) {
                        throw new NotFoundHttpException(
                            'Workflow not associated to element.'
                        );
                    }
                },
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), [
            'stages' => $this->getSelfLink() . '/stage',
        ]);
    }
}
