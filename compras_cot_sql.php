<?php
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Compras Cot.";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO compras_cotacao (data) VALUES ('$hj')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM compras_cotacao");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("INSERT INTO compras_cotacao_list (cotacao) VALUES ('$id')");
}elseif($acao=="gcompra"){
	$hj=date("Y-m-d");
	$sql=mysql_query("SELECT * FROM compras_cotacao WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$sql=mysql_query("INSERT INTO compras (fornecedor,emissao) VALUES ('$res[fornecedor]','$hj')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM compras");
	$res=mysql_fetch_array($sql);
	$compra=$res["id"];
	$sql=mysql_query("SELECT * FROM compras_cotacao_list WHERE cotacao='$id'");
	if(mysql_num_rows($sql)){
		while($res=mysql_fetch_array($sql)){
			$sql1=mysql_query("INSERT INTO compras_list (compra,produto,qtd,unitario) VALUES ('$compra','$res[produto]','$res[qtd]','$res[unitario]')");
		}
	}
	header("Location:compras.php?acao=alt&id=$compra");
	$_SESSION["mensagem"]="Pedido de compra gerado com sucesso!";
	exit;
}elseif($acao=="req"){
	if(isset($qtd)){
		$hj=date("Y-m-d");
		foreach($qtd AS $ids => $idss){
			$sita=$sit[$ids];
			$sql=mysql_query("UPDATE compras_requisicao_list SET data='$hj',sit='$sita' WHERE id='$ids'");
		}
	}			
	header("Location:compras_cot.php");
	$_SESSION["mensagem"]="Lista de requisições alterada com sucesso!";
	exit;
}elseif($acao=="alt"){
	$data=data2banco($data);
	$ucd=data2banco($ucd);
	$ucv=valor2banco($ucv);
	$prazo=data2banco($prazo);
	$sql=mysql_query("UPDATE compras_cotacao SET fornecedor='$fornecedor',prazo='$prazo',data='$data',ucd='$ucd',ucv='$ucv' WHERE id='$id'");
	if(isset($qtd)){
		foreach($qtd AS $ids => $idss){
			$prodserv2=$prodserv[$ids];
			$qtd2=valor2banco($qtd[$ids]);
			$unitario2=valor2banco($unitario[$ids]);
			$valor2+=$qtd2*$unitario2;
			$sql=mysql_query("UPDATE compras_cotacao_list SET produto='$prodserv2',qtd='$qtd2',unitario='$unitario2' WHERE id='$ids'");
		}			
	}
	$sql=mysql_query("UPDATE compras_cotacao SET valor='$valor2' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cotação alterada com sucesso!";
	}else{
		$_SESSION["mensagem"]="A cotação não pôde ser alterada!";
	}
	if($maisum){
		$sql=mysql_query("INSERT INTO compras_cotacao_list (cotacao) VALUES ('$id')");
		unset($_SESSION["mensagem"]);
	}
	if($delsel){
		if(isset($del)){
			foreach($del AS $ids => $idss){
				$sql=mysql_query("DELETE FROM compras_cotacao_list WHERE id='$ids'");
			}
			unset($_SESSION["mensagem"]);
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
}elseif($acao=="exc"){
	$sql=mysql_query("DELETE FROM compras_cotacao WHERE id='$id'");
	if($sql){
		$sql=mysql_query("DELETE FROM compras_cotacao_list WHERE cotacao='$id'");
		$_SESSION["mensagem"]="Cotação excluída com sucesso!";
	}else{
		$_SESSION["mensagem"]="O Cotação não pôde ser excluída!";
	}
	header("Location:compras_cot.php");
	exit;
}
header("Location:compras_cot.php?acao=alt&id=$id");
?>