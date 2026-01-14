<?php
include("conecta.php");
$acao=Input::request("acao");
$descricao=Input::request("descricao");
$codigo=Input::request("codigo");
$tipo=Input::request("tipo");
$id=Input::request("id");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Tab. Operações";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}s
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO pcontas (descricao,codigo,tipo) VALUES ('$descricao','$codigo','$tipo')");
	if($sql){
		$_SESSION["mensagem"]="Conta incluída com sucesso!";
		$acao="plano";
	}else{
		$_SESSION["mensagem"]="A conta não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE pcontas SET descricao='$descricao',codigo='$codigo',tipo='$tipo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Conta alterada com sucesso!";
		$acao="plano";
	}else{
		$_SESSION["mensagem"]="A conta não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM pcontas WHERE idpai='$id'");
		$sql=mysql_query("DELETE FROM pcontas WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Conta excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A conta não pôde ser excluída!";
		}		
	}
	$acao="plano";
}
if($acao=="plano"){
	header("Location:pcontas.php");
}elseif($acao=="inc"){
	header("Location:pconta_inc.php");
}elseif($acao=="alt"){
	header("Location:pconta_inc.php?acao=alt&id=$id");
}
?>