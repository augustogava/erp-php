<?php
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Produtos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$qtd=valor2banco($qtd);
	$val=valor2banco($val);
	$sql=mysql_query("INSERT INTO prodserv_item (prodserv,item,qtd,fixo,val) VALUES ('$ps','$item','$qtd','$fixo','$val')");
	if($sql){
		$_SESSION["mensagem"]="Item incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O item não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$qtd=valor2banco($qtd);
	$val=valor2banco($val);
	$sql=mysql_query("UPDATE prodserv_item SET item='$item',qtd='$qtd',fixo='$fixo',val='$val' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Item alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O item não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM prodserv_item WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Item excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O item não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
header("Location:prodserv_item.php?acao=$acao&id=$id&ps=$ps");
?>