<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Slug;
use yii\web\Linkable;

/**
 * ROA contract to handle workflow stage records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Stage extends \tecnocen\workflow\models\Stage
    implements Linkable
{
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
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['transitions'];
    }
}
