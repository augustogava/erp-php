<?php
include("conecta.php");
if(empty($acao)) exit;
$hj=date("Y-m-d");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Ordem Separação";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="baixa"){
	$sql=mysql_query("SELECT * FROM prodserv_sep WHERE compra='$cp'");
	$res=mysql_fetch_array($sql); 
		$cli=$res["cliente"];
	$sqlp=mysql_query("SELECT id FROM vendas WHERE id='$res[pedido]'");
	$resp=mysql_fetch_array($sqlp);
		$pedido=$resp["id"];
	$sqlc=mysql_query("SELECT * FROM e_compra WHERE id='$cp'");
	$resc=mysql_fetch_array($sqlc);
	$pagamento=$resc["pagamento"];
	$sqls=mysql_query("SELECT * FROM prodserv_sep_list WHERE est='$id' and sit='5'");
	while($ress=mysql_fetch_array($sqls)){
		$sqle=mysql_query("SELECT SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE prodserv='$ress[prodserv]'");
		$rese=mysql_fetch_array($sqle);
		if($rese["qtdd"]<=0){ 
			//$passar="n"; 
		}
	}
	if(!$passar=="n"){
		//
		//
		//se for boleto
		//
		//
		$sql=mysql_query("SELECT * FROM prodserv_ordem WHERE compra='$cp' AND sit='A'");
		$sqla=mysql_query("UPDATE e_compra SET sit='F' WHERE id='$cp'");
//		if(!mysql_num_rows($sql)){
		if($pagamento=="boleto"){
				$sqlb=mysql_query("UPDATE prodserv_sep SET sit='S',status='3' WHERE id='$id'");
			//------------- Tirar estoque Total --------------
						$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$pedido'") or erp_db_fail();
						while($res=mysql_fetch_array($sql2)){
							if(!empty($res["produto"])){
									$produto=$res["produto"];
									$pro=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
									$pror=mysql_fetch_array($pro);
								if(!($pror["tipo"]=="SM")){
									$qtd=$res["qtd"];
									$total=banco2valor($qtd*$res["unitario"]);
									$total=valor2banco($total);
									$unita=$res["unitario"];
										$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt FROM prodserv_est WHERE prodserv='$produto'") or erp_db_fail();
										$res1=mysql_fetch_array($sql1);
									if($res1["qtdt"]>0 and empty($pror["porta"]) and empty($pror["cortina"])){
										$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,origem,tipomov) VALUES('$produto','$hj','$qtd','$unita','2','6')");
									}
								}else{
									$dado=explode("X",$res["medidas"]);
									$altura=$dado[0];
									$largura=$dado[1];
									$qtdit=$altura*$largura;
									$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$produto','$hj','$qtdit','2','6')");

								}
							}
					}
		//
		//
		//se for faturamento
		//
		//
		}else{
				$sqlc=mysql_query("select * from vendas WHERE pedido='$cp'"); $resc=mysql_fetch_array($sqlc); $natureza=$resc["natureza"];
				$sql=mysql_query("UPDATE prodserv_sep SET sit='S' WHERE id='$id'");
				//AQUI GERA A NF --------=========>>>
								$sql=mysql_query("SELECT MAX(numero) AS numero FROM nf");
								$res=mysql_fetch_array($sql);
									$numero=$res[numero]+1;
								$sql=mysql_query("INSERT INTO nf(numero,pedido,compra,cliente,cliente_tipo,es,emissao,natureza,cfop,fatura,vis) VALUES('$numero','$pedido','$cp','$cli','C','S','$hj','$natureza','','','S')") or erp_db_fail();
									$sql=mysql_query("SELECT MAX(id) AS idn FROM nf");
									$res=mysql_fetch_array($sql);
		
									$pro=mysql_query("SELECT * FROM e_itens WHERE compra='$cp' and produto_id<>0") or erp_db_fail();
									$i=1;
										while($resp=mysql_fetch_array($pro)){
											$pro2=mysql_query("SELECT * FROM prodserv WHERE id='$resp[produto_id]'") or erp_db_fail();
												$resp2=mysql_fetch_array($pro2);
											$sql=mysql_query("INSERT INTO nf_prod(nota,prodserv,codigo,unitario,descricao,qtd) VALUES('$res[idn]','$resp[produto_id]','$resp2[codprod]','$resp[produto_preco]','$resp2[desc_curta]','$resp[qtd]')") or erp_db_fail();
										}
			}
			/*
		}else{
			$_SESSION["mensagem"]="Exite itens na ordem de produção!";
			header("Location:prodserv_ordem.php");
				exit;
		}*/
				
	// FIM NF  <<<==============--------------- ///////////////////////
			if($sql){
				$_SESSION["mensagem"]="Separado com Sucesso!";
				$acao="entrar";
			}else{
				$_SESSION["mensagem"]="Não pode ser Separado!";
				$acao="inc";
			}
			/*
		
		*/
	}else{
		$_SESSION["mensagem"]="Exite produtos aguardando compras nessa ordem!";
		header("Location:prodserv_oc.php");
		exit;
	}
	if($acao=="entrar"){
		header("Location:prodserv_sep.php");
	}else{
		header("Location:prodserv_sep.php?acao=$acao&id=$id");
	}
}
?>