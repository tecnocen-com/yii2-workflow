<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Slug;
use tecnocen\roa\hal\Embeddable;
use tecnocen\roa\hal\EmbeddableTrait;
use yii\web\Link;
use yii\web\Linkable;

/**
 * ROA contract to handle workflow stage records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Stage extends \tecnocen\workflow\models\Stage
    implements Linkable, Embeddable
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
        return array_merge($this->attributes(), ['totalTransitions']);
    }
    /**
     * @inheritdoc
     */
    protected $workflowClass = Workflow::class;

    /**
     * @inheritdoc
     */
    protected $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'stage',
                'parentSlugRelation' => 'workflow',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), [
            'transitions' => $this->getSelfLink() . '/transition',
            'curies' => [
                new Link([
                    'name' => 'nestable',
                    'href' => $this->getSelfLink() . '?expand={rel}',
                    'title' => 'Embeddable and Nestable related resources.',
                ]),
                new Link([
                    'name' => 'embeddable',
                    'href' => $this->getSelfLink() . '?expand={rel}',
                    'title' => 'Embeddable and not Nestable related resources.',
                ]),
            ],
            'nestable:workflow' => 'workflow',
            'embeddable:detailTransitions' => 'detailTransitions',
            'embeddable:totalTransitions' => 'totalTransitions',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'workflow',
            'detailTransitions',
            'totalTransitions',
        ];
    }
}
