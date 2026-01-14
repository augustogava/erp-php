<?php
include("conecta.php");
$acao=Input::request("acao");
$id=Input::request("id");
$nome=Input::request("nome");
$apelido=Input::request("apelido");
$valor_ma=Input::request("valor_ma");
$peso=Input::request("peso");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Material";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$valor_ma=valor2banco($valor_ma);
	$peso=valor2banco($peso);
	$sql=mysql_query("INSERT INTO material (nome,apelido,valor,peso) VALUES ('$nome','$apelido','$valor','$peso')");
	if($sql){
		$_SESSION["mensagem"]="Material Incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Material não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$valor_ma=valor2banco($valor_ma);
	$peso=valor2banco($peso);
	$sql=mysql_query("UPDATE material SET nome='$nome',apelido='$apelido', valor='$valor_ma',peso='$peso' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Material alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Material não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM material WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Material excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Material não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:material.php");
}else{
	header("Location:material.php?acao=$acao&id=$id");
}
?>