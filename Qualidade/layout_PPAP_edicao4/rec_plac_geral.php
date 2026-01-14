<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Recebimento - Pl. Controle";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

$sql=mysql_query("SELECT * FROM rec_plac WHERE id='$id'");
$res=mysql_fetch_array($sql);


if($acao=="alt"){
$sql3=mysql_query("SELECT * FROM unidades WHERE id='$res[unie1]'");
$res3=mysql_fetch_array($sql3);
$sql4=mysql_query("SELECT * FROM unidades WHERE id='$res[unie2]'");
$res4=mysql_fetch_array($sql4);
$sql5=mysql_query("SELECT * FROM unidades WHERE id='$res[unia1]'");
$res5=mysql_fetch_array($sql5);
$sql6=mysql_query("SELECT * FROM unidades WHERE id='$res[unia2]'");
$res6=mysql_fetch_array($sql6);
$id=$res["id"];
$fitn=$res["fitn"];
$verf=$res["verf"];
$descr=$res["descr"];
$apli=$res["apli"];
$ndes=$res["ndes"];
$dvig=banco2data($res["dvig"]);
$ddes=banco2data($res["ddes"]);
$revd=$res["revd"];
$ptol=$res["ptol"];
$doco=$res["doco"];
$shel=$res["shel"];
$unie1=$res3["apelido"];
$unie2=$res4["apelido"];
$unia1=$res5["apelido"];
$unia2=$res6["apelido"];
$idunie1=$res["unie1"];
$idunie2=$res["unie2"];
$idunia1=$res["unia1"];
$idunia2=$res["unia2"];
$fatc1=$res["fatc1"];
$fatc2=$res["fatc2"];
}

$data2=data2banco($dvig);
$data3=data2banco($ddes);

if($acao=="incluir"){
$fitn=strtoupper($fitn);

	$sql2=mysql_query("SELECT fitn FROM rec_plac WHERE fitn='$fitn'");
		if(!mysql_num_rows($sql2)==0){
		$_SESSION["mensagem"]="O cadastro do Plano de Controle não foi incluído. Digite outro número para o Plano de Controle, este já existe!";
		header("Location:rec_plac_geral.php?acao=inc&verf=$verf&descr=$descr&apli=$apli&ndes=$ndes&dvig=$dvig&ddes=$ddes&revd=$revd&ptol=$ptol&doco=$doco&shel=$shel&unie1=$unie1&idunie1=$idunie1&unie2=$unie2&idunie2=$idunie2&unia1=$unia1&idunia1=$idunia1&unia2=$unia2&idunia2=$idunia2&fatc1=$fatc1&fatc2=$fatc2&fitn=$fitn&id3=$id3");
		exit;		
	}
	
	$sql=mysql_query("INSERT INTO rec_plac (fitn,verf,descr,apli,ndes,dvig,ddes,revd,ptol,doco,shel,unie1,unie2,unia1,unia2,fatc1,fatc2) VALUES ('$fitn', '$verf', '$descr', '$apli', '$ndes', '$data2', '$data3', '$revd', '$ptol', '$doco', '$shel', '$idunie1', '$idunie2', '$idunia1', '$idunia2', '$fatc1', '$fatc2')");
	if($sql){
//		$_SESSION["mensagem"]="Plano de Controle incluído com sucesso!";
		// cria followup caso inclua
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Plano de Controle.','O usuário $quem1 incluiu um novo Plano de Controle chamado $descr.','$user')");
		$getid=mysql_query("SELECT id FROM rec_plac WHERE fitn='$fitn'");
		$resid=mysql_fetch_array($getid);
		header("Location:rec_plac_ensa.php?id3=$resid[id]&acao=inc&fitn=$fitn&verf=$verf&descr=$descr");
		exit;
	}else{
		$_SESSION["mensagem"]="O Plano de Controle não pôde ser incluído!";
	}
}

if($acao=="alterar"){
	$sql=mysql_query("UPDATE rec_plac SET fitn='$fitn', verf='$verf', descr='$descr', apli='$apli', ndes='$ndes', dvig='$data2', ddes='$data3', revd='$revd', ptol='$ptol', doco='$doco', shel='$shel', unie1='$idunie1', unie2='$idunie2', unia1='$idunia1', unia2='$idunia2', fatc1='$fatc1', fatc2='$fatc2' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="O Plano de Controle foi alterado com sucesso!";
		// cria followup caso altere
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro do Plano de Controle.','O usuário $quem1 alterou o cadastro do Plano de Controle chamado $descr.','$user')");
		//	
		$sql7=mysql_query("SELECT * FROM rec_rese WHERE cod_plac='$id'");
//		$res7=mysql_num_rows($sql7);
//		if($res7!=0){
		if(mysql_fetch_array($sql7)){
			header("Location:rec_plac.php");
		}else{
			$_SESSION["mensagem"]="O sistema não encontrou nenhum Ensaio cadastrado. Por favor, clique no botão Incluir Ensaio para cadastrá-lo.";
			header("Location:rec_plac_geral.php?acao=alt&id=$id");	
		}
		exit;		
	}else {
		$_SESSION["mensagem"]="O Plano de Controle não pôde ser alterado!";
	}
}
if($acao=="exc"){
$fitn=$res["fitn"];
$verf=$res["verf"];
$descr=$res["descr"];
	// cria followup caso exclua 
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão de Ensaio do Recebimento.','O usuário $quem1 excluiu o Ensaio do Recebimento $ensaio.','$user')");
	//	

	foreach($del as $key=>$valor){
	$sql=mysql_query("DELETE FROM rec_rese WHERE id='$key'");
	}
	if($sql){
		$_SESSION["mensagem"]="Ensaio excluído com sucesso";
		$sql3=mysql_query("SELECT * FROM rec_rese WHERE cod_plac='$id'");
		if(mysql_fetch_array($sql3)){
			header("Location:rec_plac_geral.php");
		}else{
			header("Location:rec_plac_ensa.php?acao=inc&id3=$id&fitn=$fitn&verf=$verf&descr=$descr");
		}
	}else{
		$_SESSION["mensagem"]="O Ensaio não pôde ser excluído";
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
	if(cad.fitn.value==''){
		alert('Preencha o Número do Plano de Controle.');
		cad.fitn.focus();
		return false;
	}
	if(cad.verf.value==''){
		alert('Preencha a Revisão do Plano de Controle.');
		cad.verf.focus();
		return false;
	}	
	if(cad.desc.value==''){
		alert('Preencha a Descrição.');
		cad.desc.focus();
		return false;
	}
	return true;
}
function veri(){
	if(confirm("Deseja realmente excluir?")){
		return true;
	}
	return false;
}
function ask2(wmsg,wsim){
	if(confirm(wmsg)){
		window.location.href = wsim;
	}
	return false;
}

</script>
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="845" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="406" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="texto">
      <tr>
        <td width="16" align="center"><div align="left"><a href="#" onClick=""><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver=""></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="344" align="right"><div align="left" class="textobold style1"><span class="titulos">Recebimento &gt; Plano de Controle &gt; Cadastro </span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr> 
    <td width="845"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
      <table width="84" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="702" border="0" cellpadding="0" cellspacing="3">
            <tr>
              <td width="143" class="textobold">N&ordm; Plano de Controle: </td>
              <td width="277"><table width="108%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="31%"><span class="textobold">
                      <input name="fitn" type="text" class="formulario" id="fitn" size="10" maxlength="10" value="<?php print $fitn;?>" <?php if($acao=="alt"){ print "readonly"; } ?>>
                    </span></td>
                    <td width="36%" class="textobold"><div align="center">Rev :</div></td>
                    <td width="33%" class="textobold"><input name="verf" type="text" class="formulario" id="verf" size="10" maxlength="3" value="<?php print $verf;?>">
                      &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=metr_lab_cad','','scrollbars=no,width=155,height=138');"></a></td>
                  </tr>
              </table></td>
              <td class="textobold">&nbsp;&nbsp;&nbsp;Unidade de Entrega 1: </td>
              <td class="textobold"><input type="hidden" name="idunie1" value="<?php echo $idunie1;?>">
                <input name="unie1" type="text" class="formulario" id="unie1" size="10" maxlength="20" value="<?php print $unie1;?>" readonly="">
                <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('rec_plac_unid.php?campo=1','PPAP','width=330,height=280,scrollbars=1');"> </a></td>
            </tr>
            <tr>
              <td class="textobold">Descri&ccedil;&atilde;o:</td>
              <td class="textobold"><input name="descr" type="text" class="formulario" id="descr" size="50" maxlength="50" value="<?php print $descr;?>"></td>
              <td class="textobold">&nbsp;&nbsp;&nbsp;Unidade de Amostragem 1:</td>
              <td class="textobold"><input type="hidden" name="idunia1" value="<?php echo $idunia1;?>">
                <input name="unia1" type="text" class="formulario" id="unia1" size="10" maxlength="20" value="<?php print $unia1;?>" readonly="">
                <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('rec_plac_unid.php?campo=3','PPAP','width=330,height=280,scrollbars=1');">                </a></td>
            </tr>
            <tr>
              <td class="textobold">Aplica&ccedil;&atilde;o:</td>
              <td class="textobold"><input name="apli" type="text" class="formulario" id="apli" size="50" maxlength="50" value="<?php print $apli;?>"></td>
              <td class="textobold">&nbsp;&nbsp;&nbsp;Fator p/ calculo do lote 1: </td>
              <td class="textobold"><input name="fatc1" type="text" class="formulario" id="fatc1" size="10" maxlength="20" value="<?php print $fatc1;?>"></td>
            </tr>
            <tr>
              <td class="textobold">N&ordm; do Desenho:</td>
              <td><input name="ndes" type="text" class="formulario" id="ndes" size="50" maxlength="20" value="<?php print $ndes;?>"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td class="textobold">Em vig&ecirc;ncia ap&oacute;s: </td>
              <td><table width="108%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="34%"><span class="textobold">
                      <input name="dvig" type="text" class="formulario" id="dvig" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print $dvig;?>">
                    <a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_fiti_geral_1&var_field=dvig','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></span></td>
                    <td width="34%" class="textobold"><div align="left">&nbsp;&nbsp;Data</div></td>
                    <td width="32%" class="textobold">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=metr_lab_cad','','scrollbars=no,width=155,height=138');"></a></td>
                  </tr>
              </table></td>
              <td width="161" class="textobold">&nbsp;&nbsp;&nbsp;Unidade de Entrega 2: </td>
              <td width="106"><input type="hidden" name="idunie2" value="<?php echo $idunie2;?>">
                <input name="unie2" type="text" class="formulario" id="unie2" size="10" maxlength="20" value="<?php print $unie2;?>" readonly="">
                <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('rec_plac_unid.php?campo=2','PPAP','width=330,height=280,scrollbars=1');">                </a></td>
            </tr>
            <tr>
              <td class="textobold">Data do Desenho:</td>
              <td><table width="108%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="34%"><span class="textobold">
                      <input name="ddes" type="text" class="formulario" id="ddes" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print $ddes;?>">
                    <a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_fiti_geral_2&var_field=ddes','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></span></td>
                    <td width="32%" class="textobold"><div align="center">Rev :</div></td>
                    <td width="34%" class="textobold"><input name="revd" type="text" class="formulario" id="revd" size="10" maxlength="3" value="<?php print $revd;?>">
                      &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=metr_lab_cad','','scrollbars=no,width=155,height=138');"></a></td>
                  </tr>
              </table></td>
              <td class="textobold">&nbsp;&nbsp;&nbsp;Unidade de Amostragem 2:</td>
              <td><input type="hidden" name="idunia2" value="<?php echo $idunia2;?>">
                <input name="unia2" type="text" class="formulario" id="unia2" size="10" maxlength="20" value="<?php print $unia2;?>" readonly="">
                <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('rec_plac_unid.php?campo=4','PPAP','width=330,height=280,scrollbars=1');">                </a></td>
            </tr>
            <tr>
              <td class="textobold">% de Toler&acirc;ncia: </td>
              <td><input name="ptol" type="text" class="formulario" id="ptol" size="10" maxlength="3" value="<?php print $ptol;?>"></td>
              <td class="textobold">&nbsp;&nbsp;&nbsp;Fator p/ calculo do lote 2:</td>
              <td><input name="fatc2" type="text" class="formulario" id="fatc2" size="10" maxlength="20" value="<?php print $fatc2;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Documento obrigat&oacute;rio: </td>
              <td><label class="textobold">
                <input name="doco" type="radio" value="S" <?php if($doco=="S") print "checked"; ?>>
                Sim
  <input name="doco" type="radio" value="N" <?php if($doco=="N") print "checked"; ?>>
                N&atilde;o</label></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td class="textobold">Shelf-Fire:</td>
              <td><input name="shel" type="text" class="formulario" id="shel" size="20" maxlength="5" value="<?php print $shel;?>">
                  <span class="textobold">&nbsp;&nbsp;N&ordm; Dias</span> </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
          </table>
            </td>
        </tr>
      </table>
      <table width="83%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><span class="textobold">
		  <?php $sql8=mysql_query("SELECT * FROM rec_rese WHERE cod_plac='$id'");
		  	 $sql9=mysql_query("SELECT * FROM rec_plac WHERE id='$id'");?>
            <input name="Voltar" type="button" class="microtxt" id="Voltar" <?php if((mysql_num_rows($sql8)==0) && (mysql_num_rows($sql9)!=0)){?> onClick="return ask2('É necessário incluir pelo menos um Ensaio para finalizar o Plano de Controle. Por favor, clique no botão Incluir Ensaio para cadastrá-lo.','rec_plac_geral.php?id=<?php echo $id;?>&acao=alt')" <?php } else { ?> onClick="window.location='rec_plac.php';"<?php } ?> value="Voltar">
&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if ($acao=="alt"){ ?>
			<input name="Alterar" type="submit" class="microtxt" value="Alterar">
			<?php } ?>
			<?php if($acao=="inc"){ ?>
			<input name="Incluir" type="submit" class="microtxt" id="Incluir" value="Incluir">
			<?php } ?>
			<input type="hidden" name="acao" id="acao"	value="<?php if($acao=="alt"){ print "alterar"; } else if($acao=="inc"){ print "incluir"; } ?>">
			<input type="hidden" name="id" value="<?php print $id;?>">
&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($acao!="inc"){ ?>
<input name="ensaio" type="button" class="microtxt" id="ensaio" value="Incluir Ensaio" onClick="window.location='rec_plac_ensa.php?id3=<?php echo $res["id"];?>&acao=inc&fitn=<?php echo $fitn;?>&verf=<?php echo $verf;?>&descr=<?php echo $descr;?>';">
</span><span class="textobold">
<?php } ?>
</span></div></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
        <tr class="textoboldbranco">
          <td width="30" align="center" class="textoboldbranco">&nbsp;</td>
          <td width="25" align="center">&nbsp;</td>
          <td width="85" align="center"><a href="apqp_car.php?acao=inc&ord=1&id=<?php print $id; ?>" class="textoboldbranco">&nbsp;</a>Ensaio</td>
          <td width="95"><div align="center">Unid. de Medida </div></td>
          <td width="55"><div align="center">Nominal</div></td>
          <td width="55" align="center">AFI</td>
          <td width="55" align="center">AFS</td>
          <td width="56" align="center">Plano</td>
          <td width="55" align="center">N&iacute;vel</td>
          <td width="263" align="center">Obs.</td>
          </tr>
        <?php
		$sql=mysql_query("SELECT * FROM rec_rese WHERE cod_plac='$id' ORDER BY plaa");
		if(mysql_num_rows($sql)==0){
		?>
        <tr bgcolor="#FFFFFF">
          <td colspan="10" align="center" class="textopretobold">NENHUM ENSAIO CADASTRADO </td>
        </tr>
        <?php
}else{ ?>
			<form name="frm3" action="" method="post">
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center" class="textobold"><input name="imageField" type="image" src="imagens/icon14_lixeira.gif" width="14" height="14" border="0" onClick="return veri();">
              <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
              <input name="acao" type="hidden" id="acao" value="exc"></td>
          <td colspan="9" align="center" class="textobold">&nbsp;</td>
        </tr>
        <?php
	while($res=mysql_fetch_array($sql)){
		$sql4=mysql_query("SELECT * FROM unidades WHERE id='$res[unim]'");
		$res4=mysql_fetch_array($sql4);
		$sql5=mysql_query("SELECT * FROM ensaio WHERE id='$res[codens]'");
		$res5=mysql_fetch_array($sql5);
		$sql6=mysql_query("SELECT * FROM ins_medicao WHERE id='$res[tipi]'");
		$res6=mysql_fetch_array($sql6);
?>
        <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td width="30" align="center"><input type="checkbox" name="del[<?php print $res["id"]; ?>]" value="checkbox"></td>
          <td width="25" align="center"><a href="rec_plac_ensa.php?acao=alt&id=<?php print $res["id"]; ?>&fitn=<?php echo $fitn;?>&verf=<?php echo $verf;?>&descr=<?php echo $descr;?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="85" align="center">&nbsp;<?php print $res5["descricao"]; ?></td>
          <td align="center"><?php print $res4["apelido"]; ?></td>
          <td width="55" align="center"><?php print $res["nomi"]; ?></td>
          <td width="55" align="center"><?php print banco2valor2($res["afi"]);?></td>
          <td width="55" align="center"><?php print banco2valor2($res["afs"]);?></td>
          <td width="56" align="center"><?php print $res["plaa"];?></td>
          <td width="55" align="center"><?php print $res["nive"]; ?></td>
          <td align="left">&nbsp;<?php print $res["obs"]; ?></td>
          </tr>
        <?php
	} ?>
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center" class="textobold"><input name="imageField" type="image" src="imagens/icon14_lixeira.gif" width="14" height="14" border="0" onClick="return veri();">          </td>
          <td colspan="9" align="center" class="textobold">&nbsp;</td>
        </tr>
		</form>
        <?php } ?>
      </table>
      <a href="#top" class="textobold">Top</a>
    </td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>