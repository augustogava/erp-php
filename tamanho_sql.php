<?php
include("conecta.php");
if(empty($acao)) exit;
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO tamanho (nome) VALUES ('$nome')");
	if($sql){
		$_SESSION["mensagem"]="Tamanho incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Tamanho não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE tamanho SET nome='$nome' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Tamanho alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Tamanho não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM tamanho WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Tamanho excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Tamanho não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:tamanho.php");
}else{
	header("Location:tamanho.php?acao=$acao&id=$id");
}
?>