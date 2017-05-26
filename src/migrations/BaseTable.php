<?php

namespace tecnocen\workflow\migrations;

class BaseTable extends \tecnocen\migrate\CreateTableMigration
{
    public function defaultColumns()
    {
        return [
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->normalKey(),
        ];
    }
}
