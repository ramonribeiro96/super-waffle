<?php

namespace RamonRibeiro\SuperWaffle\Infrastructure;

class Connection
{
    private \PDO $connection;

    public function __construct(
        private string $host,
        private int    $port,
        private string $database,
        private string $username,
        private string $password,
    )
    {
        $this->connect();
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    public function connect(): void
    {
        try {
            $this->connection = new \PDO("pgsql:dbname={$this->database};host={$this->host};port=$this->port", $this->username, $this->password);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

//    public function close(): void
//    {
//        pg_close($this->connection);
//    }
}