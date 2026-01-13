<?
include("conecta.php");
if(empty($acao)) exit;
if($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM op_pagamento WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Opзгo Pagamento excluнdo com sucesso!";
		}else{
			$_SESSION["mensagem"]="A opзao nгo pфde ser excluнdo!";
		}
	}
	$acao="entrar";
}else if($acao=="inc"){
	$desconto=valor2banco($desconto);
	$sql=mysql_query("INSERT INTO op_pagamento (nome,parcelamento,operador,desconto) VALUES('$nome','$parcelamento','$op','$desconto')");
	if($sql){
		$_SESSION["mensagem"]="Opзгo pagamento incluнdo com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A opзao nгo pфde ser incluнdo!";
		$acao="inc";
	}
}else if($acao=="alt"){
	if(!empty($id)){
		$desconto=valor2banco($desconto);
		$sql=mysql_query("UPDATE op_pagamento SET nome='$nome',parcelamento='$parcelamento',desconto='$desconto',operador='$op' WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Opзгo pagamento alterado com sucesso!";
			$acao="entrar";
		}else{
			$_SESSION["mensagem"]="A opзгo nгo pфde ser alterado!";
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