<?php
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Vendas propostas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO vendas_orc (emissao,cliente) VALUES ('$hj','$cli')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM vendas_orc");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("INSERT INTO vendas_orc_list (orcamento) VALUES ('$id')");
}elseif($acao=="gvenda"){
	$hj=date("Y-m-d");
	$hora=hora();
	
	$sql=mysql_query("UPDATE vendas_orc SET sit='1' WHERE id='$id'") or die("erro");
	$sql=mysql_query("SELECT * FROM vendas_orc WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	//INSERIR CLIENTE pois nao existe!
	/*
	mysql_query("INSERT INTO clientes (nome,fantasia,fone,email) VALUES('$res[cliente]','$res[cliente]','$res[telefone]','$res[email]')");
	$clis=mysql_query("SELECT MAX(id) as id FROM clientes");
	$clir=mysql_fetch_array($clis);
	$cli=$clir["id"];
	*/
	//
	$sql=mysql_query("INSERT INTO vendas_orcamento (acao,emissao,vendedor,cod) VALUES ('$res[acao]','$hj','$res[vendedor]','$res[cod]')");
	$max=mysql_query("SELECT MAX(id) as id from vendas_orcamento"); $rmax=mysql_fetch_array($max);
		//followup
	$sql=mysql_query("INSERT INTO followup (cliente,tipo,data,hora,titulo,descricao,contato,vendedor) VALUES ('$cli','3','$hj','$hora','followup','Orçamento foi fechada e gerada a proposta Nº: $venda','$contato','$rmax[id]')");

	$venda=$rmax["id"];
	$sql=mysql_query("SELECT * FROM vendas_orc_list WHERE orcamento='$id'");
	if(mysql_num_rows($sql)){
		while($res=mysql_fetch_array($sql)){
			$sql1=mysql_query("INSERT INTO vendas_orcamento_list (orcamento,produto,qtd,altura,largura,unitario,desconto,material,local) VALUES ('$venda','$res[produto]','$res[qtd]','$res[altura]','$res[largura]','$res[unitario]','$res[desconto]','$res[material]','$res[local]')");
		}
	}	
	header("Location:vendas_orc.php?acao=alt&id=$venda");
	$_SESSION["mensagem"]="Orçamento Fechado com sucesso!";
	exit;
}elseif($acao=="alt"){
	$emissao=data2banco($emissao);
	$sql=mysql_query("UPDATE vendas_orc SET cod='$cod',acao='$acaom',cliente='$cliente',telefone='$telefone',email='$email',emissao='$emissao',vendedor='$vendedor' WHERE id='$id'");
	if(isset($qtd)){
		foreach($qtd AS $ids => $idss){
			$prodserv2=$prodserv[$ids];
			$qtd2=valor2banco($qtd[$ids]);
			$unitario2=valor2banco($unitario[$ids]);
			$local2=$local[$ids];
			$altura2=valor2banco($altura[$ids]);
			$largura2=valor2banco($largura[$ids]);
			$desconto2=valor2banco($desconto[$ids]);
			$material2=$material[$ids];
			$valor2+=($qtd2*$unitario2)-($qtd2*$unitario2*$desconto2/100);
			$sql=mysql_query("UPDATE vendas_orc_list SET produto='$prodserv2',local='$local2',altura='$altura2',largura='$largura2',qtd='$qtd2',unitario='$unitario2',desconto='$desconto2',material='$material2' WHERE id='$ids'");
		}			
	}
	$sql=mysql_query("UPDATE vendas_orc SET valor='$valor2' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Orçamento alterado com sucesso!";
	}else{
		$_SESSION["mensagem"]="Orçamento não pôde ser alterado!";
	}
	if($maisum){
		$sql=mysql_query("INSERT INTO vendas_orc_list (orcamento) VALUES ('$id')");
		unset($_SESSION["mensagem"]);
	}
	if($delsel){
		if(isset($del)){
			foreach($del AS $ids => $idss){
				$sql=mysql_query("DELETE FROM vendas_orc_list WHERE id='$ids'");
			}
			unset($_SESSION["mensagem"]);
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
}elseif($acao=="exc"){
	$sql=mysql_query("DELETE FROM vendas_orc WHERE id='$id'");
	if($sql){
		$sql=mysql_query("DELETE FROM vendas_orc_list WHERE orcamento='$id'");
		$_SESSION["mensagem"]="Orçamento excluído com sucesso!";
	}else{
		$_SESSION["mensagem"]="Orçamento não pôde ser excluído!";
	}
	header("Location:vendas_orca.php");
	exit;
}
header("Location:vendas_orca.php?acao=alt&id=$id");
?>