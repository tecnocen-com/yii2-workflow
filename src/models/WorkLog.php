<?php

namespace tecnocen\workflow\models;

use tecnocen\rmdb\models\Pivot;

/**
 * @property integer $process_id
 * @property integer $stage_id
 * @property string $name
 *
 * @property ActiveRecord $process
 */
abstract class WorkLog extends Pivot
{
    const SCENARIO_INITIAL = 'initial';
    const SCENARIO_FLOW = 'flow';

    /**
     * @return string class name for the process this worklog is attached to.
     */
    protected abstract function processClass();

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id'], 'required', 'on' => [self::SCENARIO_DEFAULT]],
            [['process_id'], 'integer', 'on' => [self::SCENARIO_DEFAULT]],
            [['stage_id'], 'required'],
            [['stage_id'], 'integer'],
            [
                ['process_id'],
                'exist',
                'targetAttribute' => ['process_id' => 'id'],
                'targetClass' => $this->processClass(),
                'on' => [self::SCENARIO_DEFAULT],
            ],
            [
                ['stage_id'],
                'exist',
                'targetAttribute' => ['stage_id' => 'id'],
                'targetClass' => Stage::class,
                'filter' => function ($query) {
                    $query->andWhere(['initial' => true]);
                },
                'on' => [self::SCENARIO_INITIAL],
            ],
            [
                ['stage_id'],
                'exist',
                'targetAttribute' => ['stage_id' => 'target_stage_id'],
                'targetClass' => Transition::class,
                'filter' => function ($query) {
                    $query->andWhere([
                        'source_stage_id' => $this->process->activeWorkLog
                            ->stage_id
                    ]);
                },
                'when' => function () {
                    return !$this->hasErrors('process_id')
                        && null === $this->process->currentStage;
                },
                'on' => [self::SCENARIO_FLOW],
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
    public function getProcess()
    {
        return $this->hasOne($this->processClass(), ['id' => 'process_id']);
    }
}
