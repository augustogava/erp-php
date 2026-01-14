<?
include("conecta.php");
if(empty($acao)) exit;
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO pcontas (idpai,descricao,codigo,tipo) VALUES ('$idpai','$descricao','$codigo','$tipo')");
	if($sql){
		$_SESSION["mensagem"]="Subconta incluída com sucesso!";
		$acao="plano";
	}else{
		$_SESSION["mensagem"]="A subconta não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE pcontas SET descricao='$descricao',codigo='$codigo',tipo='$tipo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Subconta alterada com sucesso!";
		$acao="plano";
	}else{
		$_SESSION["mensagem"]="A subconta não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM pcontas WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Subconta excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A subconta não pôde ser excluída!";
		}		
	}
	$acao="plano";
}
if($acao=="plano"){
	header("Location:pcontas.php");
}elseif($acao=="inc"){
	header("Location:pcontasub_inc.php?idpai=$idpai");
}elseif($acao=="alt"){
	header("Location:pcontasub_inc.php?acao=alt&id=$id");
}
?>