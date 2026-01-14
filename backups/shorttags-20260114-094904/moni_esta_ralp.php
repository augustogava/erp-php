<?
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
          <td> <form name="form1" method="post" action="pdf/moni_esta_ralp_imp.php" onSubmit="return verifica(this)">
<table width="591" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
    <td width="564" align="right"><div align="left"><span class="textobold style1 style1"><span class="titulos">Monitoramento &gt; Estat&iacute;stica &gt; Relat&oacute;rio de Acesso por Local da P&aacute;gina </span></span></div></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="58%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
                <tr>
                  <td><table width="342" border="0" cellspacing="3" cellpadding="0">
                    <tr>
                      <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
                    </tr>
                    <tr class="textobold">
                      <td>Local da P&aacute;gina : </td>
                      <td><p>
                        <label></label>
                        <label>
                        <select name="pagina" class="textobold" id="pagina">
                          <option value="">Selecione</option>
						    <? $sql=mysql_query("SELECT DISTINCT (pagina) AS pagina, local FROM log ORDER BY local");
							   while($res=mysql_fetch_array($sql)){ 
							?>				  
					    <option value= <? print $res[pagina];?> > <?  print $res[local]; ?></option> 
						<? } ?>
                        </select>
                        </label>
                        <br>
                      </p></td>
                    </tr>
                    <tr class="textobold">
                      <td width="116">Data: </td>
                      <td width="217"><label>
                        <input name="data" type="text" class="formulario" id="data" size="20" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                      </label></td>
                    </tr>
                    <tr class="textobold">
                      <td>Hora Inicial: </td>
                      <td><input name="hora_i" type="text" class="formulario" id="hora_i" size="20" onKeyPress="return validanum(this, event)" onKeyUp="mhora(this)"></td>
                    </tr>
                    <tr class="textobold">
                      <td>Hora Final: </td>
                      <td><input name="hora_f" type="text" class="formulario" id="hora_f" size="20" onKeyPress="return validanum(this, event)" onKeyUp="mhora(this)"></td>
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
  <? if($wpaginar){ ?>
<? } ?>
</table>
</body>
</html>

<? include("mensagem.php"); ?>