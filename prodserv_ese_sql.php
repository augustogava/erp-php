<?php
include("conecta.php");
if(empty($acao)) exit;
$qtd=valor2banco($qtd);
$valor=valor2banco($valor);
$quem=$_SESSION["login_nome"];
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Mov. Estoque";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="em"){
	$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtde,valor,doc,origem,tipomov,quem) VALUES ('$item',NOW(),'$qtd','$valor','$doc',1,1,'$quem')");
	if($sql){
		$sql=mysql_query("UPDATE prodserv SET est=est+$qtd WHERE id='$item'");
		$_SESSION["mensagem"]="Entrada manual registrada com sucesso!";
		$acao="close";
	}else{
		$_SESSION["mensagem"]="A entrada manual não pôde ser registrada!";
	}
}elseif($acao=="sm"){
	$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,doc,origem,tipomov,quem) VALUES ('$item',NOW(),'$qtd','$valor','$doc',1,2,'$quem')");
	if($sql){
		$sql=mysql_query("UPDATE prodserv SET est=est-$qtd WHERE id='$item'");
		$_SESSION["mensagem"]="Saída manual registrada com sucesso!";
		$acao="close";
	}else{
		$_SESSION["mensagem"]="A saída manual não pôde ser registrada!";
	}
}elseif($acao=="ee"){
	$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,doc,origem,tipomov,quem) VALUES ('$item',NOW(),'$qtd','$valor','$doc',1,3,'$quem')");
	if($sql){
		$sql=mysql_query("UPDATE prodserv SET est=est-$qtd WHERE id='$item'");
		$_SESSION["mensagem"]="Estorno de entrada registrado com sucesso!";
		$acao="close";
	}else{
		$_SESSION["mensagem"]="O estorno de entrada não pôde ser registrado!";
	}
}elseif($acao=="es"){
	$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtde,valor,doc,origem,tipomov,quem) VALUES ('$item',NOW(),'$qtd','$valor','$doc',1,4,'$quem')");
	if($sql){
		$sql=mysql_query("UPDATE prodserv SET est=est+$qtd WHERE id='$item'");
		$_SESSION["mensagem"]="Estorno de saída registrado com sucesso!";
		$acao="close";
	}else{
		$_SESSION["mensagem"]="O estorno de saída não pôde ser registrado!";
	}
}
if($acao=="close"){
	print"
	<script>
	opener.form1.submit();
	window.close();
	</script>";
}else{
	header("Location:prodserv_ese.php?act=$acao&item=$item");
}
?>