<?php

namespace tecnocen\workflow\models;

use tecnocen\rmdb\models\Entity;
use yii\base\InvalidConfigException;

/**
 * Model class for process which change stages depending on a worklow
 */
abstract class Process extends Entity
{
    protected abstract function workLogClass();

    public abstract function getWorkflowId();

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

    public function getWorkLogs()
    {
        return $this->hasMany($this->workLogClass(), [
            'process_id' => 'id',
        ]);
    }

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

    public function flow(&$workLog)
    {
        $workLog = $this->ensureWorkLog($workLog);
        $workLog->scenario = WorkLog::SCENARIO_FLOW;

        return $workLog->save();
    }

    public function initialLog(&$workLog)
    {
        $workLog = $this->ensureWorkLog($workLog);
        $workLog->scenario = WorkLog::SCENARIO_INITIAL;

        return $workLog->save();
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
        $workLog->setRelation('process', $this);

        return $workLog;
    }
}
