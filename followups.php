<?php
include("conecta.php");
include("seguranca.php");
if(!empty($cli)){
	$_SESSION["fwcli2"]=$cli;
}else{
	$cli=$_SESSION["fwcli2"];
}
if(!empty($cliente)){
	$_SESSION["fwcli1"]=$cliente;
}else{
	$cliente=$_SESSION["fwcli1"];
}
$fwcli=$cliente;
if(!empty($bid)){
	$sql=mysql_query("SELECT * FROM followup WHERE id='$bid'");
	$res=mysql_fetch_array($sql);
	$wtitulo=$res["titulo"];
	$wdesc=$res["descricao"];
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
<!--
function fw(caixa){
	window.location=caixa.options[caixa.selectedIndex].value;
}
function verifica(cad){
	if(cad.cliente.value=='' || cad.cli.value==''){
		alert('Selecione o cliente');
		abre('fwcli.php','a','width=320,height=300,scrollbars=1');
		return false;
	}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="titulos"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Followup</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><form action="" method="post" name="form1" id="form1" onSubmit="return verifica(this)">
      <table width="400" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="textobold">Cliente</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="92%"><input name="cli" type="text" class="formularioselect" id="cli" value="<?php print $_SESSION["fwcli2"]; ?>" readonly></td>
              <td width="8%" align="center"><a href="#" onClick="return abre('fwcli.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_pess.gif" width="14" height="14" border="0"></a></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="25%" class="textobold">Buscar por data&nbsp;&nbsp;&nbsp; <br>          </td>
          <td width="75%"><input name="bdata" type="text" class="formulario" id="bdata" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
            <input name="cliente" type="hidden" id="cliente" value="<?php print $_SESSION["fwcli1"]; ?>"></td>
        </tr>
        <tr>
          <td class="textobold">por palavra chave </td>
          <td><input name="bpal" type="text" class="formulario" id="palavra2">
           
            <input name="Submit2" type="submit" class="microtxt" value="Buscar">
       </td>
        </tr>
        <tr>
          <td colspan="2" class="texto"><img src="imagens/dot.gif" width="1" height="1"></td>
        </tr>
        <tr>
          <td colspan="2" class="textobold">Ou selecione na caixa abaixo</td>
        </tr>
        <tr>
          <td colspan="2" class="texto">
            <select name="select" size="5" class="formularioselect" onclick="fw(this);">
			<?php
			$busca="";
			$lim="LIMIT 0, 10";
			if(!empty($bdata)){
				$busca.=" AND data=".data2banco($bdata);
				$lim="";
			}
			if(!empty($bpal)){
				$busca.=" AND (titulo LIKE '%$bpal%' OR descricao LIKE '%$bpal%')";
				$lim="";
			}
			$sql=mysql_query("SELECT * FROM followup WHERE cliente='$fwcli' $busca ORDER BY data DESC, hora DESC $lim");
			while($res=mysql_fetch_array($sql)){
				$data=banco2data($res["data"])." ".$res["hora"];
				$titulo=$res["titulo"];
				$id=$res["id"];
				?><option value="followups.php?bid=<?php print $id; ?>&bdata=<?php print $bdata; ?>&bpal=<?php print $bpal; ?>"><?php print "$data - $titulo"; ?></option>
				<?php } ?></select></td>
        </tr>
      </table>
    </form>
      <form name="form2" method="post" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="textobold">T&iacute;tulo</td>
          </tr>
          <tr>
            <td class="texto"><input name="textfield" type="text" class="formularioselect" value="<?php print $wtitulo; ?>" readonly></td>
          </tr>
          <tr>
            <td class="textobold">Descri&ccedil;&atilde;o</td>
          </tr>
          <tr>
            <td><textarea name="descricao" cols="70" rows="6" wrap="VIRTUAL" class="formularioselect" id="textarea2"  readonly><?php print $wdesc; ?>
      </textarea></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>