<?
include("conecta.php");
//include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="AF";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) exit;
$recebimento=data2banco($recebimento);
$recebimento_anexo=data2banco($recebimento_anexo);
$entrega=data2banco($entrega);
$atualizacao=data2banco($atualizacao);

if($acao=="inc"){
			$sql=mysql_query("INSERT INTO af (af,recebimento,anexo,recebimento_anexo,entrega,atualizacao,situacao) VALUES ('$af','$recebimento','$anexo','$recebimento_anexo','$entrega','$atualizacao','$situacao')");
	if($sql){
		$_SESSION["mensagem"]="AF incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A AF não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alt"){
	$sql=mysql_query("UPDATE af SET af='$af',recebimento='$recebimento',anexo='$anexo',recebimento_anexo='$recebimento_anexo',entrega='$entrega',atualizacao='$atualizacao',situacao='$situacao' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="AF alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A AF não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM af WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="AF excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A AF não pôde ser excluída!";
		}		
	}
	$acao="entrar";
}
header("Location:af.php?acao=$acao&id=$id");
?>