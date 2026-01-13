<?
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Funcionario_login";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)){
	$sql=mysql_query("SELECT * FROM cliente_login WHERE funcionario='$id'");
	if(mysql_num_rows($sql)==0){
		$acao="inc";
	}else{
		$acao="alt";
	}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM cliente_login WHERE funcionario='$id'");
	if(mysql_num_rows($sql)!=0){
		$res=mysql_fetch_array($sql);
	}
	$login=$res["login"];
	$senha=$res["senha"];
	$per=$res["perm"];
	$nivel=$res["nivel"];
	$sit=$res["sit"];
	$prim=$res["primeiro"];
}elseif($acao=="alterar"){
	//Assinatura
	$ima=stristr($_FILES["img"]["name"],".png");
	if(!empty($img)){
		if($_FILES["img"]["type"]!="image/x-png"){
			$_SESSION["mensagem"]="\\nA imagem deve ter extensão .png";
			header("Location:funcionario_login.php?id=$id");
			exit;	
		}else{
			$sql=mysql_query("SELECT MAX(assinatura) as assinatura FROM cliente_login WHERE funcionario='$id'");
			$res=mysql_fetch_array($sql);
			$nomeid=$res["assinatura"]+1;
			$arquivo="$patch/assinaturas/$nomeid.png";
			copy($img, "$arquivo");
			$sql=mysql_query("UPDATE cliente_login SET assinatura='$nomeid' WHERE funcionario='$id'");
		//fim
		}
	}
	if(strlen($senha)<6){
		$_SESSION["mensagem"]="A senha deve ter mais de 6 Dígitos!";		
		header("Location:funcionario_login.php?acao=inc&id=$id");
		exit;		
	}else{
		$sql=mysql_query("UPDATE cliente_login SET login='$login',senha='$senha',nivel='$nivel',sit='$sit',perm='$porra',primeiro='$primeiro' WHERE funcionario='$id'");
		if($sql){
			$_SESSION["mensagem"]="Cadastro de login alterado!";
			header("Location:funcionarios.php");
			exit;				
		}else{
			$_SESSION["mensagem"]="O cadastro de login não pôde ser alterado!";
			$acao="alt";
		}	
	}
}elseif($acao=="incluir"){
	if(!empty($img)){
		if($_FILES["img"]["type"]!="image/x-png"){
			$_SESSION["mensagem"]="\\nA imagem deve ter extensão .png";
			header("Location:funcionario_login.php?acao=inc&id=$id");
			exit;	
		}else{
			$sql=mysql_query("SELECT MAX(assinatura) as assinatura FROM cliente_login WHERE funcionario='$id'");
			$res=mysql_fetch_array($sql);
			$nomeid=$res["assinatura"]+1;
			$arquivo="$patch/assinaturas/$nomeid.png";
			copy($img, "$arquivo");
		//fim
		}
	}
	if(strlen($senha)<6){
		$_SESSION["mensagem"]="A senha deve ter mais de 6 Dígitos!";		
		header("Location:funcionario_login.php?acao=inc&id=$id");
		exit;		
	}else{
		$sql=mysql_query("SELECT * FROM cliente_login WHERE login='$login'");
		if(!mysql_num_rows($sql)){
			$sql=mysql_query("INSERT INTO cliente_login (funcionario,login,senha,nivel,sit,assinatura,primeiro,perm) VALUES ('$id','$login','$senha','$nivel','$sit','$nomeid','$primeiro','$porra')");
		}else{
			$_SESSION["mensagem"]="Usuário já existe!";		
			header("Location:funcionario_login.php?id=$id");
			exit;		
		}
		if($sql){
			$_SESSION["mensagem"]="Cadastro de login concluído!";
			header("Location:funcionarios.php");
			exit;				
		}else{
			$_SESSION["mensagem"]="O cadastro de login não pôde ser concluído!";
			$acao="inc";
		}	
	}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script>
function verifica(cad){
	if(cad.login.value==''){
		alert('Informe o nome de Usuário');
		cad.login.focus();
		return false;
	}
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
	return true;
}
</script>
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)" enctype="multipart/form-data">
        <table width="450" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2" align="center" class="titulos"><table width="591" border="0" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td width="27" align="center" bgcolor="#FFFFFF"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                <td width="564" align="right" bgcolor="#FFFFFF"><div align="left" class="titulos">Cadastro de funcion&aacute;rios- Login</div></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr class="textobold"> 
            <td width="94">&nbsp;Usu&aacute;rio:</td>
            <td width="353">
<input name="login" type="text" class="formulario" id="login" value="<? print $login; ?>" size="50" maxlength="50" ></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Senha:</td>
            <td>
<input name="senha" type="password" class="formulario" id="senha" value="<?= $senha; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Conf.&nbsp;Senha:</td>
            <td>
<input name="senha2" type="password" class="formulario" id="senha2" value="<?= $senha; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;N&iacute;vel:</td>
            <td>
<select name="nivel" class="formulario" id="nivel">
                <?
				$sql=mysql_query("SELECT * FROM niveis WHERE nome<>'cliente' and nome<>'clientes' ORDER BY nome ASC");
				while($resniv=mysql_fetch_array($sql)){
				?>
				<option value="<? print $resniv["id"]; ?>"<? if($resniv["id"]==$nivel) print "selected"; ?>><? print $resniv["nome"]; ?></option>
				<?
				}
				?>
              </select> <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066"> 
              <input name="id" type="hidden" id="id" value="<? print $id; ?>">
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">
              </font></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Permiss&atilde;o:</td>
            <td><select name="porra" class="textobold" id="porra">
                <option>Selecione</option>
                <option value="4" <? if($per=="4"){ print "Selected"; } ?>>Total</option>
                <option value="3" <? if($per=="3"){ print "Selected"; } ?>>Escrita</option>
                <option value="2" <? if($per=="2"){ print "Selected"; } ?>>Exclus&atilde;o</option>
                <option value="1" <? if($per=="1"){ print "Selected"; } ?>>Leitura</option>
              </select>
            </td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Assinatura Digital:  </td>
            <td><input name="img" type="file" class="formularioselect" id="img"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Situa&ccedil;&atilde;o:</td>
            <td>&nbsp;
                <input name="sit" type="radio" value="A" <? if($sit=="A" or empty($sit)) print "checked"; ?>>
              Ativo
              <input type="radio" name="sit" value="I"<? if($sit=="I") print "checked"; ?>>
              Inativo</td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Trocar senha </td>
            <td>&nbsp; 
              <input name="primeiro" type="radio" value="S" <? if($prim=="S") print "checked"; ?>>
              Sim
              <input type="radio" name="primeiro" value="N" <? if($prim=="N") print "checked"; ?>>
N&atilde;o</td>
          </tr>
          <tr class="textobold"> 
            <td colspan="2" align="center"> 
              <? if($acao=="alt"){ ?>
              <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='funcionarios.php<? if(!empty($bcod) or!empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>';">
              &nbsp;&nbsp;&nbsp;&nbsp;
              <? } ?>
              <input name="button122" type="submit" class="microtxt" value="Continuar"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>