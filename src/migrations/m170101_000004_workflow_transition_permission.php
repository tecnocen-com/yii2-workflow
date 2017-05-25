<?php

class m170101_000004_workflow_transition_permission
    extends \tecnocen\workflow\\migrations\BaseTable
{
    /**
     * @inhertidoc
     */
    public function getTableName()
    {
        return 'tecnocen_workflow_transition_permission';
    }

    /**
     * @inhertidoc
     */
    public function columns()
    {
        return [
            'source_stage_id' => $this->normalKey(),
            'target_stage_id' => $this->normalKey(),
            'permission' => $this->string()->notNull(),
        ];
    }

    /**
     * @inhertidoc
     */
    public function compositePrimaryKeys()
    {
        return ['source_stage_id', 'target_stage_id', 'permission'];
    }
}
