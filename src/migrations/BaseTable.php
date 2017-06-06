<?php

namespace tecnocen\workflow\migrations;

abstract class BaseTable extends \tecnocen\migrate\CreateTableMigration
{
    /**
     * @inhertidoc
     */
    public function defaultColumns()
    {
        return [
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->normalKey(),
            'deleted_at' => $this->datetime()->null(),
            'deleted_by' => $this->normalKey()->null()            
        ];
    }
}
