<?php
include("conecta.php");
$acao=Input::request("acao");
$nome=Input::request("nome");
$apelido=Input::request("apelido");
$id=Input::request("id");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Situação T.";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO sitri (nome,apelido) VALUES ('$nome','$apelido')");
	if($sql){
		$_SESSION["mensagem"]="Situação incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A situação não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE sitri SET nome='$nome',apelido='$apelido' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Situação alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A situação não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM sitri WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Situação excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A situação não pôde ser excluída!";
		}		
	}
	$acao="entrar";
}
header("Location:sitri.php?acao=$acao&id=$id");
?>