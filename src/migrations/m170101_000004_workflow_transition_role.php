<?php

class m170101_000004_workflow_transition_role
    extends \tecnocen\workflow\\migrations\BaseTable
{
    public function getTableName()
    {
        return 'tecnocen_workflow_transition_role';
    }

    public function columns()
    {
        return [
            'source_stage_id' => $this->normalKey(),
            'target_stage_id' => $this->normalKey(),
            'role' => $this->string()->notNull(),
        ];
    }

    public function compositePrimaryKeys()
    {
        return ['source_stage_id', 'target_stage_id', 'role'];
    }
}
