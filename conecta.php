<?php
/**
 * Core bootstrap: DB connection + input handling (PHP 8.2 migration)
 *
 * IMPORTANT:
 * - This file now initializes mysqli via `database/Database.php`
 * - For legacy compatibility, it also wires the mysqli link into the existing
 *   `mysql_compat.php` global connection so old `mysql_*` calls still work.
 * - Auto-registering variables from $_REQUEST was removed (security). Use
 *   `Input::request()` or `getRequestVar()` instead.
 */
declare(strict_types=1);

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

require_once(__DIR__ . '/mysql_compat.php'); // keeps legacy mysql_* + ereg/split shims available
require_once(__DIR__ . '/database/Database.php');
require_once(__DIR__ . '/database/Input.php');
require_once(__DIR__ . '/configuracoes.php');

ini_set('default_charset', 'UTF-8');
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

try {
    $db = Database::getInstance($host, $user, $pwd, $bd);
    $cnx = $db->getConnection();

    // Provide DB connection to Input helper (transitional)
    Input::setDatabase($cnx);

    // Legacy: ensure mysql_compat.php wrappers use the same mysqli link.
    $GLOBALS['__mysql_compat_link'] = $cnx;
} catch (Throwable $e) {
    error_log('Database initialization error: ' . $e->getMessage());
    die('Erro de conexao com o banco de dados. Contate o administrador do sistema.');
}

// Secure-ish session defaults (adjust cookie_secure to 1 when HTTPS is enforced)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_secure', '0');
    session_start();
}

/**
 * Transitional helper (explicit access to request variables).
 * Prefer: Input::request('campo', 'default')
 */
function getRequestVar(string $name, mixed $default = null): mixed
{
    return Input::request($name, $default);
}

?>