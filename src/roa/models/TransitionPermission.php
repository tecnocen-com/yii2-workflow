<?php

namespace tecnocen\workflow\roa\models;

use Yii;
use tecnocen\roa\behaviors\Slug;
use tecnocen\roa\hal\Embeddable;
use tecnocen\roa\hal\EmbeddableTrait;
use yii\web\Linkable;

/**
 *
 * ROA contract to handle workflow transition permissions records.
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class TransitionPermission
    extends \tecnocen\workflow\models\TransitionPermission
    implements Linkable, Embeddable
{
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
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return $this->getSlugLinks();
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['sourceStage', 'targetStage', 'transition'];
    }
}
