<?
include("conecta.php");
include("seguranca.php");
//$fwcli=$_SESSION["login_codigo"];
$fwcli=7;
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
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--
function fw(caixa){
	window.location=caixa.options[caixa.selectedIndex].value;
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
    <td align="left" valign="top"><form action="" method="post" name="frmcad" id="frmcad">
      <table width="400" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="25%" class="textobold">Buscar por data&nbsp;&nbsp;&nbsp; <br>          </td>
          <td width="75%"><input name="bdata" type="text" class="formulario" id="bdata" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">            </td>
        </tr>
        <tr>
          <td class="textobold">por palavra chave </td>
          <td><input name="bpal" type="text" class="formulario" id="palavra2">
            <span class="textobold">
            <input name="Submit2" type="submit" class="microtxt" value="Buscar">
            </span></td>
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
			<?
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
				?><option value="followup.php?bid=<? print $id; ?>&bdata=<? print $bdata; ?>&bpal=<? print $bpal; ?>"><? print "$data - $titulo"; ?></option>
				<? } ?></select></td>
        </tr>
      </table>
    </form>
      <form name="form2" method="post" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="textobold">T&iacute;tulo</td>
          </tr>
          <tr>
            <td class="texto"><input name="textfield" type="text" class="formularioselect" value="<? print $wtitulo; ?>" readonly></td>
          </tr>
          <tr>
            <td class="textobold">Descri&ccedil;&atilde;o</td>
          </tr>
          <tr>
            <td><textarea name="descricao" cols="70" rows="6" wrap="VIRTUAL" class="formularioselect" id="textarea2"  readonly><? print $wdesc; ?>
      </textarea></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>