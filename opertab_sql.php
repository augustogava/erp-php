<?php
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Tab. Operações";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO opertab (codigo,nome,tipo) VALUES ('$codigo','$nome','$tipo')");
	if($sql){
		$_SESSION["mensagem"]="Operação incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A operação não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE opertab SET codigo='$codigo',nome='$nome',tipo='$tipo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Operação alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A operação não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM opertab WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Operação excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A operação não pôde ser excluída!";
		}		
	}
	$acao="entrar";
}
header("Location:opertab.php?acao=$acao&id=$id");
?>