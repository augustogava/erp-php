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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">Cadastros</div></td>
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
              <td width="988" class="textoboldbranco">&nbsp;Cadastros</td>
              <td width="20" align="center" class="textoboldbranco"><a href="#" onClick="return some('4');"><img src="imagens/icon14_min.gif" name="minmax4" width="16" height="16" border="0" id="minmax4"></a></td>
            </tr>
            <tr align="left" bgcolor="#FFFFFF">
              <td colspan="2" id="apqp4"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="124"><a href="clientes_geral.php?acao=sel"><img src="imagens/icon_forn_cad.jpg"  width="32" height="30" border="0"></a></td>
                  <td width="124"><a href="clientes.php"><img src="imagens/icon_forn.jpg"  width="32" height="27" border="0"></a></td>
                  <td width="124"><a href="funcionarios.php"><img src="imagens/icon_forn_cad.jpg" width="21" height="20" border="0"></a></td>
                  <td width="124"><a href="fornecedores_geral.php"><img src="imagens/icon_cr.jpg" width="28" height="35" border="0"></a></td>
                  <td width="124" class="textobold"><a href="fornecedores.php"><img src="imagens/icon_cr.jpg" width="28" height="35" border="0"></a></td>
                  <td width="124" class="textobold"><a href="vendedo.php"><img src="imagens/icon_cr.jpg" width="28" height="35" border="0"></a></td>
                  <td width="124" class="textobold"><a href="representantes.php"><img src="imagens/icon_cr.jpg" width="28" height="35" border="0"></a></td>
                  <td width="124" class="textobold"><a href="transp_incluir.php"><img src="imagens/icon20_transp.gif" width="37" height="20" border="0"></a></td>
                  <td width="124"><a href="af.php"><img src="imagens/icon_cg.jpg" width="29" height="35" border="0"></a></td>
                  <td width="139" class="textobold"><a href="fornecedores_site.php"><img src="imagens/icon_cr.jpg" width="28" height="35" border="0"></a></td>
                  <td width="139" class="textobold"><a href="flash.php"><img src="imagens/icon_no.jpg" width="37" height="35" border="0"></a></td>
                </tr>
                <tr align="center" class="textobold">
                  <td width="124"><a href="clientes_geral.php?acao=sel" class="textobold">Incluir Cliente</a></td>
                  <td width="124"><a href="clientes.php" class="textobold">Clientes</a></td>
                  <td width="124"><a href="funcionarios.php" class="textobold">Funcionarios</a></td>
                  <td width="124"><a href="fornecedores_geral.php" class="textobold">Incluir Fornecedor</a></td>
                  <td width="124"><a href="fornecedores.php" class="textobold">Fornecedores</a></td>
                  <td width="124"><a href="vendedo.php" class="textobold">Vendedores</a></td>
                  <td width="124"><a href="representantes.php" class="textobold">Representantes</a></td>
                  <td width="124"><a href="transp_incluir.php" class="textobold">Transportadoras</a></td>
                  <td width="124"><a href="af.php" class="textobold">AF</a></td>
                  <td width="139"><a href="fornecedores_site.php" class="textobold">Fornecedores Site </a></td>
                  <td width="139"><a href="flash.php" class="textobold">Flash Home </a></td>
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
              <td width="988" class="textoboldbranco">&nbsp;Produtos</td>
              <td width="20" align="center" class="textoboldbranco"><a href="#" onClick="return some('1');"><img src="imagens/icon14_min.gif" name="minmax1" width="16" height="16" border="0" id="minmax1"></a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td id="apqp1" colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td width="13%"><a href="prodserv.php"><img src="imagens/icon_forn_cad.jpg"  width="32" height="30" border="0"></a></td>
                  <td width="12%"><a href="prodserv_cat.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                  <td width="12%"><a href="cpvc.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                  <td width="13%" class="textobold"><a href="cortinas.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                  <td width="13%" class="textobold"><a href="cortina.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                  <td width="12%" class="textobold"><a href="perfil.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                  <td width="13%"><a href="material.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                  <td width="13%" class="textobold"><a href="fixacao.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                </tr>
                <tr align="center" class="textobold">
                  <td><a href="prodserv.php" class="textobold">Produtos / Servi&ccedil;os</a></td>
                  <td><a href="prodserv_cat.php" class="textobold">E-Categorias</a></td>
                  <td><a href="cpvc.php" class="textobold">Portas</a></td>
                  <td><a href="cortinas.php" class="textobold">Cortina</a></td>
                  <td><a href="cortina.php" class="textobold">Cortina Noturna </a></td>
                  <td><a href="perfil.php" class="textobold">Perfil</a></td>
                  <td><a href="material.php" class="textobold">Material</a></td>
                  <td><a href="fixacao.php" class="textobold">Fixa&ccedil;&atilde;o</a></td>
                </tr>
                
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="imagens/dot.gif" width="200" height="3"></td>
      </tr>
      
      
      <tr>
        <td>
          <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td width="987" class="textoboldbranco">&nbsp;Diversos</td>
              <td width="21" align="center" class="textoboldbranco"><a href="#" onClick="return some('2');"><img src="imagens/icon14_min.gif" name="minmax2" width="16" height="16" border="0" id="minmax2"></a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td id="apqp2" colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="123"><a href="dados.php"><img src="imagens/icon_ct.jpg"  width="36" height="35" border="0"></a></td>
                    <td width="123"><a href="empresa.php"><img src="imagens/icon_ct.jpg"  width="36" height="35" border="0"></a></td>
                    <td width="126"><a href="cargos.php"><img src="imagens/icon_tba.jpg" width="35" height="35" border="0"></a></td>
                    <td width="123"><a href="feriados.php"><img src="imagens/icon_cb.jpg" width="31" height="35" border="0"></a></td>
                    <td width="123"><a href="unidades.php"><img src="imagens/icon_onf.jpg" width="28" height="35" border="0"></a></td>
                    <td width="124"><a href="posicao.php"><img src="imagens/icon_cb.jpg" width="31" height="35" border="0"></a></td>
                    <td width="125"><a href="niveis.php"><img src="imagens/icon_np.jpg" width="35" height="35" border="0"></a></td>
                    <td width="128"><a href="followup_tipo.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                    <td width="128"><a href="grupos.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                    <td width="128"><a href="ramo.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                    <td width="139" class="textobold"><a href="cep.php"><img src="imagens/icon_tb.jpg" width="27" height="34" border="0"></a></td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="123"><a href="dados.php" class="textobold">Dados Adicionais</a> </td>
                    <td width="123"><a href="empresa.php" class="textobold">Empresas</a></td>
                    <td width="126"><a href="cargos.php" class="textobold">Cargos</a><a href="apqp_fluxo.php" class="textobold"></a></td>
                    <td width="123"><a href="feriados.php" class="textobold">Feriados</a></td>
                    <td width="123"><a href="unidades.php" class="textobold">Unidades</a></td>
                    <td width="124"><a href="posicao.php" class="textobold">Posicao</a></td>
                    <td width="125"><a href="niveis.php" class="textobold">N&iacute;veis de Acesso</a></td>
                    <td width="128"><a href="followup_tipo.php" class="textobold">Tipo Follow Up </a></td>
                    <td width="128"><a href="grupos.php" class="textobold">Grupos</a></td>
                    <td width="128"><a href="ramo.php" class="textobold">Ramo de Atividade </a></td>
                    <td width="139"><a href="cep.php" class="textobold">Fretes</a></td>
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