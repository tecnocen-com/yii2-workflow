<?php

class m170101_000002_workflow_stage extends tecnocen\workflow\migrations\BaseTable
{
    public function getTableName()
    {
        return 'tecnocen_workflow_stage';
    }

    public function columns()
    {
        return [
            'id' => $this->primaryKey(),
            'workflow_id' => $this->normalKey(),
            'name' => $this->string(64)->notNull(),
            'initial' => $this->activable(false),
        ];
    }

    public function foreignKeys()
    {
        return ['workflow_id' => ['table' => 'tecnocen_workflow']];
    }

    public function compositeUniqueKeys()
    {
        return ['workflow_id', 'name'];
    }
}
