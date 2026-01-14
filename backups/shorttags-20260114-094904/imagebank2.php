<?
include("conecta.php");
if(empty($_SESSION["login_nome"]) or empty($_SESSION["login_nivel"])){
	print "<script>top.window.close();</script>";
	exit;
}
if($acao=="ok"){
	if(!empty($_FILES["img"]["name"])){
		$nome=$_FILES["img"]["name"];
		$erros=0;
		if($_FILES["img"]["type"]!="image/pjpeg"){
			$erros++;
			$_SESSION["mensagem"]="A imagem deve ter extensão .jpg ou .jpeg";
		}
		if($_FILES["img"]["size"] > 51200){
			$erros++;
			$_SESSION["mensagem"].="\\nA imagem deve ter até 50Kb";			
		}
		if(file_exists("$patch/imagebank/$nome")){
			$erros++;
			$_SESSION["mensagem"].="\\nJá existe uma imagem no banco com este nome";
		}
		if($erros==0){
			$arquivo="$patch/imagebank/$nome";
			if (file_exists($arquivo)) { 
				unlink($arquivo);
			}
			$upa=copy($_FILES["img"]["tmp_name"], $arquivo);
			if($upa){
				$_SESSION["mensagem"]="Imagem incluída com sucesso";
			}else{
				$_SESSION["mensagem"]="A imagem não pôde ser carregada\\nVerifique e tente novamente";
				header("Location:imagebank2.php");
				exit;
			}
		}else{
			header("Location:imagebank2.php");
			exit;		
		}
	}
	header("Location:imagebank.php");
	exit;
}
?>
<html>
<head>
<title>Banco de Imagens</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function verifica(cad){
	if(cad.img.value==''){
		alert('Selecione a imagem');
		return false;
	}
	return true;
}
</script>
<script src="scripts.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<tr>
  <td><form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return verifica(this);">
      <table width="350" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr> 
          <td colspan="2" align="center" class="textoboldbranco">Inserir uma Imagem</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="58" class="textobold">&nbsp;Imagem</td>
          <td width="439"><input name="img" type="file" class="formularioselect" id="img"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="2" align="center">
            <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='imagebank.php'">
          <img src="imagens/dot.gif" width="20" height="8">
            <input name="Submit2" type="submit" class="microtxt" value="Continuar">
            
          <input name="acao" type="hidden" id="acao" value="ok"></td></tr>
      </table>
    </form>
</body>
</html>
<? include("mensagem.php"); ?>