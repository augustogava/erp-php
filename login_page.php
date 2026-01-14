<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
require_once("mysql_compat.php");
include("configuracoes.php");
$cnx = @mysql_connect($host,$user,$pwd);
if($cnx) {
    @mysql_select_db($bd, $cnx);
    @mysql_set_charset('utf8mb4', $cnx);
}

$erro = isset($_SESSION["lerro"]) ? $_SESSION["lerro"] : "";
unset($_SESSION["lerro"]);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sistema ERP - Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #3498db 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.login-container {
    background: white;
    padding: 50px 40px;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    width: 100%;
    max-width: 420px;
}
.login-header {
    text-align: center;
    margin-bottom: 35px;
}
.login-header h1 {
    color: #2c3e50;
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 8px;
}
.login-header p {
    color: #7f8c8d;
    font-size: 14px;
}
.form-group {
    margin-bottom: 24px;
}
.form-group label {
    display: block;
    color: #2c3e50;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-group input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #ecf0f1;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s;
    background: #f8f9fa;
}
.form-group input:focus {
    outline: none;
    border-color: #3498db;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(52,152,219,0.1);
}
.btn-login {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.btn-login:hover {
    background: linear-gradient(135deg, #2980b9, #1f5f8b);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52,152,219,0.4);
}
.error-msg {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 14px;
    border-radius: 8px;
    margin-bottom: 24px;
    text-align: center;
    font-size: 14px;
    font-weight: 500;
}
.footer-text {
    text-align: center;
    margin-top: 30px;
    color: #bdc3c7;
    font-size: 12px;
}
</style>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h1>Sistema ERP</h1>
        <p>Acesse sua conta</p>
    </div>
    
    <?php if(!empty($erro)): ?>
    <div class="error-msg"><?php echo $erro; ?></div>
    <?php endif; ?>
    
    <form method="post" action="login.php">
        <div class="form-group">
            <label>Usuario</label>
            <input type="text" name="usuario" required autofocus>
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input type="password" name="senha" required>
        </div>
        <button type="submit" class="btn-login">Entrar</button>
    </form>
    
    <p class="footer-text">Sistema ERP v3.5.1</p>
</div>
</body>
</html>