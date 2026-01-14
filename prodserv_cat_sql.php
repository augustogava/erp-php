<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Produtos Cat";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	$sql=mysql_query("INSERT INTO prodserv_cat (idpai,codigo,texto,ativo) VALUES ('$idpai','$codigo','$texto','$ativo')");
	if($sql){
		$_SESSION["mensagem"]="Categoria incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A categoria não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alt"){
	$sql=mysql_query("UPDATE prodserv_cat SET idpai='$idpai',codigo='$codigo',texto='$texto',ativo='$ativo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Categoria alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A categoria não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("SELECT * FROM prodserv_cat WHERE id='$id'");
		if(mysql_num_rows($sql));
		if($sql){
			function delno($id){
				$sql=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$id'");
				$sqld=mysql_query("DELETE FROM prodserv_cat WHERE id='$id'");
				if(mysql_num_rows($sql)){
					while($res=mysql_fetch_array($sql)){
						$sqld=mysql_query("DELETE FROM prodserv_cat WHERE idpai='$id'");
						delno($res["id"]);
					}
				}
			}
			delno($id);
			$_SESSION["mensagem"]="Categoria excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A categoria não pôde ser excluída!";
		}
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:prodserv_cat.php");
}else{
	header("Location:prodserv_cat.php?acao=$acao&id=$id");
}
?>