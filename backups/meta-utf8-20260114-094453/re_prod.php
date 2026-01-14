<?
include("conecta.php");
include("seguranca.php");
unset($_SESSION["ps"]);
if(empty($acao)) $acao="entrar";
if(!empty($cat)){
	$where="WHERE categoria='$cat'";
}
if(!empty($nome)){
	$where="WHERE nome LIKE '%$nome%'";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.codprod.value==''){
		alert('Informe o Código do produto');
		cad.codprod.focus();
		return false;
	}
	if(cad.nome.value==''){
		alert('Informe o nome');
		cad.nome.focus();
		return false;
	}
	if(cad.apelido.value==''){
		alert('Informe o apelido');
		cad.apelido.focus();
		return false;
	}
	if(cad.categoria.value==''){
		alert('Informe a Categoria');
		cad.categoria.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Relat&oacute;rios</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="pdf/rel_prod.php" target="_blank">
      <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#003366">
          <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Categoria:</td>
          <td><select name="cat" class="formularioselect" id="cat">
              <option value="">Selecione</option>
              <?
$sqlr=mysql_query("SELECT * FROM categorias ORDER BY nome ASC");
while($resr=mysql_fetch_array($sqlr)){
?>
              <option value="<? print $resr["id"]; ?>"><? print($resr["nome"]); ?></option>
              <? } ?>
          </select></td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Nome:</td>
          <td><input name="nome" type="text" class="textobold" id="nome"></td>
        </tr>
        <tr class="textobold">
          <td width="55">&nbsp;C&oacute;digo:</td>
          <td><input name="cod" type="text" class="textobold" id="cod" size="15" maxlength="15"></td>
        </tr>

        <tr class="textobold">
          <td colspan="2" align="center"><input name="Submit2" type="submit" class="microtxt" value="Buscar"></td>
        </tr>
      </table>
  </form>  </tr>
  <tr> 
    <td align="left" valign="top"></tr>
</td>
</table>

</body>
</html>
<? include("mensagem.php"); ?>