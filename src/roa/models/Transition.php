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
    public function setStage_id($id) {
        $this->source_stage_id = $id;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            [
                [['stage_id'], 'safe'],
                [['source_stage_id'], 'default', 'value' => function () {
                    return Yii::$app->request->getQueryParam('stage_id');
                }],
            ],
            parent::rules()
        );
    }

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
}
