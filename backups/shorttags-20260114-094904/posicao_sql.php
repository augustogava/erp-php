<?
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Posições";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
$acao="alt";
	reset($posicao); 
	while (list($key, $val) = each($posicao)) {  
		  $ids[]=$key;
	}
	reset($ids);
	while (list($key, $val) = each($ids)) {  
		$posicao1=$posicao[$val];
		$sql=mysql_query("UPDATE prodserv SET posicao='$posicao1' WHERE id='$val'");
	}
	if($sql){
		$_SESSION["mensagem"]="Posições alteradas com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="As Posições não pôdem ser alterada!";
		$acao="alt";
	}
header("Location:posicao.php?acao=$acao&id=$id");
?>