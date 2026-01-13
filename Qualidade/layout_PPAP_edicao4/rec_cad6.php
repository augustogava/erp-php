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
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_cad_pecas.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Cadastro de peças'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Preencha os campos obrigatórios, Numero interno, Rev, Data, Nome da peça, Cliente, N° peça Cli e depois de um clique em Cadastrar')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Recebimento - Notifica&ccedil;&atilde;o de N&atilde;o-Conformidade </div></td>
      </tr>
</table>
  <form name="form1" method="post" action="" onSubmit="return verifica(this)">
    <table width="469" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <td width="465" align="left" valign="top">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3" class="textobold"><table width="467" border="0" cellspacing="3" cellpadding="0">
                <tr class="textobold">
                  <td colspan="7" class="textoboldbranco">&nbsp;Solicita&ccedil;&atilde;o de An&aacute;lise Comprobat&oacute;ria </td>
                </tr>
                <tr class="textobold">
                  <td width="22%">&nbsp;Notifica&ccedil;&atilde;o N&ordm;:</td>
                  <td width="22%"><input name="textfield2" type="text" class="formulario" size="10"></td>
                  <td colspan="5">&nbsp;</td>
                </tr>
                <tr class="textobold">
                  <td colspan="5"><img src="imagens/dot.gif" width="20" height="8"></td>
                </tr>
                <tr class="textobold">
                  <td><div align="left">&nbsp;Fornecedor:</div></td>
                  <td colspan="6"><input name="textfield3" type="text" class="formularioselect" size="10"></td>
                </tr>
                <tr class="textobold">
                  <td><div align="left">&nbsp;&Iacute;tem:</div></td>
                  <td colspan="6">
                    <input name="textfield" type="text" class="formularioselect" size="10">                  </td>
                </tr>
                <tr class="textobold">
                  <td colspan="7"><img src="imagens/dot.gif" width="20" height="8"></td>
                </tr>
                
                <tr class="textobold">
                  <td colspan="2">Trefilador</td>
                  <td width="17%">&nbsp;</td>
                  <td colspan="4">&nbsp;</td>
                </tr>
                <tr class="textobold">
                  <td colspan="7"><table width="461" border="0" cellpadding="3" cellspacing="0">
                    <tr>
                      <td width="22%" class="textobold">Data Entrega: </td>
                      <td width="30%" class="textobold"><input name="textfield22" type="text" class="formulario" size="10"></td>
                      <td width="24%" class="textobold">N&ordm; do Lote: </td>
                      <td width="21%" class="textobold"><input name="textfield26" type="text" class="formulario" size="10"></td>
                      <td width="3%" class="textobold">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="textobold">Nota Fiscal: </td>
                      <td class="textobold"><input name="textfield23" type="text" class="formulario" size="10"></td>
                      <td class="textobold">Data N.F.: </td>
                      <td class="textobold"><input name="textfield27" type="text" class="formulario" size="10"></td>
                      <td class="textobold">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="textobold">Num. do Pedido: </td>
                      <td class="textobold"><input name="textfield24" type="text" class="formulario" size="10"></td>
                      <td class="textobold">CRM:</td>
                      <td class="textobold"><input name="textfield28" type="text" class="formulario" size="10"></td>
                      <td class="textobold">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="textobold">Certificado</td>
                      <td class="textobold"><input name="textfield25" type="text" class="formulario" size="10"></td>
                      <td class="textobold">Tamanho do Lote: </td>
                      <td class="textobold"><input name="textfield29" type="text" class="formulario" size="10"></td>
                      <td class="textobold">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="5" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td class="textobold"><div align="left">&nbsp;Causas da N/C:&nbsp;</div></td>
              <td width="77%" rowspan="2" class="textobold"><textarea name="historico" rows="4" wrap="VIRTUAL" class="formularioselect" id="historico" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["historico"]; ?></textarea></td>
              <td width="1%" rowspan="2"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc_inc_2&var_field=dteng','','scrollbars=no,width=155,height=138');"></a></td>
            </tr>
            <tr>
              <td width="22%" class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td class="textobold"><div align="left">&nbsp;A&ccedil;&otilde;es Imediatas:&nbsp;</div></td>
              <td rowspan="2" class="textobold"><textarea name="historico" rows="4" wrap="VIRTUAL" class="formularioselect" id="historico" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["historico"]; ?></textarea></td>
              <td rowspan="2"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc_inc_2&var_field=dteng','','scrollbars=no,width=155,height=138');"></a></td>
            </tr>
            <tr>
              <td class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td class="textobold"><div align="left">&nbsp;A&ccedil;&otilde;es a Longo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prazo:</div></td>
              <td rowspan="2" class="textobold"><textarea name="historico" rows="4" wrap="VIRTUAL" class="formularioselect" id="historico" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["historico"]; ?></textarea></td>
              <td rowspan="2"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc_inc_2&var_field=dteng','','scrollbars=no,width=155,height=138');"></a></td>
            </tr>
            <tr>
              <td class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td class="textobold"><div align="left">&nbsp;Estimativas:&nbsp;</div></td>
              <td rowspan="2" class="textobold"><textarea name="historico" rows="4" wrap="VIRTUAL" class="formularioselect" id="historico" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["historico"]; ?></textarea></td>
              <td rowspan="2"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc_inc_2&var_field=dteng','','scrollbars=no,width=155,height=138');"></a></td>
            </tr>
            <tr>
              <td class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
          </table>
	    </td>
      </tr>
    </table>
    <span class="textobold"><img src="imagens/dot.gif" width="20" height="8"></span>
    <table width="469" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div align="center"><span class="textobold">
          <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_pc.php';">
          &nbsp;&nbsp;&nbsp;
          <input name="button1222" type="submit" class="microtxt" value="Incluir">
        </span></div></td>
      </tr>
    </table>
  </form>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>