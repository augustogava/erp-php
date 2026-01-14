<?php
include("conecta.php");
$acao=Input::request("acao");
$id=Input::request("id");
$nome=Input::request("nome");
$trilho=Input::request("trilho");
$pvc=Input::request("pvc");
$arrebites=Input::request("arrebites");
$parafusos=Input::request("parafusos");
$buchas=Input::request("buchas");
$penduralg=Input::request("penduralg");
$penduralp=Input::request("penduralp");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Cortinas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="alterar"){
	$sql=mysql_query("UPDATE cortinas SET nome='$nome',trilho='$trilho',pvc='$pvc',arrebites='$arrebites',parafusos='$parafusos',buchas='$buchas',penduralg='$penduralg',penduralp='$penduralp'  WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cortina alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Cortina não pôde ser alterado!";
		$acao="alt";
	}
}else if($acao=="incluir"){
		$sql=mysql_query("INSERT INTO cortinas (nome,trilho,pvc,arrebites,parafusos,buchas,penduralg,penduralp) VALUES ('$nome','$trilho','$pvc','$arrebites','$parafusos','$buchas','$penduralg','$penduralp')");
	if($sql){
		$_SESSION["mensagem"]="Cortina incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Cortina não pôde ser incluído!";
		$acao="inc";
	}
}
header("Location:cortinas.php?acao=$acao&id=$id");
?>