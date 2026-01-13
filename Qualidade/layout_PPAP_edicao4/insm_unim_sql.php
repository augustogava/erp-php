<?
include("conecta.php");
if(empty($acao)) exit;
if(!empty($acao)){
	$loc="Recebimento - Unidades";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
$sql2=mysql_query("SELECT * FROM unidades WHERE nome='$nome'");

	if(mysql_num_rows($sql2)==0){
	$sql=mysql_query("INSERT INTO unidades (nome,apelido) VALUES ('$nome','$apelido')");
		if($sql){
			$_SESSION["mensagem"]="Unidade incluída com sucesso!";
			$acao="entrar";
		}else{
			$_SESSION["mensagem"]="A unidade não pôde ser incluída!";
			$acao="inc";
		}

	}else{ 
		$_SESSION["mensagem"]="A Unidade não pôde ser incluída porque já existe!";
	}
}else if($acao=="alterar"){
	$sql=mysql_query("UPDATE unidades SET nome='$nome',apelido='$apelido' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Unidade alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A unidade não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM unidades WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Unidade excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A unidade não pôde ser excluída!";
		}		
	}
	$acao="entrar";
}

header("Location:insm_unim.php?acao=$acao&id=$id");
?>