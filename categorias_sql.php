<?php
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Categorias";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO categorias (nome) VALUES ('$nome')");
	if($sql){
		$_SESSION["mensagem"]="Categoria incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Categoria não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE categorias SET nome='$nome' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Categoria alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Categoria não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("SELECT * FROM prodserv WHERE categoria='$id'");
		 if(!mysql_num_rows($sql)){
			$sql=mysql_query("DELETE FROM categorias WHERE id='$id'");
			if($sql){
				$_SESSION["mensagem"]="Categoria excluída com sucesso!";
			}else{
				$_SESSION["mensagem"]="A Categoria não pôde ser excluída!";
			}	
		 }else{
		 	$_SESSION["mensagem"]="Categoria Não pode ser excluída pois existem produtos cadastrados!";
		 }
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:categorias.php");
}else{
	header("Location:categorias.php?acao=$acao&id=$id");
}
?>