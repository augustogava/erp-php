<?
include("conecta.php");
include("seguranca.php");
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script>
<!--
function verifica(cad){
	if(cad.numero.value==''){
		alert('Preencha o Número Interno');
		cad.numero.focus();
		return false;
	}
	if(cad.rev.value==''){
		alert('Preencha o Número da Revisão');
		cad.rev.focus();
		return false;
	}
	if(cad.dtrev.value==''){
		alert('Preencha a data da Revisão');
		cad.dtrev.focus();
		return false;
	}
	if(cad.nome.value==''){
		alert('Preencha o Nome da peça');
		cad.nome.focus();
		return false;
	}
	if(cad.nomecli.value==''){
		alert('Escolha o Cliente');
		cad.nomecli.focus();
		return false;
	}
	return true;
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
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_cad_pecas.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Cadastro de peças'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Preencha os campos obrigatórios, Numero interno, Rev, Data, Nome da peça, Cliente, N° peça Cli e depois de um clique em Cadastrar')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Cadastro de Pe&ccedil;as </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="547" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="537" align="left" valign="top"><form name="form1" method="post" action="apqp_pc_sql.php" onSubmit="return verifica(this)">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="140" class="textobold">N&uacute;mero Interno</td>
          <td width="362" class="textobold">
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="35%"><input name="numero" type="text" class="formularioselect" id="numero" size="0" maxlength="8"></td>
                <td width="13%" class="textobold"><div align="center">Rev.</div></td>
                <td width="16%" class="textobold">
                  <input name="rev" type="text" class="formularioselect" id="rev" size="5" maxlength="20" onKeyPress="return validanum(this, event)"></td>
                <td width="12%" class="textobold"><div align="center">Data&nbsp; </div></td>
                <td class="textobold">  <input name="dtrev" type="text" class="formularioselect" id="dtrev2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="15" maxlength="10" value="<? print banco2data($res["dtrev"]); ?>"></td>
              </tr>
            </table></td>
          <td width="14"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc_inc_1&var_field=dtrev','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
        </tr>
        <tr>
          <td class="textobold">Nome da Pe&ccedil;a</td>
          <td><input name="nome" type="text" class="formularioselect" id="nome" maxlength="150"></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td class="textobold">Cliente</td>
          <td><input name="nomecli" type="text" class="formularioselect" id="nomecli" readonly></td>
          <td align="center">
            <a href="#" onClick="return abre('apqp_pccli.php','a','width=320,height=360,scrollbars=1');"><img src="imagens/icon14_pessoas.gif" width="14" height="14" border="0"></a>            </td>
        </tr>
        <tr>
          <td class="textobold">Desenho Int.</td>
          <td><input name="desenhoi" type="text" class="formulario" id="desenhoi" maxlength="30"><input name="cliente" type="hidden" id="cliente" value="">
            </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="textobold">N&ordm; Pe&ccedil;a Cli.</td>
          <td><input name="pecacli" type="text" class="formulario" id="pecacli" maxlength="30"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="textobold">Desenho Cli. </td>
          <td><input name="desenhoc" type="text" class="formulario" id="desenhoc" maxlength="30">
            <span class="textobold">
            <input name="acao" type="hidden" value="add">
            </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="textobold">Aplica&ccedil;&atilde;o</td>
          <td><input name="aplicacao" type="text" class="formulario" id="aplicacao" maxlength="50"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="textobold">N&iacute;vel de altera&ccedil;&atilde;o Eng. </td>
          <td class="textobold">
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="65%"><input name="niveleng" type="text" class="formularioselect" id="niveleng" maxlength="20"></td>
                <td width="12%" class="textobold"><div align="center">Data</div></td>
                <td width="23%"><input name="dteng" type="text" class="formularioselect" id="dteng2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="9" maxlength="10" data></td>
              </tr>
            </table></td>
          <td><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc_inc_2&var_field=dteng','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
        </tr>
        <tr>
          <td class="textobold">Hist&oacute;rico das Altera&ccedil;&otilde;es</td>
          <td class="textobold"><textarea name="historico" rows="6" wrap="VIRTUAL" class="formularioselect" id="historico" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["historico"]; ?></textarea></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
        <tr align="center">
          <td colspan="3" class="textobold">
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_pc.php';">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="button122" type="submit" class="microtxt" value="Cadastrar">
            </td>
          </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>