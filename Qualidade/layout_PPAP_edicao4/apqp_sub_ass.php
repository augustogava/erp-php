<?php
include("conecta.php");
if($abre=="S"){
	$_SESSION["vendas_prodserv_line"]=$line;
}
$line=$_SESSION["vendas_prodserv_line"];
if($buscar){
	unset($wp);
}
if(!empty($bcli)){
	$busca="WHERE nome LIKE '%$bcli%'";
}
$sql2=mysql_query("SELECT * FROM cliente_login WHERE funcionario='$_SESSION[login_codigo]'");
$res2=mysql_fetch_array($sql2);
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>

function seleciona(id){
	opener.form1.assinatura.value=id;
	opener.form1.acao.value='s4'
	opener.form1.ir.value='sim';
	opener.form1.submit();
	window.close();
}
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="300" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td align="center">
      <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">

		  <tr bgcolor="#FFFFFF" class="texto">
		    <td colspan="2" bgcolor="#003366" class="rodape">Escolha tipo de Assinatura </td>
	    </tr>
		  <tr bgcolor="#FFFFFF" class="texto">
            <td>&nbsp;Digital</td>
		    <td align="center"><a href="#" onClick="<?php if($res2["assinatura"]!="0"){ print "return seleciona('D');"; }else{ print "window.alert('Sua assinatura não esta cadastrada, favor verificar com o administrador do sistema para cadastrar a mesma ou usar outro modo de assinatura. (ex: Manual ou eletrônica)');"; } ?>"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
	    </tr>
		  <tr bgcolor="#FFFFFF" class="texto">
            <td>&nbsp;El&ecirc;tronica</td>
		    <td align="center"><a href="#" onClick="return seleciona('E');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
	    </tr>
		  <tr bgcolor="#FFFFFF" class="texto"> 
            <td width="277">&nbsp;Manual</td>
            <td width="20" align="center"><a href="#" onClick="return seleciona('M');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
          </tr>
    </table></td></tr>
</table>
</body>
</html>