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
<script>
function someini(){
	apqp4.style.display = 'inline';
	minmax4.src='imagens/icon14_min.gif';			
	pos4=false;
	apqp1.style.display = 'inline';
	minmax1.src='imagens/icon14_max.gif';			
	pos1=true;
}
function some(num){
	if(pos1==false && num=='1'){
		apqp1.style.display = 'none';
		minmax1.src='imagens/icon14_max.gif';
		pos1=true;
	}else if(num=='1'){
		apqp1.style.display = 'inline';
		minmax1.src='imagens/icon14_min.gif';
		pos1=false;
	}
	
	if(pos4==false && num=='4'){
		apqp4.style.display = 'none';
		minmax4.src='imagens/icon14_max.gif';
		pos4=true;
	}else if(num=='4'){
		apqp4.style.display = 'inline';
		minmax4.src='imagens/icon14_min.gif';
		pos4=false;
	}
	return false;
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
.style4 {font-size: 9px}
.style5 {
	font-size: 10px;
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">Movimentação </div></td>
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
              <td width="569" class="textoboldbranco">&nbsp;Movimentação </td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('4');"><img src="imagens/icon14_min.gif" name="minmax4" width="16" height="16" border="0" id="minmax4"></a></td>
            </tr>
            <tr align="left" bgcolor="#FFFFFF">
              <td colspan="2" id="apqp4"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="124"><a href="prodserv_est.php"><img src="imagens/icon_forn_cad.jpg"  width="32" height="30" border="0"></a></td>
                    <td width="124"><a href="prodserv_sep.php"><img src="imagens/icon_forn.jpg"  width="32" height="27" border="0"></a></td>
                    <td width="124"><a href="prodserv_ordem.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                    <td width="124"><a href="romaneio.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                    <td width="124" class="textobold">&nbsp;</td>
                    <td width="124" class="textobold">&nbsp;</td>
                    <td width="124">&nbsp;</td>
                    <td width="139" class="textobold">&nbsp;</td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="124"><a href="prodserv_est.php" class="textobold">Estoque</a></td>
                    <td width="124"><a href="prodserv_sep.php" class="textobold">Logística </a></td>
                    <td width="124"><a href="prodserv_ordem.php" class="textobold">Ordem de Produ&ccedil;&atilde;o </a></td>
                    <td width="124"><a href="romaneio.php" class="textobold">Romaneio</a></td>
                    <td width="124">&nbsp;</td>
                    <td width="124">&nbsp;</td>
                    <td width="124">&nbsp;</td>
                    <td width="139">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="imagens/dot.gif" width="200" height="3"></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td width="569" class="textoboldbranco">&nbsp;Financeiro</td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('1');"><img src="imagens/icon14_min.gif" name="minmax1" width="16" height="16" border="0" id="minmax1"></a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td id="apqp1" colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="124"><a href="nf.php"><img src="imagens/icon_cd.jpg"  width="29" height="35" border="0"></a></td>
                    <td width="124"><a href="pedidospendentes.php"><img src="imagens/icon_cb.jpg" width="31" height="35" border="0"></a></td>
                    <td width="505">&nbsp;</td>
                    <td width="254">&nbsp;</td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="124"><a href="nf.php" class="textobold">Notas Fiscais </a></td>
                    <td width="124"><a href="pedidospendentes.php" class="textobold">Aprovac. Financeira </a><a href="apqp_fluxo.php" class="textobold"></a></td>
                    <td width="505">&nbsp;</td>
                    <td width="254">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="imagens/dot.gif" width="200" height="3"></td>
      </tr>
      <script>someini();</script>
    </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>