<?php

namespace DAO;

class Connection
{
    private \PgSql\Connection $connection;
    private string $host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;

    public function __construct(
        $host = 'db',
        $port = 5432,
        $database = 'db_waffle',
        $username = 'user_waffle',
        $password = 'password_waffle'
    )
    {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    public function getConnection(): \PgSql\Connection
    {
        return $this->connection;
    }

    public function connect(): void
    {
        $this->connection = pg_connect("host={$this->host} port={$this->port} dbname={$this->database} user={$this->username} password={$this->password}");
    }

    public function close(): void
    {
        pg_close($this->connection);
    }
}