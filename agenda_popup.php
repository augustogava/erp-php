<?php
include("conecta.php");
$sql=mysql_query("SELECT * FROM agenda WHERE numero='$cpm'");
$res=mysql_fetch_array($sql);
$nome=$res["nome"];
$titulo=$res["titulo"];
$d=$res["data"];
$hora=$res["hora"];
$texto=$res["texto"];
$data=banco2data($d);
$texto=eregi_replace("\n","<br>",$texto);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Compromissos</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
windowWidth=350;
windowHeight=190;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
function imprimir(botao){
	var guarda=botao.src;
	botao.src='imagens/dot.gif';
	window.print();
	botao.src=guarda;
	return false;
}
</script>
</head>

<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="300" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#CCCCCC" class="celula1pix"><span class="textobold">Agendado 
      para:</span><span class="texto"> <?php print($nome); ?></span></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCCCC"><span class="textobold">Data:</span> <span class="texto"><?php print($data); ?></span></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCCCC"><span class="textobold">Hora:</span> <span class="texto"><?php print($hora); ?></span></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCCCC" class="textobold">Compromisso</td>
  </tr>
  <tr> 
    <td bgcolor="#CCCCCC" class="texto"><?php print($titulo); ?></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCCCC" class="textobold">Descri&ccedil;&atilde;o</td>
  </tr>
  <tr> 
    <td bgcolor="#CCCCCC" class="texto"><?php print($texto); ?></td>
  </tr>
</table>
<div align="center">
  <input name="Submit2" type="button" class="microtxt" value="Imprimir" onClick="return imprimir(this)">
</div>
</body>
</html>
