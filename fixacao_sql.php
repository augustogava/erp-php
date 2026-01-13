<?
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Fixaзгo";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$valor=valor2banco($valor);
	$sql=mysql_query("INSERT INTO fixacao (nome,valor) VALUES ('$nome','$valor')");
	if($sql){
		$_SESSION["mensagem"]="Modo de fixaзгo Incluнdo com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Modo de fixaзгo nгo pфde ser incluнdo!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$valor=valor2banco($valor);
	$sql=mysql_query("UPDATE fixacao SET nome='$nome', valor='$valor' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Modo de fixaзгo alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Modo de fixaзгo nгo pфde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM fixacao WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Modo de fixaзгo excluнdo com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Modo de fixaзгo nгo pфde ser excluнdo!";
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