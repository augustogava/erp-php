<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Compras";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if(empty($emissao)){
	$emissao=date("d/m/Y");
	$emissao2=date("d/m/Y");
}

if(!isset($wsit)) $wsit="2";

if($wsit=="2"){
	$busca=" WHERE compras.fornecedor=fornecedores.id ";
}else{
	$busca=" WHERE compras.fornecedor=fornecedores.id AND compras.sit='$wsit' ";
}

if(!empty($emissao)){
	$emissao_banco=data2banco($emissao);
	$busca.="AND compras.emissao>='$emissao_banco' ";
	if(!empty($emissao2)){
		$emissao2_banco=data2banco($emissao2);
		$busca.="AND compras.emissao<='$emissao2_banco' ";
	}
}

if($acao=="exc"){
	$sql=mysql_query("DELETE FROM compras_list WHERE compras='$id'");
	$sql=mysql_query("DELETE FROM compras WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Compra exclua­da com sucesso!";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Compras - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-shopping-cart"></i> Compras</h1>
            <div style="display:flex;gap:8px;">
                <a href="compras_req.php" class="erp-btn erp-btn-outline">
                    ð Requisicaµes
                </a>
                <a href="compras_cot.php" class="erp-btn erp-btn-outline">
                    ð¼ Cotacaµes
                </a>
                <a href="compras_sql.php?acao=inc" class="erp-btn erp-btn-primary">
                    + Nova Compra
                </a>
            </div>
        </div>
    </div>
    
    <div class="erp-card">
        <form method="post" action="">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Inicial</label>
                        <input name="emissao" type="text" class="erp-form-control" value="<?=$emissao?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Final</label>
                        <input name="emissao2" type="text" class="erp-form-control" value="<?=$emissao2?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Situacao</label>
                        <select name="wsit" class="erp-form-control">
                            <option value="2" <?=$wsit=="2"?"selected":""?>>Todas</option>
                            <option value="A" <?=$wsit=="A"?"selected":""?>>Aberto</option>
                            <option value="F" <?=$wsit=="F"?"selected":""?>>Fechado</option>
                            <option value="C" <?=$wsit=="C"?"selected":""?>>Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            ð Filtrar
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
                    <th width="60">Pedido</th>
                    <th width="90">Emissao</th>
                    <th>Fornecedor</th>
                    <th width="90">Entrega</th>
                    <th width="120" class="erp-text-right">Valor Total</th>
                    <th width="100">Status</th>
                    <th width="200" class="erp-text-center">Acaµes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT compras.*,fornecedores.fantasia FROM compras,fornecedores $busca ORDER BY compras.emissao DESC, compras.id DESC");
            
            if(mysql_num_rows($sql)==0){
                echo '<tr><td colspan="7" class="erp-text-center" style="padding:40px;">Nenhuma compra encontrada</td></tr>';
            }else{
                $total_geral = 0;
                while($res=mysql_fetch_array($sql)){
                    $valor_total = banco2valor($res["valor"]);
                    $total_geral += $res["valor"];
                    
                    switch($res["sit"]){
                        case "A": $status_class="warning"; $status_text="Aberto"; break;
                        case "F": $status_class="success"; $status_text="Fechado"; break;
                        case "C": $status_class="danger"; $status_text="Cancelado"; break;
                        default: $status_class="info"; $status_text="Novo";
                    }
                    ?>
                    <tr>
                        <td><strong>#<?=$res["id"]?></strong></td>
                        <td><?=banco2data($res["emissao"])?></td>
                        <td>
                            <div style="font-weight:600;"><?=$res["fantasia"]?></div>
                        </td>
                        <td><?=!empty($res["entrega"])?banco2data($res["entrega"]):"-"?></td>
                        <td class="erp-text-right"><strong>R$ <?=$valor_total?></strong></td>
                        <td>
                            <span class="erp-badge erp-badge-<?=$status_class?>"><?=$status_text?></span>
                        </td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="compras_sql.php?acao=alt&id=<?=$res["id"]?>" class="erp-table-action" title="Editar">
                                    âï¸
                                </a>
                                <a href="compras_prodserv.php?compras=<?=$res["id"]?>" class="erp-table-action" title="Produtos">
                                    ð¦
                                </a>
                                <a href="compras_entrega.php?id=<?=$res["id"]?>" class="erp-table-action" title="Entrega">
                                    ð
                                </a>
                                <a href="#" onclick="window.open('compras_imp.php?id=<?=$res["id"]?>','','width=800,height=600');" class="erp-table-action" title="Imprimir">
                                    ð¨ï¸
                                </a>
                                <?php if($nivel=="1"): ?>
                                <a href="#" onclick="return pergunta('Confirma exclusao?','compras.php?acao=exc&id=<?=$res["id"]?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
                    <td colspan="4" class="erp-text-right">TOTAL GERAL:</td>
                    <td class="erp-text-right" style="color:#27AE60;font-size:16px;">R$ <?=banco2valor($total_geral)?></td>
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
