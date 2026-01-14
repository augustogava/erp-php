<?php
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Mov. Estoque";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($buscar){
	unset($wp);
}
if(!empty($item)){
	$busca="WHERE prodserv='$item' ";
	$sql=mysql_query("SELECT nome,virtual FROM prodserv WHERE id='$item'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
		$bnome=$res["nome"];
	}
}
if(!empty($bde) and !empty($bate)){
	if($buscar){
		$bde=data2banco($bde);
		$bate=data2banco($bate);
	}
	$busca.="AND (data >= '$bde' AND data <= '$bate') ";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Movimentacao de Estoque - ERP System</title>
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
function verifica(bus){
	if(bus.nome.value=='' || bus.item.value==''){
		alert('Selecione o produto/servico');
		abre('prodserv_bus.php','busca','width=320,height=300,scrollbars=1');
		return false;
	}
	return true;
}
</script>
</head>
<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-boxes"></i> Movimentacao de Estoque</h1>
        </div>
    </div>

    <div class="erp-card">
        <form method="post" action="" name="form1" onSubmit="return verifica(this)">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Produto</label>
                        <div style="display:flex;gap:5px;">
                            <input name="nome" type="text" class="erp-form-control" value="<?php echo $bnome?>" readonly style="flex:1;">
                            <a href="#" onclick="return abre('prodserv_bus.php','busca','width=420,height=350,scrollbars=1');" class="erp-btn erp-btn-outline" style="padding:0 12px;">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                        <input name="item" type="hidden" value="<?php echo $item?>">
                        <input name="buscar" type="hidden" value="true">
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
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

<?php if(!empty($item)){ ?>
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="100">Data</th>
                    <th>Tipo</th>
                    <th width="100" class="erp-text-right">Qtd</th>
                    <th width="100" class="erp-text-right">Valor</th>
                    <th>Documento</th>
                    <th width="100">Origem</th>
                </tr>
            </thead>
            <tbody>
<?php
$sql=mysql_query("SELECT * FROM prodserv_est $busca ORDER BY id ASC");
if(mysql_num_rows($sql)==0){
?>
                <tr>
                    <td colspan="6" class="erp-text-center" style="padding:40px;">Nenhuma movimentacao encontrada</td>
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
        $sql=mysql_query("SELECT * FROM prodserv_est $busca ORDER BY id ASC LIMIT $param, $maxpag");
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
        $reg_final++;
        $origem = "";
        $tipo = "";
        $qtd = "";
        switch ($res["origem"]){
            case 1: $origem="Manual"; break;
            case 2: $origem="Ordem"; break;
            case 3: $origem="Nota"; break;
        }
        switch ($res["tipomov"]){
            case 1: $tipo="Entrada Manual"; $qtd=banco2valor($res["qtde"]); break;
            case 2: $tipo="Saida Temp."; $qtd=banco2valor($res["qtdd"]); break;
            case 3: $tipo="Estorno Entrada"; $qtd=banco2valor($res["qtds"]); break;
            case 4: $tipo="Estorno Saida"; $qtd=banco2valor($res["qtde"]); break;
            case 5: $tipo="Entrada"; $qtd=banco2valor($res["qtde"]); break;
            case 6: $tipo="Saida"; $qtd=banco2valor($res["qtds"]); break;
        }
        $tipo_class = (strpos($tipo, "Entrada") !== false || strpos($tipo, "Estorno Saida") !== false) ? "success" : "danger";
?>
                <tr>
                    <td><?php echo banco2data($res["data"])?></td>
                    <td><span class="erp-badge erp-badge-<?php echo $tipo_class?>"><?php echo $tipo?></span></td>
                    <td class="erp-text-right"><strong><?php echo $qtd?></strong></td>
                    <td class="erp-text-right">R$ <?php echo banco2valor($res["valor"])?></td>
                    <td><?php echo $res["doc"]?></td>
                    <td><?php echo $origem?></td>
                </tr>
<?php
    }
}
$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt, SUM(qtde-qtdd) AS qtdd, SUM((qtde-qtds)*valor) AS valort FROM prodserv_est WHERE prodserv='$item'");
$res1=mysql_fetch_array($sql1);
$qtdt=$res1["qtdt"];
$qtdd=$res1["qtdd"];
$valort=$res1["valort"];
?>
            </tbody>
        </table>
    </div>

    <div class="erp-row" style="margin-top:20px;">
        <div class="erp-col" style="flex:0 0 300px;">
            <div class="erp-card">
                <div class="erp-card-header">
                    <h4><i class="fas fa-info-circle"></i> Situacao Atual</h4>
                </div>
                <div class="erp-card-body">
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;">
                        <span>Quantidade</span>
                        <strong><?php echo banco2valor($qtdt)?></strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;">
                        <span>Qtd Disponivel</span>
                        <strong><?php echo banco2valor($qtdd)?></strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:8px 0;">
                        <span>Valor</span>
                        <strong style="color:#27AE60;">R$ <?php echo banco2valor($valort)?></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="erp-col">
            <div class="erp-card">
                <div class="erp-card-header">
                    <h4><i class="fas fa-cogs"></i> Acoes</h4>
                </div>
                <div class="erp-card-body">
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <a href="#" onclick="return abre('prodserv_ese.php?act=em&item=<?php echo $item?>','entrada','width=420,height=240,scrollbars=1');" class="erp-btn erp-btn-success">
                            <i class="fas fa-plus"></i> Entrada Manual
                        </a>
                        <a href="#" onclick="return abre('prodserv_ese.php?act=sm&item=<?php echo $item?>','saida','width=420,height=240,scrollbars=1');" class="erp-btn erp-btn-danger">
                            <i class="fas fa-minus"></i> Saida Manual
                        </a>
                        <a href="#" onclick="return abre('prodserv_ese.php?act=ee&item=<?php echo $item?>','eentrada','width=420,height=240,scrollbars=1');" class="erp-btn erp-btn-warning">
                            <i class="fas fa-undo"></i> Estorno Entrada
                        </a>
                        <a href="#" onclick="return abre('prodserv_ese.php?act=es&item=<?php echo $item?>','esaida','width=420,height=240,scrollbars=1');" class="erp-btn erp-btn-warning">
                            <i class="fas fa-redo"></i> Estorno Saida
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if(isset($wpaginar) && $wpaginar) { ?>
    <div style="display:flex;justify-content:center;padding:20px;gap:5px;">
        <?php if($wp>1){ ?>
        <a href="prodserv_est.php?wp=<?php echo $pg_anterior?>&item=<?php echo $item?>&bde=<?php echo $bde?>&bate=<?php echo $bate?>" class="erp-btn erp-btn-outline erp-btn-sm">
            <i class="fas fa-chevron-left"></i> Anterior
        </a>
        <?php } ?>
        <span style="padding:8px 16px;background:#f0f0f0;border-radius:4px;">
            Pagina <?php echo $pg_atual?> de <?php echo $n_paginas?>
        </span>
        <?php if($reg_final<$results_tot){ ?>
        <a href="prodserv_est.php?wp=<?php echo $pg_proxima?>&item=<?php echo $item?>&bde=<?php echo $bde?>&bate=<?php echo $bate?>" class="erp-btn erp-btn-outline erp-btn-sm">
            Proximo <i class="fas fa-chevron-right"></i>
        </a>
        <?php } ?>
    </div>
<?php } ?>

<?php }else{ ?>
    <div class="erp-card" style="max-width:300px;">
        <div class="erp-card-header">
            <h4><i class="fas fa-warehouse"></i> Situacao Atual do Estoque</h4>
        </div>
        <div class="erp-card-body">
<?php
$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt, SUM((qtde-qtds)*valor) AS valort FROM prodserv_est");
$res1=mysql_fetch_array($sql1);
$qtdt=$res1["qtdt"];
$valort=$res1["valort"];
?>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;">
                <span>Quantidade Total</span>
                <strong><?php echo banco2valor($qtdt)?></strong>
            </div>
            <div style="display:flex;justify-content:space-between;padding:8px 0;">
                <span>Valor Total</span>
                <strong style="color:#27AE60;">R$ <?php echo banco2valor($valort)?></strong>
            </div>
        </div>
    </div>
<?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
