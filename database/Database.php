<?php
/**
 * Database Abstraction Layer (mysqli)
 * Temporary compatibility layer for the PHP 8.2 migration.
 *
 * End-state recommendation: migrate to PDO + prepared statements everywhere.
 */
declare(strict_types=1);

final class Database
{
    private static ?self $instance = null;
    private ?mysqli $connection = null;

    private function __construct(string $host, string $user, string $password, string $database)
    {
        $this->connect($host, $user, $password, $database);
    }

    private function connect(string $host, string $user, string $password, string $database): void
    {
        mysqli_report(MYSQLI_REPORT_OFF);

        $conn = @mysqli_connect($host, $user, $password, $database);
        if (!$conn) {
            throw new RuntimeException('Erro de conexao: ' . mysqli_connect_error());
        }

        $this->connection = $conn;

        // Always use utf8mb4 (full UTF-8) for the DB connection.
        @mysqli_set_charset($this->connection, 'utf8mb4');
    }

    public static function getInstance(
        ?string $host = null,
        ?string $user = null,
        ?string $password = null,
        ?string $database = null
    ): self {
        if (self::$instance === null) {
            if ($host === null || $user === null || $password === null || $database === null) {
                throw new InvalidArgumentException('Database parameters required on first call');
            }
            self::$instance = new self($host, $user, $password, $database);
        }

        return self::$instance;
    }

    public function getConnection(): mysqli
    {
        if ($this->connection === null) {
            throw new RuntimeException('Database connection not initialized');
        }
        return $this->connection;
    }

    public function query(string $sql): mysqli_result|bool
    {
        $result = mysqli_query($this->getConnection(), $sql);
        if ($result === false) {
            error_log('SQL Error: ' . mysqli_error($this->getConnection()));
            error_log('SQL Query: ' . $sql);
        }
        return $result;
    }

    public function fetchArray(mysqli_result $result, int $mode = MYSQLI_BOTH): array|null
    {
        return mysqli_fetch_array($result, $mode) ?: null;
    }

    public function fetchAssoc(mysqli_result $result): array|null
    {
        return mysqli_fetch_assoc($result) ?: null;
    }

    public function numRows(mysqli_result $result): int
    {
        return mysqli_num_rows($result);
    }

    public function insertId(): int
    {
        return (int) mysqli_insert_id($this->getConnection());
    }

    public function error(): string
    {
        return mysqli_error($this->getConnection());
    }

    public function escape(string $string): string
    {
        return mysqli_real_escape_string($this->getConnection(), $string);
    }

    public function close(): void
    {
        if ($this->connection) {
            mysqli_close($this->connection);
            $this->connection = null;
        }
    }
}

