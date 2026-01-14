<?php
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Alterar Peça";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
//Verificação
$_SESSION["modulo"]="cadpeca";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='cadpeca'");
if(mysql_num_rows($sqlm)){
	$resm=mysql_fetch_array($sqlm);
	if($resm["funcionario"]=="S" or empty($resm["funcionario"])){
		$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}else{
		$sql2=mysql_query("SELECT * FROM clientes WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}
	$_SESSION["mensagem"]="O usuario $res2[nome] está alterando este módulo!";
	header("Location:apqp_menu.php?menu=S&pc=$pc");
	exit;
}
// - - -FIM- - - 
if($acao="alt"){
	$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$id' AND apqp_pc.cliente=clientes.id");
	$res=mysql_fetch_array($sql);
}
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$id' AND ativ='Certificado de Submissão'");
	if(mysql_num_rows($sqlb)){
		$bnt="window.alert('O Certificado de submissão já esté aprovado, não pode ser alterado!');";
	}else{
		$bnt="form1.submit();";
	}

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
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_STICKY=true; this.T_TITLE='Cadastro de peça'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Esta é a tela de uma peça já cadastrada podendo ser alterada caso haja algum tipo de erro de digitação. Obs: Campos Número Interno, Revisão e data não podem ser alterados.')"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Cadastro de Pe&ccedil;as </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="547" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="537" align="left" valign="top"><form name="form1" method="post" action="apqp_pc_sql.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="140" class="textobold">N&uacute;mero Interno</td>
            <td width="362" class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="35%"><input name="numero" type="text" class="formularioselect" id="numero" size="0" maxlength="8" value="<?php print $res["numero"]; ?>" readonly=""></td>
                  <td width="13%" class="textobold"><div align="center">Rev.</div></td>
                  <td width="16%" class="textobold"><input name="rev" type="text" class="formularioselect" id="rev" size="5" maxlength="20" value="<?php print $res["rev"]; ?>" onKeyPress="return validanum(this, event)" readonly=""></td>
                  <td width="12%" class="textobold"><div align="center">Data&nbsp; </div></td>
                  <td class="textobold"><input name="dtrev" type="text" class="formularioselect" id="dtrev2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="15" maxlength="10" value="<?php print banco2data($res["dtrev"]); ?>"></td>
                </tr>
            </table></td>
            <td width="14"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc2_1','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
          </tr>
          <tr>
            <td class="textobold">Nome da Pe&ccedil;a</td>
            <td><input name="nome" type="text" class="formularioselect" id="nome" maxlength="150" value="<?php print $res["nome"]; ?>"></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td class="textobold">Cliente</td>
            <td><input name="nomecli" type="text" class="formularioselect" id="nomecli" value="<?php print $res["nomecli"]; ?>" readonly></td>
            <td align="center"><a href="#" onClick="return abre('apqp_pccli.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_cli.gif" width="18" height="18" border="0"></a><a href="#" onClick="return abre('apqp_pccli.php','a','width=320,height=300,scrollbars=1');"></a> </td>
          </tr>
          <tr>
            <td class="textobold">N&ordm; do pedido de compra da ferramenta</td>
            <td><input name="num_ferram" type="text" class="formulario" id="num_ferram" maxlength="10" value="<?php print $res["num_ferram"]; ?>"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="textobold">Desenho Int.</td>
            <td><input name="desenhoi" type="text" class="formulario" id="desenhoi" maxlength="30" value="<?php print $res["desenhoi"]; ?>">
                <input name="cliente" type="hidden" id="cliente" value="<?php print $res["cliente"]; ?>">            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="textobold">N&ordm; Pe&ccedil;a Cli.</td>
            <td><input name="pecacli" type="text" class="formulario" id="pecacli" value="<?php print $res["pecacli"]; ?>" maxlength="30"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="textobold">Desenho Cli. </td>
            <td><input name="desenhoc" type="text" class="formulario" id="desenhoc" value="<?php print $res["desenhoc"]; ?>" maxlength="30">
                <span class="textobold">
                <input name="acao" type="hidden" value="<?php echo  $acao; ?>">
                <input name="id" type="hidden" id="id" value="<?php echo  $id; ?>">
</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="textobold">Aplica&ccedil;&atilde;o</td>
            <td><input name="aplicacao" type="text" class="formulario" id="aplicacao" value="<?php print $res["aplicacao"]; ?>" maxlength="50"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="textobold">N&iacute;vel de altera&ccedil;&atilde;o Eng. </td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="65%"><input name="niveleng" type="text" class="formularioselect" id="niveleng" value="<?php print $res["niveleng"]; ?>" maxlength="20"></td>
                  <td width="12%" class="textobold"><div align="center">Data</div></td>
                  <td width="23%"><input name="dteng" type="text" class="formularioselect" id="dteng2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($res["dteng"]); ?>" size="9" maxlength="10"></td>
                </tr>
            </table></td>
            <td><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc2_2','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
          </tr>
          <tr>
            <td class="textobold">N&iacute;vel de altera&ccedil;&atilde;o Proj. </td>
            <td class="textobold"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="65%"><input name="nivelproj" type="text" class="formularioselect" id="nivelproj" value="<?php print $res["nivelproj"]; ?>" maxlength="20"></td>
                <td width="12%"><div align="center" class="textobold">Data</div></td>
                <td width="23%"><input name="dtproj" type="text" class="formularioselect" id="dteng" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($res["dtproj"]); ?>" size="9" maxlength="10"></td>
              </tr>
            </table></td>
            <td><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc2_3','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
          </tr>
          <tr>
            <td class="textobold">Hist&oacute;rico das Altera&ccedil;&otilde;es</td>
            <td class="textobold"><textarea name="historico" rows="6" wrap="VIRTUAL" class="formularioselect" id="historico" onFocus="enterativa=0;" onBlur="enterativa=1;"><?php print $res["historico"]; ?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
          <tr align="center">
            <td colspan="3" class="textobold"><input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Button" type="button" class="microtxt" value="Alterar" onClick="<?php echo  $bnt; ?>"></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>