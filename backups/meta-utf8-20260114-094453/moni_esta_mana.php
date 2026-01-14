<?
include("conecta.php");
include("seguranca.php");
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>

<style type="text/css">
<!--
.style1 {font-size: 14px}
.style4 {font-size: 9px}
.style5 {	font-size: 10px;
	font-weight: bold;
	color: #FFFFFF;
	text-decoration: none;
	background-color: #004996;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">Estat&iacute;stica</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="100%"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td width="569" class="textoboldbranco">RELAT&Oacute;RIOS <span class="style4">(Obs: &Eacute; necess&aacute;rio Acrobat Reader atualizado para visualiza&ccedil;&atilde;o dos relat&oacute;rios. <a href="http://www.adobe.com.br/products/acrobat/readstep2.html" target="_blank" class="style5">Para baixar clique aqui</a></span><span class="style4">)</span></td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('4');"></a></td>
            </tr>
            <tr align="left" bgcolor="#FFFFFF">
              <td colspan="2" id="apqp4"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="124"><a href="moni_esta_raus.php"><img src="imagens/icon_dv.jpg" alt="Cronograma" width="35" height="40" border="0"></a></td>
                  <td width="124"><a href="moni_esta_raex.php"><img src="imagens/icon_ab.jpg" width="34" height="40" border="0"></a></td>
                  <td width="124"><a href="moni_esta_radh.php"><img src="imagens/icon_ab2.jpg" width="34" height="40" border="0"></a></td>
                  <td width="124"><a href="moni_esta_raudh.php"><img src="imagens/icon_de.jpg" width="34" height="40" border="0"></a></td>
                  <td width="124"><a href="moni_esta_raac.php"><img src="imagens/icon_lc.jpg" width="34" height="40" border="0"></a></td>
                  <td width="124"><a href="moni_esta_ralp.php"><img src="imagens/icon_bc.jpg" width="34" height="40" border="0"></a></td>
                  <td width="124">&nbsp;</td>
                  <td width="124">&nbsp;</td>
                </tr>
                <tr align="center" class="textobold">
                  <td width="124"><a href="moni_esta_raus.php" class="textobold">Relat&oacute;rio de Acesso por Usu&aacute;rio </a><a href="conr_imp_dven.php" class="textobold"></a></td>
                  <td width="124"><a href="moni_esta_raex.php" class="textobold">Relat&oacute;rio de Acesso por Usu&aacute;rio Externo </a><a href="conr_imp_dacl.php" class="textobold"></a></td>
                  <td width="124"><a href="moni_esta_radh.php" class="textobold">Relat&oacute;rio de Acesso por Data e Hora </a></td>
                  <td width="124"><a href="moni_esta_raudh.php" class="textobold">Relat&oacute;rio de Acesso por Usu&aacute;rio, Data e Hora </a></td>
                  <td width="124"><a href="moni_esta_raac.php" class="textobold">Relat&oacute;rio de Acesso por A&ccedil;&atilde;o </a></td>
                  <td width="124"><a href="moni_esta_ralp.php" class="textobold">Relat&oacute;rio de Acesso por Local da P&aacute;gina</a></td>
                  <td width="124">&nbsp;</td>
                  <td width="124">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      
      <script>someini();</script>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? include("mensagem.php"); ?>