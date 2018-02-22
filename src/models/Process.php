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
     * @var WorkLog model used internally to create the initial worklog
     */
    private $initialWorklog;

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
    public function load($data, $formName = null)
    {
        if ($this->isNewRecord) {
            $this->ensureInitialWorklog();
            $logLoad = $this->initialWorklog->load($data, $formName);

            return parent::load($data, $formName) || $logLoad;
        }

        return parent::load($data, $formName);
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
    public function validate($attributeNames = null, $clearErrors = true)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->initialWorklog->save();
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
        parent::init();
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
            'created_at' => $workLogClass::find()
                ->select(['MAX(created_at)'])
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
