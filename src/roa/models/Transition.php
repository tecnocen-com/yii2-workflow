<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Slug;
use tecnocen\roa\hal\Embeddable;
use tecnocen\roa\hal\EmbeddableTrait;
use yii\web\Link;
use yii\web\Linkable;

/**
 * ROA contract to handle workflow transitions records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Transition extends \tecnocen\workflow\models\Transition
    implements Linkable, Embeddable
{
    use EmbeddableTrait;

    /**
     * @inheritdoc
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    protected $permissionClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'transition',
                'parentSlugRelation' => 'sourceStage',
                'idAttribute' => 'target_stage_id',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), [
            'permissions' => $this->getSelfLink() . '/permission',
            'target_stage' => $this->targetStage->getSelfLink(),
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
            'nestable:sourceStage' => 'sourceStage',
            'nestable:targetStage' => 'targetStage',
            'embeddable:permissions' => 'permissions',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['sourceStage', 'targetStage', 'permissions'];
    }
}
