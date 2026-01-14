<?php
include("conecta.php");
include("seguranca.php");
$bd=new set_bd;
if(empty($acao)) $acao="entrar";
$where="WHERE prodserv_sep.sit='P' AND vendas.id=prodserv_sep.pedido AND prodserv_sep.cliente=clientes.id ";
if(!empty($bde)){
	$bde=data2banco($bde);
	$where.="AND vendas.emissao>='$bde' ";
	$bde=banco2data($bde);
	if(!empty($bate)){
		$bate=data2banco($bate);
		$where.="AND vendas.emissao<='$bate' ";
		$bate=banco2data($bate);
	}
}
if(!empty($pedido)){
	$where.="AND prodserv_sep.pedido='$pedido' ";
}
if(!empty($status)){
	$where.="AND prodserv_sep.status='$status' ";
}
if(!empty($produto)){
	$where.="AND prodserv_sep.cliente like '%$produto%' ";
}
if(!empty($razao)){
	$where.="AND clientes.nome like '%$razao%' ";
}

$res = array();
$res2 = array();
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM prodserv_sep WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$sql2=mysql_query("SELECT * FROM vendas WHERE id='$pedido'");
	$res2=mysql_fetch_array($sql2);
}else if($acao=="alterar"){
	$previsao=data2banco($previsao);
	mysql_query("UPDATE prodserv_sep SET previsao='$previsao',coleta='$coleta',motorista='$motorista',placa='$placa',obs='$obs',status='$status' WHERE id='$id'");
	mysql_query("UPDATE vendas SET transportadora='$transportadora' WHERE id='$pedido'");
	$_SESSION["mensagem"]="Pedido de venda alterado com sucesso!";
	header("Location:prodserv_sep.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Separacao - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function MM_openBrWindow(theURL,winName,features) {
	window.open(theURL,winName,features);
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-boxes"></i> Separacao</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <?php if($acao=="entrar"){ ?>
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:16px;color:#2c3e50;"><i class="fas fa-search"></i> Busca</h3>
        <form name="form2" method="post" action="">
            <div class="erp-row">
                <div class="erp-col" style="max-width:200px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Periodo</label>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <input name="bde" type="text" class="erp-form-control" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo isset($bde) ? $bde : ''; ?>" maxlength="10" placeholder="De">
                            <span>a</span>
                            <input name="bate" type="text" class="erp-form-control" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo isset($bate) ? $bate : ''; ?>" maxlength="10" placeholder="Ate">
                        </div>
                    </div>
                </div>
                <div class="erp-col" style="max-width:120px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Pedido</label>
                        <input name="pedido" type="text" class="erp-form-control" maxlength="10">
                    </div>
                </div>
                <div class="erp-col" style="max-width:120px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cod. Cliente</label>
                        <input name="produto" type="text" class="erp-form-control" maxlength="10">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Razao Social</label>
                        <input name="razao" type="text" class="erp-form-control">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col" style="max-width:250px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Status</label>
                        <select name="status" class="erp-form-control">
                            <option value="">Selecione</option>
                            <option value="1">Aguardando Compras</option>
                            <option value="4">Em Separacao</option>
                            <option value="5">Em Producao</option>
                            <option value="6">Agendado Entrega MKR</option>
                            <option value="7">Aguardando Transportadora</option>
                            <option value="2">Aguardando Correio</option>
                            <option value="3">Coletado</option>
                            <option value="8">Entregue</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <input name="buscar" type="hidden" value="true">
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">Pedido</th>
                    <th width="100">Data</th>
                    <th>Cliente</th>
                    <th width="150">Vendedor</th>
                    <th width="100">Previsao</th>
                    <th width="150">Status</th>
                    <th width="150" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT prodserv_sep.pedido,prodserv_sep.id,vendas.emissao,prodserv_sep.cliente as codigo,clientes.nome,vendas.previsao,prodserv_sep.status,vendas.vendedor,prodserv_sep.compra FROM prodserv_sep,clientes,vendas $where ORDER BY prodserv_sep.pedido ASC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="7" class="erp-text-center" style="padding:40px;">Nenhum registro encontrado</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
                    $sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[vendedor]'");
                    $res2=mysql_fetch_array($sql2);
                    $st="";
                    $st_class="info";
                    switch($res["status"]){
                        case "1": $st="Aguardando Compras"; $st_class="warning"; break;
                        case "2": $st="Aguardando Correio"; $st_class="info"; break;
                        case "3": $st="Coletado"; $st_class="success"; break;
                        case "4": $st="Em Separacao"; $st_class="info"; break;
                        case "5": $st="Em Producao"; $st_class="warning"; break;
                        case "6": $st="Agendado Entrega MKR"; $st_class="info"; break;
                        case "7": $st="Aguardando Transportadora"; $st_class="warning"; break;
                        case "8": $st="Entregue"; $st_class="success"; break;
                        case "9": $st="Aguardando Cliente"; $st_class="warning"; break;
                    }
            ?>
                <tr>
                    <td><strong>#<?php echo $res["pedido"]; ?></strong></td>
                    <td><?php echo banco2data($res["emissao"]); ?></td>
                    <td>
                        <a href="crm_infg.php?cli=<?php echo $res["codigo"]; ?>" style="color:#2c3e50;">
                            <?php echo $res["codigo"]." ".$res["nome"]; ?>
                        </a>
                    </td>
                    <td><?php echo $res2["nome"]; ?></td>
                    <td><?php echo banco2data($res["previsao"]); ?></td>
                    <td><span class="erp-badge erp-badge-<?php echo $st_class; ?>"><?php echo $st; ?></span></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="#" onclick="MM_openBrWindow('prodserv_sep_vis.php?id=<?php echo $res["id"]?>','','scrollbars=yes,width=700,height=500');" class="erp-table-action" title="Imprimir">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="prodserv_sep.php?acao=alt&id=<?php echo $res["id"]?>&pedido=<?php echo $res["pedido"]?>&cp=<?php echo $res["compra"]?>" class="erp-table-action" title="Alterar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if($res["status"]=="7" or $res["status"]=="9" or $res["status"]=="3" or $res["status"]=="8"){ ?>
                            <a href="prodserv_sep_sql.php?acao=baixa&id=<?php echo $res["id"]?>&pedido=<?php echo $res["pedido"]?>&cp=<?php echo $res["compra"]?>" class="erp-table-action" title="Baixar" style="color:#27ae60;">
                                <i class="fas fa-check-circle"></i>
                            </a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php }else{ ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <i class="fas fa-edit"></i> Alterar
        </h3>
        <form name="form1" method="post" action="">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Situacao</label>
                        <select name="status" class="erp-form-control">
                            <option value="">Selecione</option>
                            <option value="1" <?php if(isset($res["status"]) && $res["status"]=="1") echo "selected"; ?>>Aguardando Compras</option>
                            <option value="4" <?php if(isset($res["status"]) && $res["status"]=="4") echo "selected"; ?>>Em Separacao</option>
                            <option value="5" <?php if(isset($res["status"]) && $res["status"]=="5") echo "selected"; ?>>Em Producao</option>
                            <option value="6" <?php if(isset($res["status"]) && $res["status"]=="6") echo "selected"; ?>>Agendado Entrega MKR</option>
                            <option value="7" <?php if(isset($res["status"]) && $res["status"]=="7") echo "selected"; ?>>Aguardando Transportadora</option>
                            <option value="2" <?php if(isset($res["status"]) && $res["status"]=="2") echo "selected"; ?>>Aguardando Correio</option>
                            <option value="9" <?php if(isset($res["status"]) && $res["status"]=="9") echo "selected"; ?>>Aguardando Cliente</option>
                            <option value="3" <?php if(isset($res["status"]) && $res["status"]=="3") echo "selected"; ?>>Coletado</option>
                            <option value="8" <?php if(isset($res["status"]) && $res["status"]=="8") echo "selected"; ?>>Entregue</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Previsao</label>
                        <input name="previsao" type="text" class="erp-form-control" value="<?php echo isset($res["previsao"]) ? banco2data($res["previsao"]) : ''; ?>" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" maxlength="15">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Transportadora</label>
                        <div style="display:flex;gap:8px;">
                            <input name="transportadora" type="hidden" value="<?php echo isset($res2["transportadora"]) ? $res2["transportadora"] : ''; ?>">
                            <input name="transp" type="text" class="erp-form-control" readonly style="background:#e9ecef;" value="<?php if(isset($res2["transportadora"])) $bd->pega_nome_bd("transportadora","nome",$res2["transportadora"],$idc="id"); ?>">
                            <a href="#" onclick="return abre('vendas_trans.php','busca','width=320,height=300,scrollbars=1');" class="erp-btn erp-btn-outline">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">No Coleta</label>
                        <input name="coleta" type="text" class="erp-form-control" value="<?php echo isset($res["coleta"]) ? $res["coleta"] : ''; ?>" maxlength="10">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Motorista</label>
                        <input name="motorista" type="text" class="erp-form-control" value="<?php echo isset($res["motorista"]) ? $res["motorista"] : ''; ?>">
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Placa</label>
                        <input name="placa" type="text" class="erp-form-control" value="<?php echo isset($res["placa"]) ? $res["placa"] : ''; ?>" maxlength="10">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Obs</label>
                        <textarea name="obs" class="erp-form-control" rows="4"><?php echo isset($res["obs"]) ? $res["obs"] : ''; ?></textarea>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='prodserv_sep.php'">
                    Voltar
                </button>
                <button type="submit" class="erp-btn erp-btn-primary">
                    <i class="fas fa-check"></i> Salvar
                </button>
            </div>
            <input name="acao" type="hidden" value="alterar">
            <input name="id" type="hidden" value="<?php echo $id; ?>">
            <input name="pedido" type="hidden" value="<?php echo isset($res["pedido"]) ? $res["pedido"] : ''; ?>">
        </form>
    </div>
    <?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
