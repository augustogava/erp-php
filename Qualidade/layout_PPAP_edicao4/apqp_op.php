<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="inc";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM apqp_op WHERE id='$op'");
	$res=mysql_fetch_array($sql);
}
//Verificação
$_SESSION["modulo"]="operacao";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='operacao'");
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
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$btn="frmop.submit();";
		$btn2="return abre('apqp_op_pc.php?id=$id&npc2=$npc','selimagem','width=640,height=600,scrollbars=yes');";
		$btn3="return veri();";
	}else{
		$btn="window.alert('Não pode ser alterado/incluido pois está peça já foi aprovada!');";
		$btn2="window.alert('Não pode ser alterado/incluido pois está peça já foi aprovada!');";
		$btn3="window.alert('Não pode ser alterado/incluido pois está peça já foi aprovada!'); return false;";
	}
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
guardasimbol='apqp_fluxo/<?php print $res["simbolo"]; ?>.jpg';
guardasimbolo='<?php print $res["simbolo"]; ?>';
function pinta(num){
	frmop.imop.src='imagens/op_'+num+'.jpg';
}
function verifica(cad){
	if(cad.numero.value==''){
		alert('Informe o número da operação');
		cad.numero.focus();
		return false;
	}
	if(cad.descricao.value==''){
		alert('Informe a descrição');
		cad.descricao.focus();
		return false;
	}
	if(cad.tipo.value==''){
		alert('Informe o Tipo');
		cad.tipo.focus();
		return false;
	}
	return true;
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
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_cad_ope.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Cadastro de Operações'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Existem 6 tipos de Operações - </strong>Operação, Operação com Inspeção, Inspeção, Estocagem, Transporte e Decisão e cada operação tem uma simbologia que o representa.<br><strong>N° da operação - </strong>Identificação da operação<br><strong>Maquina/Local - </strong>Lugar ou local onde vai ser executada a operação<br><strong>Descrição - </strong>Como vai ser executada a operação<br><strong>Observação - </strong>Algo que deve ser ressaltado ou lembrado.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Opera&ccedil;&otilde;es <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="100%"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><table width="102%" border="0" cellpadding="0" cellspacing="0">
      <?php if($acao=="inc" or $acao=="alt"){ ?>
      <tr>
        <td align="left" valign="top"><form action="apqp_op_sql.php" method="post" name="frmop" id="frmop" onSubmit="return verifica(this);">
            <table width="100" border="0" cellpadding="3" cellspacing="1" bgcolor="#003366">
              <tr>
                <td align="center" bgcolor="#004993" class="textoboldbranco"><?php if($acao=="alt"){ print "Alterar"; }else{ print "Incluir"; } ?>
&nbsp;opera&ccedil;&atilde;o </td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF"><table width="594" border="0" cellspacing="0" cellpadding="3">
                    <tr class="textobold">
                      <td width="85">&nbsp;Opera&ccedil;&atilde;o N&ordm; </td>
                      <td width="115"><input name="numero" type="text" class="formulario" id="numero" value="<?php print $res["numero"]; ?>" size="5" maxlength="20">
                          <input name="id" type="hidden" id="id5" value="<?php print $id; ?>">
                          <input name="acao" type="hidden" id="acao5" value="<?php print $acao; ?>">
                          <input name="op" type="hidden" id="car5" value="<?php print $res["id"]; ?>"></td>
                      <td width="93">M&aacute;quina / Local </td>
                      <td width="271"><input name="macloc" type="text" class="formularioselect" id="espec3" value="<?php print $res["macloc"]; ?>" maxlength="200"></td>
                      <td width="30" align="center"><a href="#" onClick="return abre('apqp_desc1.php','icones','width=520,height=280,scrollbars=1');"><img src="imagens/icon_14img.gif" alt="Procurar Descri&ccedil;&atilde;o" width="14" height="14" border="0"></a></td>
                    </tr>
                    <tr class="textobold">
                      <td>&nbsp;Descri&ccedil;&atilde;o</td>
                      <td colspan="3"><input name="descricao" type="text" class="formularioselect" id="descricao" value="<?php print $res["descricao"]; ?>" maxlength="200"></td>
                      <td align="center"><a href="#" onClick="return abre('apqp_desc2.php','icones','width=520,height=280,scrollbars=1');"><img src="imagens/icon_14img.gif" alt="Procurar Descri&ccedil;&atilde;o" width="14" height="14" border="0"></a></td>
                    </tr>
                    <tr class="textobold">
                      <td>&nbsp;Observa&ccedil;&otilde;es</td>
                      <td colspan="3"><input name="obs" type="text" class="formularioselect" id="obs" value="<?php print $res["obs"]; ?>" size="96" maxlength="200"></td>
                      <td align="center">&nbsp;</td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="5" align="center"><table width="410" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
                          <tr bgcolor="#004993">
                            <td colspan="2" align="center" class="textoboldbranco">Tipo</td>
                          </tr>
                          <tr bgcolor="#FFFFFF" class="textobold">
                            <td width="338" align="center"><input name="tipo" type="radio" value="1" <?php if(empty($res["tipo"]) or $res["tipo"]=="1") print "checked"; ?> onClick="return pinta(this.value);">
                          Opera&ccedil;&atilde;o
                          <input name="tipo" type="radio" value="2" <?php if($res["tipo"]=="2") print "checked"; ?> onClick="return pinta(this.value);">
                          Opera&ccedil;&atilde;o com Inspe&ccedil;&atilde;o
                          <input name="tipo" type="radio" value="3" <?php if($res["tipo"]=="3") print "checked"; ?> onClick="return pinta(this.value);">
                          Inspe&ccedil;&atilde;o</td>
                            <td width="57" rowspan="2" align="center" valign="middle"><span class="texto"><img src="imagens/op_<?php if(empty($res["tipo"])){ print "1"; }else{ print $res["tipo"]; } ?>.jpg" name="imop" width="30" height="30" id="imop"></span></td>
                          </tr>
                          <tr bgcolor="#FFFFFF" class="textobold">
                            <td align="center"><input name="tipo" type="radio" value="4" <?php if($res["tipo"]=="4") print "checked"; ?>  onClick="return pinta(this.value);">
                          Estocagem
                            <input name="tipo" type="radio" value="5" <?php if($res["tipo"]=="5") print "checked"; ?>  onClick="return pinta(this.value);">
                          Transporte
                          <input name="tipo" type="radio" value="6" <?php if($res["tipo"]=="6") print "checked"; ?>  onClick="return pinta(this.value);">
                          Decis&atilde;o</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="5" align="center"><input name="button1222" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
                         &nbsp;&nbsp;&nbsp;&nbsp;
                         <input name="Button" type="button" class="microtxt" onClick="<?php echo  $btn2; ?>" value="Importar">
&nbsp;&nbsp;
                    <input name="im2" type="button" class="microtxt" value="Continuar" onClick="<?php echo  $btn; ?>">
                      </td>
                    </tr>
                </table></td>
              </tr>
            </table>
        </form></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
            <tr bgcolor="#004993" class="textoboldbranco">
              <td width="77" align="center">&nbsp;</td>
              <td width="26" align="center">&nbsp;</td>
              <td width="64" align="center">&nbsp;Num</td>
              <td width="223">&nbsp;Descri&ccedil;&atilde;o</td>
              <td width="272">&nbsp;M&aacute;quina / Local </td>
              <td width="54" align="center">Tipo</td>
              <td width="273">&nbsp;Obs</td>
            </tr>
            <?php
$sql=mysql_query("SELECT * FROM apqp_op WHERE peca='$id' ORDER BY numero ASC");
if(mysql_num_rows($sql)==0){
?>
            <tr bgcolor="#FFFFFF">
              <td colspan="7" align="center" class="textopretobold">nenhuma opera&ccedil;&atilde;o cadastrada </td>
            </tr>
            <?php }else{ ?>
            <form name="frm3" action="apqp_op_sql.php" method="post">
              <tr bgcolor="#FFFFFF">
                <td align="center" class="textobold"><input name="imageField" onClick="<?php echo  $btn3; ?>" type="image" src="imagens/icon14_lixeira.gif" width="14" height="14" border="0">
                    <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
                    <input name="acao" type="hidden" id="acao" value="exc"></td>
                <td colspan="6" align="center" class="textobold">&nbsp;</td>
              </tr>
              <?php
	while($res=mysql_fetch_array($sql)){
?>
              <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                <td align="center"><input name="del[<?php print $res["id"]; ?>]" type="checkbox" id="del"></td>
                <td align="center"><a href="apqp_op.php?acao=alt&op=<?php print $res["id"]; ?>&id=<?php print $id; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td align="center"><?php print $res["numero"]; ?></td>
                <td>&nbsp;<?php print $res["descricao"]; ?></td>
                <td>&nbsp;<?php print $res["macloc"]; ?></td>
                <td align="center"><img src="imagens/op_<?php print $res["tipo"]; ?>.jpg" width="15" height="15"></td>
                <td >&nbsp;<?php print $res["obs"]; ?></td>
              </tr>
              <?php } ?>
              <tr bgcolor="#FFFFFF">
                <td align="center" class="textobold"><input name="imageField" type="image" src="imagens/icon14_lixeira.gif" width="14" height="14" border="0" onClick="return veri();">
                </td>
                <td colspan="6" align="center" class="textobold">&nbsp;</td>
              </tr>
            </form>
            <?php } ?>
        </table></td>
      </tr>
      <tr>
        <td><img src="imagens/dot.gif" width="50" height="5"></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top"></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>