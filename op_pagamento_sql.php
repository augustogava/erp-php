<?php
include("conecta.php");
$acao=Input::request("acao");
$id=Input::request("id");
$desconto=Input::request("desconto");
$nome=Input::request("nome");
$parcelamento=Input::request("parcelamento");
$op=Input::request("op");
if(empty($acao)) exit;
if($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM op_pagamento WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Opção Pagamento excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="A opçao não pôde ser excluído!";
		}
	}
	$acao="entrar";
}else if($acao=="inc"){
	$desconto=valor2banco($desconto);
	$sql=mysql_query("INSERT INTO op_pagamento (nome,parcelamento,operador,desconto) VALUES('$nome','$parcelamento','$op','$desconto')");
	if($sql){
		$_SESSION["mensagem"]="Opção pagamento incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A opçao não pôde ser incluído!";
		$acao="inc";
	}
}else if($acao=="alt"){
	if(!empty($id)){
		$desconto=valor2banco($desconto);
		$sql=mysql_query("UPDATE op_pagamento SET nome='$nome',parcelamento='$parcelamento',desconto='$desconto',operador='$op' WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Opção pagamento alterado com sucesso!";
			$acao="entrar";
		}else{
			$_SESSION["mensagem"]="A opção não pôde ser alterado!";
			$acao="alt";
		}
	}else{
		$acao="entrar";
	}
}
if($acao=="entrar"){
	header("Location:op_pagamento.php");
}elseif($acao=="inc"){
	header("Location:op_pagamento.php?acao=inc");
}elseif($acao=="alt"){
	header("Location:op_pagamento.php?acao=alt&id=$id");
}
?>