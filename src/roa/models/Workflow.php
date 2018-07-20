<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Curies;
use tecnocen\roa\behaviors\Slug;
use tecnocen\roa\hal\Embeddable;
use tecnocen\roa\hal\EmbeddableTrait;
use tecnocen\workflow\models as base;
use yii\web\Linkable;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle workflow records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Workflow extends base\Workflow implements Linkable, Embeddable
{
    use EmbeddableTrait {
        EmbeddableTrait::toArray as embedArray;
    }

    /**
     * @inheritdoc
     */
    public function toArray(
        array $fields = [],
        array $expand = [],
        $recursive = true
    ) {
        return $this->embedArray(
            $fields ?: $this->attributes(),
            $expand,
            $recursive
        );
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
            'curies' => Curies::class,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), $this->getCuriesLinks(), [
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
