<?php

namespace tests;

use DAO\Connection;
use PHPUnit\Framework\TestCase;

class PgConnectionTest extends TestCase
{
    public function testConnection(): void
    {
        $connection = new Connection();

        $this->assertInstanceOf(\PgSql\Connection::class, $connection->getConnection());
    }
}