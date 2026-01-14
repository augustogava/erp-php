<?php
include("conecta.php");
include("seguranca.php");
unset($_SESSION["mpc"]);
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">Metrologia</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="67%"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td class="textoboldbranco">CADASTROS<a href="#" onClick="return some('4');"></a></td>
              </tr>
            <tr align="left" bgcolor="#FFFFFF">
              <td id="apqp4"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="12%"><div align="center"><a href="metr_cali_hist.php"><img src="imagens/icon_dv2.jpg" width="34" height="40" border="0"></a></div></td>
                  <td width="12%"><div align="center"><a href="metr_cati.php"><img src="imagens/icon_dv2.jpg" width="34" height="40" border="0"></a></div></td>
                  <td width="12%"><div align="center"><a href="metr_unim.php"><img src="imagens/icon_dv2.jpg" width="34" height="40" border="0"></a></div></td>
                  <td width="12%"><div align="center"><a href="metr_insm_busca.php"><img src="imagens/icon_dv2.jpg" width="34" height="40" border="0"></a></div></td>
                  <td width="12%"><div align="center"><a href="metr_lab_busca.php"><img src="imagens/icon_dv2.jpg" width="34" height="40" border="0"></a></div></td>
                  <td width="12%"><a href="metr_pad_busca.php"><img src="imagens/icon_dv2.jpg" width="34" height="40" border="0"></a></td>
                  <td width="12%"><a href="metr_inst_busca.php"><img src="imagens/icon_dv2.jpg" width="34" height="40" border="0"></a></td>
                  </tr>
                <tr align="center" class="textobold">
                  <td><a href="metr_cali_hist.php" class="textobold">Hist&oacute;rico de Calibra&ccedil;&atilde;o de Instrumentos</a></td>
                  <td><a href="metr_cati.php" class="textobold">Cadastro de Tipo de Instrumento </a></td>
                  <td><a href="metr_unim.php" class="textobold">Unidades de Medida </a></td>
                  <td><div align="center"><a href="metr_insm_busca.php" class="textobold">Cadastro de Instrumento de Medi&ccedil;&atilde;o</a> </div></td>
                  <td><a href="metr_lab_busca.php" class="textobold">Cadastro de Laborat&oacute;rio</a></td>
                  <td><a href="metr_pad_busca.php" class="textobold">Cadastro de Padr&atilde;o </a></td>
                  <td><a href="metr_instr_busca.php" class="textobold">Cadastro de Instru&ccedil;&atilde;o</a></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
          <tr>
            <td class="textoboldbranco">RELAT&Oacute;RIOS<a href="#" onClick="return some('4');"></a></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF">
            <td id="apqp4"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="12%"><div align="center"><a href="pdf/metr_reca_imp.php"><img src="imagens/icon_dv2.jpg" alt="Cronograma" width="35" height="40" border="0"></a></div></td>
                  <td width="16%">&nbsp;</td>
                  <td width="16%">&nbsp;</td>
                  <td width="14%">&nbsp;</td>
                  <td width="14%">&nbsp;</td>
                  <td width="14%">&nbsp;</td>
                  <td width="14%">&nbsp;</td>
                </tr>
                <tr align="center" class="textobold">
                  <td><a href="pdf/metr_reca_imp.php" class="textobold">Ficha de Re-calibra&ccedil;&atilde;o </a></td>
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
      
      <script>someini();</script>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php include("mensagem.php"); ?>