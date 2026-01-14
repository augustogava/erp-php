<?php
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT custo FROM prodserv_custo WHERE prodserv='$item'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	$valor=$res["custo"];
}
if($act=="em"){
	$titulo="Entrada Manual";
}elseif($act=="sm"){
	$titulo="Saída Manual";
}elseif($act=="ee"){
	$titulo="Estorno de Entrada";
	$sql=mysql_query("SELECT qtde,valor FROM prodserv_est WHERE tipomov=1 ORDER BY data DESC,id DESC");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
		$qtd=$res["qtde"];
		$valor=$res["valor"];
	}
	$block=true;
}elseif($act=="es"){
	$titulo="Estorno de Saída";
	$sql=mysql_query("SELECT qtds,valor FROM prodserv_est WHERE tipomov=2 ORDER BY data DESC,id DESC");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
		$qtd=$res["qtds"];
		$valor=$res["valor"];
	}
	$block=true;
}
$sql=mysql_query("SELECT nome FROM prodserv WHERE id='$item'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	$ps=$res["nome"];
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
	if(!verifica_data(cad.data.value)){
		alert('Data incorreta');
		cad.data.focus();
		return false;
	}
	if(cad.qtd.value=='' || cad.qtd.value=='0,00'){
		alert('Verifique a quantidade movimentada');
		cad.qtd.focus();
		return false;
	}
	if(cad.valor.value=='' || cad.valor.value=='0,00'){
		alert('Verifique o valor do produto');
		cad.valor.focus();
		return false;
	}		
	return true;
}
windowWidth=420;
windowHeight=240;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua2.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top" class="titulos"><?php print $titulo; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="prodserv_ese_sql.php" onSubmit="return verifica(this);">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="textobold"><span class="titulos"><?php print $ps; ?></span></td>
        </tr>
        <tr>
          <td><img src="imagens/dot.gif" width="20" height="5"></td>
        </tr>
        <tr>
          <td><table width="400" border="0" cellspacing="0" cellpadding="0">
            <tr align="center" bgcolor="#003366" class="textoboldbranco">
              <td width="70" bgcolor="#003366">Data</td>
              <td width="10" bgcolor="#FFFFFF">&nbsp;</td>
              <td width="118" bgcolor="#003366">Qtd movimentada </td>
              <td width="9" bgcolor="#FFFFFF">&nbsp;</td>
              <td width="85" bgcolor="#003366">valor</td>
              <td width="9" bgcolor="#FFFFFF">&nbsp;</td>
              <td width="104" bgcolor="#003366">documento</td>
            </tr>
            <tr>
              <td><span class="textobold">
                <input name="data" type="text" class="formularioselect" id="data" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
              </span></td>
              <td width="10">&nbsp;</td>
              <td width="118"><input name="qtd" type="text" class="formularioselect" id="qtd" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?php print banco2valor($qtd); ?>" size="10"></td>
              <td width="9">&nbsp;</td>
              <td><input name="valor" type="text" class="formularioselect" id="valor" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?php print banco2valor($valor); ?>" size="10" <?php if($block) print "readonly"; ?>></td>
              <td width="9">&nbsp;</td>
              <td width="104"><input name="doc" type="text" class="formularioselect" id="doc" size="10" maxlength="25"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><img src="imagens/dot.gif" width="20" height="5"></td>
        </tr>
        <tr>
          <td class="textobold">Observa&ccedil;&otilde;es
            <input name="acao" type="hidden" id="acao" value="<?php print $act; ?>">
            <input name="item" type="hidden" id="item" value="<?php print $item; ?>"></td>
        </tr>
        <tr>
          <td><textarea name="obs" rows="5" wrap="VIRTUAL" class="formularioselect" id="obs"></textarea></td>
        </tr>
        <tr>
          <td><img src="imagens/dot.gif" width="20" height="5"></td>
        </tr>
        <tr>
          <td align="center">
            <input name="Submit22" type="button" class="microtxt" value="Fechar" onClick="window.close();">
         <img src="imagens/dot.gif" width="20" height="5">
            <input name="Submit2" type="submit" class="microtxt" value="Continuar"></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>