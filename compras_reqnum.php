<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script>
function verifica(){
	if(qtd.value=='' || qtd.value=='0'){
		alert('Informe a quantidade de produtos');
		return false;
	}
	opener.location='compras_req.php?acao=inc&qtd='+qtd.value;
	window.close();
}
windowWidth=300;
windowHeight=80;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua2.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">Informe a quantidade de produtos </td>
  </tr>
  <tr class="textobold">
    <td width="42">&nbsp;Qtd:</td>
    <td width="258"><input name="qtd" type="text" class="formularioselect" id="qtd" onKeyPress="return validanum(this, event)"></td>
  </tr>
  <tr class="textobold">
    <td colspan="2"><img src="imagens/dot.gif" width="50" height="5"></td>
  </tr>
  <tr class="textobold">
    <td colspan="2" align="center">
      <input name="Submit2" type="submit" class="microtxt" value="Cancelar" onClick="window.close();">
 <img src="imagens/dot.gif" width="20" height="5"><input name="Submit2" type="submit" class="microtxt" value="Continuar" onClick="return verifica();"></td>
  </tr>
</table>
</body>
</html>
