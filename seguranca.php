<?php
/**
 * Security bootstrap (PHP 8.2 migration)
 *
 * Preserves current session keys (`login_nome`, `login_nivel`, `login_menus`)
 * while adding timeout + CSRF token utilities.
 */
declare(strict_types=1);

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session timeout (30 minutes)
$timeout = 1800;
if (isset($_SESSION['last_activity']) && (time() - (int)$_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    $_SESSION = [];
    header('Location: login_page.php?timeout=1');
    exit;
}
$_SESSION['last_activity'] = time();

// Authentication check (legacy keys)
if (
    !isset($_SESSION['login_nome']) || $_SESSION['login_nome'] === '' ||
    !isset($_SESSION['login_nivel']) || $_SESSION['login_nivel'] === ''
) {
    $_SESSION['lerro'] = 'Acesso Restrito';
    header('Location: login_page.php');
    exit;
}

// Optional menu whitelist check (legacy behavior kept as a no-op if not allowed)
if (isset($_SESSION['login_menus']) && is_array($_SESSION['login_menus'])) {
    $wndp = explode('/', (string)($_SERVER['PHP_SELF'] ?? ''));
    $wndp2 = $wndp[count($wndp) - 1] ?? '';
    if ($wndp2 !== '' && !in_array($wndp2, $_SESSION['login_menus'], true)) {
        // Historically this block was empty; keep it empty to avoid breaking flows.
        // Future: enforce authorization here.
    }
}

// CSRF helpers
function generateCSRFToken(): string
{
    if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token']) || $_SESSION['csrf_token'] === '') {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken(string $token): bool
{
    return isset($_SESSION['csrf_token']) && is_string($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

$csrf_token = generateCSRFToken();

?>