<?
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Situaзгo T.";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO sitri (nome,apelido) VALUES ('$nome','$apelido')");
	if($sql){
		$_SESSION["mensagem"]="Situaзгo incluнda com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A situaзгo nгo pфde ser incluнda!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE sitri SET nome='$nome',apelido='$apelido' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Situaзгo alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A situaзгo nгo pфde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM sitri WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Situaзгo excluнda com sucesso!";
		}else{
			$_SESSION["mensagem"]="A situaзгo nгo pфde ser excluнda!";
		}		
	}
	$acao="entrar";
}
header("Location:sitri.php?acao=$acao&id=$id");
?>