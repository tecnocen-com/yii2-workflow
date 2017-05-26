<?php

class m170101_000001_workflow extends tecnocen\workflow\migrations\BaseTable
{
    public function getTableName()
    {
        return 'tecnocen_workflow';
    }

    public function columns()
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->unique()->notNull(),
        ];
    }
}
