<?php

class m130101_000001_user extends \tecnocen\migrate\CreateTableMigration
{
    public function getTableName()
    {
        return 'user';
    }

    public function columns()
    {
        return [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
        ];
    }
}
