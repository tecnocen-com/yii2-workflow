<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Slug;
use yii\web\Linkable;

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
            ]
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
