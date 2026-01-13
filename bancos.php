<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Bancos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="exc"){
	$sql=mysql_query("DELETE FROM bancos WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Banco exclua­do com sucesso!";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Bancos - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
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
            <h1 class="erp-card-title">ð¦ Bancos</h1>
            <div>
                <a href="bancos_sql.php?acao=inc" class="erp-btn erp-btn-primary">
                    + Novo Banco
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
                    <th width="60">Ca³d</th>
                    <th>Banco / Apelido</th>
                    <th width="120">Agaªncia</th>
                    <th width="120">Conta</th>
                    <th width="120" class="erp-text-right">Saldo</th>
                    <th width="120" class="erp-text-right">Limite</th>
                    <th width="200" class="erp-text-center">Acaµes</th>
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
                        <td><strong><?=$res["id"]?></strong></td>
                        <td>
                            <div style="font-weight:600;"><?=$res["apelido"]?></div>
                            <div style="font-size:12px;color:#6c757d;">Banco: <?=$res["bco"]?></div>
                        </td>
                        <td><?=$res["agencia"]?></td>
                        <td><?=$res["conta"]?></td>
                        <td class="erp-text-right">
                            <strong style="color:<?=$saldo_class?>">R$ <?=banco2valor($res["saldo"])?></strong>
                        </td>
                        <td class="erp-text-right">
                            <div>R$ <?=banco2valor($res["limite"])?></div>
                            <div style="font-size:11px;color:#6c757d;">Disp: R$ <?=banco2valor($saldo_disponivel)?></div>
                        </td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="bancos_lan.php?setbco=<?=$res["id"]?>" class="erp-table-action" title="Lancamentos">
                                    ð°
                                </a>
                                <a href="bancos_sql.php?acao=alt&id=<?=$res["id"]?>" class="erp-table-action" title="Editar">
                                    âï¸
                                </a>
                                <a href="bancos_lan_imp.php?banco=<?=$res["id"]?>" target="_blank" class="erp-table-action" title="Extrato">
                                    ð
                                </a>
                                <?php if($nivel=="1"): ?>
                                <a href="#" onclick="return pergunta('Confirma exclusao?','bancos.php?acao=exc&id=<?=$res["id"]?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                    ðï¸
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
                    <td class="erp-text-right" style="color:<?=$total_saldo>=0?'#27AE60':'#E74C3C'?>;font-size:16px;">
                        R$ <?=banco2valor($total_saldo)?>
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

<? include("mensagem.php"); ?>
</body>
</html>
