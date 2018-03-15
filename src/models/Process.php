<?php

namespace tecnocen\workflow\models;

use tecnocen\rmdb\models\Entity;
use yii\base\InvalidConfigException;

/**
 * Model class for process which change stages depending on a worklow
 *
 * @property int workflowId
 * @property WorkLog[] $workLogs
 * @property WorkLog $activeWorkLog
 */
abstract class Process extends Entity
{
    /**
     * @return string full class name of the class to be used to store the
     * assignment records.
     */
    protected abstract function assignmentClass();

    /**
     * @return string full class name of the class to be used to store the
     * worklog records.
     */
    protected abstract function workLogClass();

    /**
     * @return int the id of the workflow this process belongs to.
     */
    public abstract function getWorkflowId();

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['initial_stage_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
    	    'required_initial' => [
                ['initial_stage_id'],
                'required',
                'when' => function () {
    	            return $this->getIsNewRecord();
    	        },
            ],
            'integer_initial' => [['initial_stage_id'], 'integer'],
            'exist_initial' => [
                ['initial_stage_id'],
                'exist',
                'targetClass' => Stage::class,
                'targetAttribute' => ['initial_stage_id' => 'id'],
                'skipOnError' => true,
                'filter' => function ($query) {
                    $query->andWhere([
                        'initial' => true,
                        'workflow_id' => $this->getWorkflowId(),
                    ]);
                },
            ],
        ];
    }

    /**
     * Whether the user is asigned to the process.
     *
     * @param int $userId [description]
     * @return boolean
     */
    public function userAssigned($userId)
    {
        return !$this->getAssignments()->exists() || $this->getAssignments()
            ->andWhere(['user_id' => $userId]);
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT,
        ];
    }

    /**
     * @inheritdoc
     */
    public function updateInternal($attributes = null)
    {
        return parent::updateInternal($attributes ?: parent::attributes());
    }

    /**
     * @inheritdoc
     */
    public function insertInternal($attributes = null)
    {
        return parent::insertInternal($attributes ?: parent::attributes());
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $initialLog = ['stage_id' => $this->initial_stage_id];
            $this->initialLog($initialLog, false);
        }
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
        if (!is_subclass_of($this->assignmentClass(), Assignment::class)) {
            throw new InvalidConfigException(
                static::class . '::assignmentClass() must extend '
                    . Assignment::class
            );
        }
        parent::init();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany($this->assignmentClass(), [
            'process_id' => 'id',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkLogs()
    {
        return $this->hasMany($this->workLogClass(), [
            'process_id' => 'id',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @see https://dev.mysql.com/doc/refman/5.7/en/example-maximum-column-group-row.html
     */
    public function getActiveWorkLog()
    {
        $query = $this->getWorkLogs()->alias('worklog');
        $query->multiple = false;
        $workLogClass = $this->workLogClass();

        return $query->andWhere([
            'id' => $workLogClass::find()
                ->select(['MAX(id)'])
                ->alias('worklog_groupwise')
                ->andWhere('worklog.process_id = worklog_groupwise.process_id')
        ]);
    }

    /**
     * Adds record to the worklog effectively transitioning the stage of the
     * process.
     *
     * @param array|WorkLog the worklog the process will transit to or an array
     * to create said worklog.
     * @param bool $runValidation
     */
    public function flow(&$workLog, $runValidation = true)
    {
        $workLog = $this->ensureWorkLog($workLog);
        $workLog->scenario = WorkLog::SCENARIO_FLOW;

        return $workLog->save($runValidation);
    }

    /**
     * Saves the initial log record of the process
     *
     * @param array|WorkLog the worklog the process will use as the first log.\
     * @param bool $runValidation
     */
    public function initialLog(&$workLog, $runValidations = true)
    {
        $workLog = $this->ensureWorkLog($workLog);
        $workLog->scenario = WorkLog::SCENARIO_INITIAL;

        return $workLog->save($runValidations);
    }

    private function ensureWorkLog($workLog)
    {
        $workLogClass = $this->workLogClass();
        if (is_array($workLog)) {
            $workLog = new $workLogClass($workLog);
        } elseif (!$workLog instanceof $workLogClass) {
            throw new InvalidParamException(
                "Parameter must be an instance of {$workLogClass} or an "
                    . 'array to configure an instance'
            );
        }

        $workLog->process_id = $this->id;
        $workLog->populateRelation('process', $this);

        return $workLog;
    }
}
