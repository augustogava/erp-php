<?php
include("conecta.php");
$acao=Input::request("acao");
$nome=Input::request("nome");
$valor=Input::request("valor");
$id=Input::request("id");
if(empty($acao)) exit;
if($acao=="incluir"){
	$valor=valor2banco($valor);
	$sql=mysql_query("INSERT INTO tip_material (nome,valorm) VALUES ('$nome','$valor')");
	if($sql){
		$_SESSION["mensagem"]="Material Incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Material não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$valor=valor2banco($valor);
	$sql=mysql_query("UPDATE tip_material SET nome='$nome', valorm='$valor' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Material alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Material não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM tip_material WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Material excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Material não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:tip_material.php");
}else{
	header("Location:tip_material.php?acao=$acao&id=$id");
}
?>