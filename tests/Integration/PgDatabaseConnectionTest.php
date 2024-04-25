<?php

namespace Integration;

use PHPUnit\Framework\TestCase;
use RamonRibeiro\SuperWaffle\Infrastructure\Connection;

class PgDatabaseConnectionTest extends TestCase
{
    public function testConnection(): void
    {
        $connection = new Connection();

        $this->assertInstanceOf(\PDO::class, $connection->getConnection());
    }
}