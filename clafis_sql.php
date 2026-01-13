<?
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Class. Fiscal";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO clafis (nome,apelido) VALUES ('$nome','$apelido')");
	if($sql){
		$_SESSION["mensagem"]="Classificaзгo incluнda com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A classificaзгo nгo pфde ser incluнda!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE clafis SET nome='$nome',apelido='$apelido' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Classificaзгo alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A classificaзгo nгo pфde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM clafis WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Classificaзгo excluнda com sucesso!";
		}else{
			$_SESSION["mensagem"]="A classificaзгo nгo pфde ser excluнda!";
		}		
	}
	$acao="entrar";
}
header("Location:clafis.php?acao=$acao&id=$id");
?>