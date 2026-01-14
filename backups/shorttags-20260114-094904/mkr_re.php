<?
include("conecta.php");
include("seguranca.php");
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function someini(){
	apqp4.style.display = 'inline';
	minmax4.src='imagens/icon14_min.gif';			
	pos4=false;
}
function some(num){
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">Relat&oacute;rios</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="100%"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><img src="imagens/dot.gif" width="200" height="3">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td width="988" class="textoboldbranco">&nbsp;Relatórios</td>
              <td width="20" align="center" class="textoboldbranco"><a href="#" onClick="return some('4');"><img src="imagens/icon14_min.gif" name="minmax4" width="16" height="16" border="0" id="minmax4"></a></td>
            </tr>
            <tr align="left" bgcolor="#FFFFFF">
              <td colspan="2" id="apqp4"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="124"><a href="re_prod.php"><img src="imagens/icon_forn_cad.jpg"  width="32" height="30" border="0"></a></td>
                  <td width="124"><a href="etiqueta.php"><img src="imagens/icon_forn_cad.jpg"  width="32" height="30" border="0"></a></td>
                  <td width="124"><a href="re_des.php"><img src="imagens/icon_forn_cad.jpg"  width="32" height="30" border="0"></a></td>
                  <td width="124">&nbsp;</td>
                  <td width="124" class="textobold">&nbsp;</td>
                  <td width="124" class="textobold">&nbsp;</td>
                  <td width="124">&nbsp;</td>
                  <td width="139" class="textobold">&nbsp;</td>
                </tr>
                <tr align="center" class="textobold">
                  <td width="124"><a href="re_prod.php" class="textobold">Produtos</a></td>
                  <td width="124"><a href="etiqueta.php" class="textobold">Etiquetas</a></td>
                  <td width="124" class="textobold"><a href="re_des.php" class="textobold">Desempenho Comercial </a></td>
                  <td width="124">&nbsp;</td>
                  <td width="124">&nbsp;</td>
                  <td width="124">&nbsp;</td>
                  <td width="124">&nbsp;</td>
                  <td width="139">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      

      
      <script>someini();</script>
    </table></td></tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? include("mensagem.php"); ?>