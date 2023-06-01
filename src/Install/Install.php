<?php
namespace Pyncer\Snyppet\Log\Install;

use Pyncer\Database\Value;
use Pyncer\Snyppet\AbstractInstall;

class Install extends AbstractInstall
{
    protected function safeInstall(): bool
    {
        $this->connection->createTable('log')
            ->serial('id')
            ->string('level', 25)->index()
            ->text('message')
            ->text('context')
            ->dateTime('insert_date_time')->default(Value::NOW)->index()
            ->execute();

        return true;
    }

    protected function safeUninstall(): bool
    {
        if ($this->connection->hasTable('log')) {
            $this->connection->dropTable('log');
        }

        return true;
    }
}
