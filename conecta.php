<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
require_once("mysql_compat.php");
include("configuracoes.php");

if (!ini_get('default_charset')) {
    ini_set('default_charset', 'UTF-8');
} else {
    ini_set('default_charset', 'UTF-8');
}

if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

$cnx = @mysql_connect($host,$user,$pwd);
if(!$cnx) {
    die("Erro de conexao com o banco de dados. Verifique as configuracoes.");
}

$bnc = @mysql_select_db($bd, $cnx);
if(!$bnc) {
    die("Banco de dados nao encontrado: " . $bd);
}

// UTF-8 correto (MySQL/MariaDB): use utf8mb4 (não "utf8")
@mysql_set_charset('utf8mb4', $cnx);

foreach($_REQUEST as $name=>$valor){
    if(!in_array($name, array('GLOBALS', '_SERVER', '_GET', '_POST', '_FILES', '_COOKIE', '_SESSION', '_REQUEST', '_ENV'))) {
        $$name = $valor;
    }
}
?>