<?php

namespace tecnocen\workflow\models;

/**
 * Model class for table `{{%tecnocen_workflow}}`
 *
 * @property integer $source_stage_id
 * @property integer $target_stage_id
 * @property string $name
 *
 * @property ActiveRecord $process
 */
abstract class Worklog extends BaseActiveRecord
{
    /**
     * @return string class name for the process this worklog is attached to.
     */
    abstract function getProcessClass();

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'stage_id'], 'required'],
            [['process_id', 'stage_id'], 'integer'],
            [
                ['process_id'],
                'exist',
                'targetClass' => $this->getProcessClass(),
            ],
            [
                ['stage_id'],
                'exist',
                'targetClass' => Stage::class,
            ],
            [
                ['stage_id'],
                'exist',
                'targetClass' => Stage::class,
                'when' => function () { 
                    return !$this->hasErrors('process_id')
                        && null === $this->process->currentStage;
                },
                'filter' => function ($query) {
                    $query->andWhere(['initial' => true]);
                },
            ],
            [
                ['stage_id'],
                'exist',
                'targetClass' => Transition::class,
                'targetAttribute' => ['stage_id' => 'target_stage_id'],
                'when' => function () {
                    return !$this->hasErrors('process_id')
                        && null !== $this->process->currentStage;
                },
                'filter' => function ($query) {
                    $query->andWhere([
                        'source_stage_id' => $this->process->currentStage->id
                   ]);
                },
                'message' => 'There is no transition for the current stage'
            ],    
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'id' => 'ID',
            'name' => 'Workflow name',
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStages()
    {
        return $this->hasMany(Stage::class, ['workflow_id' => 'id'])
            ->inverseOf('workflow');
    }
}
