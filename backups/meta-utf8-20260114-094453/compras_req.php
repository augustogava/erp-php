<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Requisicao de Compra";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
$busca="WHERE data<>'' ";
if($buscar){
	$bde=data2banco($bde);
	$busca.="AND data >= '$bde' ";
	if(!empty($bate)){
		$bate=data2banco($bate);
		$busca.="AND data <= '$bate' ";
	}
	if(!empty($bnum)){
		$busca.="AND id = '$bnum' ";
	}
}else{
	$bde=date("Y-m-d");
	$bate=date("Y-m-d");
	$busca.="AND data >= '$bde' AND data <= '$bate' ";
}
if(!empty($bde)) $bde=banco2data($bde);
if(!empty($bate)) $bate=banco2data($bate);
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM compras_requisicao WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Requisicoes de Compra - ERP System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	for(i=0;i<ind.length;i++){
		if(cad.elements['prodserv'+ind[i]].value!=''){
			if(cad.elements['qtd'+ind[i]].value=='' || cad.elements['qtd'+ind[i]].value=='0,00'){
				alert('Informe a quantidade');
				cad.elements['qtd'+ind[i]].focus();
				return false
			}
		}
	}
	return true;
}
function verbusca(cad){
	if(!verifica_data(cad.bde.value)){
		alert('Informe o inicio do periodo');
		cad.bde.focus();
		return false;
	}
	if(!verifica_data(cad.bate.value)){
		cad.bate.value='';
	}
	return true;
}
function abrenovo(codal,alt,lar){
	alt = eval(alt.replace(",","."));
	lar = eval(lar.replace(",","."));
	abre('vendas_prodserv.php?line='+codal+'&altura='+alt+'&largura='+lar+'&abre=S','busca','width=520,height=300,scrollbars=1');
}
</script>
</head>
<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-clipboard-list"></i> Requisicoes de Compra</h1>
            <div style="display:flex;gap:8px;">
                <a href="compras_req_sql.php?acao=inc" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Nova Requisicao
                </a>
            </div>
        </div>
    </div>

<?php if($acao=="entrar"){ ?>
    <div class="erp-card">
        <form method="post" action="" name="frm_bus" onSubmit="return verbusca(this)">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Inicial</label>
                        <input name="bde" type="text" class="erp-form-control" value="<?=$bde?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Final</label>
                        <input name="bate" type="text" class="erp-form-control" value="<?=$bate?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col" style="flex:0.5;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Numero</label>
                        <input name="bnum" type="text" class="erp-form-control" maxlength="8" onKeyPress="return validanum(this, event)">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <input name="buscar" type="hidden" value="true">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">Numero</th>
                    <th width="100">Data</th>
                    <th width="100" class="erp-text-right">Valor</th>
                    <th>Solicitante</th>
                    <th width="100">Situacao</th>
                    <th width="150" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
<?php
$sql=mysql_query("SELECT * FROM compras_requisicao $busca ORDER BY data DESC");
if(mysql_num_rows($sql)==0){
?>
                <tr>
                    <td colspan="6" class="erp-text-center" style="padding:40px;">Nenhuma requisicao encontrada</td>
                </tr>
<?php
}else{
    $tota = array();
    while($res=mysql_fetch_array($sql)){
        $sql2=mysql_query("SELECT * FROM compras_requisicao_list WHERE requisicao='$res[id]'");
        while($res2=mysql_fetch_array($sql2)){
            if(!isset($tota[$res2["motivo"]])) $tota[$res2["motivo"]] = 0;
            $tota[$res2["motivo"]]+=$res2["valor"]*$res2["qtd"];
        }
        $sql2=mysql_query("SELECT SUM(valor*qtd) as tot FROM compras_requisicao_list WHERE requisicao='$res[id]'");
        $res2=mysql_fetch_array($sql2);
        $status_class = ($res["fechar"]==1) ? "success" : "warning";
        $status_text = ($res["fechar"]==1) ? "Fechado" : "Aberto";
?>
                <tr>
                    <td><strong>#<?=completa($res["id"],8)?></strong></td>
                    <td><?=banco2data($res["data"])?></td>
                    <td class="erp-text-right"><strong>R$ <?=banco2valor($res2["tot"])?></strong></td>
                    <td><?=$res["responsavel"]?></td>
                    <td><span class="erp-badge erp-badge-<?=$status_class?>"><?=$status_text?></span></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="#" onclick="window.open('compras_req_imp.php?id=<?=$res["id"]?>','','scrollbars=yes,width=730,height=500');" class="erp-table-action" title="Imprimir">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="<?=$_SERVER['PHP_SELF']?>?acao=alt&id=<?=$res["id"]?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
<?php if($res["fechar"]!=1){ ?>
                            <a href="compras_req_sql.php?acao=fechar&id=<?=$res["id"]?>" class="erp-table-action" title="Fechar">
                                <i class="fas fa-check-circle"></i>
                            </a>
<?php } ?>
                            <a href="#" onclick="return pergunta('Deseja excluir esta Requisicao?','compras_req_sql.php?acao=exc&id=<?=$res["id"]?>')" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                <i class="fas fa-trash"></i>
                            </a>
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

<?php if(isset($tota) && count($tota) > 0){ ?>
    <div class="erp-card" style="margin-top:20px;">
        <div class="erp-card-header">
            <h3><i class="fas fa-chart-pie"></i> Resumo por Motivo</h3>
        </div>
        <div class="erp-card-body">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>Motivo</th>
                        <th class="erp-text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$tot = 0;
foreach($tota as $key=>$valor){
    $tot += $valor;
?>
                    <tr>
                        <td><?=$key?></td>
                        <td class="erp-text-right">R$ <?=banco2valor($valor)?></td>
                    </tr>
<?php } ?>
                    <tr style="background:#f8f9fa;font-weight:600;">
                        <td>TOTAL GERAL</td>
                        <td class="erp-text-right" style="color:#27AE60;">R$ <?=banco2valor($tot)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>

<?php }else{ ?>
    <div class="erp-card">
        <div class="erp-card-header">
            <h3><i class="fas fa-edit"></i> <?php if($acao=="inc"){ echo "Incluir"; }else{ echo "Alterar";} ?> Requisicao</h3>
        </div>
        <div class="erp-card-body">
            <form name="form1" method="post" action="compras_req_sql.php" onSubmit="return verifica(this);">
                <div class="erp-row">
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Numero</label>
                            <input type="text" class="erp-form-control" value="<?=completa($res["id"],8)?>" readonly>
                        </div>
                    </div>
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Data</label>
                            <input name="data" type="text" class="erp-form-control" value="<?=banco2data($res["data"])?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                        </div>
                    </div>
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Responsavel</label>
                            <input type="text" class="erp-form-control" value="<?=$res["responsavel"]?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="erp-table-container" style="margin-top:20px;">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th width="30"></th>
                                <th width="60">Qtd</th>
                                <th width="80">Unidade</th>
                                <th>Descricao</th>
                                <th width="30"></th>
                                <th width="100">Unitario</th>
                                <th width="150">Motivo</th>
                                <th width="100">Solicitante</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
$sql=mysql_query("SELECT * FROM compras_requisicao_list WHERE requisicao='$id'");
if(!mysql_num_rows($sql)){
    $sql=mysql_query("INSERT INTO compras_requisicao_list (requisicao) VALUES ('$id')");
    $sql=mysql_query("SELECT * FROM compras_requisicao_list WHERE requisicao='$id'");
}
if(mysql_num_rows($sql)){
    $b=0;
    while($resl=mysql_fetch_array($sql)){
        $b++;
        $tot+=($resl["qtd"]*$resl["valor"]);
        if($resl["produto"]){
            $sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$resl[produto]'");
            $resp=mysql_fetch_array($sqlp);
            $resl["prod"]=$resp["nome"];
        }
?>
                            <tr>
                                <td><input name="del[<?=$resl["id"]?>]" type="checkbox" value="<?=$resl["id"]?>"></td>
                                <td><input name="qtd[<?=$resl["id"]?>]" type="text" class="erp-form-control" style="width:100%;" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?php if(!empty($resl["qtde"])){ echo banco2valor($resl["qtde"]); }else{ echo banco2valor($resl["qtd"]); } ?>"></td>
                                <td><input name="unidade[<?=$resl["id"]?>]" type="text" class="erp-form-control" style="width:100%;" value="<?=$resl["unidade"]?>"></td>
                                <td><input name="descricao[<?=$resl["id"]?>]" type="text" class="erp-form-control" style="width:100%;" readonly value="<?=$resl["prod"]?>"></td>
                                <td><a href="#" onclick="abrenovo('<?=$resl["id"]?>','','');"><i class="fas fa-search"></i></a>
                                    <input name="prodserv[<?=$resl["id"]?>]" type="hidden" value="<?=$resl["produto"]?>">
                                </td>
                                <td><input name="unitario[<?=$resl["id"]?>]" type="text" class="erp-form-control" style="width:100%;" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?=banco2valor($resl["valor"])?>"></td>
                                <td>
                                    <select name="motivo[<?=$resl["id"]?>]" class="erp-form-control" style="width:100%;">
                                        <option value="" <?php if(empty($resl["motivo"])) echo "selected"; ?>>Selecione</option>
                                        <option value="acerto" <?php if($resl["motivo"]=="acerto") echo "selected"; ?>>Acerto Estoque</option>
                                        <option value="producao" <?php if($resl["motivo"]=="producao") echo "selected"; ?>>Producao</option>
                                        <option value="manutencao" <?php if($resl["motivo"]=="manutencao") echo "selected"; ?>>Manutencao</option>
                                        <option value="amostra" <?php if($resl["motivo"]=="amostra") echo "selected"; ?>>Amostra</option>
                                        <option value="transf_int" <?php if($resl["motivo"]=="transf_int") echo "selected"; ?>>Transformacao Interna</option>
                                        <option value="transf_ext" <?php if($resl["motivo"]=="transf_ext") echo "selected"; ?>>Transformacao Externa</option>
                                    </select>
                                </td>
                                <td><input name="solicitante[<?=$resl["id"]?>]" type="text" class="erp-form-control" style="width:100%;" value="<?=$resl["solicitante"]?>"></td>
                            </tr>
<?php
    }
}
?>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:20px;display:flex;gap:10px;justify-content:center;">
                    <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='compras_req.php'">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
<?php if($res["fechar"]==1){ ?>
                    <button type="button" class="erp-btn erp-btn-secondary" onclick="alert('Requisicao ja fechada!')">
                        <i class="fas fa-plus"></i> Adicionar Linha
                    </button>
                    <button type="button" class="erp-btn erp-btn-secondary" onclick="alert('Requisicao ja fechada!')">
                        <i class="fas fa-minus"></i> Excluir Linha
                    </button>
                    <button type="button" class="erp-btn erp-btn-secondary" onclick="alert('Requisicao ja fechada!')">
                        <i class="fas fa-save"></i> Continuar
                    </button>
<?php }else{ ?>
                    <button type="button" class="erp-btn erp-btn-secondary" onclick="form1.maisum.value='1'; form1.submit();">
                        <i class="fas fa-plus"></i> Adicionar Linha
                    </button>
                    <button type="button" class="erp-btn erp-btn-danger" onclick="form1.delsel.value='1'; form1.submit();">
                        <i class="fas fa-minus"></i> Excluir Linha
                    </button>
                    <button type="submit" class="erp-btn erp-btn-primary">
                        <i class="fas fa-save"></i> Continuar
                    </button>
<?php } ?>
                </div>

                <input name="acao" type="hidden" value="alt">
                <input name="id" type="hidden" value="<?=$id?>">
                <input name="maisum" type="hidden">
                <input name="delsel" type="hidden">
            </form>
        </div>
    </div>
<?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
