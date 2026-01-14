<?php
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Alterar Senha";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alterar"){
	$sql=mysql_query("UPDATE cliente_login SET primeiro='N',senha='$senha' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Senha aletarada com Sucesso!";
		header("Location:index.php");
	}else{
		$_SESSION["mensagem"]="A senha não pôde ser alterado!";
		$acao="alt";
	}
}
$sql2=mysql_query("SELECT * FROM cliente_login WHERE id='$id'");
$res2=mysql_fetch_array($sql2);
$antigo=$res2["senha"];
?>
<html>
<head>
<title>
</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.senha.value==cad.antigo.value){
		alert('A senha não pode ser igual a anterior, escolha outra!');
			cad.senha.focus();
			return false;
	}else{
		if(cad.senha.value!=''){
			if(cad.senha2.value==''){
				alert('Confirme a Senha');
				cad.senha2.focus();
				return false;
			}
			if(cad.senha2.value!=cad.senha.value){
				alert('A senha e a confirmação não conferem');
				cad.senha2.value='';
				cad.senha2.focus();
				return false;
			}
		}else{
			alert('Informe a senha');
			cad.senha.focus();
			return false;
		}
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td align="center"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="textopreto">
        <tr>
          <td align="center">Est&aacute; &eacute; sua primeira visita ao sistema, sua senha deve ser alterada para sua maior seguran&ccedil;a, qualquer d&uacute;vida entre em contato com administrador. </td>
        </tr>
        <tr>
          <td align="center"><table width="223" border="0" cellpadding="0" cellspacing="0" class="textopreto">
            <tr>
              <td colspan="2" align="center" class="textoboldbranco">Altera&ccedil;&atilde;o Senha </td>
            </tr>
            <tr>
              <td width="100" align="right"><strong>Senha:</strong></td>
              <td width="123"><input name="senha" type="password" class="formularioselect" id="senha" value="" maxlength="20"></td>
            </tr>
            <tr>
              <td align="right"><strong>Repetir Senha: </strong></td>
              <td><input name="senha2" type="password" class="formularioselect" id="senha2" value="" maxlength="20"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="button12222" type="submit" class="microtxt" value="Salvar" >
                  <input name="id" type="hidden" id="id" value="<?php echo  $id; ?>">
                  <input name="acao" type="hidden" id="acao" value="alterar">
                  <input name="antigo" type="hidden" id="antiga" value="<?php echo  $antigo; ?>"></td>
            </tr>
          </table></td>
        </tr>
      </table>
      </form>    </td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>