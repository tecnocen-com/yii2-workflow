<?php

namespace tecnocen\workflow\models;

use yii\db\ActiveQuery;

/**
 * Model class for table `{{%workflow_transition}}`
 *
 * @property integer $source_stage_id
 * @property integer $target_stage_id
 * @property string $permission
 *
 * @property Transition $transition
 * @property Stage $sourceStage
 * @property Stage $targetStage
 */
class TransitionPermission extends \tecnocen\rmdb\models\Entity
{
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CREATE = 'create';

    /**
     * @var string full class name of the model to be used for the relations
     * `getSourceStage()` and `getTargetStage()`.
     */
    protected $stageClass = Stage::class;

    /**
     * @var string full class name of the model to be used for the relation
     * `getTransition()`.
     */
    protected $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow_transition_permission}}';
    }

    /**
     * @inheritdoc
     */
    protected function attributeTypecast()
    {
        return parent::attributeTypecast() + [
            'source_stage_id' => 'integer',
            'target_stage_id' => 'integer',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['!source_stage_id', '!target_stage_id', '!permission'],
                'safe',
                'on' => [self::SCENARIO_UPDATE],
            ],
            [['source_stage_id', 'target_stage_id', 'permission'], 'required'],
            [
                ['source_stage_id', 'target_stage_id'],
                'integer',
                'on' => [self::SCENARIO_CREATE],
            ],
            [
                ['permission'],
                'string',
                'min' => 6,
                'on' => [self::SCENARIO_CREATE],
            ],

            [
                ['target_stage_id'],
                'exist',
                'targetClass' => Transition::class,
                'targetAttribute' => [
                    'source_stage_id' => 'source_stage_id',
                    'target_stage_id' => 'target_stage_id',
                ],
                'skipOnError' => true,
                'when' => function () {
                    return !$this->hasErrors('source_stage_id');
                },
                'message' => 'There is no transaction between the stages.',
                'on' => [self::SCENARIO_CREATE],
            ],

            [
                ['permission'],
                'unique',
                'targetAttribute' => [
                    'source_stage_id',
                    'target_stage_id',
                    'permission',
                ],
                'message' => 'Permission already set for the transition.',
                'on' => [self::SCENARIO_CREATE],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'source_stage_id' => 'Source Stage ID',
            'target_stage_id' => 'Target Stage ID',
            'permission' => 'Permission',
        ], parent::attributeLabels());
    }

    /**
     * @return ActiveQuery
     */
    public function getSourceStage(): ActiveQuery
    {
        return $this->hasOne($this->stageClass, ['id' => 'source_stage_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTargetStage(): ActiveQuery
    {
        return $this->hasOne($this->stageClass, ['id' => 'target_stage_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransition(): ActiveQuery
    {
        return $this->hasOne(
            $this->transitionClass,
            [
                'source_stage_id' => 'source_stage_id',
                'target_stage_id' => 'target_stage_id',
            ]
        );
    }
}
