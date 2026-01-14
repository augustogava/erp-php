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
    <td align="left" valign="top"><form name="form1" method="post" action="pdf/rel_des.php" target="_blank">
      <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#003366">
          <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
        </tr>
        
        <tr class="textobold">
          <td>Per&iacute;odo:</td>
          <td width="428"><input name="ini" type="text" class="formulario" id="bde2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="7" maxlength="10">
&nbsp;&agrave;&nbsp;
<input name="fim" type="text" class="formulario" id="bate2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="7" maxlength="10"></td>
        </tr>
        <tr class="textobold">
          <td>Vendedor:</td>
          <td><select name="vendedor" class="formularioselect" id="vendedor" onChange="form1.representante.value='';">
              <option value="0">Selecione</option>
			  <option value="todos">Todos Vendedores</option>
              <?
		  $sqlven=mysql_query("SELECT c.id,c.nome FROM clientes AS c,cliente_login AS cl, niveis AS n WHERE c.id=cl.cliente AND cl.nivel=n.id AND n.vendedor=1 ORDER BY c.nome ASC");
		  if(mysql_num_rows($sqlven)){
		  	while($resven=mysql_fetch_array($sqlven)){
		  ?>
              <option value="<?= $resven["id"]; ?>" <? if($resven["id"]==$res["vendedor"]) print "selected"; ?>>
              <?= $resven["nome"]; ?>
              </option>
              <?
		  	}
		}
		?>
          </select></td>
        </tr>
        <tr class="textobold">
          <td width="72">Representante</td>
          <td><select name="representante" class="formularioselect" id="representante" onChange="form1.vendedor.value='';">
            <option value="0">Selecione</option>
			 <option value="todos">Todos Representantes</option>
            <?
		  $sqlven=mysql_query("SELECT * FROM representante ORDER By nome ASC");
		  if(mysql_num_rows($sqlven)){
		  	while($resven=mysql_fetch_array($sqlven)){
		  ?>
            <option value="<?= $resven["id"]; ?>">
              <?= $resven["nome"]; ?>
              </option>
            <?
		  	}
		}
		?>
          </select></td>
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