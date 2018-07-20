<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Curies;
use tecnocen\roa\behaviors\Slug;
use tecnocen\roa\hal\Embeddable;
use tecnocen\roa\hal\EmbeddableTrait;
use tecnocen\workflow\models as base;
use yii\web\Linkable;

/**
 *
 * ROA contract to handle workflow transition permissions records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class TransitionPermission extends base\TransitionPermission implements
    Linkable,
    Embeddable
{
    use EmbeddableTrait;

    /**
     * @inheritdoc
     */
    protected $stageClass = Stage::class;

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
                'idAttribute' => 'permission',
                'resourceName' => 'permission',
                'parentSlugRelation' => 'transition',
            ],
            'curies' => Curies::class,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), $this->getCuriesLinks());
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['sourceStage', 'targetStage', 'transition'];
    }
}
