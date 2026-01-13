<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sqlc=mysql_query("SELECT * FROM apqp_car WHERE id='$car'");
if(mysql_num_rows($sqlc)) $resc=mysql_fetch_array($sqlc);
$sql=mysql_query("SELECT * FROM apqp_cap WHERE peca='$pc' AND car='$car'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	$sql=mysql_query("INSERT INTO apqp_cap (peca,car) VALUES ('$pc','$car')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM apqp_cap");
	$res=mysql_fetch_array($sql);
}
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de Capabilidade'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Dimensional'");
			if(!mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){  }else{ return false; }";
			}else{
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){   }else{ return false; }";
			}
		}else{
			$sqlc=mysql_query("SELECT * FROM apqp_car WHERE id='$car' AND quem_cap<>''");
			if(mysql_num_rows($sqlc)){
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){  }else{ return false; }";
			}
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.submit(); }else{ return false; } }else{ return false; }";

	}
$id=$res["id"];
if(empty($digitos)){ $digitos=$res["digitos"]; }
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--
function verifica(cad){
	for(i=1;i<form1.nli.value*5;i++){
		if(document.all['a'+i].value=='0.'){
			alert('Os valores não podem ser ZERO');
			cad.a1.focus();
			return false;
		}
	}
}
function linha(){
	for(i=125;i>=1;i--){
		document.all['a'+i].disabled=false;
	}
	for(i=125;i>form1.nli.value*5;i--){
		document.all['a'+i].disabled=true;
	}
	for(e=25;e>=1;e--){
		document.all['media'+e].disabled=false;
		document.all['amplitude'+e].disabled=false;
	}
	for(e=25;e>form1.nli.value;e--){
		document.all['media'+e].disabled=true;
		document.all['amplitude'+e].disabled=true;
	}
}
function digitos(){
window.location='apqp_cap2.php?car=<? print $car; ?>&digitos='+form1.ndi.value;
}

function digitos2(digit,obj,media){
	strdigit = new String("");
	var i=1;
	var nume1=document.all[obj].value;
	var ponto=nume1.indexOf('.');
	var ponto2=nume1.indexOf(',');
	var pontop=ponto+1;
	var pontop2=ponto2+1;
if((ponto != -1)){ 
	var nume=document.all[obj].value.length-pontop;
	if(nume>digit){
		var part1=nume1.substr(0,1);
		var part2=nume1.substr(2,digit);
		document.all[obj].value=part1+'.'+part2;
	}else{
		while(nume<digit){
			strdigit+='0';
		nume++;
		}
	}
}else if((ponto2 != -1)){
	var nume=document.all[obj].value.length-pontop2;
	if(nume>digit){
		var part1=nume1.substr(0,1);
		var part2=nume1.substr(2,digit);
		document.all[obj].value=part1+'.'+part2;
	}else{
		while(nume<digit){
			strdigit+='0';
		nume++;
		}
	}
}
	if(nume1.substr(1,1)==','){
		var part1=nume1.substr(0,1);
		var part2=nume1.substr(2,digit);
		var part3=part1+'.'+part2;
		
		document.all[obj].value=part3+strdigit;
	}else{
		document.all[obj].value+=strdigit;
	}
	//Médiaaaasss - - - - -
	total=0;
	md=0;
	dado = new Array(5);
	b=1;
	for(e=media-4;e<=media;e++){
		dado[b]=document.all['a'+e].value;
		val=eval(document.all['a'+e].value);
		total+=val;
		b++;
	}
	
	maxi=Math.max(dado[1],dado[2],dado[3],dado[4],dado[5]);
	mini=Math.min(dado[1],dado[2],dado[3],dado[4],dado[5]);
	md=media/5;
	document.all['amplitude'+md].value=(maxi-mini);
	document.all['media'+md].value=(total/5);
	// - - -- - - - - - - - 
}

function digitos3(digit){
for(e=125;e>=1;e--){
	strdigit = new String("");
	var i=1;
	var nume1=document.all['a'+e].value;
	var ponto=nume1.indexOf('.');
	var pontop=ponto+1;
	if(nume1==0){
		for(i=0;i<digit;i++){
		strdigit+='0';
		}
	document.all['a'+e].value='0.'+strdigit;
	}else{
if(ponto != -1){ 
	var nume=document.all['a'+e].value.length-pontop;
	if(nume>digit){
		var part1=nume1.substr(0,1);
		var part2=nume1.substr(2,digit);
		document.all['a'+e].value=part1+'.'+part2;
	}else{
		while(nume<digit){
			strdigit+='0';
		nume++;
	}
	}
}
		document.all['a'+e].value+=strdigit;
}
}
}
function sele(el){
	var tr = el.createTextRange();
    tr.select();
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Característica - </strong>Característica da peça a ser estudada.<br><strong>Especificação - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do responsável pelo estudo de R&R.<br><strong>Operação - </strong>Operação da manufatura na qual a especificação de engenharia é originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">APQP - Estudo de Capabilidade <? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">estudo</td>
		<? if(!(empty($res["a1"]) and empty($res["a3"]) and empty($res["a5"]))){ ?><a href="apqp_cap3.php?car=<?= $car; ?>"><? } ?>
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">resultados</td>
		<? if(!(empty($res["a1"]) and empty($res["a3"]) and empty($res["a5"]))){ ?></a><? } ?>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_cap_sql.php" onSubmit="return verifica(this)"><td bgcolor="#FFFFFF">
          <table width="571" border="0" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td colspan="5"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td width="135" class="textobold">Caracter&iacute;stica</td>
              <td colspan="4"><input name="junk3" type="text" class="formularioselect" id="junk3" value="<?= $resc["numero"]; ?> - <?= $resc["descricao"]; ?>" size="10" readonly=""></td>
              </tr>
            <tr>
              <td class="textobold">N&uacute;mero Disp. Medi&ccedil;&atilde;o </td>
              <td><input name="numerodisp" type="text" class="formularioselect" id="junk2" value="<?= $res["numerodisp"]; ?>" size="7"></td>
              <td class="textobold">Nome Disp. Medi&ccedil;&atilde;o </td>
              <td width="154" colspan="2"><input name="nomedisp" type="text" class="formularioselect" id="numerodisp" value="<?= $res["nomedisp"]; ?>" size="7"><? $a=0; if($a): print "entro"; else: print "nao1"; print "nao"; endif; ?></td>
            </tr>
            <tr>
              <td class="textobold">Especifica&ccedil;&atilde;o</td>
              <td width="143"><input name="junk2" type="text" class="formularioselect" id="ini4" value="<?= $resc["espec"]; ?>" size="7" readonly=""></td>
              <td width="115" class="textobold"><div align="left">Toler&acirc;ncia</div></td>
              <td colspan="2"><input name="junk1" type="text" class="formularioselect" id="junk1" value="<?= banco2valor3($resc["tol"]); ?>" size="15" readonly=""></td>
              </tr>
            <tr>
              <td class="textobold">Realizado por </td>
              <td colspan="2"><input name="por" type="text" class="formularioselect" id="equipe5" value="<?= $res["por"]; ?>" size="7" maxlength="100">                <div align="left"></div></td>
              <td class="textobold"><div align="center">Data</div></td>
              <td><input name="dtpor" type="text" class="formulario" id="dteng2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print banco2data($res["dtpor"]); ?>" size="10" maxlength="10" data>
                &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_cap2&var_field=dtpor','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              </tr>
            <tr>
              <td class="textobold">Obs</td>
              <td colspan="4"><input name="obs" type="text" class="formularioselect" id="obs" value="<?= $res["obs"]; ?>" size="7" maxlength="255"></td>
            </tr>
            <tr>
              <td class="textobold">Opera&ccedil;&atilde;o</td>
              <td colspan="4"><select name="wop" class="formularioselect">
			 <option value="0">Selecione uma operação</option>
			<?
			$ops=mysql_query("SELECT * FROM apqp_op WHERE peca='$pc' ORDER BY numero ASC");
			if(mysql_num_rows($ops)){
				while($rops=mysql_fetch_array($ops)){
			?>
			<option value="<?= $rops["id"]; ?>" <? if($rops["id"]==$res["ope"]) print "selected"; ?>><?= htmlspecialchars($rops["numero"], ENT_QUOTES); ?> - <?= htmlspecialchars($rops["descricao"], ENT_QUOTES); ?></option>
			<?
				}
			}?>
              </select></td>
            </tr>
            <tr>
              <td colspan="5"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td colspan="5" class="textobold"><table width="425" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
                <tr>
                  <td colspan="2" align="center" class="textoboldbranco">Op&ccedil;&otilde;es</td>
                  <td align="center" class="textoboldbranco">&nbsp;</td>
                  <td colspan="2" align="center" class="textoboldbranco">Casas Decimais </td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="111" align="center" class="textobold">N&ordm; de Pe&ccedil;as</td>
                  <td width="83" class="textobold"><select name="nli" class="formularioselect" id="nli" onChange="linha();">
					<option value="1" <? if($res["nli"]==1 or empty($res["nli"])) print "selected"; ?>>5</option>
					<option value="2" <? if($res["nli"]==2) print "selected"; ?>>10</option>
                    <option value="3" <? if($res["nli"]==3) print "selected"; ?>>15</option>
                    <option value="4" <? if($res["nli"]==4) print "selected"; ?>>20</option>
                    <option value="5" <? if($res["nli"]==5) print "selected"; ?>>25</option>
                    <option value="6" <? if($res["nli"]==6) print "selected"; ?>>30</option>
                    <option value="7" <? if($res["nli"]==7) print "selected"; ?>>35</option>
                    <option value="8" <? if($res["nli"]==8) print "selected"; ?>>40</option>
                    <option value="9" <? if($res["nli"]==9) print "selected"; ?>>45</option>
                    <option value="10" <? if($res["nli"]==10) print "selected"; ?>>50</option>
					<option value="11" <? if($res["nli"]==11) print "selected"; ?>>55</option>
					<option value="12" <? if($res["nli"]==12) print "selected"; ?>>60</option>
					<option value="13" <? if($res["nli"]==13) print "selected"; ?>>65</option>
					<option value="14" <? if($res["nli"]==14) print "selected"; ?>>70</option>
					<option value="15" <? if($res["nli"]==15) print "selected"; ?>>75</option>
					<option value="16" <? if($res["nli"]==16) print "selected"; ?>>80</option>
					<option value="17" <? if($res["nli"]==17) print "selected"; ?>>85</option>
					<option value="18" <? if($res["nli"]==18) print "selected"; ?>>90</option>
					<option value="19" <? if($res["nli"]==19) print "selected"; ?>>95</option>
					<option value="20" <? if($res["nli"]==20) print "selected"; ?>>100</option>
					<option value="21" <? if($res["nli"]==21) print "selected"; ?>>105</option>
					<option value="22" <? if($res["nli"]==22) print "selected"; ?>>110</option>
					<option value="23" <? if($res["nli"]==23) print "selected"; ?>>115</option>
					<option value="24" <? if($res["nli"]==24) print "selected"; ?>>120</option>
					<option value="25" <? if($res["nli"]==25) print "selected"; ?>>125</option>
                                                                        </select></td>
                  <td width="45" class="textobold">&nbsp;</td>
                  <td width="86" align="center" class="textobold">N&ordm; de Casas </td>
                  <td width="94" class="textobold"><select name="ndi" class="formularioselect" id="select2" onChange="digitos();">
                    <option value="" selected>Selecione</option>
				    <option value="2" <? if(empty($digitos)){ if($res["digitos"]=="2"){ print "selected"; } }else{ if($digitos=="2"){ print "selected"; } } ?>>2</option>
                    <option value="3" <? if(empty($digitos)){ if($res["digitos"]=="3"){ print "selected"; } }else{ if($digitos=="3"){ print "selected"; } } ?>>3</option>
                    <option value="4" <? if(empty($digitos)){ if($res["digitos"]=="4"){ print "selected"; } }else{ if($digitos=="4"){ print "selected"; } } ?>>4</option>

                  </select></td>
                  </tr>
              </table>                
                <div align="center">Obs: Slecione os N&ordm; de Casas Decimais </div></td>
            </tr>
            <tr>
              <td colspan="5"><img src="imagens/dot.gif" width="20" height="8"></td>
              </tr>
            <tr>
              <td colspan="5"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
                <tr class="textobold">
                  <td width="0" align="center" valign="middle" class="textoboldbranco">&nbsp;</td>
                  <td width="90" align="center" class="textoboldbranco">Amostra 1 </td>
                  <td width="90" align="center" class="textoboldbranco">Amostra 2 </td>
                  <td width="90" align="center" class="textoboldbranco">Amostra 3</td>
                  <td width="90" align="center" class="textoboldbranco">Amostra 4 </td>
                  <td width="90" align="center" class="textoboldbranco">Amostra 5 </td>
                  <td width="90" align="center" class="textoboldbranco">M&eacute;dia</td>
                  <td width="90" align="center" class="textoboldbranco">Amplitude</td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">1</td>
                  <td bgcolor="#FFFFFF"><input name="a1" type="text" class="formularioselectsemborda" id="a1"  value="<? if(empty($res["a1"])){ print "0"; }else{ print $res["a1"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a1','5');" onFocus="sele(this);"></td>
                  <td bgcolor="#FFFFFF"><input name="a2" type="text" class="formularioselectsemborda" id="a2"  value="<? if(empty($res["a2"])){ print "0"; }else{ print $res["a2"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a2','5');" onFocus="sele(this);"></td>
                  <td bgcolor="#FFFFFF"><input name="a3" type="text" class="formularioselectsemborda" id="a3"  value="<? if(empty($res["a3"])){ print "0"; }else{ print $res["a3"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a3','5');" onFocus="sele(this);"></td>
                  <td bgcolor="#FFFFFF"><input name="a4" type="text" class="formularioselectsemborda" id="a4"  value="<? if(empty($res["a4"])){ print "0"; }else{ print $res["a4"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a4','5');" onFocus="sele(this);"></td>
                  <td bgcolor="#FFFFFF"><input name="a5" type="text" class="formularioselectsemborda" id="a5"  value="<? if(empty($res["a5"])){ print "0"; }else{ print $res["a5"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a5','5');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media1" type="text" class="formularioselectsemborda3" id="media1" value="<? print $res["media1"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude1" type="text" class="formularioselectsemborda3" id="amplitude1" value="<? print $res["amplitude1"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">2</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a6" type="text" class="formularioselectsemborda" id="a6"  value="<? if(empty($res["a6"])){ print "0"; }else{ print $res["a6"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a6','10');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a7" type="text" class="formularioselectsemborda" id="a7"  value="<? if(empty($res["a7"])){ print "0"; }else{ print $res["a7"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a7','10');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a8" type="text" class="formularioselectsemborda" id="a8"  value="<? if(empty($res["a8"])){ print "0"; }else{ print $res["a8"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a8','10');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a9" type="text" class="formularioselectsemborda" id="a9"  value="<? if(empty($res["a9"])){ print "0"; }else{ print $res["a9"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a9','10');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a10" type="text" class="formularioselectsemborda" id="a10" value="<? if(empty($res["a10"])){ print "0"; }else{ print $res["a10"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a10','10');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media2" type="text" class="formularioselectsemborda3" id="media2" value="<? print $res["media2"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude2" type="text" class="formularioselectsemborda3" id="amplitude2" value="<? print $res["amplitude2"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">3</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a11" type="text" class="formularioselectsemborda" id="a11"  value="<? if(empty($res["a11"])){ print "0"; }else{ print $res["a11"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a11','15');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a12" type="text" class="formularioselectsemborda" id="a12"  value="<? if(empty($res["a12"])){ print "0"; }else{ print $res["a12"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a12','15');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a13" type="text" class="formularioselectsemborda" id="a13"  value="<? if(empty($res["a13"])){ print "0"; }else{ print $res["a13"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a13','15');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a14" type="text" class="formularioselectsemborda" id="a14"  value="<? if(empty($res["a14"])){ print "0"; }else{ print $res["a14"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a14','15');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a15" type="text" class="formularioselectsemborda" id="a15"  value="<? if(empty($res["a15"])){ print "0"; }else{ print $res["a15"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a15','15');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media3" type="text" class="formularioselectsemborda3" id="media3" value="<? print $res["media3"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude3" type="text" class="formularioselectsemborda3" id="amplitude3" value="<? print $res["amplitude3"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">4</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a16" type="text" class="formularioselectsemborda" id="a16"  value="<? if(empty($res["a16"])){ print "0"; }else{ print $res["a16"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a16','20');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a17" type="text" class="formularioselectsemborda" id="a17"  value="<? if(empty($res["a17"])){ print "0"; }else{ print $res["a17"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a17','20');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a18" type="text" class="formularioselectsemborda" id="a18"  value="<? if(empty($res["a18"])){ print "0"; }else{ print $res["a18"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a18','20');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a19" type="text" class="formularioselectsemborda" id="a19"  value="<? if(empty($res["a19"])){ print "0"; }else{ print $res["a19"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a19','20');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a20" type="text" class="formularioselectsemborda" id="a20"  value="<? if(empty($res["a20"])){ print "0"; }else{ print $res["a20"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a20','20');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media4" type="text" class="formularioselectsemborda3" id="media4" value="<? print $res["media4"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude4" type="text" class="formularioselectsemborda3" id="amplitude4" value="<? print $res["amplitude4"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">5</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a21" type="text" class="formularioselectsemborda" id="a21"  value="<? if(empty($res["a21"])){ print "0"; }else{ print $res["a21"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a21','25');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a22" type="text" class="formularioselectsemborda" id="a22"  value="<? if(empty($res["a22"])){ print "0"; }else{ print $res["a22"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a22','25');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a23" type="text" class="formularioselectsemborda" id="a23"  value="<? if(empty($res["a23"])){ print "0"; }else{ print $res["a23"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a23','25');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a24" type="text" class="formularioselectsemborda" id="a24"  value="<? if(empty($res["a24"])){ print "0"; }else{ print $res["a24"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a24','25');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a25" type="text" class="formularioselectsemborda" id="a25"  value="<? if(empty($res["a25"])){ print "0"; }else{ print $res["a25"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a25','25');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media5" type="text" class="formularioselectsemborda3" id="media5" value="<? print $res["media5"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude5" type="text" class="formularioselectsemborda3" id="amplitude5" value="<? print $res["amplitude5"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">6</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a26" type="text" class="formularioselectsemborda" id="a26"  value="<? if(empty($res["a26"])){ print "0"; }else{ print $res["a26"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a26','30');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a27" type="text" class="formularioselectsemborda" id="a27"  value="<? if(empty($res["a27"])){ print "0"; }else{ print $res["a27"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a27','30');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a28" type="text" class="formularioselectsemborda" id="a28"  value="<? if(empty($res["a28"])){ print "0"; }else{ print $res["a28"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a28','30');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a29" type="text" class="formularioselectsemborda" id="a29"  value="<? if(empty($res["a29"])){ print "0"; }else{ print $res["a29"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a29','30');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a30" type="text" class="formularioselectsemborda" id="a30"  value="<? if(empty($res["a30"])){ print "0"; }else{ print $res["a30"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a30','30');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media6" type="text" class="formularioselectsemborda3" id="media6" value="<? print $res["media6"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude6" type="text" class="formularioselectsemborda3" id="amplitude6" value="<? print $res["amplitude6"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">7</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a31" type="text" class="formularioselectsemborda" id="a31"  value="<? if(empty($res["a31"])){ print "0"; }else{ print $res["a31"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a31','35');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a32" type="text" class="formularioselectsemborda" id="a32"  value="<? if(empty($res["a32"])){ print "0"; }else{ print $res["a32"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a32','35');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a33" type="text" class="formularioselectsemborda" id="a33"  value="<? if(empty($res["a33"])){ print "0"; }else{ print $res["a33"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a33','35');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a34" type="text" class="formularioselectsemborda" id="a34"  value="<? if(empty($res["a34"])){ print "0"; }else{ print $res["a34"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a34','35');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a35" type="text" class="formularioselectsemborda" id="a35"  value="<? if(empty($res["a35"])){ print "0"; }else{ print $res["a35"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a35','35');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media7" type="text" class="formularioselectsemborda3" id="media7" value="<? print $res["media7"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude7" type="text" class="formularioselectsemborda3" id="amplitude7" value="<? print $res["amplitude7"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">8</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a36" type="text" class="formularioselectsemborda" id="a36"  value="<? if(empty($res["a36"])){ print "0"; }else{ print $res["a36"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a36','40');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a37" type="text" class="formularioselectsemborda" id="a37"  value="<? if(empty($res["a37"])){ print "0"; }else{ print $res["a37"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a37','40');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a38" type="text" class="formularioselectsemborda" id="a38"  value="<? if(empty($res["a38"])){ print "0"; }else{ print $res["a38"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a38','40');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a39" type="text" class="formularioselectsemborda" id="a39"  value="<? if(empty($res["a39"])){ print "0"; }else{ print $res["a39"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a39','40');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a40" type="text" class="formularioselectsemborda" id="a40"  value="<? if(empty($res["a40"])){ print "0"; }else{ print $res["a40"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a40','40');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media8" type="text" class="formularioselectsemborda3" id="media8" value="<? print $res["media8"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude8" type="text" class="formularioselectsemborda3" id="amplitude8" value="<? print $res["amplitude8"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">9</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a41" type="text" class="formularioselectsemborda" id="a41"  value="<? if(empty($res["a41"])){ print "0"; }else{ print $res["a41"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a41','45');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a42" type="text" class="formularioselectsemborda" id="a42"  value="<? if(empty($res["a42"])){ print "0"; }else{ print $res["a42"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a42','45');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a43" type="text" class="formularioselectsemborda" id="a43"  value="<? if(empty($res["a43"])){ print "0"; }else{ print $res["a43"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a43','45');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a44" type="text" class="formularioselectsemborda" id="a44"  value="<? if(empty($res["a44"])){ print "0"; }else{ print $res["a44"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a44','45');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a45" type="text" class="formularioselectsemborda" id="a45"  value="<? if(empty($res["a45"])){ print "0"; }else{ print $res["a45"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a45','45');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media9" type="text" class="formularioselectsemborda3" id="media9" value="<? print $res["media9"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude9" type="text" class="formularioselectsemborda3" id="amplitude9" value="<? print $res["amplitude9"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">10</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a46" type="text" class="formularioselectsemborda" id="a46"  value="<? if(empty($res["a46"])){ print "0"; }else{ print $res["a46"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a46','50');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a47" type="text" class="formularioselectsemborda" id="a47"  value="<? if(empty($res["a47"])){ print "0"; }else{ print $res["a47"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a47','50');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a48" type="text" class="formularioselectsemborda" id="a48"  value="<? if(empty($res["a48"])){ print "0"; }else{ print $res["a48"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a48','50');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a49" type="text" class="formularioselectsemborda" id="a49"  value="<? if(empty($res["a49"])){ print "0"; }else{ print $res["a49"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a49','50');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a50" type="text" class="formularioselectsemborda" id="a50"  value="<? if(empty($res["a50"])){ print "0"; }else{ print $res["a50"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a50','50');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media10" type="text" class="formularioselectsemborda3" id="media10" value="<? print $res["media10"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude10" type="text" class="formularioselectsemborda3" id="amplitude10" value="<? print $res["amplitude10"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">11</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a51" type="text" class="formularioselectsemborda" id="a51"  value="<? if(empty($res["a51"])){ print "0"; }else{ print $res["a51"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a51','55');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a52" type="text" class="formularioselectsemborda" id="a52"  value="<? if(empty($res["a52"])){ print "0"; }else{ print $res["a52"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a52','55');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a53" type="text" class="formularioselectsemborda" id="a53"  value="<? if(empty($res["a53"])){ print "0"; }else{ print $res["a53"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a53','55');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a54" type="text" class="formularioselectsemborda" id="a54"  value="<? if(empty($res["a54"])){ print "0"; }else{ print $res["a54"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a54','55');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a55" type="text" class="formularioselectsemborda" id="a55"  value="<? if(empty($res["a55"])){ print "0"; }else{ print $res["a55"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a55','55');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media11" type="text" class="formularioselectsemborda3" id="media11" value="<? print $res["media11"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude11" type="text" class="formularioselectsemborda3" id="amplitude11" value="<? print $res["amplitude11"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">12</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a56" type="text" class="formularioselectsemborda" id="a56"  value="<? if(empty($res["a56"])){ print "0"; }else{ print $res["a56"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a56','60');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a57" type="text" class="formularioselectsemborda" id="a57"  value="<? if(empty($res["a57"])){ print "0"; }else{ print $res["a57"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a57','60');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a58" type="text" class="formularioselectsemborda" id="a58"  value="<? if(empty($res["a58"])){ print "0"; }else{ print $res["a58"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a58','60');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a59" type="text" class="formularioselectsemborda" id="a59"  value="<? if(empty($res["a59"])){ print "0"; }else{ print $res["a59"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a59','60');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a60" type="text" class="formularioselectsemborda" id="a60"  value="<? if(empty($res["a60"])){ print "0"; }else{ print $res["a60"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a60','60');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media12" type="text" class="formularioselectsemborda3" id="media12" value="<? print $res["media12"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude12" type="text" class="formularioselectsemborda3" id="amplitude12" value="<? print $res["amplitude12"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">13</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a61" type="text" class="formularioselectsemborda" id="a61"  value="<? if(empty($res["a61"])){ print "0"; }else{ print $res["a61"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a61','65');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a62" type="text" class="formularioselectsemborda" id="a62"  value="<? if(empty($res["a62"])){ print "0"; }else{ print $res["a62"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a62','65');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a63" type="text" class="formularioselectsemborda" id="a63"  value="<? if(empty($res["a63"])){ print "0"; }else{ print $res["a63"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a63','65');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a64" type="text" class="formularioselectsemborda" id="a64"  value="<? if(empty($res["a64"])){ print "0"; }else{ print $res["a64"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a64','65');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a65" type="text" class="formularioselectsemborda" id="a65"  value="<? if(empty($res["a65"])){ print "0"; }else{ print $res["a65"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a65','65');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media13" type="text" class="formularioselectsemborda3" id="media13" value="<? print $res["media13"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude13" type="text" class="formularioselectsemborda3" id="amplitude13" value="<? print $res["amplitude13"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">14</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a66" type="text" class="formularioselectsemborda" id="a66"  value="<? if(empty($res["a66"])){ print "0"; }else{ print $res["a66"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a66','70');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a67" type="text" class="formularioselectsemborda" id="a67"  value="<? if(empty($res["a67"])){ print "0"; }else{ print $res["a67"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a67','70');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a68" type="text" class="formularioselectsemborda" id="a68"  value="<? if(empty($res["a68"])){ print "0"; }else{ print $res["a68"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a68','70');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a69" type="text" class="formularioselectsemborda" id="a69"  value="<? if(empty($res["a69"])){ print "0"; }else{ print $res["a69"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a69','70');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a70" type="text" class="formularioselectsemborda" id="a70"  value="<? if(empty($res["a70"])){ print "0"; }else{ print $res["a70"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a70','70');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media14" type="text" class="formularioselectsemborda3" id="media14" value="<? print $res["media14"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude14" type="text" class="formularioselectsemborda3" id="amplitude14" value="<? print $res["amplitude14"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">15</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a71" type="text" class="formularioselectsemborda" id="a71"  value="<? if(empty($res["a71"])){ print "0"; }else{ print $res["a71"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a71','75');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a72" type="text" class="formularioselectsemborda" id="a72"  value="<? if(empty($res["a72"])){ print "0"; }else{ print $res["a72"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a72','75');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a73" type="text" class="formularioselectsemborda" id="a73"  value="<? if(empty($res["a73"])){ print "0"; }else{ print $res["a73"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a73','75');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a74" type="text" class="formularioselectsemborda" id="a74"  value="<? if(empty($res["a74"])){ print "0"; }else{ print $res["a74"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a74','75');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a75" type="text" class="formularioselectsemborda" id="a75"  value="<? if(empty($res["a75"])){ print "0"; }else{ print $res["a75"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a75','75');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media15" type="text" class="formularioselectsemborda3" id="media15" value="<? print $res["media15"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude15" type="text" class="formularioselectsemborda3" id="amplitude15" value="<? print $res["amplitude15"]; ?>" size="1" readonly=""></td>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">16</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a76" type="text" class="formularioselectsemborda" id="a76"  value="<? if(empty($res["a76"])){ print "0"; }else{ print $res["a76"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a76','80');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a77" type="text" class="formularioselectsemborda" id="a77"  value="<? if(empty($res["a77"])){ print "0"; }else{ print $res["a77"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a77','80');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a78" type="text" class="formularioselectsemborda" id="a78"  value="<? if(empty($res["a78"])){ print "0"; }else{ print $res["a78"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a78','80');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a79" type="text" class="formularioselectsemborda" id="a79"  value="<? if(empty($res["a79"])){ print "0"; }else{ print $res["a79"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a79','80');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a80" type="text" class="formularioselectsemborda" id="a80"  value="<? if(empty($res["a80"])){ print "0"; }else{ print $res["a80"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a80','80');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media16" type="text" class="formularioselectsemborda3" id="media16" value="<? print $res["media16"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude16" type="text" class="formularioselectsemborda3" id="amplitude16" value="<? print $res["amplitude16"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">17</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a81" type="text" class="formularioselectsemborda" id="a81"  value="<? if(empty($res["a81"])){ print "0"; }else{ print $res["a81"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a81','85');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a82" type="text" class="formularioselectsemborda" id="a82"  value="<? if(empty($res["a82"])){ print "0"; }else{ print $res["a82"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a82','85');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a83" type="text" class="formularioselectsemborda" id="a83"  value="<? if(empty($res["a83"])){ print "0"; }else{ print $res["a83"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a83','85');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a84" type="text" class="formularioselectsemborda" id="a84"  value="<? if(empty($res["a84"])){ print "0"; }else{ print $res["a84"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a84','85');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a85" type="text" class="formularioselectsemborda" id="a85"  value="<? if(empty($res["a85"])){ print "0"; }else{ print $res["a85"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a85','85');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media17" type="text" class="formularioselectsemborda3" id="media17" value="<? print $res["media17"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude17" type="text" class="formularioselectsemborda3" id="amplitude17" value="<? print $res["amplitude17"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">18</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a86" type="text" class="formularioselectsemborda" id="a86"  value="<? if(empty($res["a86"])){ print "0"; }else{ print $res["a86"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a86','90');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a87" type="text" class="formularioselectsemborda" id="a87"  value="<? if(empty($res["a87"])){ print "0"; }else{ print $res["a87"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a87','90');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a88" type="text" class="formularioselectsemborda" id="a88"  value="<? if(empty($res["a88"])){ print "0"; }else{ print $res["a88"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a88','90');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a89" type="text" class="formularioselectsemborda" id="a89"  value="<? if(empty($res["a89"])){ print "0"; }else{ print $res["a89"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a89','90');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a90" type="text" class="formularioselectsemborda" id="a90"  value="<? if(empty($res["a90"])){ print "0"; }else{ print $res["a90"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a90','90');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media18" type="text" class="formularioselectsemborda3" id="media18" value="<? print $res["media18"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude18" type="text" class="formularioselectsemborda3" id="amplitude18" value="<? print $res["amplitude18"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">19</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a91" type="text" class="formularioselectsemborda" id="a91"  value="<? if(empty($res["a91"])){ print "0"; }else{ print $res["a91"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a91','95');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a92" type="text" class="formularioselectsemborda" id="a92"  value="<? if(empty($res["a92"])){ print "0"; }else{ print $res["a92"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a92','95');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a93" type="text" class="formularioselectsemborda" id="a93"  value="<? if(empty($res["a93"])){ print "0"; }else{ print $res["a93"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a93','95');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a94" type="text" class="formularioselectsemborda" id="a94"  value="<? if(empty($res["a94"])){ print "0"; }else{ print $res["a94"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a94','95');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a95" type="text" class="formularioselectsemborda" id="a95"  value="<? if(empty($res["a95"])){ print "0"; }else{ print $res["a95"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a95','95');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media19" type="text" class="formularioselectsemborda3" id="media19" value="<? print $res["media19"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude19" type="text" class="formularioselectsemborda3" id="amplitude19" value="<? print $res["amplitude19"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">20</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a96" type="text" class="formularioselectsemborda" id="a96"  value="<? if(empty($res["a96"])){ print "0"; }else{ print $res["a96"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a96','100');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a97" type="text" class="formularioselectsemborda" id="a97"  value="<? if(empty($res["a97"])){ print "0"; }else{ print $res["a97"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a97','100');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a98" type="text" class="formularioselectsemborda" id="a98"  value="<? if(empty($res["a98"])){ print "0"; }else{ print $res["a98"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a98','100');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a99" type="text" class="formularioselectsemborda" id="a99"  value="<? if(empty($res["a99"])){ print "0"; }else{ print $res["a99"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a99','100');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a100" type="text" class="formularioselectsemborda" id="a100"  value="<? if(empty($res["a100"])){ print "0"; }else{ print $res["a100"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a100','100');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media20" type="text" class="formularioselectsemborda3" id="media20" value="<? print $res["media20"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude20" type="text" class="formularioselectsemborda3" id="amplitude20" value="<? print $res["amplitude20"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">21</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a101" type="text" class="formularioselectsemborda" id="a101" value="<? if(empty($res["a101"])){ print "0"; }else{ print $res["a101"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a101','105');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a102" type="text" class="formularioselectsemborda" id="a102"  value="<? if(empty($res["a102"])){ print "0"; }else{ print $res["a102"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a102','105');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a103" type="text" class="formularioselectsemborda" id="a103"  value="<? if(empty($res["a103"])){ print "0"; }else{ print $res["a103"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a103','105');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a104" type="text" class="formularioselectsemborda" id="a104"  value="<? if(empty($res["a104"])){ print "0"; }else{ print $res["a104"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a104','105');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a105" type="text" class="formularioselectsemborda" id="a105"  value="<? if(empty($res["a105"])){ print "0"; }else{ print $res["a105"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a105','105');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media21" type="text" class="formularioselectsemborda3" id="media21" value="<? print $res["media21"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude21" type="text" class="formularioselectsemborda3" id="amplitude21" value="<? print $res["amplitude21"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">22</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a106" type="text" class="formularioselectsemborda" id="a106"  value="<? if(empty($res["a106"])){ print "0"; }else{ print $res["a106"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a106','110');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a107" type="text" class="formularioselectsemborda" id="a107"  value="<? if(empty($res["a107"])){ print "0"; }else{ print $res["a107"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a107','110');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a108" type="text" class="formularioselectsemborda" id="a108"  value="<? if(empty($res["a108"])){ print "0"; }else{ print $res["a108"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a108','110');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a109" type="text" class="formularioselectsemborda" id="a109"  value="<? if(empty($res["a109"])){ print "0"; }else{ print $res["a109"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a109','110');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a110" type="text" class="formularioselectsemborda" id="a110"  value="<? if(empty($res["a110"])){ print "0"; }else{ print $res["a110"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a110','110');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media22" type="text" class="formularioselectsemborda3" id="media22" value="<? print $res["media22"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude22" type="text" class="formularioselectsemborda3" id="amplitude22" value="<? print $res["amplitude22"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">23</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a111" type="text" class="formularioselectsemborda" id="a111"  value="<? if(empty($res["a111"])){ print "0"; }else{ print $res["a111"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a111','115');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a112" type="text" class="formularioselectsemborda" id="a112"  value="<? if(empty($res["a112"])){ print "0"; }else{ print $res["a112"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a112','115');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a113" type="text" class="formularioselectsemborda" id="a113"  value="<? if(empty($res["a113"])){ print "0"; }else{ print $res["a113"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a113','115');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a114" type="text" class="formularioselectsemborda" id="a114"  value="<? if(empty($res["a114"])){ print "0"; }else{ print $res["a114"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a114','115');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a115" type="text" class="formularioselectsemborda" id="a115"  value="<? if(empty($res["a115"])){ print "0"; }else{ print $res["a115"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a115','115');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media23" type="text" class="formularioselectsemborda3" id="media23" value="<? print $res["media23"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude23" type="text" class="formularioselectsemborda3" id="amplitude23" value="<? print $res["amplitude23"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">24</td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a116" type="text" class="formularioselectsemborda" id="a116"  value="<? if(empty($res["a116"])){ print "0"; }else{ print $res["a116"]; } ?>" size="4"  onBlur="digitos2('<? print $digitos; ?>','a116','120');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a117" type="text" class="formularioselectsemborda" id="a117"  value="<? if(empty($res["a117"])){ print "0"; }else{ print $res["a117"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a117','120');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a118" type="text" class="formularioselectsemborda" id="a118"  value="<? if(empty($res["a118"])){ print "0"; }else{ print $res["a118"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a118','120');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a119" type="text" class="formularioselectsemborda" id="a119"  value="<? if(empty($res["a119"])){ print "0"; }else{ print $res["a119"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a119','120');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a120" type="text" class="formularioselectsemborda" id="a120"  value="<? if(empty($res["a120"])){ print "0"; }else{ print $res["a120"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a120','120');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media24" type="text" class="formularioselectsemborda3" id="media24" value="<? print $res["media24"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude24" type="text" class="formularioselectsemborda3" id="amplitude24" value="<? print $res["amplitude24"]; ?>" size="1" readonly=""></td>
                </tr>
                <tr class="textobold">
                  <td align="center" class="textoboldbranco">25</td> 
                  <td width="68" bgcolor="#FFFFFF"><input name="a121" type="text" class="formularioselectsemborda" id="a121"  value="<? if(empty($res["a121"])){ print "0"; }else{ print $res["a121"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a121','125');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a122" type="text" class="formularioselectsemborda" id="a122"  value="<? if(empty($res["a122"])){ print "0"; }else{ print $res["a122"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a122','125');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a123" type="text" class="formularioselectsemborda" id="a123"  value="<? if(empty($res["a123"])){ print "0"; }else{ print $res["a123"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a123','125');" onFocus="sele(this);"></td>
                  <td width="67" bgcolor="#FFFFFF"><input name="a124" type="text" class="formularioselectsemborda" id="a124"  value="<? if(empty($res["a124"])){ print "0"; }else{ print $res["a124"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a124','125');" onFocus="sele(this);"></td>
                  <td width="68" bgcolor="#FFFFFF"><input name="a125" type="text" class="formularioselectsemborda" id="a125"  value="<? if(empty($res["a125"])){ print "0"; }else{ print $res["a125"]; } ?>" size="4" onBlur="digitos2('<? print $digitos; ?>','a125','125');" onFocus="sele(this);"></td>
                  <td width="52" bgcolor="#FFFFFF"><input name="media25" type="text" class="formularioselectsemborda3" id="media25" value="<? print $res["media25"]; ?>" size="1" readonly=""></td>
                  <td width="57" bgcolor="#FFFFFF"><input name="amplitude25" type="text" class="formularioselectsemborda3" id="amplitude25" value="<? print $res["amplitude25"]; ?>" size="1" readonly=""></td>
                </tr>
              </table></td>
              </tr>
            
            <tr>
              <td colspan="5" align="center">
                <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_cap.php';">
&nbsp;                <input name="button122" type="submit" class="microtxt" value="Salvar" onClick="">
                <input name="car" type="hidden" id="car" value="<?= $car; ?>">
                <input name="acao" type="hidden" id="acao" value="cap2">
                <input name="id" type="hidden" id="id" value="<?= $res["id"]; ?>"></td>
              </tr>
          </table>
        </td></form>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script>
linha();
digitos3('<? print $digitos; ?>');
</script>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>