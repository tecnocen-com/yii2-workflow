<?php

namespace tecnocen\workflow\migrations;

/**
 * Base Migration for creating worklog tables for process.
 *
 *
 */
class WorkLog extends BaseMigration
{
    /**
     * @var string suffix attached at the end of the process table.
     */
    public $worklogSuffix = '_worklog';

    /**
     * @return string name of the table to which the worklog will be attached.
     */
    abstract public function getProcessTableName();

    /**
     * @inhertidoc
     */
    public function getTableName()
    {
        return $this->getProcessTableName() . $this->worklogSuffix;
    }

    /**
     * @inhertidoc
     */
    public function columns()
    {
        return [
            'id' => $this->primaryKey(),
            'process_id' => $this->normalKey(),
            'stage_id' => $this->normalKey(),
            'commentary' => $this->text(),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys()
    {
        return [
            'stage_id' => ['table' => 'tecnocen_workflow_stage']
            'process_id' => ['table' => $this->getProcessTableName()];
        ];
    }
}
