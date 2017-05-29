<?php

namespace tecnocen\workflow\models;

/**
 * Model class for table `{{%tecnocen_workflow_transition}}`
 *
 * @property integer $source_stage_id
 * @property integer $target_stage_id
 * @property string $permission
 *
 * @property Transition $transition
 * @property Stage $sourceStage
 * @property Stage $targetStage
 */
class TransitionPermission extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tecnocen_workflow_transition_permission}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_stage_id', 'target_stage_id', 'permission'], 'required'],
            [['source_stage_id', 'target_stage_id'], 'integer'],
            [['permission'], 'string', 'min' => 8],

            [
                ['source_stage_id', 'target_stage_id'],
                'exist',
                'targetClass' => Transition::class,
                'targetAttribute' => ['source_stage_id', 'target_stage_id'],
                'skipOnError' => true,
                'message' => 'There is no transaction between the stages.',
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
     * @return \yii\db\ActiveQuery
     */
    public function getSourceStage()
    {
        return $this->hasOne(
            $this->getNamespace(). '\\Stage',
            ['id' => 'source_stage_id']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetStage()
    {
        return $this->hasOne(
            $this->getNamespace(). '\\Stage',
            ['id' => 'target_stage_id']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransition()
    {
        return $this->hasOne(
            $this->getNamespace(). '\\Transition',
            [
                'source_stage_id' => 'source_stage_id',
                'target_stage_id' => 'target_stage_id',
            ]
        );
    }
}
