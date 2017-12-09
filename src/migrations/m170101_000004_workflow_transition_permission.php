<?php

class m170101_000004_workflow_transition_permission
    extends tecnocen\rmdb\migrations\CreateEntity
{
    /**
     * @inhertidoc
     */
    public function getTableName()
    {
        return 'workflow_transition_permission';
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
    public function foreignKeys()
    {
        return [
            'transition' => [
                'table' => 'workflow_transition',
                'columns' => [
                    'source_stage_id' => 'source_stage_id',
                    'target_stage_id' => 'target_stage_id',
                ]
            ],
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
