<?php

namespace tecnocen\workflow\roa\models;

use Yii;
use tecnocen\roa\behaviors\Slug;
use yii\web\Linkable;

/**
 * ROA contract to handle workflow transitions records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Transition extends \tecnocen\workflow\models\Transition
    implements Linkable
{
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
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), [
            'permissions' => $this->getSelfLink() . '/permission'
            'target_stage' => $this->targetStage->getSelfLink();
        ]);
    }
}
