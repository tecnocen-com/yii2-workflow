<?php

namespace tecnocen\workflow\migrations;

/**
 * Base Migration for creating assignment tables for process.
 */
abstract class Assignment extends \tecnocen\rmdb\migrations\CreatePivot
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
        return $this->getProcessTableName() . $this->assignmentSuffix;
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
 
    /**
     * @inhertidoc
     */
    public function compositePrimaryKeys()
    {
        return ['process_id', 'user_id'];
    }

}
