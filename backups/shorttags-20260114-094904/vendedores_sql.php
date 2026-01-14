<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Vendedores";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(isset($vendedores)){
	$sql=mysql_query("UPDATE niveis SET vendedor=0");
	foreach($vendedores AS $dedores => $ven){
		$sql=mysql_query("UPDATE niveis SET vendedor=1 WHERE id='$ven'");
	}
	if($sql){
		$_SESSION["mensagem"]="Alteraзгo concluнda com sucesso";
	}else{
		$_SESSION["mensagem"]="Nгo foi possнvel realizar a alteraзгo";
	}
}else{
	$_SESSION["mensagem"]="Selecione pelo menos um nнvel";
}
header("Location:vendedores.php");
?>