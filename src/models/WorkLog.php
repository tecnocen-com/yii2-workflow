<?php

namespace tecnocen\workflow\models;

use tecnocen\rmdb\models\Pivot;

/**
 * @property int $id
 * @property int $process_id
 * @property int $stage_id
 *
 * @property Process $process
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
            [['process_id', 'stage_id'], 'required'],
            [['process_id', 'stage_id'], 'integer'],
            [
                ['process_id'],
                'exist',
                'targetAttribute' => ['process_id' => 'id'],
                'targetClass' => $this->processClass(),
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
		        'message' => 'Not an initial stage for the workflow.'
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
                        && null !== $this->process->activeWorkLog;
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
            'process_id' => 'Process ID',
            'stage_id' => 'Stage ID',
        ], parent::attributeLabels());
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!is_subclass_of($this->workLogClass(), WorkLog::class)) {
            throw new InvalidConfigException(
                static::class . '::workLogClass() must extend '
                    . WorkLog::class
            );
        }
        parent::init();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcess()
    {
        return $this->hasOne($this->processClass(), ['id' => 'process_id']);
    }
}
