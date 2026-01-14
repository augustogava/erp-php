<?php
include("conecta.php");
include("seguranca.php");
$acao = Input::request('acao', '');
$id = Input::request('id', '');
$acao = verifi($permi, $acao);
$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Bancos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="exc"){
	$sql=mysql_query("DELETE FROM bancos WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Banco excluido com sucesso!";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Bancos - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-university"></i> Bancos</h1>
            <div>
                <a href="bancos_sql.php?acao=inc" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Novo Banco
                </a>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="60">Cod</th>
                    <th>Banco / Apelido</th>
                    <th width="120">Agencia</th>
                    <th width="120">Conta</th>
                    <th width="120" class="erp-text-right">Saldo</th>
                    <th width="120" class="erp-text-right">Limite</th>
                    <th width="200" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM bancos ORDER BY apelido ASC");
            
            if(mysql_num_rows($sql)==0){
                echo '<tr><td colspan="7" class="erp-text-center" style="padding:40px;">Nenhum banco cadastrado</td></tr>';
            }else{
                $total_saldo = 0;
                while($res=mysql_fetch_array($sql)){
                    $total_saldo += $res["saldo"];
                    $saldo_disponivel = $res["saldo"] + $res["limite"];
                    $saldo_class = $res["saldo"] >= 0 ? "#27AE60" : "#E74C3C";
                    ?>
                    <tr>
                        <td><strong><?php echo $res["id"]; ?></strong></td>
                        <td>
                            <div style="font-weight:600;"><?php echo $res["apelido"]; ?></div>
                            <div style="font-size:12px;color:#6c757d;">Banco: <?php echo $res["bco"]; ?></div>
                        </td>
                        <td><?php echo $res["agencia"]; ?></td>
                        <td><?php echo $res["conta"]; ?></td>
                        <td class="erp-text-right">
                            <strong style="color:<?php echo $saldo_class; ?>">R$ <?php echo banco2valor($res["saldo"]); ?></strong>
                        </td>
                        <td class="erp-text-right">
                            <div>R$ <?php echo banco2valor($res["limite"]); ?></div>
                            <div style="font-size:11px;color:#6c757d;">Disp: R$ <?php echo banco2valor($saldo_disponivel); ?></div>
                        </td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="bancos_lan.php?setbco=<?php echo $res["id"]; ?>" class="erp-table-action" title="Lancamentos">
                                    <i class="fas fa-list-alt"></i>
                                </a>
                                <a href="bancos_sql.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="bancos_lan_imp.php?banco=<?php echo $res["id"]; ?>" target="_blank" class="erp-table-action" title="Extrato">
                                    <i class="fas fa-print"></i>
                                </a>
                                <?php if($nivel=="1"): ?>
                                <a href="#" onclick="return pergunta('Confirma exclusao?','bancos.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr style="background:#f8f9fa;font-weight:600;">
                    <td colspan="4" class="erp-text-right">SALDO TOTAL:</td>
                    <td class="erp-text-right" style="color:<?php echo ($total_saldo>=0) ? '#27AE60' : '#E74C3C'; ?>;font-size:16px;">
                        R$ <?php echo banco2valor($total_saldo); ?>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
