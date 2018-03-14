<?php

namespace tecnocen\workflow\migrations;

/**
 * Base Migration for creating assignment tables for process.
 */
abstract class Assigment extends \tecnocen\rmdb\migrations\CreatePivot
{
    /**
     * @var string suffix attached at the end of the process table.
     */
    public $assignmentSuffix = '_assignment';

    /**
     * @return string name of the table to which the assignment will be attached.
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
            'process_id' => $this->normalKey(),
            'user_id' => $this->normalKey(),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys()
    {
        return [
           'process_id' => $this->getProcessTableName(),
        ];
    }
}
