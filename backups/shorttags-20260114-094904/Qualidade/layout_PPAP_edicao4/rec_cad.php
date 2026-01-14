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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">Recebimento - Cadastro</div></td>
      </tr>
</table>
<form name="form1" method="post" action="" onSubmit="return verifica(this)">
<table width="584" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="580" align="left" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td colspan="3" class="textobold"><table width="100%" border="0" cellspacing="3" cellpadding="0">
            <tr class="textobold">
              <td colspan="8" class="textoboldbranco">&nbsp;Identifica&ccedil;&atilde;o Interna dos Materiais </td>
              </tr>
            <tr class="textobold">
              <td width="17%"><div align="right">CRM:&nbsp;</div></td>
              <td width="13%"><label>
                <input name="textfield" type="text" class="formulario" size="10">
              </label></td>
              <td width="3%">&nbsp;</td>
              <td width="16%"><div align="right">Fornecedor:&nbsp;</div></td>
              <td colspan="3"><input name="textfield6" type="text" class="formularioselect"></td>
              <td width="4%"><input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0"></td>
              </tr>
            <tr class="textobold">
              <td><div align="right">Data da Entrada:&nbsp;</div></td>
              <td><input name="dtent" type="text" class="formulario" id="dtent" size="10"></td>
              <td><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_cad_1&var_field=dteng','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td><div align="right">&Iacute;tem:&nbsp;</div></td>
              <td colspan="3"><input name="textfield7" type="text" class="formularioselect"></td>
              <td><input name="imageField2" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0"></td>
              </tr>
            <tr class="textobold">
              <td><div align="right">N&ordm; Nota Fiscal:&nbsp;</div></td>
              <td><input name="textfield3" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="17%">&nbsp;</td>
              <td width="16%">&nbsp;</td>
              <td width="14%">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr class="textobold">
              <td colspan="2"><div align="right">Quantidade de Material:</div></td>
              <td>&nbsp;</td>
              <td><div align="right">Rolo:&nbsp;</div></td>
              <td><input name="textfield4" type="text" class="formulario" size="10"></td>
              <td><div align="right">Total:&nbsp;</div></td>
              <td><input name="textfield5" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              </tr>
          </table></td>
          </tr>
        
        <tr>
          <td class="textobold"><div align="right">OBS:&nbsp;</div></td>
          <td width="85%" rowspan="2" class="textobold"><textarea name="historico" rows="4" wrap="VIRTUAL" class="formularioselect" id="historico" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["historico"]; ?></textarea></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="11%" class="textobold">&nbsp;</td>
          <td width="4%"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc_inc_2&var_field=dteng','','scrollbars=no,width=155,height=138');"></a></td>
        </tr>
        <tr>
          <td colspan="3" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
        <tr align="center">
          <td colspan="3" class="textobold">
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_pc.php';">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="button122" type="submit" class="microtxt" value="Salvar">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="button1222" type="submit" class="microtxt" value="Continuar"></td>
          </tr>
        <tr align="center">
          <td colspan="3" class="textobold"><table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="textobold">&Uacute;ltimas Entregas:</td>
                </tr>
              </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="textobold">

                <tr>
                  <td class="textoboldbranco">&nbsp;&nbsp;Data Entrega</td>
                  <td class="textoboldbranco">&nbsp;&nbsp;N&ordm; Lote </td>
                  <td class="textoboldbranco">&nbsp;&nbsp;Skip-Lote</td>
                  <td class="textoboldbranco">&nbsp;&nbsp;Laudo</td>
                  <td class="textoboldbranco">&nbsp;&nbsp;CRM</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr align="center"></tr>
      </table>
    </td>
  </tr>
</table></form>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>