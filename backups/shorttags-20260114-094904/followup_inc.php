<?
include("conecta.php");
include("seguranca.php");
if($acao=="inc"){
	$data=date("Y-m-d");
	$hora=hora();
	$sql=mysql_query("INSERT INTO followup (cliente,data,hora,titulo,descricao) VALUES ('$cliente','$data','$hora','$titulo','$descricao')");
	if($sql){
		$_SESSION["mensagem"]="As informações foram incluídas com sucesso";
	}else{
		$_SESSION["mensagem"]="As informações não puderam ser incluídas";
	}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.cliente.value==''){
		alert('Selecione o cliente');
		abre('fwcli.php','a','width=320,height=300,scrollbars=1');
		return false;
	}
	if(cad.titulo.value==''){
		alert('Informe o título');
		cad.titulo.focus();
		return false;
	}
	if(cad.descricao.value==''){
		alert('Informe a descrição');
		cad.descricao.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top">              
      <form action="" method="post" name="form1" id="form1" onSubmit="return verifica(this)">
        <table width="594" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="textobold">Cliente</td>
          </tr>
          <tr>
            <td class="texto"><table width="594" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="573"><input name="cli" type="text" class="formularioselect" id="cli" maxlength="30" readonly></td>
                <td width="21" align="center"><a href="#" onClick="return abre('fwcli.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_pess.gif" width="14" height="14" border="0"></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td width="302" class="texto"><span class="textobold">T&iacute;tulo</span> (m&aacute;ximo 30 caracteres)
            <input name="cliente" type="hidden" id="cliente">
            <input name="acao" type="hidden" id="acao" value="inc"></td>
          </tr>
          <tr>
            <td><input name="titulo" type="text" class="formularioselect" id="titulo2" maxlength="30"></td>
          </tr>
          <tr>
            <td class="textobold">Descri&ccedil;&atilde;o</td>
          </tr>
          <tr>
            <td><textarea name="descricao" rows="6" wrap="VIRTUAL" class="formularioselect" id="textarea"  onFocus="enterativa=0;" onBlur="enterativa=1;"></textarea></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><span class="textobold">
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
            </span></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>