<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Slug;
use tecnocen\roa\hal\Embeddable;
use tecnocen\roa\hal\EmbeddableTrait;
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
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['permissions'];
    }
}
