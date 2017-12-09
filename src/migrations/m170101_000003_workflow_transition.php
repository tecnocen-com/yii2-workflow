<?php

class m170101_000003_workflow_transition extends tecnocen\rmdb\migrations\CreateEntity
{
    /**
     * @inhertidoc
     */
    public function getTableName()
    {
        return 'workflow_transition';
    }

    /**
     * @inhertidoc
     */
    public function columns()
    {
        return [
            'source_stage_id' => $this->normalKey(),
            'target_stage_id' => $this->normalKey(),
            'name' => $this->string(64)->notNull(),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys()
    {
        return [
            'source_stage_id' => 'workflow_stage',
            'target_stage_id' => 'workflow_stage',
        ];
    }

    /**
     * @inhertidoc
     */
    public function compositePrimaryKeys()
    {
        return ['source_stage_id', 'target_stage_id'];
    }

    /**
     * @inhertidoc
     */
    public function compositeUniqueKeys()
    {
        return [['source_stage_id', 'name']];
    }
}
