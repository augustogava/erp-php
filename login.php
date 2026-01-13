<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
include("conecta.php");

$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : (isset($usuario) ? $usuario : '');
$senha = isset($_POST['senha']) ? $_POST['senha'] : (isset($senha) ? $senha : '');

$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
$data = date("Y-m-d");
$hora = date("H:i:s");
$pip = explode(".", $ip);
$ext = ($pip[0] != "192");

if($ext && !empty($usuario)){
    @mysql_query("INSERT INTO externo (usuario,data,hora,ip) VALUES('$usuario','$data','$hora','$ip')");
}

@mysql_query("DELETE FROM online WHERE (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(data)) > 100");

$sqlb = @mysql_query("SELECT * FROM bloquear WHERE id=1");
$resb = @mysql_fetch_array($sqlb);
if(isset($resb["block"]) && $resb["block"]=="S"){
    $_SESSION["lerro"] = "Sistema em Manutencao";
    header("Location:login_page.php");
    exit;
}

if($ext && isset($resb["externo"]) && $resb["externo"]=="N"){
    $_SESSION["lerro"] = "Acesso Externo Proibido";
    header("Location:login_page.php");
    exit;
}

$erro = false;
$erro2 = false;

if(empty($usuario) || empty($senha)){
    $erro = true;
}else{
    $usuario = @mysql_real_escape_string($usuario);
    $senha = @mysql_real_escape_string($senha);
    
    if(!$ext){
        $sql = @mysql_query("SELECT * FROM cliente_login WHERE login='$usuario' AND senha='$senha' AND sit='A' AND blok='0'");
        if(!$sql || mysql_num_rows($sql)==0){
            $erro = true;
        }
    }else{
        $sql = @mysql_query("SELECT * FROM cliente_login WHERE login='$usuario' AND senha='$senha' AND sit='A' AND blok='0' AND blok_externo='0'");
        if(!$sql || mysql_num_rows($sql)==0){
            $erro2 = true;
        }
    }
}

if($erro){
    $_SESSION["lerro"] = "Login ou senha incorretos";
    header("Location:login_page.php");
    exit;
}else if($erro2){
    $_SESSION["lerro"] = "Usuario bloqueado para acesso externo";
    header("Location:login_page.php");
    exit;
}else{
    $res = @mysql_fetch_array($sql);
    $nome = "";
    $nivel = "";
    $cargo = "";
    $nivelnum = isset($res["nivel"]) ? $res["nivel"] : 1;
    $cliente = 0;
    
    if(empty($res["funcionario"])){
        $cliente = isset($res["cliente"]) ? $res["cliente"] : 0;
        $sql2 = @mysql_query("SELECT clientes.nome as clinome, niveis.nome as nivel, cliente_login.primeiro as primeiro, cliente_login.id as ids, cliente_login.perm as permissao FROM clientes, niveis, cliente_login WHERE clientes.id='$cliente' AND clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id");
        if($sql2 && mysql_num_rows($sql2)!=0){
            $res2 = mysql_fetch_array($sql2);
            $nome = $res2["clinome"];
            $nivel = $res2["nivel"];
            $res["primeiro"] = $res2["primeiro"];
            $res["ids"] = $res2["ids"];
            $res["permissao"] = $res2["permissao"];
        }else{
            $nome = "Usuario";
            $nivel = "Padrao";
        }
        $sql3 = @mysql_query("SELECT cargos.nome as cargonome FROM funcionarios, cargos WHERE funcionarios.cliente='$cliente' AND cargos.id=funcionarios.cargo");
        if($sql3 && mysql_num_rows($sql3)){
            $res3 = mysql_fetch_array($sql3);
            $cargo = isset($res3["cargonome"]) ? $res3["cargonome"] : "";
        }
        $_SESSION["login_funcionario"] = "N";
    }else{
        $cliente = $res["funcionario"];
        $sql2 = @mysql_query("SELECT funcionarios.nome as clinome, niveis.nome as nivel, cliente_login.primeiro as primeiro, cliente_login.id as ids, cliente_login.perm as permissao FROM funcionarios, niveis, cliente_login WHERE funcionarios.id='$cliente' AND funcionarios.id=cliente_login.funcionario AND cliente_login.nivel=niveis.id");
        if($sql2 && mysql_num_rows($sql2)!=0){
            $res2 = mysql_fetch_array($sql2);
            $nome = $res2["clinome"];
            $nivel = $res2["nivel"];
            $res["primeiro"] = $res2["primeiro"];
            $res["ids"] = $res2["ids"];
            $res["permissao"] = $res2["permissao"];
        }else{
            $nome = "Administrador";
            $nivel = "Administrador";
        }
        $sql3 = @mysql_query("SELECT cargo FROM funcionarios WHERE id='$cliente'");
        if($sql3 && mysql_num_rows($sql3)){
            $res3 = mysql_fetch_array($sql3);
            $cargo = isset($res3["cargo"]) ? $res3["cargo"] : "";
        }
        $_SESSION["login_funcionario"] = "S";
    }
    
    $_SESSION["permissao"] = isset($res["permissao"]) ? $res["permissao"] : "4";
    $_SESSION["login_codigo"] = $cliente;
    $_SESSION["login_nome"] = $nome;
    $_SESSION["login_cargo"] = $cargo;
    $_SESSION["login_nivel_nome"] = $nivel;
    $_SESSION["login_nivel"] = $nivelnum;
    $_SESSION["login_c1"] = $usuario;
    
    @mysql_query("INSERT INTO online (user, data) VALUES ('$cliente', NOW())");
    
    if(isset($res["primeiro"]) && $res["primeiro"]=="S"){
        header("Location:primeiro.php?id=".$res["ids"]);
    }else{
        header("Location:index.php");
    }
    exit;
}
?>