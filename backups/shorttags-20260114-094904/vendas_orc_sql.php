<?
include("conecta.php");
if(empty($acao)) exit;
//$acao=verifi($permi,$acao);
$hj=date("Y-m-d");
$hora=hora();
if(!empty($acao)){
	$loc="Vendas propostas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO vendas_orcamento (emissao,cliente) VALUES ('$hj','$cli')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM vendas_orcamento");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	if(!empty($cli)){
		//followup
		$sql=mysql_query("INSERT INTO followup (cliente,tipo,data,hora,titulo,descricao,contato,vendedor) VALUES ('$cli','3','$hj','$hora','followup','Proposta Nº $id foi criadaa.','','$_SESSION[login_codigo]')");
	}
	$sql=mysql_query("INSERT INTO vendas_orcamento_list (orcamento) VALUES ('$id')");
}elseif($acao=="gvenda"){
	$sql=mysql_query("UPDATE vendas_orcamento SET sit='1' WHERE id='$id'") or die("erro");
	$sql=mysql_query("SELECT * FROM vendas_orcamento WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$cli=mysql_query("SELECT * FROM clientes WHERE id='$res[cliente]'");
	$rcli=mysql_fetch_array($cli);
		if($rcli["estado"]=="27"){
			$natu="17";
		}else{
			$natu="18";
		}
	switch($res["frete"]){
		case 2:
		$por="E";
		break;
		case 3:
		$freti="1";
		$por="D";
		break;
		case 4:
		$freti="2";
		$por="D";
		break;
	}
	if($res["p_entrega"]=="1"){ $previ="3"; }elseif($res["p_entrega"]=="2"){ $previ="7"; }elseif($res["p_entrega"]=="3"){ $previ="15"; }else{ $previ="30"; }
	
	//AGENDA // // // // // / / / / / / / / / 
	mysql_query("DELETE FROM agenda WHERE id_prop='$id'");

	$prev=date("Y-m-d", mktime(0,0,0,date("m"),date("d")+$previ,date("Y")));

	$cli=$res["cliente"];
	$sql=mysql_query("INSERT INTO vendas (cliente,acao,emissao,vendedor,fretepor,parcelamento,previsao,frete,frete_tp,natureza,valor,representante) VALUES ('$res[cliente]','$res[acao]','$hj','$res[vendedor]','$por','$res[p_pag]','$prev','$res[frete_val]','$freti','$natu','$res[valor]','$res[representante]')");
	$max=mysql_query("SELECT MAX(id) as id from vendas"); $rmax=mysql_fetch_array($max);
		//followup
	$sql=mysql_query("INSERT INTO followup (cliente,tipo,data,hora,titulo,descricao,contato,vendedor) VALUES ('$res[cliente]','3','$hj','$hora','followup','Proposta foi fechada e gerada a venda Nº: $rmax[id]','$contato','$res[vendedor]')");
	
	$sql=mysql_query("SELECT MAX(id) AS id FROM vendas");
	$res=mysql_fetch_array($sql);
	$venda=$res["id"];
	$sql=mysql_query("SELECT * FROM vendas_orcamento_list WHERE orcamento='$id'");
	if(mysql_num_rows($sql)){
		while($res=mysql_fetch_array($sql)){
			$sql1=mysql_query("INSERT INTO vendas_list (venda,produto,qtd,altura,largura,unitario,desconto,material) VALUES ('$venda','$res[produto]','$res[qtd]','$res[altura]','$res[largura]','$res[unitario]','$res[desconto]','$res[material]')");
		}
	}
//Gerar Separacao e Producaooo
//	
	header("Location:crm_clientes_geral.php?acao=alt&id=$cli&venda=$venda");
//	header("Location:vendas.php?acao=alt&id=$venda");
	$_SESSION["mensagem"]="Pedido de venda gerado com sucesso!";
	exit;
}elseif($acao=="alt"){
	$emissao=data2banco($emissao);
	$sql=mysql_query("UPDATE vendas_orcamento SET cod='$cod',cliente='$cliente',contato='$contato',validade='$validade',emissao='$emissao',vendedor='$vendedor',p_pag='$p_pag',instalacao='$instalacao',p_entrega='$p_entrega',frete='$frete',nivel='$nivel',frete_val='$frete_val',acao='$acaom',sit='0',representante='$representante' WHERE id='$id'");
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
			$peso2=$peso[$ids];
			$valor2+=($qtd2*$unitario2)-($qtd2*$unitario2*$desconto2/100);
			$sql=mysql_query("UPDATE vendas_orcamento_list SET produto='$prodserv2',local='$local2',altura='$altura2',largura='$largura2',qtd='$qtd2',unitario='$unitario2',desconto='$desconto2',material='$material2',peso='$peso2' WHERE id='$ids'");
		}			
	}
	$valor2+=$frete_val;
	$sql=mysql_query("UPDATE vendas_orcamento SET valor='$valor2' WHERE id='$id'");
	//AGENDA // // // // // / / / / / / / / / 
	$sl=mysql_query("SELECT * FROM agenda WHERE id_prop='$id'");
	if(!mysql_num_rows($sl)){
		//Selecionar NOME Vendedor
		$vend=mysql_query("SELECT * FROM clientes WHERE id='$vendedor'");
		$rven=mysql_fetch_array($vend);
		// DATA
		$dp=explode("-",$emissao);
		$prev=date("Y-m-d", mktime(0,0,0,$dp[1],$dp[2]+$previ,$dp[0]));
		//
		$sql=mysql_query("INSERT INTO agenda (cliente,id_prop,nome,texto,titulo,data,hora) VALUES ('$cliente','$id','$rven[nome]','Proposta criada $id','Proposta Agendada $id','$prev','')");
	}else{
		// DATA
			$dp=explode("-",$emissao);
			$prev=date("Y-m-d", mktime(0,0,0,$dp[1],$dp[2]+$previ,$dp[0]));
		//
		$sql=mysql_query("UPDATE agenda SET data='$prev' WHERE id_prop='$id'");
	}
	if($sql){
		$_SESSION["mensagem"]="Proposta alterada com sucesso!";
	}else{
		$_SESSION["mensagem"]="A proposta não pôde ser alterado!";
	}
	if($maisum){
		$sql=mysql_query("INSERT INTO vendas_orcamento_list (orcamento) VALUES ('$id')");
		unset($_SESSION["mensagem"]);
	}
	if($delsel){
		if(isset($del)){
			foreach($del AS $ids => $idss){
				$sql=mysql_query("DELETE FROM vendas_orcamento_list WHERE id='$ids'");
			}
			unset($_SESSION["mensagem"]);
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
	if($continuar){
		header("Location:vendas_orc.php?acao=alt&id=$id");
		exit;
	}
}elseif($acao=="exc"){
	$sql=mysql_query("DELETE FROM vendas_orcamento WHERE id='$id'");
	if($sql){
		$sql=mysql_query("DELETE FROM vendas_orcamento_list WHERE orcamento='$id'");
		$_SESSION["mensagem"]="Proposta excluída com sucesso!";
	}else{
		$_SESSION["mensagem"]="A proposta não pôde ser excluído!";
	}
	header("Location:vendas_orc.php");
	exit;
}
header("Location:vendas_orc.php?acao=alt&id=$id");
?>