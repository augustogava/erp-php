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
	apqp2.style.display = 'inline';
	minmax2.src='imagens/icon14_max.gif';
	pos2=true;
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
	
	if(pos2==false && num=='2'){
		apqp2.style.display = 'none';
		minmax2.src='imagens/icon14_max.gif';
		pos2=true;
	}else if(num=='2'){
		apqp2.style.display = 'inline';
		minmax2.src='imagens/icon14_min.gif';
		pos2=false;
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">Financeiro</div></td>
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
              <td width="569" class="textoboldbranco">&nbsp;Financeiro </td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('4');"><img src="imagens/icon14_min.gif" name="minmax4" width="16" height="16" border="0" id="minmax4"></a></td>
            </tr>
            <tr align="left" bgcolor="#FFFFFF">
              <td colspan="2" id="apqp4"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="124"><a href="bancos.php"><img src="imagens/icon_forn_cad.jpg"  width="32" height="30" border="0"></a></td>
                  <td width="124"><a href="fluxodecaixa.php"><img src="imagens/icon_forn.jpg"  width="32" height="27" border="0"></a></td>
                  <td width="124"><a href="vendas_fat.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                  <td width="124"><a href="nf.php"><img src="imagens/icon_cd.jpg"  width="29" height="35" border="0"></a></td>
                  <td width="124"><a href="pedidospendentes.php"><img src="imagens/icon_cb.jpg" width="31" height="35" border="0"></a></td>
                  <td width="124" class="textobold">&nbsp;</td>
                  <td width="124">&nbsp;</td>
                  <td width="139" class="textobold">&nbsp;</td>
                </tr>
                <tr align="center" class="textobold">
                  <td width="124"><a href="bancos.php" class="textobold">Bancos</a></td>
                  <td width="124"><a href="fluxodecaixa.php" class="textobold">Fluxo de Caixa </a></td>
                  <td width="124"><a href="vendas_fat.php" class="textobold">Faturamento</a></td>
                  <td width="124"><a href="nf.php" class="textobold">Notas Fiscais </a></td>
                  <td width="124"><a href="pedidospendentes.php" class="textobold">Aprovac. Financeira </a><a href="apqp_fluxo.php" class="textobold"></a></td>
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
              <td width="569" class="textoboldbranco">&nbsp;Contas Receber / Pagar </td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('1');"><img src="imagens/icon14_min.gif" name="minmax1" width="16" height="16" border="0" id="minmax1"></a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td id="apqp1" colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="122"><a href="cr.php"><img src="imagens/icon_cr.jpg"  width="28" height="35" border="0"></a></td>
                  <td width="123"><a href="cr_aberto.php"><img src="imagens/icon_cf.jpg" width="27" height="35" border="0"></a></td>
                  <td width="125"><a href="cp.php"><img src="imagens/icon_cp.jpg"  width="62" height="35" border="0"></a></td>
                  <td width="124"><a href="cp_aberto.php"><img src="imagens/icon_cpr.jpg" width="25" height="40" border="0"></a></td>
                  <td width="126">&nbsp;</td>
                  <td width="126">&nbsp;</td>
                  <td width="126">&nbsp;</td>
                  <td width="137">&nbsp;</td>
                </tr>
                <tr align="center" class="textobold">
                  <td width="122"><a href="cr.php" class="textobold">Contas a Receber</a></td>
                  <td width="123"><a href="cr_aberto.php" class="textobold">Recebimentos </a><a href="apqp_fluxo.php" class="textobold"></a></td>
                  <td width="125"><a href="cp.php" class="textobold">Contas a Pagar</a></td>
                  <td width="124"><a href="cp_aberto.php" class="textobold">Pagamentos</a><a href="apqp_fluxo.php" class="textobold"></a></td>
                  <td width="126">&nbsp;</td>
                  <td width="126">&nbsp;</td>
                  <td width="126">&nbsp;</td>
                  <td width="137">&nbsp;</td>
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
              <td width="569" class="textoboldbranco">&nbsp;Diversos<span class="style4"></span></td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('2');"><img src="imagens/icon14_min.gif" name="minmax2" width="16" height="16" border="0" id="minmax2"></a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td id="apqp2" colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="123"><a href="sitri.php"><img src="imagens/icon_tv.jpg"  width="62" height="35" border="0"></a></td>
                  <td width="127"><a href="clafis.php"><img src="imagens/icon_lp.jpg" width="48" height="35" border="0"></a></td>
                  <td width="122"><a href="natureza.php"><img src="imagens/icon_np.jpg" width="35" height="35" border="0"></a></td>
                  <td width="123"><a href="opertab.php"><img src="imagens/icon_tc.jpg" width="22" height="34" border="0"></a></td>
                  <td width="126"><a href="pcontas.php"><img src="imagens/icon_iuf.jpg" width="38" height="35" border="0"></a></td>
                  <td width="121"><a href="parcelamentos.php"><img src="imagens/icon_repre.jpg" width="36" height="35" border="0"></a></td>
                  <td width="131"><a href="op_pagamento.php"><img src="imagens/icon_cg.jpg" width="29" height="35" border="0"></a></td>
                  <td width="139">&nbsp;</td>
                </tr>
                <tr align="center" class="textobold">
                  <td width="123"><a href="sitri.php" class="textobold">Sit. Tribut&aacute;rias</a></td>
                  <td width="127"><a href="clafis.php" class="textobold">Class. Fiscais</a><a href="apqp_fluxo.php" class="textobold"></a></td>
                  <td width="122"><a href="natureza.php" class="textobold">Natureza Opera&ccedil;&atilde;o</a></td>
                  <td width="123"><a href="opertab.php" class="textobold">Tab. Opera&ccedil;&otilde;es</a></td>
                  <td width="126"><a href="pcontas.php" class="textobold">Plano de Contas</a></td>
                  <td width="121"><a href="parcelamentos.php" class="textobold">Parcelamentos</a></td>
                  <td width="131"><a href="op_pagamento.php" class="textobold">Op&ccedil;&otilde;es de pagamento</a></td>
                  <td width="139">&nbsp;</td>
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
<p>&nbsp;</p>
</body>
</html>
<? include("mensagem.php"); ?>