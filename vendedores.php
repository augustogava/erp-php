<?php
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
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
 <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Vendedores</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="50" height="8"></td>
  </tr>
  <form name="form1" method="post" action="vendedores_sql.php">
  <tr>
    <td align="left" valign="top" bgcolor="#003366" class="textoboldbranco">&nbsp;Designar n&iacute;veis que ser&atilde;o reconhecidos como vendedores </td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="116" class="textobold">Selecione os n&iacute;veis:</td>
        <td width="478"><select name="vendedores[]" size="5" multiple class="formularioselect" id="vendedores">
<?php
$sql=mysql_query("SELECT * FROM niveis ORDER BY nome ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
?>
		  <option value="<?php echo  $res["id"]; ?>" <?php if($res["vendedor"]==1) print "selected"; ?>><?php echo  $res["nome"]; ?></option>
<?php
	}
}
?>
        </select></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="50" height="8"></td>
  </tr>
  <tr>
    <td align="center" valign="top"><input name="Submit2" type="submit" class="microtxt" value="Continuar">
    <input name="acao" type="hidden" id="acao" value="alt"></td>
  </tr>
  </form>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>