<?php
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Unidades";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO unidades (nome,apelido) VALUES ('$nome','$apelido')");
	if($sql){
		$_SESSION["mensagem"]="Unidade incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A unidade não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
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
header("Location:unidades.php?acao=$acao&id=$id");
?>