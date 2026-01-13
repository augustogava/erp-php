<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Cad Inst Medição";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

$sql=mysql_query("SELECT * FROM ins_medicao WHERE id='$id'");
$res=mysql_fetch_array($sql);
	
if($acao=="alt"){
	$tipo=$res["tipo"];
	$descricao=$res["descricao"];
	$inst_cali=$res["inst_cali"];
	$inst_util=$res["inst_util"];
	$org_cali=$res["org_cali"];
	$cad_med=$res["cad_med"];
	$tip_med=$res["tip_med"];
}
	
if($acao=="incluir"){
$tipo=strtoupper($tipo);

	$sql2=mysql_query("SELECT tipo FROM ins_medicao WHERE tipo='$tipo'");
		if(!mysql_num_rows($sql2)==0){
		$_SESSION["mensagem"]="O cadastro do Tipo de Instrumento não foi incluído. Digite outro Tipo para o Tipo de Instrumento, este já existe!";
		header("Location:metr_medg.php?acao=inc&tipo=$tipo&descricao=$descricao&inst_cali=$inst_cali&inst_util=$inst_util&org_cali=$org_cali&cad_med=$cad_med&tip_med=$tip_med");
		exit;		
	}

	$sql=mysql_query("INSERT INTO ins_medicao (tipo,descricao,inst_cali,inst_util,org_cali,cad_med,tip_med) VALUES ('$tipo','$descricao','$inst_cali','$inst_util','$org_cali','$cad_med', '$tip_med')");
	//print "INSERT INTO ins_medicao (tipo,descricao,inst_cali,inst_util,org_cali,cad_med,tip_med) VALUES ('$tipo','$descricao','$inst_cali','$inst_util','$org_cali','$cad_med', '$tip_med')";
	if($sql){
		$_SESSION["mensagem"]="Cadastro concluído!";
		// cria followup caso inclua 
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Tipo de Instrumento.','O usuário $quem1 incluiu um novo Tipo de Instrumento chamado $descricao.','$user')");
		//	
		header("Location:metr_cati.php");
		exit;
	}else{
		$_SESSION["mensagem"]="O cadastro não pôde ser concluído!";
		$acao="inc";
	}	
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE ins_medicao SET tipo='$tipo',descricao='$descricao', inst_cali='$inst_cali', inst_util='$inst_util', org_cali='$org_cali', cad_med='$cad_med', tip_med='$tip_med' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro de Instrumento alterado com sucesso!";
		// cria followup caso altere
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro do Tipo de Instrumento.','O usuário $quem1 alterou o cadastro do Tipo de Instrumento $descricao.','$user')");
		//			
		header("Location:metr_cati.php?desc=$desc&bnome=$bnome");
		exit;		
	}else{
		$_SESSION["mensagem"]="O cadastro não pôde ser alterado!";
		$acao="alt";
	}
}

?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function verifica(cad){
	if(cad.tipo.value==''){
		alert('Preencha o Tipo');
		cad.tipo.focus();
		return false;
	}
	if(cad.descricao.value==''){
		alert('Preencha a Descrição');
		cad.descricao.focus();
		return false;
	}
	if(cad.inst_cali2.value==''){
		alert('Selecione a Instrução de Calibração');
		cad.inst_cali2.focus();
		return false;
	}
	if(cad.inst_util2.value==''){
		alert('Selecione a Instrução de Utilização');
		cad.inst_util2.focus();
		return false;
	}
	if(cad.org_cali2.value==''){
		alert('Selecione o Órgão Calibrador');
		cad.org_cali2.focus();
		return false;
	}
	if(cad.tip_med.value==''){
		alert('Selecione a quantidade de Tipos de Medições');
		cad.tip_med.focus();
		return false;
	}
	return true;
}
</script>
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="432" border="0" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                <td width="405" align="right"><div align="left"><span class="textobold style1 style1 style1 style1">Cadastro de Tipo de Intrumento</span></div></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
</table>
<table width="423" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="421" height="238"><table width="70%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td>
            <table width="411" border="0" cellpadding="0" cellspacing="3">
			<form name="form1" method="post" action=""  id="form1" onSubmit="return verifica(this)">
              <tr class="textobold">
                <td>Tipo: </td>
                <td><input name="tipo" type="text" class="formulario" id="tipo" value="<? print $tipo; ?>" size="20" maxlength="25" <? if($acao=="alt") { ?> readonly="" <? } ?>></td>
              </tr>
              <tr class="textobold">
                <td width="145">Descri&ccedil;&atilde;o:</td>
                <td width="257"><input name="descricao" type="text" class="formulario" id="descricao" value="<? print $descricao; ?>" size="49" maxlength="100"></td>
              </tr>
              <tr class="textobold">
                <td>Instr. de Calibra&ccedil;&atilde;o:</td><? $sql2=mysql_query("SELECT metr_instr_desc FROM metrologia_instr WHERE metr_instr_id='$inst_cali'"); $res2=mysql_fetch_array($sql2);?>
                <td><input name="inst_cali2" type="text" class="formulario" id="inst_cali2" value="<?= $res2["metr_instr_desc"];?>" size="45" maxlength="100" readonly>
                  <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('metr_medg_instc.php','PPAP','width=520,height=280,scrollbars=1');"></a></td>
              </tr>
              <tr class="textobold">
                <td>Instr. de Utiliza&ccedil;&atilde;o:</td><? $sql3=mysql_query("SELECT metr_instr_desc FROM metrologia_instr WHERE metr_instr_id='$inst_util'"); $res3=mysql_fetch_array($sql3); ?>
                <td><input name="inst_util2" type="text" class="formulario" id="inst_util2" value="<?= $res3["metr_instr_desc"];?>" size="45" maxlength="100" readonly>
                <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('metr_medg_instu.php','PPAP','width=520,height=280,scrollbars=1');"></a></td>
              </tr>
              <tr class="textobold">
                <td>&Oacute;rg&atilde;o Calibrador:</td><? $sql4=mysql_query("SELECT metr_lab_fant FROM metrologia_lab WHERE metr_lab_id='$org_cali'"); $res4=mysql_fetch_array($sql4); ?>
                <td><input name="org_cali2" type="text" class="formulario" id="org_cali2" value="<?= $res4["metr_lab_fant"];?>" size="45" maxlength="100" readonly>
                  <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('metr_medg_orgc.php','PPAP','width=520,height=280,scrollbars=1');"></a></td>
              </tr>
              <tr class="textobold">
                <td>Cad. Medi&ccedil;&otilde;es:</td>
                <td><label>&nbsp;
                    <input name="cad_med" type="radio" value="S" <? if($cad_med=="S"){?>checked<? } ?>>                  
                  Sim
                &nbsp;&nbsp;&nbsp;&nbsp;
                  <input name="cad_med" type="radio" value="N" <? if($cad_med=="N"){?>checked<? } ?>>
N&atilde;o </label></td>
              </tr>
              <tr class="textobold">
                <td height="20">Tipos de Medi&ccedil;&otilde;es :</td>
                <td><label>
                  <select name="tip_med" class="formulario" id="tip_med">
                    <option value="1"<? if($tip_med=="1") print "selected";?>>1</option>
                    <option value="2"<? if($tip_med=="2") print "selected";?>>2</option>
                    <option value="3"<? if($tip_med=="3") print "selected";?>>3</option>
                    <option value="4"<? if($tip_med=="4") print "selected";?>>4</option>
                    <option value="5"<? if($tip_med=="5") print "selected";?>>5</option>
                    <option value="6"<? if($tip_med=="6") print "selected";?>>6</option>
                    <option value="7"<? if($tip_med=="7") print "selected";?>>7</option>
                    <option value="8"<? if($tip_med=="8") print "selected";?>>8</option>
                    <option value="9"<? if($tip_med=="9") print "selected";?>>9</option>
                    <option value="10"<? if($tip_med=="10") print "selected";?>>10</option>
                    <option value="11"<? if($tip_med=="11") print "selected";?>>11</option>
                    <option value="12"<? if($tip_med=="12") print "selected";?>>12</option>
                  </select>
                </label></td>
              </tr>
            </table>
          </td>
        </tr>
        </table>
      <table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
          <td><div align="center">
            <input name="acao" type="hidden" id="acao2" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">
            <input name="id" type="hidden" id="id" value="<? print $id; ?>">
            <input name="inst_cali" type="hidden" id="inst_cali" value="<? print $inst_cali; ?>">
            <input name="inst_util" type="hidden" id="inst_util" value="<? print $inst_util; ?>">
            <input name="org_cali" type="hidden" id="org_cali" value="<? print $org_cali; ?>">
            <input name="Voltar" type="button" class="microtxt" id="Voltar" onClick="window.location='metr_cati.php';" value="Voltar">
  &nbsp;&nbsp;&nbsp;&nbsp;
  <? if ($acao=="alt"){ ?>
  <input name="alterar" type="submit" class="microtxt" id="alterar" value="Alterar">
  <? } ?>
<? if($acao=="inc"){ ?>
<input name="incluir" type="submit" class="microtxt" id="incluir" value="Incluir">
<? } ?>
          </div></td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>