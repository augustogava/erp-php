<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="cara";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='cara'");
if(mysql_num_rows($sqlm)){
	$resm=mysql_fetch_array($sqlm);
	if($resm["funcionario"]=="S" or empty($resm["funcionario"])){
		$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}else{
		$sql2=mysql_query("SELECT * FROM clientes WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}
	$_SESSION["mensagem"]="O usuario $res2[nome] está alterando este módulo!";
	header("Location:apqp_menu.php");
	exit;
}
// - - -FIM- - - 

if(empty($id)) $id=$pc; 
if($acao=="inc"){
	$sql=mysql_query("SELECT MAX(numero) AS numero FROM apqp_car WHERE tipo='Dim' AND peca='$id'");
	if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	$dimn=$res["numero"]+1;
	}else{
	$dimn=1;
	}
	
	$sql=mysql_query("SELECT MAX(numero) AS numero FROM apqp_car WHERE tipo='Mat' AND peca='$id'");
	if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	$matn=$res["numero"]+1;
	}else{
	$matn=1;
	}
	
	$sql=mysql_query("SELECT MAX(numero) AS numero FROM apqp_car WHERE tipo='Des' AND peca='$id'");
	if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	$desn=$res["numero"]+1;
	}else{
	$desn=1;
	}
	
	$sql=mysql_query("SELECT MAX(numero) AS numero FROM apqp_car WHERE tipo='Pro' AND peca='$id'");
	if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	$pron=$res["numero"]+1;
	}else{
	$pron=1;
	}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM apqp_car WHERE id='$car'");
	$res=mysql_fetch_array($sql);
}
		switch($ord){
		case 1:
		$ord="numero DESC";
		break;
		case 2:
		$ord="descricao ASC";
		break;
		case 3:
		$ord="espec ASC";
		break;
		default:
		$ord="numero ASC";
		}
		switch($ord2){
		case 1:
		$ord2="tipo DESC";
		break;
		default:
		$ord2="tipo ASC";
		}
		switch($busca){
		case 1:
		$busca2="AND tipo='Dim'";
		break;
		case 2:
		$busca2="AND tipo='Des'";
		break;
		case 3:
		$busca2="AND tipo='Mat'";
		break;
		case 4:
		$busca2="AND tipo='Pro'";
		break;
		default:
		$busca2="";
		}
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$btn="";
		$btn2="return abre('apqp_pc_pop.php?id=$id&npc2=$npc','selimagem','width=640,height=600,scrollbars=yes');";
		$btn3="return abre('apqp_simbol.php','icones','width=630,height=330,scrollbars=1');";
		$btn4="return veri();";
	}else{

		$btn="window.alert('Não pode ser alterado/incluido pois está peça já foi aprovada!'); return false;";
		$btn2="window.alert('Não pode ser alterado/incluido pois está peça já foi aprovada!');";
		$btn3="window.alert('Não pode ser alterado/incluido pois está peça já foi aprovada!'); return false;";
		$btn4="window.alert('Não pode ser alterado/incluido pois está peça já foi aprovada!'); return false;";
	}

?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="ajax.js" type="text/javascript"></script>
<script src="funcoes.js" type="text/javascript"></script>
<script src="scripts.js"></script>
<script src="mascaras.js"></script>

<script>
<!--
guardasimbol='apqp_fluxo/<?php print $res["simbolo"]; ?>.jpg';
guardasimbolo='<?php print $res["simbolo"]; ?>';
function verifica(cad){
	if(cad.numero.value==''){
		alert('Informe o número da característica');
		cad.numero.focus();
		return false;
	}
		//validacao de radio buttons sem saber quantos sao
	marcado = -1
	for (i=0; i<cad.tipo2.length; i++) {
		if (cad.tipo2[i].checked) {
			marcado = i
			resposta = cad.tipo2[i].value
		}
	}
	
	if (marcado == -1) {
		alert("Selecione um Tipo");
		cad.tipo2[0].focus();
		return false;
	}
	if(cad.descricao.value==''){
		alert('Informe a descrição da característica');
		cad.descricao.focus();
		return false;
	}
	if(cad.espec.value==''){
		alert('Informe a Especificação da característica');
		cad.espec.focus();
		return false;
	}
	if(cad.numero.value==''){
		alert('Informe o número da característica');
		cad.numero.focus();
		return false;
	}
	if(cad.pc.checked){
		lie = frmcar.lie.value.replace(".","");
		lie = eval(frmcar.lie.value.replace(",","."));
		lse = frmcar.lse.value.replace(".","");
		lse = eval(frmcar.lse.value.replace(",","."));
		if(lie > lse){
			alert('O Limite superior de engenharia (LSE) deve ser maior que o Limite inferior de engenharia (LIE)');
			frmcar.lie.focus();
			return false;
		}
	}
	
	return true;
}
function tipoadd(val,carac,busc){
frmcar.tipo.value=carac;
window.location='apqp_car.php?acao=inc&ord=1&busca='+busc+'&id=<?php print $id; ?>&tipo='+carac+'&npc=<?php print $npc; ?>';
}
function abrepop(){
	if(frmcar.pc.checked){
		return abre('apqp_simbolpopup.php','icones','width=520,height=280,scrollbars=1');
	}else{
		return false;
	}
}
function funcpc(cad){
	if(!cad.pc.checked){
		cad.lie.disabled=true;
		cad.lse.disabled=true;
		cad.tol.disabled=true;
		guardasimbol=cad.simbol.src;
		guardasimbolo=cad.simbolo.value;
		cad.simbol.src='imagens/0.jpg';
		cad.simbolo.value='999';
	}else{
		cad.lie.disabled=false;
		cad.lse.disabled=false;
		cad.tol.disabled=false;
		cad.simbol.src=guardasimbol;
		cad.simbolo.value=guardasimbolo;
	}
}
function adiciona(id){
	if(id==1){
		frmcar.espec.value+='±';
		frmcar.espec.focus();
	}else if(id==2){
		frmcar.espec.value+='°';
		frmcar.espec.focus();
	}
	return false;
}
function toler(){
	lie = frmcar.lie.value.replace(".",".");
	lie = eval(frmcar.lie.value.replace(",","."));
	lse = frmcar.lse.value.replace(".",".");
	lse = eval(frmcar.lse.value.replace(",","."));
	if(lie <= lse){
		tol=lse-lie;
		tol=formata_numero(tol,3);
		tol = tol.replace(".",",");


		if(tol=='0,010'){
			frmcar.tol.value='0,1';
		}else{ 		frmcar.tol.value=tol; }
/*
		if(tol.substr(2,1)=='0'){
			var vari=tol.substr(3,8);
			tol='0,'+vari;
			
		}else{
				frmcar.tol.value=tol;
		}*/

	}
}
function veri(){
	if(confirm("Deletar mesmo?")){
		return true;
	}
	return false;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function getSelectedRadio(buttonGroup) {
   // returns the array number of the selected radio button or -1 if no button is selected
   if (buttonGroup[0]) { // if the button group is an array (one button is not an array)
      for (var i=0; i<buttonGroup.length; i++) {
         if (buttonGroup[i].checked) {
            return i
         }
      }
   } else {
      if (buttonGroup.checked) { return 0; } // if the one button is checked, return zero
   }
   // if we get to this point, no radio button is selected
   return -1;
}
function getSelectedRadioValue(buttonGroup) {
   // returns the value of the selected radio button or "" if no button is selected
   var i = getSelectedRadio(buttonGroup);
   if (i == -1) {
      return "";
   } else {
      if (buttonGroup[i]) { // Make sure the button group is an array (not just one button)
         return buttonGroup[i].value;
      } else { // The button group is just the one button, and it is checked
         return buttonGroup.value;
      }
   }
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
.style2 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_cad_cara.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Cadastro de Características'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Existem 4 tipos de característica: Dimensional, Material, Desempenho e Processo.<br><strong>Símbolo - </strong>Que indica o tipo de característica<br><strong>Descrição - </strong>Como aparenta a peça ou objeto Ex.: Diâmetro Interno, Largura, Espessura, etc...<br><strong>Especificação - </strong>Medida ou valor a ser seguido, ex: +- 0,5mm tolerância<br><strong>Especificações de Engenharia - </strong>Medida ou valor ou procedimento a ser seguido.<br><strong>Tipo - </strong>Tipos de características - matéria, dimensional, processo e desempenho.')"></a></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1">APQP - Caracter&iacute;sticas <?php print $npc; ?><a name="top"></a></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="100%"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <?php if($acao=="entrar" or $acao=="alt" or $acao=="inc"){ ?>
      <tr>
        <td align="left" valign="top"><form action="apqp_car_sql.php" method="post" name="frmcar" id="frmcar" onSubmit="return verifica(this);">
            <table width="594" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
              <tr>
                <td bgcolor="#FFFFFF"><table width="594" border="0" cellspacing="0" cellpadding="3">
                    <tr class="textobold">
                      <td colspan="6"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="30" class="textobold">Tipo</td>
                            <td width="57" class="textopreto"><input name="tipo2" type="radio" value="Dim" id="tipo2" <?php if(($res["tipo"]=="Dim") or ($tipo=="Dim")) print "checked"; ?> onClick="return tipoadd('<?php print $dimn; ?>','Dim','1');">
                          Dim</td>
                            <td width="53" class="textopreto"><input name="tipo2" type="radio" value="Mat" id="tipo2" <?php if(($res["tipo"]=="Mat") or ($tipo=="Mat")) print "checked"; ?> onClick="return tipoadd('<?php print $matn; ?>','Mat','3');">
                          Mat</td>
                            <td width="56" class="textopreto"><input name="tipo2" type="radio" value="Des" id="tipo2" <?php if(($res["tipo"]=="Des") or ($tipo=="Des")) print "checked"; ?> onClick="return tipoadd('<?php print $desn; ?>','Des','2');">
                          Des</td>
                            <td width="68" class="textopreto"><input name="tipo2" type="radio" value="Pro" id="tipo2" <?php if(($res["tipo"]=="Pro") or ($tipo=="Pro")) print "checked"; ?> onClick="return tipoadd('<?php print $pron; ?>','Pro','4');">
                          Proc</td>
                            <td width="117" class="textobold">&nbsp;Caracter&iacute;stica N&ordm; </td>
                            <td width="25"><?php if(!empty($busca)){ $sql2=mysql_query("SELECT MAX(numero) AS numero FROM apqp_car WHERE peca='$id' $busca2"); $res2=mysql_fetch_array($sql2); $numero=$res2["numero"]+1; } ?>
                                <input name="numero" type="text" class="formulario" id="numero" value="<?php if($acao=="inc"){ print $numero; }else{ print $res["numero"]; } ?>" size="5" maxlength="20" onBlur="javascript: envia('receber.php', 'POST', false, getSelectedRadioValue(frmcar.tipo2));"></td>
                            <td width="182" class="textobold">&nbsp;&nbsp;&nbsp;
                                <input name="pc" type="checkbox" id="pc" onClick="funcpc(this.form);" value="S" <?php if($res["pc"]=="S") print "checked"; ?>>
                          Plano de Controle</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center"><span class="style2"><img src="imagens/dot.gif" width="50" height="5">
                        <div id="teste2"></div> </span></td>
                    </tr>
                    <tr class="textobold">
                      <td>&nbsp;Descri&ccedil;&atilde;o:</td>
                      <td colspan="4"><select name="descricao2" class="formularioselect" id="descricao2">
                          <option value="" selected>Selecione</option>
                          <?php $sql2=mysql_query("SELECT * FROM apqp_desc ORDER BY txt ASC");
			  	while($res2=mysql_fetch_array($sql2)){
			  ?>
                          <option value="<?php print $res2["txt"] ?>"><?php print $res2["txt"] ?></option>
                          <?php } ?>
                      </select></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr class="textobold">
                      <td width="87">&nbsp;</td>
                      <td colspan="4"><input name="descricao" type="text" class="formularioselect" id="descricao" value="<?php print $res["descricao"]; ?>" maxlength="200"></td>
                      <td width="35">&nbsp;&nbsp;</td>
                    </tr>
                    <tr class="textobold">
                      <td>&nbsp;Especifica&ccedil;&atilde;o:</td>
                      <td colspan="4"><input name="espec" type="text" class="formularioselect" id="espec" value="<?php print $res["espec"]; ?>" maxlength="200">
                        <label></label></td>
                      <td align="center"><a href="#" onClick="return adiciona(1);"><img src="imagens/icon14_maismenos.gif" name="a" width="14" height="19" border="0" id="a"></a><a href="#" onClick="return adiciona(2);"><img src="imagens/icon14_bola.gif" name="b" width="14" height="19" border="0" id="b"></a></td>
                    </tr>
                    <tr class="textobold">
                      <td>&nbsp;S&iacute;mbolo:</td>
                      <td width="76"><input name="simbolonome" type="text" class="textobold" id="simbolonome" value="Nenhuma" size="15" readonly=""></td>
                      <td width="126" valign="middle"><table width="98%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="30" align="left"><img src="<?php if(empty($res["simbolo"])){ print "imagens/0.jpg"; }else{ print "apqp_fluxo/$res[simbolo].jpg"; }?>" name="simbol" width="30" height="30" id="simbol"></td>
                            <td width="72%">&nbsp;&nbsp;&nbsp;<a href="#" onClick="return abrepop();"><img src="imagens/icon_14img.gif" alt="Selecionar caracter&iacute;stica" width="14" height="14" border="0"></a>
                                <input name="simbolo" type="hidden" id="simbolo3" value="<?php if(empty($res["simbolo"])){ print "999"; }else{ print "$res[simbolo]"; }?>">
                                <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
                                <input name="acao" type="hidden" id="acao" value="<?php print $acao; ?>">
                                <input name="car" type="hidden" id="car" value="<?php print $res["id"]; ?>">
                                <input name="busca" type="hidden" id="busca" value="<?php print $busca; ?>">
                                <input name="tipo" type="hidden" id="tipo" value="<?php if(empty($res["tipo"])){ print $tipo; }else{ print $res["tipo"]; } ?>">                            </td>
                          </tr>
                      </table></td>
                      <td colspan="2"><table width="270" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
                          <tr>
                            <td align="center" bgcolor="#004993" class="textoboldbranco"><p>Especifica&ccedil;&otilde;es da Engenharia </p></td>
                          </tr>
                          <tr>
                            <td align="center" bgcolor="#FFFFFF" class="textobold">LIE:
                                <input name="lie" type="text" class="formulario" id="lie3"  value="<?php print $res["lie"]; ?>" size="4" onBlur="toler();">
&nbsp;LSE:&nbsp;
                          <input name="lse" type="text" class="formulario" id="lse3"  value="<?php print $res["lse"]; ?>" size="4" onBlur="toler();">
&nbsp;Tol:
                          <input name="tol" type="text" class="formulario" id="tol3" value="<?php print $res["tol"]; ?>" size="4" readonly></td>
                          </tr>
                      </table></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="6"><img src="imagens/dot.gif" width="50" height="8"></td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="6" align="center"><input name="Submit2" type="submit" class="microtxt" value="Inserir S&iacute;mbolo" onClick="<?php echo  $btn3; ?>">
                        &nbsp;&nbsp;
                        <input name="button1222" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
  &nbsp;
  <input name="Button" type="button" class="microtxt" onClick="<?php echo  $btn2; ?>" value="Importar">
  &nbsp;
  <input name="Submit" type="submit" class="microtxt" value="Incluir" id="incluir" onClick="<?php echo  $btn; ?>"></td></tr>
                </table></td>
              </tr>
            </table>
            <script>funcpc(frmcar);</script>
        </form></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
            <tr class="textoboldbranco">
              <td width="36" align="center" class="textoboldbranco">&nbsp;</td>
              <td width="31" align="center">&nbsp;</td>
              <td width="31" align="center"><a href="apqp_car.php?acao=inc&ord=1&id=<?php print $id; ?>" class="textoboldbranco">&nbsp;Num</a></td>
              <td width="290">&nbsp;<a href="apqp_car.php?acao=inc&ord=2&id=<?php print $id; ?>" class="textoboldbranco">Descri&ccedil;&atilde;o</a></td>
              <td width="280">&nbsp;<a href="apqp_car.php?acao=inc&ord=3&id=<?php print $id; ?>" class="textoboldbranco">Especifica&ccedil;&atilde;o</a></td>
              <td width="62" align="center"><a href="apqp_car.php?acao=inc&ord2=1&id=<?php print $id; ?>" class="textoboldbranco">Tipo</a></td>
              <td width="32" align="center">PC</td>
              <td width="28" align="center">S</td>
              <td width="50" align="center">LIE</td>
              <td width="54" align="center">LSE</td>
              <td width="78" align="center">Tol</td>
            </tr>
            <?php
		$sql=mysql_query("SELECT * FROM apqp_car WHERE peca='$id' $busca2 ORDER BY $ord2,$ord");
		if(mysql_num_rows($sql)==0){
		?>
            <tr bgcolor="#FFFFFF">
              <td colspan="11" align="center" class="textopretobold">NENHUMA CARACTER&Iacute;STICA CADASTRADA </td>
            </tr>
            <?php
}else{ ?>
            <form name="frm3" action="apqp_car_sql.php" method="post">
              <tr bgcolor="#FFFFFF">
                <td width="36" align="center" class="textobold"><input name="imageField" type="image" src="imagens/icon14_lixeira.gif" width="14" height="14" border="0" onClick="<?php echo  $btn4; ?>">
                    <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
                    <input name="acao" type="hidden" id="acao" value="exc"></td>
                <td colspan="10" align="center" class="textobold">&nbsp;</td>
              </tr>
              <?php
	while($res=mysql_fetch_array($sql)){
?>
              <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                <td width="36" align="center"><input type="checkbox" name="del[<?php print $res["id"]; ?>]" value="checkbox"></td>
                <td width="31" align="center"><a href="apqp_car.php?acao=alt&car=<?php print $res["id"]; ?>&id=<?php print $id; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="31" align="center">&nbsp;<?php print $res["numero"]; ?></td>
                <td>&nbsp;<?php print $pal=cortar("$res[descricao]","6"); ?></td>
                <td width="280">&nbsp;<?php print $pal=cortar("$res[espec]","6"); ?></td>
                <td width="62" align="center"><?php print $res["tipo"]; ?></td>
                <td width="32" align="center"><img src="imagens/icon14_check<?php if($res["pc"]=="S"){ print "2"; }else{ print "1"; } ?>.gif" width="13" height="13"></td>
                <td width="28" align="center"><img src="<?php if($res["pc"]=="S"){ print "apqp_fluxo/$res[simbolo].jpg"; }else{ print "imagens/dot.gif"; } ?>" width="15" height="15"></td>
                <td width="50" align="center"><?php print banco2valor3($res["lie"]); ?></td>
                <td width="54" align="center"><?php print banco2valor3($res["lse"]); ?></td>
                <td width="78" align="center"><?php print banco2valor3($res["tol"]); ?></td>
              </tr>
              <?php
	} ?>
              <tr bgcolor="#FFFFFF">
                <td width="36" align="center" class="textobold"><input name="imageField" type="image" src="imagens/icon14_lixeira.gif" width="14" height="14" border="0" onClick="return veri();">
                </td>
                <td colspan="10" align="center" class="textobold">&nbsp;</td>
              </tr>
            </form>
            <?php } ?>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top" >&nbsp;<a href="#top" class="textobold">Top</a></td>
      </tr>
      <tr>
        <td><img src="imagens/dot.gif" width="50" height="5"></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>