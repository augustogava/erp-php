<?php
include("conecta.php");
include("seguranca.php");



if(!empty($acao)){
	$loc="Representantes";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

?>

<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){	
	if(!checkdate(cad.data_i)){
		return false;
	}
	if(!checkdate(cad.data_f)){
		return false;
	}
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
.style2 {color: #FF0000}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> <form name="form1" method="post" action="pdf/moni_esta_raex_imp.php" onSubmit="return verifica(this)">
<table width="591" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
    <td width="564" align="right"><div align="left"><span class="textobold style1 style1"><span class="titulos">Monitoramento &gt; Estat&iacute;stica &gt; Relat&oacute;rio de Acesso por Usu&aacute;rio Externo </span></span></div></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="70%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
                <tr>
                  <td><table width="412" border="0" cellspacing="3" cellpadding="0">
                    <tr>
                      <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
                    </tr>
                    <tr class="textobold">
                      <td>Nome Usu&aacute;rio:
                        <input name="cliente" type="hidden" id="cliente"></td>
                      <td><input name="nome_cli" type="text" class="formulario" id="nome_cli" size="50" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                        <a href="#" onClick="return abre('moni_esta_raex_imp_busc.php','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" width="14" height="14" border="0"></a></td>
                    </tr>
                    <tr class="textobold">
                      <td width="86">Data Inicial: </td>
                      <td width="271"><label>
                        <input name="data_i" type="text" class="formulario" id="data_i" size="20" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                      </label></td>
                    </tr>
                    <tr class="textobold">
                      <td>Data Final: </td>
                      <td><input name="data_f" type="text" class="formulario" id="data_f" size="20" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="2"><div align="center">
                          <input name="back" type="button" class="microtxt" id="back" onClick="window.location='moni_esta_mana.php';" value="Voltar" />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="search" type="submit" class="microtxt" id="search" value="Buscar">
                        &nbsp;
                        <input name="buscar" type="hidden" id="buscar" value="true">
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
          </form></td>
        </tr>
      </table></td> 
  </tr>
  <?php if($wpaginar){ ?>
<?php } ?>
</table>
</body>
</html>

<?php include("mensagem.php"); ?>