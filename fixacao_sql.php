<?php
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Fixação";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$valor=valor2banco($valor);
	$sql=mysql_query("INSERT INTO fixacao (nome,valor) VALUES ('$nome','$valor')");
	if($sql){
		$_SESSION["mensagem"]="Modo de fixação Incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Modo de fixação não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$valor=valor2banco($valor);
	$sql=mysql_query("UPDATE fixacao SET nome='$nome', valor='$valor' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Modo de fixação alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Modo de fixação não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM fixacao WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Modo de fixação excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Modo de fixação não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:fixacao.php");
}else{
	header("Location:material.php?acao=$acao&id=$id");
}
?>