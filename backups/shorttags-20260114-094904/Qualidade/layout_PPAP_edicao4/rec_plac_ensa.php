<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Recebimento - Inc Ensaio";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

$sql3=mysql_query("SELECT * FROM rec_plac WHERE id='$id3'");
$res3=mysql_fetch_array($sql3);

$sql=mysql_query("SELECT * FROM rec_rese WHERE id='$id'");
$res=mysql_fetch_array($sql);

if($acao=="alt"){
$sql4=mysql_query("SELECT * FROM unidades WHERE id='$res[unim]'");
$res4=mysql_fetch_array($sql4);
$sql5=mysql_query("SELECT * FROM ensaio WHERE id='$res[codens]'");
$res5=mysql_fetch_array($sql5);
$sql6=mysql_query("SELECT * FROM ins_medicao WHERE id='$res[tipi]'");
$res6=mysql_fetch_array($sql6);
$codens=$res5["descricao"];
$unim=$res4["apelido"];
$nomi=$res["nomi"];
$afi=banco2valor2($res["afi"]);
$afs=banco2valor2($res["afs"]);
$plaa=$res["plaa"];
$plan=$res["plan"];
$tipi=$res6["descricao"];
$nive=$res["nive"];
$meto=$res["meto"];
$obs=$res["obs"];
$id3=$res["cod_plac"];
$idcodens=$res["codens"];
$idunim=$res["unim"];
$idtipi=$res["tipi"];
}

$val1=valor2banco2($afi);
$val2=valor2banco2($afs);

if($acao=="incluir"){

	$sql2=mysql_query("SELECT codens FROM rec_rese WHERE codens='$idcodens' AND cod_plac='$id3'");
		if(!mysql_num_rows($sql2)==0){
		$_SESSION["mensagem"]="O cadastro do Ensaio não foi incluído. Selecione outro código para o Ensaio, este já foi cadastrado!";
		header("Location:rec_plac_ensa.php?acao=inc&id3=$id3&cod_plac=$id3&codens=$codens&idcodens=$idcodens&unim=$unim&idunim=$idunim&nomi=$nomi&afi=$val1&afs=$val2&plaa=$plaa&tipi=$tipi&idtipi=$idtipi&nive=$nive&meto=$meto&obs=$obs&fitn=$fitn&verf=$verf&descr=$descr");
		exit;		
	}
	
	$sql=mysql_query("INSERT INTO rec_rese (cod_plac, codens,unim,nomi,afi,afs,plaa,tipi,nive,meto,obs) VALUES ('$id3', '$idcodens', '$idunim', '$nomi', '$val1', '$val2', '$plaa', '$idtipi', '$nive', '$meto', '$obs')");
	if($sql){
		$_SESSION["mensagem"]="Ensaio incluído com sucesso!";
		// cria followup caso inclua
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,unimicao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Ensaio.','O usuário $quem1 incluiu um novo Ensaio do Recebimento chamado $codens.','$user')");
		//	
		header("Location:rec_plac_ensa.php?acao=inc&id3=$id3&fitn=$fitn&verf=$verf&descr=$descr");
		exit;
	}else{
		$_SESSION["mensagem"]="O Ensaio não pôde ser incluído!";
	}
}

if($acao=="alterar"){
	$sql=mysql_query("UPDATE rec_rese SET codens='$idcodens', unim='$idunim', tipi='$idtipi', nomi='$nomi', afi='$val1', afs='$val2', plaa='$plaa', nive='$nive', meto='$meto', obs='$obs' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="O Ensaio foi alterado com sucesso!";
		// cria followup caso altere
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro do Ensaio.','O usuário $quem1 alterou o cadastro do Ensaio do Recebimento chamado $codens.','$user')");
		//	
		header("Location:rec_plac_geral.php?acao=alt&id=$id3");
		exit;		
	}else {
		$_SESSION["mensagem"]="O Ensaio não pôde ser alterado!";
	}
}
if($acao=="exc"){
	// cria followup caso exclua 
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão de Ensaio do Recebimento.','O usuário $quem1 excluiu o Ensaio do Recebimento chamado $ensaio.','$user')");
	//	

	foreach($del as $key=>$valor){
	$sql=mysql_query("DELETE FROM rec_rese WHERE id='$key'");
	}
	if($sql){
		$_SESSION["mensagem"]="Ensaio excluído com sucesso";
		header("Location:rec_plac_ensa.php?acao=inc&id3=$id3&fitn=$fitn$&verf=$verf&descr=$descr");
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
	if(cad.codens.value==''){
		alert('Preencha o Código do Ensaio.');
		cad.codens.focus();
		return false;
	}
	if(cad.unim.value==''){
		alert('Preencha a Unidade de Medida.');
		cad.unim.focus();
		return false;
	}	
	if(cad.nomi.value==''){
		alert('Preencha o Nominal.');
		cad.nomi.focus();
		return false;
	}
	if(cad.afi.value==''){
		alert('Preencha o AFI.');
		cad.afi.focus();
		return false;
	}
	if(cad.afs.value==''){
		alert('Preencha o AFS.');
		cad.afs.focus();
		return false;
	}
	if(cad.tipi.value==''){
		alert('Preencha o Tipo de Instrumento.');
		cad.tipi.focus();
		return false;
	}
	if(cad.nive.value==''){
		alert('Preencha o Nível.');
		cad.nive.focus();
		return false;
	}
	if(cad.meto.value==''){
		alert('Preencha o Método.');
		cad.meto.focus();
		return false;
	}
	return true;
}
function diferenca(afi,afs){
		afi = form1.afi.value.replace(".","");
		afi = eval(form1.afi.value.replace(",","."));
		afs = form1.afs.value.replace(".","");
		afs = eval(form1.afs.value.replace(",","."));
	if(afs<afi){
		alert('O valor de AFS deve ser maior que o AFI. Verifique se os valores estão corretos.');
		cad.afi.focus();
	}
}	
function veri(){
	if(confirm("Deseja realmente excluir?")){
		return true;
	}
	return false;
}
function ask(wmsg,wmsg2,wsim){
	if(confirm(wmsg)){
			if(confirm(wmsg2)){
				window.location.href = wsim;
			}
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
    <td><table width="633" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="texto">
      <tr>
        <td width="16" align="center"><div align="left"><a href="#" onClick=""><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver=""></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="571" align="right"><div align="left" class="textobold style1"><span class="titulos">Plano de Controle Recebimento &gt; Ensaio </span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%" class="textobold">&nbsp;&nbsp;N&ordm; Plano de Controle / Rev: </td>
            <td width="76%"><span class="textobold">&nbsp;
              <input name="fitn" type="text" class="formulario" id="fitn" size="20" maxlength="20" value="<? print "$fitn / $verf"; ?>" readonly="">
            </span></td>
          </tr>

        </table></td>
        </tr>
      <tr>
        <td colspan="2" align="center"><table width="100%" border="0" cellspacing="6" cellpadding="0">
          <tr>
            <td width="24%" class="textobold">Descri&ccedil;&atilde;o: </td>
            <td width="76%"><span class="textobold">
              <input name="descr" type="text" class="formulario" id="descr" size="50" maxlength="50" value="<? print "$descr";?>" readonly="">
            </span></td>
          </tr>
        </table></td>
        </tr>
      
    </table></td>
  </tr>
  <tr> 
    <td width="828"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
      <table width="623" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td width="619"><table width="636" border="0" cellpadding="0" cellspacing="3">
            <tr>
              <td colspan="2" class="textobold">Ensaio</td>
              <td colspan="2" class="textobold">Unid. Medida </td>
              <td width="65" class="textobold">Nominal</td>
              <td width="65" class="textobold">AFI</td>
              <td width="65" class="textobold">AFS</td>
            </tr>
            <tr>
              <td colspan="2" class="textobold"><input name="idcodens" type="hidden" id="idcodens" value="<?=$idcodens;?>">
                <input name="codens" type="text" class="formulario" id="codens" size="31.5" maxlength="20" value="<? print $codens;?>" readonly="">
                <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('rec_plac_lise.php','PPAP','width=330,height=280,scrollbars=1');"></a></td>
              <td colspan="2" class="textobold"><input type="hidden" name="idunim" value="<?=$idunim;?>">
                <input name="unim" type="text" class="formulario" id="unim" size="10" maxlength="20" value="<? print $unim;?>" readonly="">
                <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('rec_plac_unid.php?campo=5','PPAP','width=330,height=280,scrollbars=1');"></a></td>
              <td class="textobold"><input name="nomi" type="text" class="formulario" id="nomi" size="10" maxlength="20" value="<? print $nomi;?>"></td>
              <td class="textobold"><input name="afi" type="text" class="formulario" id="afi" size="10" maxlength="20" onKeyDown="formataMoeda3(this,retornaKeyCode(event))" onKeyUp="formataMoeda3(this,retornaKeyCode(event))" value="<? print $afi;?>"></td>
              <td class="textobold"><input name="afs" type="text" class="formulario" id="afs" size="10" maxlength="20" onKeyDown="formataMoeda3(this,retornaKeyCode(event))" onKeyUp="formataMoeda3(this,retornaKeyCode(event))" value="<? print $afs;?>" onBlur="diferenca('$afi','$afs');"></td>
            </tr>
            <tr>
              <td width="108" class="textobold">&nbsp;</td>
              <td width="109" class="textobold">&nbsp;</td>
              <td width="109" class="textobold">&nbsp;</td>
              <td width="65" class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="textobold">Tipo de Instrumento </td>
              <td colspan="2" class="textobold">Pl. Amostragem</td>
              <td class="textobold">N&iacute;vel</td>
              <td colspan="2" class="textobold">M&eacute;todo</td>
              </tr>
            <tr>
              <td colspan="2" class="textobold"><input name="idtipi" type="hidden" id="idtipi" value="<?=$idtipi;?>">
                <input name="tipi" type="text" class="formulario" id="tipi" size="31.5" maxlength="20" value="<? print $tipi;?>" readonly="">
                <a href="#"><img src="imagens/icon_14img.gif" width="14" height="14" border="0" onClick="window.open('rec_plac_lisi.php?campo=7','PPAP','width=330,height=280,scrollbars=1');"></a></td>
              <td colspan="2" class="textobold"><input name="plaa" type="text" class="formulario" id="plaa" size="27" maxlength="20" value="<? print $plaa;?>"></td>
              <td class="textobold"><input name="nive" type="text" class="formulario" id="nive" size="10" maxlength="10" value="<? print $nive;?>"></td>
              <td colspan="2" class="textobold"><input name="meto" type="text" class="formulario" id="meto" size="27" maxlength="20" value="<? print $meto;?>"></td>
              </tr>
            <tr>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="textobold">OBS</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
              <td class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6"><span class="textobold">
                <textarea name="obs" cols="30" rows="2" class="formularioselect" id="obs" wrap="VIRTUAL" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $obs;?></textarea>
              </span></td>
              <td>&nbsp;</td>
              </tr>
          </table>            </td>
        </tr>
      </table>
      <table width="76%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><span class="textobold">
            <input name="Voltar" type="button" class="microtxt" id="Voltar" onClick="window.location='rec_plac_geral.php?acao=alt&id=<?=$id3;?>';" value="Voltar">
&nbsp;&nbsp;&nbsp;&nbsp;<? if($acao=="alt"){ ?> <input name="alterar" type="submit" class="microtxt" id="alterar" value="Alterar"><? } ?>
			<? if($acao=="inc"){ ?> <input name="incluir" type="submit" class="microtxt" id="incluir" value="Incluir Ensaio">
			<? } ?>
			<input type="hidden" name="acao" id="acao"	value="<? if($acao=="alt"){ print "alterar"; } else if($acao=="inc"){ print "incluir"; } ?>">
			<input type="hidden" name="id" value="<? print $id;?>">
			<input type="hidden" name="id3" value="<?=$id3;?>">
			<? if($acao=="inc"){ 
				$sql7=mysql_query("SELECT * FROM rec_rese WHERE cod_plac='$id3'");
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="finalizar" type="submit" class="microtxt" id="finalizar" value="Finalizar" 
			<? if(mysql_num_rows($sql7)==0){ ?>
			onClick="return ask2('É necessário incluir pelo menos um Ensaio para o Plano de Controle para finalizá-lo.','rec_plac_ensa.php?id3=<?=$id3;?>&acao=inc&fitn=<?=$fitn;?>&verf=<?=$verf;?>&descr=<?=$descr;?>')"
			<? }else{ ?>
			onClick="return ask('Deseja parar de incluir os Ensaios?','Caso alguns campos foram preenchido, os dados não serão armazenados.','rec_plac.php')"
			<? } ?>>
</span><? } ?></div></td>
        </tr>
      </table>
        <? if($acao!="alt") {?>
      <br><br><br>
    </form>
      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
        <tr class="textoboldbranco">
          <td width="30" align="center" class="textoboldbranco">&nbsp;</td>
          <td width="25" align="center">&nbsp;</td>
          <td width="85" align="center"><a href="apqp_car.php?acao=inc&ord=1&id=<? print $id; ?>" class="textoboldbranco">&nbsp;</a>Ensaio</td>
          <td width="95"><div align="center">Unid. de Medida </div></td>
          <td width="55"><div align="center">Nominal</div></td>
          <td width="55" align="center">AFI</td>
          <td width="55" align="center">AFS</td>
          <td width="56" align="center">Plano</td>
          <td width="55" align="center">N&iacute;vel</td>
          <td width="263" align="center">Obs.</td>
          </tr>
        <?
		$sql=mysql_query("SELECT * FROM rec_rese WHERE cod_plac='$id3'ORDER BY plaa");
		if(mysql_num_rows($sql)==0){
		?>
        <tr bgcolor="#FFFFFF">
          <td colspan="10" align="center" class="textopretobold">NENHUM ENSAIO CADASTRADO </td>
        </tr>
        <?
}else{ ?>
			<form name="frm3" action="" method="post">
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center" class="textobold"><input name="imageField" type="image" src="imagens/icon14_lixeira.gif" width="14" height="14" border="0" onClick="return veri();">
              <input name="id" type="hidden" id="id" value="<? print $id; ?>">
              <input name="acao" type="hidden" id="acao" value="exc"></td>
          <td colspan="9" align="center" class="textobold">&nbsp;</td>
        </tr>
        <?
	while($res=mysql_fetch_array($sql)){
		$sql4=mysql_query("SELECT * FROM unidades WHERE id='$res[unim]'");
		$res4=mysql_fetch_array($sql4);
		$sql5=mysql_query("SELECT * FROM ensaio WHERE id='$res[codens]'");
		$res5=mysql_fetch_array($sql5);
		$sql6=mysql_query("SELECT * FROM ins_medicao WHERE id='$res[tipi]'");
		$res6=mysql_fetch_array($sql6);
?>
        <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td width="30" align="center"><input type="checkbox" name="del[<? print $res["id"]; ?>]" value="checkbox"></td>
          <td width="25" align="center"><a href="rec_plac_ensa.php?acao=alt&id=<? print $res["id"]; ?>&fitn=<?=$fitn;?>&verf=<?=$verf;?>&descr=<?=$descr;?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="85" align="center">&nbsp;<? $ensaio= $res5["descricao"]; print "$ensaio";?></td>
          <td align="center"><? print $res4["apelido"]; ?></td>
          <td width="55" align="center"><? print $res["nomi"]; ?></td>
          <td width="55" align="center"><? print banco2valor2($res["afi"]);?></td>
          <td width="55" align="center"><? print banco2valor2($res["afs"]);?></td>
          <td width="56" align="center"><? print $res["plaa"];?></td>
          <td width="55" align="center"><? print $res["nive"]; ?></td>
          <td align="left">&nbsp;<? print $res["obs"]; ?></td>
          </tr>
        <?
	} ?>
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center" class="textobold"><input name="imageField" type="image" src="imagens/icon14_lixeira.gif" width="14" height="14" border="0" onClick="return veri();">          </td>
          <td colspan="9" align="center" class="textobold">&nbsp;</td>
        </tr>
		</form>
        <? }  // apqp_car.php?>
      </table>
	  <a href="#top" class="textobold">Top</a></p></td>
  </tr>
</table><? } ?>
</body>
</html>
<? include("mensagem.php"); ?>