<?php
declare(strict_types=1);

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
require_once(__DIR__ . '/conecta.php');

// Helper: fetch one row (assoc) from a prepared statement
$fetchOne = static function (mysqli_stmt $stmt): ?array {
    $res = mysqli_stmt_get_result($stmt);
    if (!$res) {
        return null;
    }
    $row = mysqli_fetch_assoc($res);
    return $row ?: null;
};

$usuario = Input::post('usuario', '');
$senha = Input::post('senha', '');

$ip = isset($_SERVER['REMOTE_ADDR']) ? (string)$_SERVER['REMOTE_ADDR'] : '127.0.0.1';
$data = date('Y-m-d');
$hora = date('H:i:s');
$pip = explode('.', $ip);
$ext = (($pip[0] ?? '') !== '192');

// Log external login attempts
if ($ext && $usuario !== '') {
    if ($stmt = mysqli_prepare($cnx, 'INSERT INTO externo (usuario, data, hora, ip) VALUES (?, ?, ?, ?)')) {
        mysqli_stmt_bind_param($stmt, 'ssss', $usuario, $data, $hora, $ip);
        @mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Cleanup "online" table
@mysqli_query($cnx, 'DELETE FROM online WHERE (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(data)) > 100');

// Maintenance / external access flags
$blockRow = null;
if ($stmt = mysqli_prepare($cnx, 'SELECT block, externo FROM bloquear WHERE id = 1')) {
    mysqli_stmt_execute($stmt);
    $blockRow = $fetchOne($stmt);
    mysqli_stmt_close($stmt);
}

if (($blockRow['block'] ?? '') === 'S') {
    $_SESSION['lerro'] = 'Sistema em Manutencao';
    header('Location: login_page.php');
    exit;
}

if ($ext && ($blockRow['externo'] ?? 'S') === 'N') {
    $_SESSION['lerro'] = 'Acesso Externo Proibido';
    header('Location: login_page.php');
    exit;
}

if ($usuario === '' || $senha === '') {
    $_SESSION['lerro'] = 'Login ou senha incorretos';
    header('Location: login_page.php');
    exit;
}

// Authenticate (prepared statements)
$sql = 'SELECT * FROM cliente_login WHERE login = ? AND senha = ? AND sit = \'A\' AND blok = \'0\'';
if ($ext) {
    $sql .= ' AND blok_externo = \'0\'';
}

$loginRow = null;
if ($stmt = mysqli_prepare($cnx, $sql)) {
    mysqli_stmt_bind_param($stmt, 'ss', $usuario, $senha);
    mysqli_stmt_execute($stmt);
    $loginRow = $fetchOne($stmt);
    mysqli_stmt_close($stmt);
}

if (!$loginRow) {
    $_SESSION['lerro'] = $ext ? 'Usuario bloqueado para acesso externo' : 'Login ou senha incorretos';
    header('Location: login_page.php');
    exit;
}

$nome = '';
$nivelNome = '';
$cargo = '';
$nivelnum = isset($loginRow['nivel']) ? (int)$loginRow['nivel'] : 1;
$clienteId = 0;

if (empty($loginRow['funcionario'])) {
    // Cliente login
    $clienteId = isset($loginRow['cliente']) ? (int)$loginRow['cliente'] : 0;

    if ($stmt = mysqli_prepare(
        $cnx,
        'SELECT clientes.nome AS clinome, niveis.nome AS nivel, cliente_login.primeiro AS primeiro, cliente_login.id AS ids, cliente_login.perm AS permissao
         FROM clientes, niveis, cliente_login
         WHERE clientes.id = ? AND clientes.id = cliente_login.cliente AND cliente_login.nivel = niveis.id'
    )) {
        mysqli_stmt_bind_param($stmt, 'i', $clienteId);
        mysqli_stmt_execute($stmt);
        $row = $fetchOne($stmt);
        mysqli_stmt_close($stmt);

        if ($row) {
            $nome = (string)($row['clinome'] ?? '');
            $nivelNome = (string)($row['nivel'] ?? '');
            $loginRow['primeiro'] = $row['primeiro'] ?? null;
            $loginRow['ids'] = $row['ids'] ?? null;
            $loginRow['permissao'] = $row['permissao'] ?? null;
        }
    }

    if ($nome === '') {
        $nome = 'Usuario';
        $nivelNome = 'Padrao';
    }

    // Cargo by cliente linkage
    if ($stmt = mysqli_prepare(
        $cnx,
        'SELECT cargos.nome AS cargonome
         FROM funcionarios, cargos
         WHERE funcionarios.cliente = ? AND cargos.id = funcionarios.cargo'
    )) {
        mysqli_stmt_bind_param($stmt, 'i', $clienteId);
        mysqli_stmt_execute($stmt);
        $row = $fetchOne($stmt);
        mysqli_stmt_close($stmt);
        $cargo = (string)($row['cargonome'] ?? '');
    }

    $_SESSION['login_funcionario'] = 'N';
} else {
    // Funcionario login
    $clienteId = (int)$loginRow['funcionario'];

    if ($stmt = mysqli_prepare(
        $cnx,
        'SELECT funcionarios.nome AS clinome, niveis.nome AS nivel, cliente_login.primeiro AS primeiro, cliente_login.id AS ids, cliente_login.perm AS permissao
         FROM funcionarios, niveis, cliente_login
         WHERE funcionarios.id = ? AND funcionarios.id = cliente_login.funcionario AND cliente_login.nivel = niveis.id'
    )) {
        mysqli_stmt_bind_param($stmt, 'i', $clienteId);
        mysqli_stmt_execute($stmt);
        $row = $fetchOne($stmt);
        mysqli_stmt_close($stmt);

        if ($row) {
            $nome = (string)($row['clinome'] ?? '');
            $nivelNome = (string)($row['nivel'] ?? '');
            $loginRow['primeiro'] = $row['primeiro'] ?? null;
            $loginRow['ids'] = $row['ids'] ?? null;
            $loginRow['permissao'] = $row['permissao'] ?? null;
        }
    }

    if ($nome === '') {
        $nome = 'Administrador';
        $nivelNome = 'Administrador';
    }

    if ($stmt = mysqli_prepare($cnx, 'SELECT cargo FROM funcionarios WHERE id = ?')) {
        mysqli_stmt_bind_param($stmt, 'i', $clienteId);
        mysqli_stmt_execute($stmt);
        $row = $fetchOne($stmt);
        mysqli_stmt_close($stmt);
        $cargo = (string)($row['cargo'] ?? '');
    }

    $_SESSION['login_funcionario'] = 'S';
}

$_SESSION['permissao'] = isset($loginRow['permissao']) ? (string)$loginRow['permissao'] : '4';
$_SESSION['login_codigo'] = $clienteId;
$_SESSION['login_nome'] = $nome;
$_SESSION['login_cargo'] = $cargo;
$_SESSION['login_nivel_nome'] = $nivelNome;
$_SESSION['login_nivel'] = $nivelnum;
$_SESSION['login_c1'] = $usuario;

// Insert into online
if ($stmt = mysqli_prepare($cnx, 'INSERT INTO online (user, data) VALUES (?, NOW())')) {
    mysqli_stmt_bind_param($stmt, 'i', $clienteId);
    @mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (($loginRow['primeiro'] ?? '') === 'S') {
    header('Location: primeiro.php?id=' . urlencode((string)($loginRow['ids'] ?? '')));
} else {
    header('Location: index.php');
}
exit;
?>