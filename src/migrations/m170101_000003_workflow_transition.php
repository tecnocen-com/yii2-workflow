<?php

class m170101_000003_workflow_transition extends tecnocen\workflow\migrations\BaseTable
{
    public function getTableName()
    {
        return 'tecnocen_workflow_transition';
    }

    public function columns()
    {
        return [
            'source_stage_id' => $this->normalKey(),
            'target_stage_id' => $this->normalKey(),
            'name' => $this->string(64)->notNull(),
        ];
    }

    public function foreignKeys()
    {
        return [
            'source_stage_id' => ['table' => 'tecnocen_workflow_stage'],
            'target_stage_id' => ['table' => 'tecnocen_workflow_stage'],
        ];
    }

    public function compositePrimaryKeys()
    {
        return ['source_stage_id', 'target_stage_id'];
    }

    public function compositeUniqueKeys()
    {
        return [['source_stage_id', 'name']];
    }

}
