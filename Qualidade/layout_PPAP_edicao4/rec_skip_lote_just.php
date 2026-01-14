<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function seleciona(){
	opener.form1.just.value=form1.just.value;
	window.close();
}
</script>
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
<table width="386" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="386" align="left" valign="top" class="chamadas"><table width="336" border="0" cellpadding="0" cellspacing="0" class="textopreto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="309" align="right"><div align="left"><span class="titulos">Recebimento &gt; Skip-Lote &gt; Justificativa </span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
<form name="form1" method="post" onSubmit="return verifica(this);">
  <tr>
    <td align="center" valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <tr>
      <td><table width="100%" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td class="textoboldbranco">&nbsp;Justificativa</td>
                </tr>
        <tr>
          <td><textarea name="just" cols="45" rows="5" class="formularioselect" id="just" onFocus="enterativa=0;" onBlur="enterativa=1;"></textarea></td>
        </tr>
        </table></td>
          </tr>
    </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
          
          <tr>
            <td><div align="center"><span class="textobold">
              <input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.close()">
              </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit" type="submit" class="microtxt" value="Continuar" onClick="return seleciona();">
            </span></div></td>
          </tr>
      </table>      </td></tr>
  </form>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>