<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="rr";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='rr'");
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
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_rr.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de R&R'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Os estudos de Repetitividade e Reprodutibilidade - R&R devem ser realizados sobre as características críticas utilizando-se o meio de medição especificado.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Estudo de R&amp;R <? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <? if($acao=="entrar"){ ?>
  <tr>
    <td align="center" valign="top" class="textobold"><input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="50" height="5"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
      <tr bgcolor="#004993" class="textoboldbranco">
        <td width="32" align="center">&nbsp;Num</td>
        <td width="157">&nbsp;Descri&ccedil;&atilde;o</td>
        <td width="143">&nbsp;Especifica&ccedil;&atilde;o</td>
        <td width="30" align="center">Tipo</td>
        <td width="30" align="center">S</td>
        <td width="58" align="center">vt</td>
        <td width="70" align="center">% R&amp;R (vt) </td>
        <td width="62" align="center">Disposi&ccedil;&atilde;o</td>
        <td width="16" align="center">&nbsp;</td>
        </tr>
<?
$sql=mysql_query("SELECT * FROM apqp_car WHERE peca='$pc' AND pc='S' ORDER BY tipo ASC");
if(mysql_num_rows($sql)==0){
?>
      <tr bgcolor="#FFFFFF">
        <td colspan="9" align="center" class="textopretobold">NENHUMA CARACTER&Iacute;STICA CADASTRADA </td>
      </tr>
<?
}else{
	while($res=mysql_fetch_array($sql)){
		unset($resrr["disp"]);
		unset($resrr["prr"]);
		unset($resrr["sit"]);
		unset($resrr["tv"]);
		$sqlrr=mysql_query("SELECT * FROM apqp_rr WHERE peca='$pc' AND car='$res[id]'");
		if(mysql_num_rows($sqlrr)) $resrr=mysql_fetch_array($sqlrr);
		if($res["disp"]==1){
			$resrr["disp"]="aprovado";
		}elseif($res["disp"]==2){
			$resrr["disp"]="reprovado";
		}else{
			$resrr["disp"]="pendente";
		}
?>
      <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td width="32" align="center">&nbsp;<? print $res["numero"]; ?></td>
        <td>&nbsp;<? print $res["descricao"]; ?></td>
        <td width="143">&nbsp;<? print $res["espec"]; ?></td>
        <td width="30" align="center"><? print $res["tipo"]; ?></td>
        <td width="30" align="center"><img src="<? if($res["pc"]=="S"){ print "apqp_fluxo/$res[simbolo].jpg"; }else{ print "imagens/dot.gif"; } ?>" width="15" height="15"></td>
        <td width="58" align="center"><? if($resrr["tv"]) print banco2valor3($resrr["tv"]); ?></td>
        <td width="70" align="center"><? if($resrr["prr"]) print banco2valor3($resrr["prr"]); ?></td>
        <td width="62" align="center"><?= $resrr["disp"]; ?></td>
        <td width="16" align="center"><a href="apqp_rr2.php?car=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
        </tr>
<?
	}
}
?>
    </table></td>
  </tr>
  <tr>
    <td><img src="imagens/dot.gif" width="50" height="5"></td>
  </tr>
  <tr><td align="center">
    <input name="button1" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
    </td>
  </tr>
  <? }else{ ?>
  <? } ?>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>