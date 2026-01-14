<?php
include("conecta.php");
$acao=Input::request("acao");
$cli=Input::request("cli");
$id=Input::request("id");
$emissao=Input::request("emissao");
$previsao=Input::request("previsao");
$entrega=Input::request("entrega");
$pliq=Input::request("pliq");
$pbruto=Input::request("pbruto");
$frete=Input::request("frete");
$seguro=Input::request("seguro");
$despesas=Input::request("despesas");
$cliente=Input::request("cliente");
$natureza=Input::request("natureza");
$nf=Input::request("nf");
$vendedor=Input::request("vendedor");
$operacao=Input::request("operacao");
$parcelamento=Input::request("parcelamento");
$transportadora=Input::request("transportadora");
$fretepor=Input::request("fretepor");
$faturamento=Input::request("faturamento");
$l_instalacao=Input::request("l_instalacao");
$l_entrega=Input::request("l_entrega");
$acaom=Input::request("acaom");
$ordemc=Input::request("ordemc");
$empresa=Input::request("empresa");
$representante=Input::request("representante");
$qtd=Input::request("qtd");
$prodserv=Input::request("prodserv");
$unitario=Input::request("unitario");
$desconto=Input::request("desconto");
$oper=Input::request("oper");
$altura=Input::request("altura");
$largura=Input::request("largura");
$maisum=Input::request("maisum");
$delsel=Input::request("delsel");
$del=Input::request("del");
$entregue=Input::request("entregue");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Vendas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO vendas (emissao,cliente) VALUES ('$hj','$cli')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM vendas");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("INSERT INTO vendas_list (venda) VALUES ('$id')");
}elseif($acao=="cr"){
	$sql=mysql_query("SELECT * FROM vendas WHERE id='$id' AND cr=0");
	if(!mysql_num_rows($sql)){
		$_SESSION["mensagem"]="Não foi possivel gerar o Contas a Receber\\nVerifique se o mesmo não foi gerado anteriormente";
	}else{
		$res=mysql_fetch_array($sql);
		$_SESSION["cliente"]=$res["cliente"];
		$_SESSION["cliente_tipo"]="C";
		$_SESSION["parcelamento"]=$res["parcelamento"];
		$_SESSION["documento"]="Venda ".$res["id"];
		$_SESSION["emissao"]=date("d/m/Y");
		$_SESSION["competencia"]=date("m/Y");
		$_SESSION["crvenda"]=1;
		$_SESSION["idvenda"]=$id;
		$sql=mysql_query("SELECT SUM((qtd * unitario) - ((qtd * unitario)* desconto / 100)) AS valor FROM vendas_list WHERE venda='$id'");
		if(mysql_num_rows($sql)){
			$res=mysql_fetch_array($sql);
			$_SESSION["valor"]=banco2valor($res["valor"]);
		}
		header("Location:cr_sql.php?acao=inc");
		exit;
	}
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM vendas WHERE id='$id' AND entrega<>'0000-00-00'");
	if(mysql_num_rows($sql)){
		$_SESSION["mensagem"]="Este pedido de venda já foi entregue e não pode mais ser alterado";		
	}else{
	$hj=date("Y-m-d");
		$emissao=data2banco($emissao);
		$previsao=data2banco($previsao);
		$entrega=data2banco($entrega);
		$pliq=valor2banco($pliq);
		$pbruto=valor2banco($pbruto);
		$frete=valor2banco($frete);
		$seguro=valor2banco($seguro);
		$despesas=valor2banco($despesas);
		$sql=mysql_query("UPDATE vendas SET cliente='$cliente',natureza='$natureza',nf='$nf',emissao='$emissao',previsao='$previsao',entrega='$entrega',vendedor='$vendedor',operacao='$operacao',parcelamento='$parcelamento',transportadora='$transportadora',pliq='$pliq',pbruto='$pbruto',frete='$frete',seguro='$seguro',despesas='$despesas',fretepor='$fretepor',faturamento='$faturamento',l_instalacao='$l_instalacao',l_entrega='$l_entrega',acao='$acaom',ordemc='$ordemc',empresa='$empresa',representante='$representante' WHERE id='$id'");
		if(isset($qtd)){
			foreach($qtd AS $ids => $idss){
				$prodserv2=$prodserv[$ids];
				$qtd2=valor2banco($qtd[$ids]);
				$unitario2=valor2banco($unitario[$ids]);
				$desconto2=valor2banco($desconto[$ids]);
				$operacao2=$oper[$ids];
				$altura2=valor2banco($altura[$ids]);
				$largura2=valor2banco($largura[$ids]);
				$valor2+=($qtd2*$unitario2)-($qtd2*$unitario2*$desconto2/100);
				$medidasa="$altura2"."X"."$largura2";
				$sql=mysql_query("UPDATE vendas_list SET produto='$prodserv2',qtd='$qtd2',unitario='$unitario2',altura='$altura2',largura='$largura2',desconto='$desconto2',operacao='$operacao2',medidas='$medidasa' WHERE id='$ids'");
			}			
		}
	$valor2+=$frete;
	$sql=mysql_query("UPDATE vendas SET valor='$valor2' WHERE id='$id'");
// nao sei se vai usar isso aqui
		if($entregue=="S"){
		$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$id'") or erp_db_fail();
			while($res=mysql_fetch_array($sql2)){
			$produto=$res["produto"];
			$qtd=$res["qtd"];
			$total=banco2valor($qtd*$res["unitario"]);
			$total=valor2banco($total);
			$unita=$res["unitario"];
			$sql=mysql_query("UPDATE vendas SET sit='1' WHERE id='$id'");
			$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,origem,tipomov) VALUES('$produto','$hj','$qtd','$unita','2','6')");
			}
		}
// - - - - - - - - - - - - - - - - -

		if($sql){
			$_SESSION["mensagem"]="Pedido de venda alterado com sucesso!";
		}else{
			$_SESSION["mensagem"]="O pedido de venda não pôde ser alterado!";
		}
		if($maisum){
			$sql=mysql_query("INSERT INTO vendas_list (venda) VALUES ('$id')");
			unset($_SESSION["mensagem"]);
		}
		if($delsel){
			if(isset($del)){
				foreach($del AS $ids => $idss){
					$sql=mysql_query("DELETE FROM vendas_list WHERE id='$ids'");
				}
				unset($_SESSION["mensagem"]);
			}else{
				$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
			}
		}
	}
}elseif($acao=="exc"){
	$sql=mysql_query("DELETE FROM vendas WHERE id='$id'");
	if($sql){
		$sql=mysql_query("DELETE FROM vendas_list WHERE venda='$id'");
		$_SESSION["mensagem"]="Pedido de venda excluído com sucesso!";
	}else{
		$_SESSION["mensagem"]="O pedido de venda não pôde ser excluído!";
	}
	header("Location:vendas.php");
	exit;
}elseif($acao=="fechar"){
	$data=date("Y-m-d H:i:s");
	$datat=date("Y-m-d");
	$hora=date("H:i:s");
		$sql=mysql_query("UPDATE vendas SET fechar='1',sit='2' WHERE id='$id'");
			$sql=mysql_query("SELECT * FROM vendas WHERE id='$id'"); $resv=mysql_fetch_array($sql);
	//Criar E-compraaa
			$cliente=$resv["cliente"];
			if(!empty($resv["l_entrega"])){
				$sqle=mysql_query("SELECT * FROM cliente_entrega WHERE cliente='$resv[l_entrega]'");
				$rese=mysql_fetch_array($sqle);
			}
			$sql=mysql_query("INSERT INTO e_compra (cliente,pedido,endereco,bairro,cep,cidade,estado,dtabre,pagamento,sit,data,hora,tipo) VALUES ('$cliente','$id','$rese[endereco]','$rese[bairro]','$rese[cep]','$rese[cidade]','$rese[estado]','$data','faturamento','E','$data','$hora','Interno')") or erp_db_fail();		
				$sql=mysql_query("SELECT MAX(id) AS id FROM e_compra");
				$res=mysql_fetch_array($sql); $cp=$res["id"];
	//Inserir Itens do E-compraaa
		$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$id'") or erp_db_fail();
		while($res=mysql_fetch_array($sql2)){
			$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$res[produto]'") or erp_db_fail(); $resp=mysql_fetch_array($sqlp);
			$nome=$resp["nome"]; $tipo=$resp["tipo"];
			$medidas="$res[altura]X$res[largura]";
				$sql=mysql_query("INSERT INTO e_itens (compra,produto_id,produto_nome,produto_preco,tipo,medidas,qtd,desconto) VALUES ('$cp','$res[produto]','$nome','$res[unitario]','$tipo','$medidas','$res[qtd]','$res[desconto]')");
				$valor2+=($res[qtd]*$res[unitario])-($res[qtd]*$res[unitario]*$res[desconto]/100);
		}
		$valor2+=$resv[frete];
		$sql=mysql_query("UPDATE vendas SET valor='$valor2' WHERE id='$id'");
		//Email
		mail("odair@mkrcomercial.com.br","Aprovar Pedido","Pedido Nº $id foi Fechado e está aguardando sua aprovação!");

	// Caba aki td parte de compra 
	// Separacaoooo
/* Teste
	$sql=mysql_query("INSERT INTO prodserv_sep (compra,pedido,cliente,emissao,sit) VALUES('$cp','$id','$cliente','$datat','P')");
		$sql=mysql_query("SELECT MAX(id) AS id FROM prodserv_sep");
			$res=mysql_fetch_array($sql);
				$id2=$res["id"];

	$pro=mysql_query("SELECT * FROM e_itens WHERE compra='$cp'");
	while($resp=mysql_fetch_array($pro)){
		$produto=$resp["produto_id"];
		$qtd=$resp["qtd"];
		$total=$resp["produto_preco"];
		$tamanho=$resp["medidas"];
		$material=$resp["material"];
		$fixacao=$resp["fixacao"];
			if(!empty($produto)){
				$sql=mysql_query("UPDATE prodserv SET ult_venda='$datat' WHERE id='$produto'");
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$produto','$datat','$qtd','2','2')");
			//verifica se tem no estoque agora
				$sql=mysql_query("SELECT SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE prodserv='$produto'");
				$qtd1=mysql_fetch_array($sql); 
					if($qtd1["qtdd"]<=0){ 
						$sit="1";
						$pro1=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
						$pror=mysql_fetch_array($pro1);
						if($pror["tipo"]=="PL"){
							$sql=mysql_query("INSERT INTO prodserv_ordem (prodserv,compra,pedido,cliente,qtd,tamanho,material,fixacao,sit) VALUES ('$produto','$cp','$id','$cliente','$qtd','$tamanho','$material','$fixacao','A')"); 
						}else{
							$sit="5";
						}
					}else{ 
						$sit="4"; 
					}
					$sql=mysql_query("INSERT INTO prodserv_sep_list (est,prodserv,pedido,qtd,data,sit) VALUES('$id2','$produto','$id','$qtd','$data','$sit')");
				}
		}
*/
		$_SESSION["mensagem"]="O pedido de venda foi fechado com sucesso!";
		header("Location:crm_infg.php?cli=$cliente");
		exit;
}
header("Location:vendas.php?acao=alt&id=$id");
?>