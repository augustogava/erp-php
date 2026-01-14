<?php
include("conecta.php");
include("seguranca.php");
$wop=Input::request("wop") ?: $_SESSION["wop"];
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT apqp_fmeaproci.* FROM apqp_fmeaproci,apqp_fmeaproc WHERE apqp_fmeaproc.peca='$pc' AND apqp_fmeaproci.fmea=apqp_fmeaproc.id AND apqp_fmeaproci.item='$wop'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function verifica(){
	for(id in jslines){
		if(document.all['sev'+jslines[id]].value>10){
				alert('SEV não pode ser maior que 10 !!');
				document.all['sev'+jslines[id]].focus();
				return false;
		}else if(document.all['ocor'+jslines[id]].value>10){
				alert('Ocor não pode ser maior que 10 !!');
				document.all['ocor'+jslines[id]].focus();
				return false;
		}else if(document.all['det'+jslines[id]].value>10){
				alert('Det não pode ser maior que 10 !!');
				document.all['det'+jslines[id]].focus();
				return false;
		}else if(document.all['sev2'+jslines[id]].value>10){
				alert('SEV não pode ser maior que 10 !!');
				document.all['sev2'+jslines[id]].focus();
				return false;
		}else if(document.all['ocor2'+jslines[id]].value>10){
				alert('Ocor não pode ser maior que 10 !!');
				document.all['ocor2'+jslines[id]].focus();
				return false;
		}else if(document.all['det2'+jslines[id]].value>10){
				alert('Det não pode ser maior que 10 !!');
				document.all['det2'+jslines[id]].focus();
				return false;
		}else{
			if(document.all['sev'+jslines[id]].value>7 || document.all['npr'+jslines[id]].value>100){
				if(document.all['ar'+jslines[id]].value==''){
					alert('Informe as ações recomendadas para o modo de falha '+document.all['modo'+jslines[id]].value);
					document.all['ar'+jslines[id]].focus();
					return false;
				}
				if(document.all['resp'+jslines[id]].value==''){
					alert('Informe o responsável pelo modo de falha '+document.all['modo'+jslines[id]].value);
					document.all['resp'+jslines[id]].focus();
					return false;
				}
				if(!verifica_data(document.all['prazo'+jslines[id]].value)){
					alert('Informe corretamente o prazo para o modo de falha '+document.all['modo'+jslines[id]].value);
					document.all['prazo'+jslines[id]].focus();
					return false;
				}
			}
		}
	}
	frmcar.submit();
}
function calcula(ln){
	sev = document.all['sev'+ln].value;
	ocor = document.all['ocor'+ln].value;
	det = document.all['det'+ln].value;
	npr = sev*ocor*det;
	document.all['npr'+ln].value=npr;
}
function calcula2(ln){
	sev = document.all['sev2'+ln].value;
	ocor = document.all['ocor2'+ln].value;
	det = document.all['det2'+ln].value;
	npr = sev*ocor*det;
	document.all['npr2'+ln].value=npr;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<style type="text/css">
<!--
.style1 {color: #ffffff}
-->
</style>
</head>
<body>
<form name="frmcar" method="post" action="apqp_fmeaproc_sql.php?acao=altt">
 <table width="1100" border="1" cellpadding="3" cellspacing="0" bordercolor="#999999">
    <tr align="center" bgcolor="#003366" class="textoboldbranco">
      <td colspan="2" rowspan="2" bgcolor="#004993"><a href="#" class="textoboldbranco" onClick="MM_openBrWindow('manual/man_fmepr_mpfa.html','','width=680,height=551')">modo de falha potencial</a></td>
      <td rowspan="2" bgcolor="#004993"><a href="#" class="textoboldbranco" onClick="MM_openBrWindow('manual/man_fmepr_efpf.html','','width=680,height=551')">efeitos potenciais da falha</a></td>
      <td rowspan="2" bgcolor="#004993"><a href="#" class="textoboldbranco" onClick="MM_openBrWindow('manual/man_fmepr_sev.html','','width=680,height=551')">SEV</a></td>
      <td rowspan="2" bgcolor="#004993"><a href="#" class="textoboldbranco" onClick="MM_openBrWindow('manual/man_fmepr_class.html','','width=680,height=551')">C</a></td>
      <td rowspan="2" bgcolor="#004993"><a href="#" class="textoboldbranco" onClick="MM_openBrWindow('manual/man_fmepr_mcpf.html','','width=680,height=551')">causas / mecanismos potenciais de falha</a></td>
      <td rowspan="2" bgcolor="#004993"><a href="#" class="textoboldbranco" onClick="MM_openBrWindow('manual/man_fmepr_ocor.html','','width=680,height=551')">OCOR</a></td>
      <td bgcolor="#4871AD"><a href="#" class="style1" onClick="MM_openBrWindow('manual/man_fmepr_coap.html','','width=680,height=551')">controles atuais do processo</a></td>
      <td bgcolor="#4871AD"><a href="#" class="style1" onClick="MM_openBrWindow('manual/man_fmepr_coap.html','','width=680,height=551')">controles atuais do processo</a></td>
      <td rowspan="2" bgcolor="#004993"><a href="#" class="textoboldbranco" onClick="MM_openBrWindow('manual/man_fmepr_dete.html','','width=680,height=551')">DET</a></td>
      <td rowspan="2" bgcolor="#004993">NPR</td>
      <td rowspan="2" bgcolor="#004993"><a href="#" class="textoboldbranco" onClick="MM_openBrWindow('manual/man_fmepr_acor.html','','width=680,height=551')">a&ccedil;&otilde;es recomendadas</a></td>
      <td rowspan="2" bgcolor="#004993">respons&aacute;vel</td>
      <td rowspan="2" bgcolor="#004993">prazo</td>
      <td rowspan="2" bgcolor="#004993">a&ccedil;&otilde;es tomadas </td>
      <td rowspan="2" bgcolor="#004993">SEV</td>
      <td rowspan="2" bgcolor="#004993">OCOR</td>
      <td rowspan="2" bgcolor="#004993">DET</td>
      <td rowspan="2" bgcolor="#004993">NPR</td>
    </tr>
    <tr align="center" bgcolor="#003366" class="textoboldbranco">
      <td bgcolor="#004993">preven&ccedil;&atilde;o</td>
	  <td bgcolor="#004993">detec&ccedil;&atilde;o</td>
    </tr>
	
<?php
$sql=mysql_query("SELECT fmea1.* FROM apqp_fmeaproc AS fmea, apqp_fmeaproci AS fmea1 WHERE fmea.peca='$pc' AND fmea.id=fmea1.fmea AND fmea1.item='$wop' ORDER By fmea1.ordem,fmea1.id ASC ");
if(mysql_num_rows($sql)==0){
	$sql1=mysql_query("INSERT INTO apqp_fmeaproci (fmea,item) VALUES ('$rec[id]','$wop')");
}
	$salva=1;
	$jslines="<script>jslines = new Array(";
	while($res=mysql_fetch_array($sql)){
		$jslines.="'$res[id]',";
		
?>
<tr>
      <td width="20" align="center"><input name="del[<?php echo  $res["id"]; ?>]" type="checkbox" id="del[<?php echo  $res["id"]; ?>]" value="<?php echo  $res["id"]; ?>"></td>
      <td width="225"><input name="modo[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="modo<?php echo  $res["id"]; ?>" size="25" maxlength="255"  value="<?php echo  $res["modo"]; ?>"></td>
      <td width="225"><input name="efeitos[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="efeitos<?php echo  $res["id"]; ?>" size="25" maxlength="255"  value="<?php echo  $res["efeitos"]; ?>"></td>
      <td width="50"><input name="sev[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="sev<?php echo  $res["id"]; ?>" onkeypress="return validanum(this, event)" onkeyup="calcula(<?php echo  $res["id"]; ?>)" value="<?php echo  $res["sev"]; ?>" size="3" maxlength="2" cclass="formulario"></td>
      <td width="24" align="center"><a href="#"  onClick="return abre('apqp_simbolpopup.php?linha=<?php echo  $res["id"]; ?>','icones','width=520,height=280,scrollbars=1');"><img src="<?php if(empty($res["icone"])){ print "imagens/quad.gif"; }else{ print "apqp_fluxo/$res[icone].jpg"; }?>" name="simbol<?php echo  $res["id"]; ?>" width="20" height="20" border="0" id="simbol<?php echo  $res["id"]; ?>"></a><input name="simbolo[<?php echo  $res["id"]; ?>]" type="hidden" id="simbolo<?php echo  $res["id"]; ?>" value="<?php echo  $res["icone"]; ?>"></td>
      <td><input name="causa[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="causa<?php echo  $res["id"]; ?>" size="25" maxlength="255"  value="<?php echo  $res["causa"]; ?>"></td>
      <td width="50"><input name="ocor[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="ocor<?php echo  $res["id"]; ?>" size="3" maxlength="2" onkeypress="return validanum(this, event)" onkeyup="calcula(<?php echo  $res["id"]; ?>)" value="<?php echo  $res["ocor"]; ?>"></td>
      <td><input name="controle[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="controle<?php echo  $res["id"]; ?>" size="25" maxlength="255"  value="<?php echo  $res["controle"]; ?>"></td>
      <td><input name="controle2[<?php echo  $res["id"]; ?>]" type="text"class="formularioselectsemborda2222" id="controle2<?php echo  $res["id"]; ?>" size="25" maxlength="255"  value="<?php echo  $res["controle2"]; ?>"></td>
      <td width="50"><input name="det[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="det<?php echo  $res["id"]; ?>" size="3" maxlength="2" onkeypress="return validanum(this, event)" onkeyup="calcula(<?php echo  $res["id"]; ?>)" value="<?php echo  $res["det"]; ?>"></td>
      <td width="50"><input name="npr[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="npr<?php echo  $res["id"]; ?>" size="3" maxlength="3" onkeypress="return validanum(this, event)" onkeyup="calcula(<?php echo  $res["id"]; ?>)" value="<?php echo  $res["npr"]; ?>"></td>
      <td width="125"><input name="ar[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="ar<?php echo  $res["id"]; ?>" size="25" maxlength="255"  value="<?php echo  $res["ar"]; ?>"></td>
      <td width="125"><input name="resp[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="resp<?php echo  $res["id"]; ?>" size="10" maxlength="50"  value="<?php echo  $res["resp"]; ?>"></td>
      <td width="100"><input name="prazo[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="prazo<?php echo  $res["id"]; ?>" size="10" maxlength="10" onkeyup="mdata(this)" onkeypress="return validanum(this, event)"  value="<?php echo  banco2data($res["prazo"]); ?>"></td>
      <td width="125"><input name="at[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="at<?php echo  $res["id"]; ?>" size="25" maxlength="255"  value="<?php echo  $res["at"]; ?>"></td>
      <td width="50"><input name="sev2[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="sev2<?php echo  $res["id"]; ?>" size="3" maxlength="2" onkeypress="return validanum(this, event)" onkeyup="calcula2(<?php echo  $res["id"]; ?>)" value="<?php echo  $res["sev2"]; ?>"></td>
      <td width="50"><input name="ocor2[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="ocor2<?php echo  $res["id"]; ?>" size="3" maxlength="2" onkeypress="return validanum(this, event)" onkeyup="calcula2(<?php echo  $res["id"]; ?>)" value="<?php echo  $res["ocor2"]; ?>"></td>
      <td width="50"><input name="det2[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="det2<?php echo  $res["id"]; ?>" size="3" maxlength="2" onkeypress="return validanum(this, event)" onkeyup="calcula2(<?php echo  $res["id"]; ?>)" value="<?php echo  $res["det2"]; ?>"></td>
      <td width="85"><input name="npr2[<?php echo  $res["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="npr2<?php echo  $res["id"]; ?>" size="3" maxlength="6" onkeypress="return validanum(this, event)" onkeyup="calcula2(<?php echo  $res["id"]; ?>)" value="<?php echo  $res["npr2"]; ?>"></td>
    </tr>
<?php
	}
	$jslines=substr($jslines,0,strlen($jslines)-1);
	$jslines.=");</script>";
?><input name="salva" type="hidden" id="salva" value="<?php echo  $salva; ?>"><input name="maisum" type="hidden" id="maisum" value="0"><input name="delsel" type="hidden" id="delsel" value="0">
  </table>
</form>
</body>
</html>
<?php print $jslines; ?>
<?php include("mensagem.php"); ?>