<?php

class m171130_000002_credit extends \tecnocen\migrate\CreateTableMigration
{
    public function getTableName()
    {
        return 'credit';
    }

    public function columns()
    {
        return [
            'id' => $this->primaryKey(),
            'workflow_id' => $this->normalKey(),
        ];
    }

    public function foreignKeys()
    {
        return [
            'workflow_id' => ['table' => 'tecnocen_workflow']
        ];
    }
}
