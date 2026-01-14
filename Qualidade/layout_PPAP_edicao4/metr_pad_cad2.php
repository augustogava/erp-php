<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$id=Input::request("id");
$codi=Input::request("codi");
$desc=Input::request("desc");
$tipo=Input::request("tipo");
$unid=Input::request("unid");
$valn=Input::request("valn");
$tole=Input::request("tole");
$padu=Input::request("padu");
$numc=Input::request("numc");
$frec=Input::request("frec");
$datc=Input::request("datc");
$valc=Input::request("valc");
$incp=Input::request("incp");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Metrologia - Inc Padrão";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="incluir"){
$codi=strtoupper($codi);
$datc=data2banco($datc);
$valc=data2banco($valc);
	$sql2=mysql_query("SELECT metr_padr_codi FROM metrologia_pad WHERE metr_padr_codi='$codi'");
	if(!mysql_num_rows($sql2)==0){
		$_SESSION["mensagem"]="Digite outro código para o Padrão, este já existe!";
		header("Location:metr_lab_cad.php?acao=inc&codi=$codi&desc=$desc&tipo=$tipo&unid=$unid&valn=$valn&tole=$tole&padu=$padu&numc=$numc&frec=$frec&datc=$datc&valc=$valc&incp=$incp");
		exit;		
	}
	
	$sql=mysql_query("INSERT INTO metrologia_pad (metr_padr_codi, metr_padr_desc, metr_padr_tipo, metr_padr_unid, metr_padr_valn, metr_padr_tole, metr_padr_padu, metr_padr_numc, metr_padr_frec, metr_padr_datc, metr_padr_valc, metr_padr_incp) VALUES ('$codi', '$desc', '$tipo', '$unid', '$valn', '$tole', '$padu', '$numc', '$frec', '$datc', '$valc', '$incp')");
	if($sql){
		$_SESSION["mensagem"]="Padrão incluído com sucesso!";
		// cria followup caso inclua um padrão
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Padrão.','O usuário $quem1 incluiu um novo Padrão chamado $desc.','$user')");
		//	
		header("Location:metr_pad_busca.php");
		exit;
	}else{
		$_SESSION["mensagem"]="O Padrão não pôde ser incluído!";
	}
}

if($acao=="alterar"){
	$datc=data2banco($datc);
	$valc=data2banco($valc);
	$sql=mysql_query("UPDATE metrologia_pad SET metr_padr_codi='$codi', metr_padr_desc='$desc', metr_padr_tipo='$tipo', metr_padr_unid='$unid', metr_padr_valn='$valn', metr_padr_tole='$tole', metr_padr_padu='$padu', metr_padr_numc='$numc', metr_padr_frec='$frec', metr_padr_datc='$datc', metr_padr_valc='$valc' ,metr_padr_incp='$incp' WHERE metr_padr_id='$id'") or die ();
	if($sql){
		$_SESSION["mensagem"]="O Padrão foi alterado com sucesso!";
		// cria followup caso altere o padrão
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração de cadastro do Padrão.','O usuário $quem1 alterou o cadastro do Padrão $desc.','$user')");
		//	
		header("Location:metr_pad_busca.php");
		exit;		
	}else {
		$_SESSION["mensagem"]="O Padrão não pôde ser alterado!";
	}
}

$sql=mysql_query("SELECT * FROM metrologia_pad WHERE metr_padr_id='$id'");
$res=mysql_fetch_array($sql);

if($acao=="alt"){
$codi=$res["metr_padr_codi"];
$desc=$res["metr_padr_desc"];
$tipo=$res["metr_padr_tipo"];
$unid=$res["metr_padr_unid"];
$valn=$res["metr_padr_valn"];
$tole=$res["metr_padr_tole"];
$padu=$res["metr_padr_padu"];
$numc=$res["metr_padr_numc"];
$frec=$res["metr_padr_frec"];
$datc=banco2data($res["metr_padr_datc"]);
$valc=banco2data($res["metr_padr_valc"]);
$valc=$res["metr_padr_valc"];
$incp=$res["metr_padr_incp"];
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function verifica(cad){
	if(cad.codi.value==''){
		alert('Preencha o Código.');
		cad.codi.focus();
		return false;
	}
	if(cad.desc.value==''){
		alert('Preencha a Descrição.');
		cad.desc.focus();
		return false;
	}	
	if(cad.tipo.value==''){
		alert('Selecione o Tipo de Padrão Pto Ref.');
		return false;
	}
	if(cad.unid.value==''){
		alert('Preencha a Unidade.');
		return false;
	}
	if(cad.valn.value==''){
		alert('Preencha o Valor Nominal.');
		cad.valn.focus();
		return false;
	}
	if(cad.tole.value==''){
		alert('Preencha a Tolerância.');
		cad.tole.focus();
		return false;
	}
	if(cad.padu.value==''){
		alert('Preencha o Padrão Utilizado.');
		cad.padu.focus();
		return false;
	}
	if(cad.numc.value==''){
		alert('Preencha o Número de Certificado.');
		cad.numc.focus();
		return false;
	}
	if(cad.frec.value==''){
		alert('Preencha a Frequência de Calibração.');
		cad.frec.focus();
		return false;
	}
	if(cad.datc.value==''){
		alert('Preencha a Data da Calibração.');
		cad.datc.focus();
		return false;
	}
	if(cad.incp.value==''){
		alert('Preencha a Incert. Padrão.');
		cad.incp.focus();
		return false;
	}
	return true;
}


function validade(){
	var frec=parseInt(form1.frec.value);
	var data=form1.datc.value;
	var frecyear;
	var frecmonth;
	var frecday;

/*	while(frec>=365){
		frecyear++;
		frec-=365;
		while(frec>=30 && frec<=364){
			frecmonth++;
			frec-=30;
			while(frec<30){
				frecday=frec;
			}
		}	
	}
*/	
	var datastr= new String(data);
	var datastrday= datastr.substr(0,2);
	var datastrmonth= datastr.substr(3,2);
	var datastryear= datastr.substr(6,10);
	var dataintday= parseInt(datastrday);
	var dataintmonth= parseInt(datastrmonth-1);
	var dataintyear= parseInt(datastryear);
	//window.alert("dia"+dataintday+"mes"+dataintmonth+"ano"+dataintyear);
	
	var myDate=new Date();
	myDate.setDate(dataintday+frec); // dia
	myDate.setMonth(dataintmonth);   // mes
	myDate.setYear(dataintyear);	 // ano
//	window.alert(myDate);

	var datacompleta = new String(myDate);
	var printday = datacompleta.substring(8,10);
	printday= parseInt(printday);
	if (printday<10) printday="0"+printday;
	var printyear = datacompleta.substring(28,33);
	printyear=parseInt(printyear);
	var namemonth = datacompleta.substring(4,7);
	switch(namemonth){
		case "Jan":
			printmonth="01";
		break;
		case "Feb":
			printmonth="02";
		break;
		case "Mar":
			printmonth="03";
		break;
		case "Apr":
			printmonth="04";
		break;
		case "May":
			printmonth="05";
		break;
		case "Jun":
			printmonth="06";
		break;
		case "Jul":
			printmonth="07";
		break;
		case "Aug":
			printmonth="08";
		break;
		case "Sep":
			printmonth="09";
		break;
		case "Oct":
			printmonth="10";
		break;
		case "Nov":
			printmonth="11";
		break;
		case "Dec":
			printmonth="12";
		break;	
	}
	form1.valc.value=printday+"/"+printmonth+"/"+printyear;
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
<table width="490" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="425" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="texto">
      <tr>
        <td width="18" align="center"><div align="left"><a href="#" onClick=""><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver=""></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="407" align="right"><div align="left" class="textobold style1"><span class="titulos">Metrologia &gt; Cad. Padr&atilde;o / Pto Ref. </span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr> 
    <td width="490"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
      <table width="99%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="479" border="0" cellpadding="0" cellspacing="3">
            <tr>
              <td width="168" class="textobold">C&oacute;digo: </td>
              <td width="302"><span class="textobold">
                <input name="codi" type="text" class="formulario" id="codi" size="10" maxlength="10" value="<?php print $codi;?>" <?php if($acao=="alt"){ print "readonly"; } ?>>
              </span></td>
            </tr>
            <tr>
              <td class="textobold">Descri&ccedil;&atilde;o:</td>
              <td class="textobold"><input name="desc" type="text" class="formulario" id="desc" size="50" maxlength="50" value="<?php print $desc;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Tipo de Padr&atilde;o Pto Ref:</td>
              <td class="textobold"><label>
                <input name="tipo" type="radio" value="1" <?php if($tipo=="1") print "checked"; ?>>
                objetivo
                <input name="tipo" type="radio" value="2" <?php if($tipo=="2") print "checked"; ?>>
                subjetivo
                <input name="tipo" type="radio" value="3" <?php if($tipo=="3") print "checked"; ?>>
                atribuído</label></td>
            </tr>
            <tr>
              <td class="textobold">Unidade de Medida:</td>
              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
                <select name="unid" class="formulario" id="unid">
                  <option>Selecione</option>
				  <?php $sql4=mysql_query("SELECT * FROM unidades ORDER BY apelido");
				  while ($res4=mysql_fetch_array($sql4)){?>
			 	  <option value="<?php print $res4["id"];?>"<?php if($res4["id"]==$unid){ print "selected"; }?>><?php print $res4["apelido"];?></option>
				<?php } ?> 					
               </select>
              </font></td>
            </tr>
            <tr>
              <td class="textobold">Valor Nominal : </td>
              <td><input name="valn" type="text" class="formulario" id="valn" size="20" maxlength="20" value="<?php print $valn;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Toler&acirc;ncia:</td>
              <td><input name="tole" type="text" class="formulario" id="tole" size="20" maxlength="20" value="<?php print $tole;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Pad. Utilizado: </td>
              <td><input name="padu" type="text" class="formulario" id="padu" size="20" maxlength="20" value="<?php print $padu;?>"></td>
            </tr>
            <tr>
              <td class="textobold">N&uacute;m. de Certificado: </td>
              <td><input name="numc" type="text" class="formulario" id="numc" size="20" maxlength="20" value="<?php print $numc;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Freq. de Calibra&ccedil;&atilde;o (dias): </td>
              <td><input name="frec" type="text" class="formulario" id="frec" size="20" maxlength="20" value="<?php print $frec;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Data da Calibra&ccedil;&atilde;o:</td>
              <td><input name="datc" type="text" class="formulario" id="datc" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" onBlur="validade();" value="<?php print $datc;?>">&nbsp;&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=metr_pab_cad','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
            </tr>
            <tr>
              <td class="textobold">Validade da Calibra&ccedil;&atilde;o: </td>
              <td><input name="valc" type="text" class="formulario" id="valc" size="20" maxlength="20" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($valc);?>" readonly=""></td>
            </tr>
            <tr>
              <td class="textobold">Incert. Padr&atilde;o: </td>
              <td><input name="incp" type="text" class="formulario" id="incp" size="20" maxlength="20" value="<?php print $incp;?>"></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="73%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><span class="textobold">
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='metr_pad_busca.php';">
&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if ($acao=="alt"){ ?>
			<input name="Alterar" type="submit" class="microtxt" value="Alterar">
			<?php } ?>
			<?php if($acao=="inc"){ ?>
			<input name="Incluir" type="submit" class="microtxt" id="Incluir" value="Incluir">
			<?php } ?>
			<input type="hidden" name="acao" id="acao2"	value="<?php if($acao=="alt"){ print "alterar"; } else if($acao=="inc"){ print "incluir"; } ?>">
			<input type="hidden" name="id" value= <?php print $id;?>>
          </span></div></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>