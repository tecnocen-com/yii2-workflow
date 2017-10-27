<?php

class m170101_000001_workflow extends tecnocen\rmdb\migrations\CreateEntity
{
    /**
     * @inhertidoc
     */
    public function getTableName()
    {
        return 'tecnocen_workflow';
    }

    /**
     * @inhertidoc
     */
    public function columns()
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->unique()->notNull(),
        ];
    }
}
