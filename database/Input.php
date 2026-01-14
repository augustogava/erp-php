<?php
/**
 * Input validation + sanitization helper.
 *
 * NOTE: This is a transitional helper. It reduces risk while we remove legacy
 * "auto-register" behavior. End-state should use explicit validation per field.
 */
declare(strict_types=1);

final class Input
{
    private static ?mysqli $db = null;

    public static function setDatabase(mysqli $connection): void
    {
        self::$db = $connection;
    }

    /**
     * Prefer POST over GET when using request(), matching typical legacy behavior.
     */
    public static function request(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $_POST)) {
            return self::sanitize($_POST[$key]);
        }
        if (array_key_exists($key, $_GET)) {
            return self::sanitize($_GET[$key]);
        }
        return $default;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (!array_key_exists($key, $_GET)) {
            return $default;
        }
        return self::sanitize($_GET[$key]);
    }

    public static function post(string $key, mixed $default = null): mixed
    {
        if (!array_key_exists($key, $_POST)) {
            return $default;
        }
        return self::sanitize($_POST[$key]);
    }

    public static function int(string $key, int $default = 0): int
    {
        $v = self::request($key, null);
        if ($v === null) {
            return $default;
        }
        return (int) filter_var($v, FILTER_VALIDATE_INT, ['options' => ['default' => $default]]);
    }

    public static function string(string $key, string $default = ''): string
    {
        $v = self::request($key, null);
        if ($v === null) {
            return $default;
        }
        return is_string($v) ? trim($v) : $default;
    }

    private static function sanitize(mixed $value): mixed
    {
        if (is_array($value)) {
            $out = [];
            foreach ($value as $k => $v) {
                $out[$k] = self::sanitize($v);
            }
            return $out;
        }

        if (!is_string($value)) {
            return $value;
        }

        // Keep it simple: normalize + optionally escape for SQL legacy usage.
        $value = trim($value);

        if (self::$db !== null) {
            $value = mysqli_real_escape_string(self::$db, $value);
        }

        return $value;
    }
}

