<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="cap";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='cap'");
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
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O resultado de um processo de manufatura estatisticamente estável pode ser descrito por sua distribuição.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1">APQP - Estudo de Capabilidade <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <?php if($acao=="entrar"){ ?>
  <tr>
    <td align="center" valign="top" class="textobold"><input name="button1222" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="50" height="5"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
      <tr bgcolor="#004993" class="textoboldbranco">
        <td width="43" align="center">&nbsp;Num</td>
        <td width="202">&nbsp;Descri&ccedil;&atilde;o</td>
        <td width="190">&nbsp;Especifica&ccedil;&atilde;o</td>
        <td width="38" align="center">Tipo</td>
        <td width="38" align="center">S</td>
        <td width="111" align="center">Cp</td>
        <td width="57" align="center">Cpk</td>
        <td width="114" align="center">Disposi&ccedil;&atilde;o</td>
        <td width="34" align="center">&nbsp;</td>
        </tr>
<?php
$sql=mysql_query("SELECT * FROM apqp_car WHERE peca='$pc' AND pc='S' ORDER BY tipo ASC");
if(mysql_num_rows($sql)==0){
?>
      <tr bgcolor="#FFFFFF">
        <td colspan="9" align="center" class="textopretobold">nenhuma caracter&iacute;stica cadastrada </td>
      </tr>
<?php
}else{
	while($res=mysql_fetch_array($sql)){
		unset($resrr["disp"]);
		unset($resrr["prr"]);
		unset($resrr["sit"]);
		$resrr["cp"]="";
		$resrr["cpk"]="";
		$sqlrr=mysql_query("SELECT * FROM apqp_cap WHERE peca='$pc' AND car='$res[id]'");
//		print "SELECT * FROM apqp_cap WHERE peca='$pc' AND car='$res[id]'";
		if(mysql_num_rows($sqlrr)) $resrr=mysql_fetch_array($sqlrr);
		if($res["disp_cap"]==1){
			$resrr["disp"]="aprovado";
		}elseif($res["disp_cap"]==2){
			$resrr["disp"]="reprovado";
		}else{
			$resrr["disp"]="pendente";
		}
?>
      <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td width="43" align="center">&nbsp;<?php print $res["numero"]; ?></td>
        <td>&nbsp;<?php print $res["descricao"]; ?></td>
        <td width="190">&nbsp;<?php print $res["espec"]; ?></td>
        <td width="38" align="center"><?php print $res["tipo"]; ?></td>
        <td width="38" align="center"><img src="<?php if($res["pc"]=="S"){ print "apqp_fluxo/$res[simbolo].jpg"; }else{ print "imagens/dot.gif"; } ?>" width="30" height="30"></td>
        <td width="111" align="center"><?php print banco2valor3($resrr["cp"]); ?></td>
        <td width="57" align="center"><?php print banco2valor3($resrr["cpk"]); ?> </td>
        <td width="114" align="center"><?php echo  $resrr["disp"]; ?></td>
        <td width="34" align="center"><a href="apqp_cap2.php?car=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
        </tr>
<?php
	}
}
?>
    </table></td>
  </tr>
  <tr>
    <td><img src="imagens/dot.gif" width="50" height="5"></td>
  </tr>
  <tr><td align="center"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';"></td>
  </tr>
  <?php }else{ ?>
  <?php } ?>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>