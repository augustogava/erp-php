<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
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
        <td width="563" align="right"><div align="left" class="titulos">Recebimento - Cadastro</div></td>
      </tr>
</table><form name="form1" method="post" action="" onSubmit="return verifica(this)">
<table width="586" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="582" align="left" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="100%" class="textobold"><table width="100%" border="0" cellspacing="3" cellpadding="0">
            <tr class="textobold">
              <td colspan="9" class="textoboldbranco">&nbsp;Controle de Entregas </td>
              </tr>
            <tr class="textobold">
              <td width="20%"><div align="right">CRM:&nbsp;</div></td>
              <td width="10%"><label>
                <input name="textfield" type="text" class="formulario" size="10">
              </label></td>
              <td width="4%">&nbsp;</td>
              <td width="17%"><div align="right">Fornecedor:&nbsp;</div></td>
              <td colspan="4"><input name="textfield6" type="text" class="formularioselect"></td>
              <td width="3%">&nbsp;</td>
              </tr>
            <tr class="textobold">
              <td><div align="right">Data da Entrada:&nbsp;</div></td>
              <td><input name="dtent" type="text" class="formulario" id="dtent" size="10"></td>
              <td><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_cad2_1&var_field=dteng','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td><div align="right">&Iacute;tem:&nbsp;</div></td>
              <td colspan="4"><input name="textfield7" type="text" class="formularioselect"></td>
              <td>&nbsp;</td>
              </tr>
            <tr class="textobold">
              <td><div align="right">N&ordm; do Lote:&nbsp;</div></td>
              <td><input name="textfield3" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              <td><div align="right">Dias/Atraso:&nbsp;</div></td>
              <td width="10%"><input name="textfield37" type="text" class="formulario" size="10"></td>
              <td width="4%">&nbsp;</td>
              <td width="17%"><div align="right">Tam/Lote:&nbsp;</div></td>
              <td width="15%"><input name="textfield38" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
            </tr>
            <tr class="textobold">
              <td><div align="right">Tam/Amost:&nbsp;</div></td>
              <td><input name="textfield32" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              <td><div align="right">RAI:&nbsp;</div></td>
              <td><input name="textfield36" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              <td><div align="right">Validade:&nbsp;</div></td>
              <td><input name="validade" type="text" class="formulario" id="validade" size="10"></td>
              <td><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_cad2_2&var_field=dteng','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              </tr>
            <tr class="textobold">
              <td><div align="right">N&ordm; Nota Fiscal:&nbsp; </div></td>
              <td><input name="textfield33" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              <td><div align="right">Data/Fisc:&nbsp;</div></td>
              <td><input name="dtfisc" type="text" class="formulario" id="dtfisc" size="10"></td>
              <td><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_cad2_3&var_field=dteng','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td><div align="right">Pre&ccedil;o Uni:&nbsp;</div></td>
              <td><input name="textfield5" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              </tr>
            <tr class="textobold">
              <td><div align="right">N&ordm; Certificado:&nbsp; </div></td>
              <td><input name="textfield34" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              <td><div align="right">N&ordm; Pedido:&nbsp; </div></td>
              <td><input name="textfield35" type="text" class="formulario" size="10"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
          </tr>
        
        <tr>
          <td class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
        <tr align="center">
          <td class="textobold">
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_pc.php';">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="button122" type="submit" class="microtxt" value="Salvar">            </td>
          </tr>
        <tr align="center">
          <td class="textobold"><table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="textobold">Amostragem:</td>
                </tr>
              </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="textobold">

                <tr>
                  <td class="textoboldbranco">&nbsp;&nbsp;Plano</td>
                  <td class="textoboldbranco">&nbsp;&nbsp;N&iacute;vel</td>
                  <td class="textoboldbranco">&nbsp;&nbsp;NQA</td>
                  <td class="textoboldbranco">&nbsp;&nbsp;Amostra</td>
                  <td class="textoboldbranco">&nbsp;Aceite</td>
                  <td class="textoboldbranco">&nbsp;&nbsp;Rejeite</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
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
      </table>
    </td>
  </tr>
</table></form>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>