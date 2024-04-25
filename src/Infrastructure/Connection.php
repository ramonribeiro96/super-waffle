<?php

namespace RamonRibeiro\SuperWaffle\Infrastructure;

class Connection
{
    private \PDO $connection;
    private string $host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->database = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];

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
}