<?php

namespace tecnocen\workflow\models;

/**
 * Model class for table `{{%tecnocen_workflow_transition}}`
 *
 * @property integer $source_stage_id
 * @property integer $target_stage_id
 * @property string $name
 *
 * @property Stage $sourceStage
 * @property Stage $targetStage
 * @property TransitionPermission[] $permissions
 */
class Transition extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tecnocen_workflow_transition}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_stage_id', 'target_stage_id', 'name'], 'required'],
            [['source_stage_id', 'target_stage_id'], 'integer'],
            [
                ['source_stage_id', 'target_stage_id'],
                'exist',
                'targetClass' => Stage::class,
                'skipOnError' => true,
            ],

            [
                ['target_stage_id'],
                'unique',
                'targetAttribute' => ['source_stage_id', 'target_stage_id'],
                'message' => 'Target already in use for the source stage.'
            ],
            [
                ['name'],
                'unique',
                'targetAttribute' => ['source_stage_id', 'name'],
                'message' => 'Name already used for the source stage.'
            ],

            [['name'], 'string', 'min' => 8],
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
            'name' => 'Transition Name',
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceStage()
    {
        return $this->hasOne(Stage::class, ['id' => 'source_stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetStage()
    {
        return $this->hasOne(Stage::class, ['id' => 'target_stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasOne(TransitionPermission::class, [
            'source_stage_id' => 'source_stage_id',
            'target_stage_id' => 'target_stage_id',
        ])->inverseOf('transition');
    }
}
