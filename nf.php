<?php
include("conecta.php");
include("seguranca.php");
$esta=new set_bd();
$hj=date("Y-m-d");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Notas Fiscais";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($buscar){
	unset($wp);
}
if(empty($btipo) or $btipo=="T"){
	$busca="WHERE (es='E' OR es='S') ";
}else{
	$busca="WHERE es='$btipo' ";
}
$busca.="AND vis='S' ";
if(!empty($bnum)){
	$busca.="AND numero='$bnum' ";
}
if(!empty($empresa)){
	$busca.="AND id_empresa='$empresa' ";
}
if(!empty($bde) and !empty($bate)){
	if($buscar){
		$bde=data2banco($bde);
		$bate=data2banco($bate);
	}
	$busca.="AND (emissao >= '$bde' AND emissao <= '$bate') ";
}
if(!empty($cliente) and !empty($cliente_tipo)){
	$busca.="AND cliente='$cliente' AND cliente_tipo='$cliente_tipo' ";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Notas Fiscais - ERP System</title>
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
function verifica(cad){
	if(!verifica_data(cad.bde.value)){
		cad.bde.value='';
	}
	if(!verifica_data(cad.bate.value)){
		cad.bate.value='';
	}
	return true;
}
</script>
</head>
<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-file-invoice"></i> Notas Fiscais</h1>
            <div style="display:flex;gap:8px;">
                <a href="nfe.php?acao=inc" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Nova NF
                </a>
            </div>
        </div>
    </div>

    <div class="erp-card">
        <form method="post" action="" name="form1" onSubmit="return verifica(this)">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cliente/Fornecedor</label>
                        <div style="display:flex;gap:5px;">
                            <input name="nome" type="text" class="erp-form-control" value="<?php echo $nome?>" readonly style="flex:1;">
                            <a href="#" onclick="return abre('nf_cli.php','a','width=320,height=300,scrollbars=1');" class="erp-btn erp-btn-outline" style="padding:0 12px;">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                        <input name="cliente" type="hidden" value="<?php echo $cliente?>">
                        <input name="cliente_tipo" type="hidden" value="<?php echo $cliente_tipo?>">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 140px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Inicial</label>
                        <input name="bde" type="text" class="erp-form-control" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 140px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Final</label>
                        <input name="bate" type="text" class="erp-form-control" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col" style="flex:0 0 120px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Numero</label>
                        <input name="bnum" type="text" class="erp-form-control" maxlength="6" onKeyPress="return validanum(this, event)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Empresa</label>
                        <select name="empresa" class="erp-form-control">
                            <option value="">Todas</option>
<?php
$emp=mysql_query("SELECT id,apelido_fat FROM empresa order by apelido_fat asc");
while($empr=mysql_fetch_array($emp)){
?>
                            <option value="<?php echo $empr["id"]?>"><?php echo $empr["apelido_fat"]?></option>
<?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Tipo</label>
                        <div style="display:flex;gap:15px;padding-top:10px;">
                            <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                                <input name="btipo" type="radio" value="E"> Entrada
                            </label>
                            <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                                <input name="btipo" type="radio" value="S"> Saida
                            </label>
                            <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                                <input name="btipo" type="radio" value="T" checked> Todas
                            </label>
                        </div>
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
                    <th width="60">Tipo</th>
                    <th width="80">Nota</th>
                    <th width="100">Emissao</th>
                    <th>Empresa</th>
                    <th width="80">Pedido</th>
                    <th width="100">Cod. Cliente</th>
                    <th width="100" class="erp-text-right">Valor</th>
                    <th width="80">Status</th>
                    <th width="100" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
<?php
$sql=mysql_query("SELECT * FROM nf $busca ORDER BY compra DESC");
if(!mysql_num_rows($sql)){
?>
                <tr>
                    <td colspan="9" class="erp-text-center" style="padding:40px;">Nenhuma nota fiscal encontrada</td>
                </tr>
<?php
}else{
    $maxpag=20;
    $results_tot=mysql_num_rows($sql);
    if($results_tot>$maxpag){
        $wpaginar=true;
        if(!isset($wp)){
            $param=0;
            $temp=0;
            $wp=0;
        }else{
            $temp = $wp;
            $passo1 = $temp - 1;
            $passo2 = $passo1*$maxpag;
            $param  = $passo2;				
        }
        $sql=mysql_query("SELECT * FROM nf $busca ORDER BY compra DESC LIMIT $param, $maxpag");
        $results_parc=mysql_num_rows($sql);
        $result_div=$results_tot/$maxpag;
        $n_inteiro=(int)$result_div;
        if($n_inteiro<$result_div){
            $n_paginas=$n_inteiro+1;
        }else{
            $n_paginas=$result_div;
        }
        $pg_atual=$param/$maxpag+1;
        $reg_inicial=$param+1;
        $pg_anterior=$pg_atual-1;
        $pg_proxima=$pg_atual+1;
        $reg_final=$param;
    }
    while($res=mysql_fetch_array($sql)){
        $ped=mysql_query("SELECT * FROM vendas WHERE id='$res[pedido]'");
        $rped=mysql_fetch_array($ped);
        $reg_final++;
        if($res["cliente_tipo"]=="C"){
            $res["cliente_tipo"]="clientes";
        }else{
            $res["cliente_tipo"]="fornecedores";
        }
        $sql2=mysql_query("SELECT SUM((qtd+qtde)*unitario)-SUM(((qtd+qtde)*unitario)*desconto/100) as tot FROM vendas_list WHERE venda='$res[pedido]'");
        $res2=mysql_fetch_array($sql2);
        
        $status_text = "";
        $status_class = "info";
        if(empty($res["impresso"])){ 
            $status_text = "Nao Impresso"; 
            $status_class = "warning";
        }else if($res["impresso"]=="1"){ 
            $status_text = "Impresso Total"; 
            $status_class = "success";
        }else{ 
            $status_text = "Impresso Parcial"; 
            $status_class = "info";
        }
        
        $tipo_class = ($res["es"]=="E") ? "success" : "primary";
        $tipo_text = ($res["es"]=="E") ? "Entrada" : "Saida";
?>
                <tr>
                    <td><span class="erp-badge erp-badge-<?php echo $tipo_class?>"><?php echo $tipo_text?></span></td>
                    <td><strong>#<?php echo $res["numero"]?></strong></td>
                    <td><?php echo banco2data($res["emissao"])?></td>
                    <td><?php $esta->pega_nome_bd("empresa","apelido_fat",$rped["empresa"],$idc="id"); ?></td>
                    <td><a href="vendas.php?acao=alt&id=<?php echo $res["pedido"]?>">#<?php echo $res["pedido"]?></a></td>
                    <td><a href="crm_infg.php?cli=<?php echo $res["cliente"]?>"><?php echo $res["cliente"]?></a></td>
                    <td class="erp-text-right"><strong>R$ <?php echo banco2valor($res2["tot"])?></strong></td>
                    <td><span class="erp-badge erp-badge-<?php echo $status_class?>"><?php echo $status_text?></span></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="#" onclick="return abre('nf_vis.php?nf=<?php echo $res["id"]?>','nota<?php echo $res["id"]?>','width=680,height=380,scrollbars=1');" class="erp-table-action" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
<?php if($res["impresso"]!="1"){ ?>
                            <a href="#" onclick="return abre('nf_canc.php?acao=canc&id=<?php echo $res["id"]?>&pedido=<?php echo $res["pedido"]?>&cp=<?php echo $res["compra"]?>','a','width=320,height=200,scrollbars=1');" class="erp-table-action" title="Cancelar" style="color:#e74c3c;">
                                <i class="fas fa-times-circle"></i>
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

<?php if(isset($wpaginar) && $wpaginar) { ?>
    <div style="display:flex;justify-content:center;padding:20px;gap:5px;">
        <?php if($wp>1){ ?>
        <a href="nf.php?wp=<?php echo $pg_anterior?>&bde=<?php echo $bde?>&bate=<?php echo $bate?>&cliente=<?php echo $cliente?>&cliente_tipo=<?php echo $cliente_tipo?>&btipo=<?php echo $btipo?>&nome=<?php echo $nome?>&bnum=<?php echo $bnum?>" class="erp-btn erp-btn-outline erp-btn-sm">
            <i class="fas fa-chevron-left"></i> Anterior
        </a>
        <?php } ?>
        
        <span style="padding:8px 16px;background:#f0f0f0;border-radius:4px;">
            Pagina <?php echo $pg_atual?> de <?php echo $n_paginas?>
        </span>
        
        <?php if($reg_final<$results_tot){ ?>
        <a href="nf.php?wp=<?php echo $pg_proxima?>&bde=<?php echo $bde?>&bate=<?php echo $bate?>&cliente=<?php echo $cliente?>&cliente_tipo=<?php echo $cliente_tipo?>&btipo=<?php echo $btipo?>&nome=<?php echo $nome?>&bnum=<?php echo $bnum?>" class="erp-btn erp-btn-outline erp-btn-sm">
            Proximo <i class="fas fa-chevron-right"></i>
        </a>
        <?php } ?>
    </div>
<?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
