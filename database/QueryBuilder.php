<?php
/**
 * Query Builder with Prepared Statements (mysqli)
 * Transitional helper for the PHP 8.2 migration.
 */
declare(strict_types=1);

final class QueryBuilder
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function insert(string $table, array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $fields = implode(', ', array_map([$this, 'quoteIdent'], array_keys($data)));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->quoteIdent($table)} ({$fields}) VALUES ({$placeholders})";
        $stmt = mysqli_prepare($this->connection, $sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . mysqli_error($this->connection));
            return false;
        }

        $values = array_values($data);
        $types = $this->getBindTypes($values);
        mysqli_stmt_bind_param($stmt, $types, ...$values);

        $ok = mysqli_stmt_execute($stmt);
        if (!$ok) {
            error_log('Execute failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $ok;
    }

    public function update(string $table, array $data, string $where, array $whereParams): bool
    {
        if (empty($data)) {
            return false;
        }

        $sets = [];
        foreach (array_keys($data) as $field) {
            $sets[] = $this->quoteIdent((string)$field) . ' = ?';
        }
        $setClause = implode(', ', $sets);

        $sql = "UPDATE {$this->quoteIdent($table)} SET {$setClause} WHERE {$where}";
        $stmt = mysqli_prepare($this->connection, $sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . mysqli_error($this->connection));
            return false;
        }

        $values = array_merge(array_values($data), array_values($whereParams));
        $types = $this->getBindTypes($values);
        mysqli_stmt_bind_param($stmt, $types, ...$values);

        $ok = mysqli_stmt_execute($stmt);
        if (!$ok) {
            error_log('Execute failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $ok;
    }

    public function delete(string $table, string $where, array $whereParams): bool
    {
        $sql = "DELETE FROM {$this->quoteIdent($table)} WHERE {$where}";
        $stmt = mysqli_prepare($this->connection, $sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . mysqli_error($this->connection));
            return false;
        }

        $values = array_values($whereParams);
        $types = $this->getBindTypes($values);
        mysqli_stmt_bind_param($stmt, $types, ...$values);

        $ok = mysqli_stmt_execute($stmt);
        if (!$ok) {
            error_log('Execute failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $ok;
    }

    public function select(string $sql, array $params = []): ?mysqli_result
    {
        if (empty($params)) {
            $res = mysqli_query($this->connection, $sql);
            if ($res === false) {
                error_log('SQL Error: ' . mysqli_error($this->connection));
                error_log('SQL Query: ' . $sql);
                return null;
            }
            return $res;
        }

        $stmt = mysqli_prepare($this->connection, $sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . mysqli_error($this->connection));
            return null;
        }

        $values = array_values($params);
        $types = $this->getBindTypes($values);
        mysqli_stmt_bind_param($stmt, $types, ...$values);

        if (!mysqli_stmt_execute($stmt)) {
            error_log('Execute failed: ' . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            return null;
        }

        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result ?: null;
    }

    public function getLastInsertId(): int
    {
        return (int) mysqli_insert_id($this->connection);
    }

    private function getBindTypes(array $values): string
    {
        $types = '';
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } elseif (is_null($value)) {
                // mysqli doesn't have a distinct "null" type; bind as string.
                $types .= 's';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }

    private function quoteIdent(string $ident): string
    {
        // Minimal identifier quoting to prevent obvious injection into table/field names.
        $safe = preg_replace('/[^a-zA-Z0-9_]/', '', $ident) ?? '';
        return '`' . $safe . '`';
    }
}

