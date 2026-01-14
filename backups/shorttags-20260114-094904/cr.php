<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="CR";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="inc";
$block=false;
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM cr WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$cliente=$res["cliente"];
	$historico=$res["historico"];
	$cliente_tipo=$res["cliente_tipo"];
	$conta=$res["conta"];
	$parcelamento=$res["parcelamento"];
	$categoria=$res["categoria"];
	$documento=$res["documento"];
	$emissao=banco2data($res["emissao"]);
	$valor=banco2valor($res["valor"]);
	$valor2=$res["valor"];
	$saldo=banco2valor($res["saldo"]);
	$competencia=$res["competencia"];
	$fluxo=$res["fluxo"];
	$cartorio=$res["cartorio"];
	$cobranca=$res["cobranca"];
	$demonstrativo=$res["demonstrativo"];
	$sit=$res["sit"];
	if($cliente_tipo=="C"){
		$sql=mysql_query("SELECT nome FROM clientes WHERE id='$cliente'");
	}else{
		$sql=mysql_query("SELECT nome FROM fornecedores WHERE id='$cliente'");
	}
	$res=mysql_fetch_array($sql);
	$nome=$res["nome"];
	$sql=mysql_query("SELECT * FROM cr_itens WHERE conta='$id' and pago='S'");
	if(mysql_num_rows($sql)!=0 or $sit=="C"){
		$block=true;
	}
	$sqlb=mysql_query("SELECT * FROM cr_itens WHERE conta='$id' AND pago='N'");
	if(mysql_num_rows($sqlb)){
		$resb=mysql_fetch_array($sqlb);
		$banco=$resb["banco"];
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Contas a Receber - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<?php if($block){ ?>
<script>
function verifica(cad){
	<?php if($sit=="C"){ ?>
	alert('Esta conta foi cancelada');	
	<?php }else{ ?>
	alert('Este lancamento nao pode ser alterado pois ja existem duplicatas recebidas');	
	<?php } ?>
	return false
}
</script>
<?php }else{ ?>
<script>
function verifica(cad){
	if(cad.nome.value=='' || cad.cliente=='' || cad.cliente_tipo==''){
		alert('Escolha o cliente/fornecedor');
		return abre('cp_cli.php','a','width=320,height=300,scrollbars=1');
	}
	if(cad.documento.value==''){
		alert('Informe o documento');
		cad.documento.focus();
		return false;
	}
	if(cad.emissao.value==''){
		alert('Informe a data de emissao');
		cad.emissao.focus();
		return false;
	}else{
		if(!verifica_data(cad.emissao.value)){
			alert('Data de emissao incorreta');
			cad.emissao.focus();
			return false;
		}
	}
	if(cad.valor.value=='' || cad.valor.value=='0,00'){
		alert('Informe o valor');
		cad.valor.focus();
		return false;
	}
	if(cad.competencia.value==''){
		alert('Informe a competencia');
		cad.competencia.focus();
		return false;
	}
	if(cad.parcelamento[cad.parcelamento.selectedIndex].value==''){
		alert('Selecione a forma de parcelamento');
		cad.parcelamento.focus();
		return false;
	}
	return true;
}
</script>
<?php } ?>
</head>
<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-hand-holding-usd"></i> Contas a Receber</h1>
            <div style="display:flex;gap:8px;">
                <a href="cr_aberto.php" class="erp-btn erp-btn-outline">
                    <i class="fas fa-list"></i> CR Aberto
                </a>
            </div>
        </div>
    </div>

    <div class="erp-card">
        <div class="erp-card-header">
            <h3><i class="fas fa-edit"></i> <?php if($acao=="inc"){ echo "Incluir"; }else{ echo "Alterar"; } ?> Conta a Receber</h3>
        </div>
        <div class="erp-card-body">
            <form name="form1" method="post" action="cr_sql.php" onSubmit="return verifica(this);">
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Nome</label>
                            <div style="display:flex;gap:5px;">
                                <input name="nome" type="text" class="erp-form-control" value="<?=$nome?>" readonly style="flex:1;">
<?php if(!$block){ ?>
                                <a href="#" onclick="return abre('cp_cli.php','a','width=320,height=300,scrollbars=1');" class="erp-btn erp-btn-outline" style="padding:0 12px;">
                                    <i class="fas fa-search"></i>
                                </a>
<?php } ?>
                            </div>
                            <input name="cliente" type="hidden" value="<?=$cliente?>">
                            <input name="cliente_tipo" type="hidden" value="<?=$cliente_tipo?>">
                        </div>
                    </div>
                </div>
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Documento</label>
                            <input name="documento" type="text" class="erp-form-control" value="<?=$documento?>" maxlength="30" <?php if($block) echo "readonly"; ?>>
                        </div>
                    </div>
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Emissao</label>
                            <input name="emissao" type="text" class="erp-form-control" value="<?=$emissao?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" <?php if($block) echo "readonly"; ?>>
                        </div>
                    </div>
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Valor</label>
                            <input name="valor" type="text" class="erp-form-control" value="<?=$valor?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <?php if($block) echo "readonly"; ?>>
                        </div>
                    </div>
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Competencia</label>
                            <input name="competencia" type="text" class="erp-form-control" value="<?=$competencia?>" maxlength="7" onKeyPress="return validanum(this, event)" onKeyUp="mcomp(this)" <?php if($block) echo "readonly"; ?>>
                        </div>
                    </div>
                </div>
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Parcelamento</label>
                            <select name="parcelamento" class="erp-form-control">
                                <option value="" <?php if(empty($parcelamento)) echo "selected"; ?>>Selecione</option>
<?php
$sql=mysql_query("SELECT * FROM parcelamentos ORDER BY descricao ASC");
while($res=mysql_fetch_array($sql)){
?>
                                <option value="<?=$res["id"]?>" <?php if($parcelamento==$res["id"]) echo "selected"; ?>><?=$res["descricao"]?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Conta Contabil</label>
                            <select name="conta" class="erp-form-control">
                                <option value="0" <?php if(empty($conta)) echo "selected"; ?>>Selecione</option>
<?php
$sql=mysql_query("SELECT * FROM pcontas WHERE idpai!=0 ORDER BY descricao ASC");
while($res=mysql_fetch_array($sql)){
?>
                                <option value="<?=$res["id"]?>" <?php if($conta==$res["id"]) echo "selected"; ?>><?=$res["descricao"]?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Categoria</label>
                            <select name="categoria" class="erp-form-control">
                                <option value="0" <?php if(empty($categoria)) echo "selected"; ?>>Selecione</option>
<?php
$sql=mysql_query("SELECT * FROM categorias ORDER BY nome ASC");
while($res=mysql_fetch_array($sql)){
?>
                                <option value="<?=$res["id"]?>" <?php if($categoria==$res["id"]) echo "selected"; ?>><?=$res["nome"]?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Filial/Banco</label>
                            <select name="banco" class="erp-form-control">
<?php
$sqlo=mysql_query("SELECT * FROM bancos ORDER BY apelido ASC");
while($reso=mysql_fetch_array($sqlo)){
?>
                                <option value="<?=$reso["id"]?>" <?php if($reso["id"]==$banco) echo "selected"; ?>><?=$reso["apelido"]?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Historico</label>
                            <input name="historico" type="text" class="erp-form-control" value="<?=$historico?>" maxlength="100">
                        </div>
                    </div>
                </div>
                <div class="erp-row" style="margin-top:15px;">
                    <div class="erp-col">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input name="fluxo" type="checkbox" value="N" <?php if($fluxo=="N") echo "checked"; ?>>
                            Nao incluir no fluxo de caixa
                        </label>
                    </div>
                    <div class="erp-col">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input name="cartorio" type="checkbox" value="S" <?php if($cartorio=="S") echo "checked"; ?>>
                            Em cartorio
                        </label>
                    </div>
                    <div class="erp-col">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input name="cobranca" type="checkbox" value="S" <?php if($cobranca=="S") echo "checked"; ?>>
                            Em cobranca
                        </label>
                    </div>
                    <div class="erp-col">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input name="demonstrativo" type="checkbox" value="S" <?php if($demonstrativo=="S") echo "checked"; ?>>
                            Nao entra na demonstracao
                        </label>
                    </div>
                </div>

                <input name="acao" type="hidden" value="<?=$acao?>">
                <input name="id" type="hidden" value="<?=$id?>">

<?php if($acao=="inc"){ ?>
                <div style="margin-top:20px;display:flex;gap:10px;justify-content:center;">
                    <button type="submit" class="erp-btn erp-btn-primary">
                        <i class="fas fa-save"></i> Continuar
                    </button>
                </div>
<?php } ?>
            </form>

<?php if($acao=="alt"){ ?>
            <div class="erp-table-container" style="margin-top:30px;">
                <h4 style="margin-bottom:15px;"><i class="fas fa-list-alt"></i> Parcelas</h4>
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th width="100">Vencimento</th>
                            <th width="100" class="erp-text-right">Valor</th>
                            <th width="100">Recebimento</th>
                            <th width="100" class="erp-text-right">Diferenca</th>
                            <th width="100">Documento</th>
                            <th>Operacao</th>
                            <th>Conta</th>
                            <th width="60">REC</th>
                            <th width="60"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$sql=mysql_query("SELECT * FROM cr_itens WHERE conta='$id' ORDER BY vencimento ASC");
$tp=0;
$tp2=0;
while($res=mysql_fetch_array($sql)){
    if($res["pago"]=="S"){
        $tp+=$res["valor"]+$res["diferenca"];
        $tp2+=$res["valor"];
    }
    $sql1=mysql_query("SELECT * FROM bancos WHERE id='$res[banco]'");
    $banco_nome = mysql_num_rows($sql1) ? mysql_fetch_array($sql1)["apelido"] : "";
    $sql1=mysql_query("SELECT * FROM operacoes WHERE id='$res[operacao]'");
    $op = mysql_num_rows($sql1) ? mysql_fetch_array($sql1)["nome"] : "";
?>
                        <tr>
                            <td>
<?php if($res["pago"]=="S" and $sit!="C"){ echo banco2data($res["vencimento"]); }else{ ?>
                                <input name="vencimento[<?=$res["id"]?>]" type="text" class="erp-form-control" style="width:100px;" value="<?=banco2data($res["vencimento"])?>" maxlength="10" onkeypress="return validanum(this, event)" onKeyUp="mdata(this)">
<?php } ?>
                            </td>
                            <td class="erp-text-right"><?=banco2valor($res["valor"])?></td>
                            <td><?=banco2data($res["pagto"])?></td>
                            <td class="erp-text-right"><?=banco2valor($res["diferenca"])?></td>
                            <td><?=$res["documento"]?></td>
                            <td><?=$op?></td>
                            <td><?=$banco_nome?></td>
                            <td class="erp-text-center">
                                <a href="#" onclick="return abre('cr_hist.php?id=<?=$res["id"]?>','a','width=470,height=300,scrollbars=1');">
<?php if($res["pago"]=="N"){ ?>
                                    <span class="erp-badge erp-badge-warning">Nao</span>
<?php }else{ ?>
                                    <span class="erp-badge erp-badge-success">Sim</span>
<?php } ?>
                                </a>
                            </td>
                            <td class="erp-text-center">
<?php if($res["pago"]=="S" and $sit!="C"){ ?>
                                <a href="#" onclick="return pergunta('Deseja desfazer o recebimento desta parcela?','cr_sql.php?acao=desf&ct=<?=$id?>&id=<?=$res["id"]?>');" class="erp-table-action" style="color:#e74c3c;">
                                    <i class="fas fa-undo"></i>
                                </a>
<?php } ?>
                            </td>
                        </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:10px;">
                <a href="#" onclick="form1.acao.value='ven'; form1.submit(); return false;" class="erp-btn erp-btn-outline erp-btn-sm">
                    <i class="fas fa-calendar-alt"></i> Alterar datas de vencimento
                </a>
            </div>

            <div class="erp-table-container" style="margin-top:20px;">
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th>Parcelado</th>
                            <th>Total Recebido</th>
                            <th>Saldo</th>
                            <th>Situacao</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>R$ <?=$valor?></strong></td>
                            <td><strong>R$ <?=banco2valor($tp)?></strong></td>
                            <td><strong style="color:#27AE60;">R$ <?=banco2valor($valor2-$tp2)?></strong></td>
                            <td>
<?php 
$sit_class = "info";
$sit_text = "";
if($sit=="C"){ $sit_class="danger"; $sit_text="Cancelado"; }
elseif($sit=="P"){ $sit_class="warning"; $sit_text="Pendente"; }
elseif($sit=="Q"){ $sit_class="success"; $sit_text="Quitado"; }
?>
                                <span class="erp-badge erp-badge-<?=$sit_class?>"><?=$sit_text?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='cr_aberto.php'">
                    <i class="fas fa-arrow-left"></i> Voltar
                </button>
                <button type="button" class="erp-btn erp-btn-danger" onclick="return <?php if($sit=="C"){ echo "alert('Esta conta ja esta cancelada');"; }else{ echo "pergunta('Deseja cancelar esta conta?','cr_sql.php?acao=can&id=$id');"; } ?>">
                    <i class="fas fa-times"></i> Cancelar Conta
                </button>
                <button type="submit" form="form1" class="erp-btn erp-btn-primary">
                    <i class="fas fa-save"></i> Alterar
                </button>
            </div>
<?php } ?>
        </div>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
