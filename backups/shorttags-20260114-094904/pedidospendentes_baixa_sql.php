<?
include("conecta.php");
include("seguranca.php");
if(empty($cp) or empty($cc)){
	header("Location:pedidospendentes.php");
	exit;
}
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Aprovação Financeira";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
$data=date("Y-m-d");
if($ft=="true"){
	$serasa=data2banco($serasa);
	$sql=mysql_query("SELECT * FROM e_itens,prodserv WHERE e_itens.produto_id=prodserv.id AND prodserv.tipo='PL' AND e_itens.compra='$cp'");
	if(mysql_num_rows($sql)){
		$sql=mysql_query("UPDATE e_compra SET sit='B',dtbai='$data',serasa='$serasa',pesq_por='$por' WHERE id='$cp'");
	}else{
		$sql=mysql_query("UPDATE e_compra SET sit='P',dtbai='$data',serasa='$serasa',pesq_por='$por' WHERE id='$cp'");
	}
	$_SESSION["mensagem"]="Baixa concluída";
//Inserir venda
	$sql=mysql_query("SELECT cliente,pedido,frete,frete_tp FROM e_compra WHERE id='$cp'");
	$res=mysql_fetch_array($sql);
	
	$ped=$res["pedido"];
	$cliente=$res["cliente"];
	$operacao="8"; //vendas
		$pag=mysql_query("SELECT * FROM op_pagamento WHERE id='$opc'");
		$rpag=mysql_fetch_array($pag);
			$parce=$rpag["parcelamento"];
	$hj=date("Y-m-d");
	
	if(empty($ped)){
		$sql=mysql_query("INSERT INTO vendas (cliente,pedido,operacao,emissao,parcelamento,faturamento,natureza,frete,frete_tp) VALUES ('$cliente','$cp','$operacao','$hj','$parce','0','$natureza','$res[frete]','$res[frete_tp]')");
			$sql=mysql_query("SELECT MAX(id) AS id FROM vendas");
				$res=mysql_fetch_array($sql);
					$id=$res["id"];
	}else{ $id=$ped; } 
	$sql=mysql_query("INSERT INTO prodserv_sep (compra,pedido,cliente,emissao,sit) VALUES('$cp','$id','$cliente','$data','P')");
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
		$pro1=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
		$pror=mysql_fetch_array($pro1);
	// --- Opcao de pagamento, Adiciona AQUI ---
		$pag=mysql_query("SELECT * FROM op_pagamento WHERE id='$opc'");
		$rpag=mysql_fetch_array($pag);
			$desconto=($total*$rpag["desconto"])/100;
			eval("\$total=$total$rpag[operador]$desconto;");
	if(!empty($produto)){
		$sql=mysql_query("UPDATE prodserv SET ult_venda='$hj' WHERE id='$produto'");
		if(empty($pror["porta"]) and empty($pror["cortina"])){
			$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$produto','$hj','$qtd','2','2')");
		}
	//verifica se tem no estoque agora
		$sql=mysql_query("SELECT SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE prodserv='$produto'");
		$qtd1=mysql_fetch_array($sql); 
		if($qtd1["qtdd"]<=0){ 
			$sit="1";
			$pro1=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
			$pror=mysql_fetch_array($pro1);
			if($pror["tipo"]=="PL" or $pror["tipo"]=="SM"){
				if(empty($pror["porta"]) and empty($pror["cortina"])){
					$sql=mysql_query("INSERT INTO prodserv_ordem (prodserv,compra,pedido,cliente,qtd,tamanho,material,fixacao,sit) VALUES ('$produto','$cp','$id','$cliente','$qtd','$tamanho','$material','$fixacao','A')"); 
				}
			}else{
				$sit="5";
			}
		}else{ 
			$sit="4"; 
		}
		
		//inserir ordem de producao para portas
		if(!empty($pror["porta"])){
		//print "foi";
			$porta=$pror["porta"];
			//Medida
				$dado=explode("X",$tamanho);
					$altura=$dado[0];
					$largura=$dado[1];
				$qtdti=$altura*$largura;
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$produto','$hj','$qtdti','2','2')");

			//Fim medida
			$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
			while($ress=mysql_fetch_array($sqls)){
				$tota+=$ress["val"]*$ress["qtd"];
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','2')");
			}
			$sql=mysql_query("SELECT * FROM portasp WHERE id='$porta'");
			$res=mysql_fetch_array($sql);
			$sql2=mysql_query("SELECT * FROM perfil WHERE id='$res[perfil]'");
			$res2=mysql_fetch_array($sql2);
				$cs=pvccs($porta,$largura,$altura);
				$ci=pvcci($porta,$largura,$altura);
				$cr=pvccr($porta,$largura,$altura);
				$perfil=perfil($res["perfil"],$largura,$altura);
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[pvc_superior]','$hj','$cs','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[pvc_inferior]','$hj','$ci','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[pvc_cristal]','$hj','$cr','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res2[perfil]','$hj','$perfil','2','2')");
				
				
				$sql=mysql_query("INSERT INTO prodserv_ordem (prodserv,compra,pedido,cliente,qtd,tamanho,material,cs,ci,cr,perfil,fixacao,sit) VALUES ('$produto','$cp','$id','$cliente','$qtd','$tamanho','$material','$cs','$ci','$cr','$perfil','$fixacao','A')");
		}
		// FIM
		//inserir ordem de producao para Cortinas
		if(!empty($pror["cortina"])){
		//print "foi";
			$cortina=$pror["cortina"];
			//Medida
				$dado=explode("X",$tamanho);
					$altura=$dado[0];
					$largura=$dado[1];
				$qtdti=$altura*$largura;
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$produto','$hj','$qtdti','2','2')");

			//Fim medida
			$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
			while($ress=mysql_fetch_array($sqls)){
				$tota+=$ress["val"]*$ress["qtd"];
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','2')");
			}
			$sql=mysql_query("SELECT * FROM cortinas WHERE id='$cortina'");
			$res=mysql_fetch_array($sql);
			$a=cortinas($largura,$altura);
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[trilho]','$hj','$a[trilho]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[pvc]','$hj','$a[pvc]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[arrebites]','$hj','$a[arrebites]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[parafusos]','$hj','$a[parafusos]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[buchas]','$hj','$a[buchas]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[penduralg]','$hj','$a[penduralg]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[penduralp]','$hj','$a[penduralp]','2','2')");
				
				
				$sql=mysql_query("INSERT INTO prodserv_ordem (prodserv,compra,pedido,cliente,qtd,tamanho,material,trilho,pvc,arrebites,parafusos,buchas,fixacao,sit) VALUES ('$produto','$cp','$id','$cliente','$qtd','$tamanho','$material','$a[trilho]','$a[pvc]','$a[arrebites]','$a[parafusos]','$a[buchas]','$fixacao','A')");
		}
		// FIM
		$sql=mysql_query("INSERT INTO prodserv_sep_list (est,prodserv,pedido,qtd,data,sit) VALUES('$id2','$produto','$id','$qtd','$data','$sit')");
	}
	if(empty($ped)){
		if(!empty($produto)){
			$sql=mysql_query("INSERT INTO vendas_list (venda,produto,qtd,unitario,medidas,separado) VALUES ('$id','$produto','$qtd','$total','$tamanho','N')");
		}
	}

	/*$sql2=mysql_query("SELECT MAX(id) AS id FROM vendas_list");
	$res2=mysql_fetch_array($sql2);
	$id2=$res2["id"];*/
	}
//mandar email para o cliente
		$msg="";
		$pedido=$cp;
		$pres=$cp;
		$lines=file("email_templates/email_fat.php");
		foreach($lines as $line){
			$line=str_replace("%PEDIDO%",$pedido,$line);
			$msg.=$line;
		}
		mail($climail,"e-Sinalização - Pedido Aceito","$msg","From: financeiro@e-sinalizacao.com.br\nContent-type: text/html\n");
		mail("domingos@cyber1.com.br","CyberHosting - $res[dominio] criado","$mensagem","From: acesso@cyberhosting.com.br\nContent-type: text/html\n");
//mail responsavel
}
// - - - - - - - -- - - - - - - - - - - - - - - - - - - - - 
//
//
// - - - - - - Boleto Pagameto ou a vista - - - - - - - - - 
if($ehbol=="true"){
	$serasa=data2banco($serasa);
	$sql=mysql_query("SELECT * FROM e_itens,prodserv WHERE e_itens.produto_id=prodserv.id AND prodserv.tipo='PL' AND e_itens.compra='$cp'");
	if(mysql_num_rows($sql)){
		$sql=mysql_query("UPDATE e_compra SET sit='B',dtbai='$data',serasa='$serasa',pesq_por='$por' WHERE id='$cp'");
	}else{
		$sql=mysql_query("UPDATE e_compra SET sit='P',dtbai='$data',serasa='$serasa',pesq_por='$por' WHERE id='$cp'");
	}
	$_SESSION["mensagem"]="Baixa concluída";
//Inserir venda
	$sql=mysql_query("SELECT cliente,pedido,frete,frete_tp FROM e_compra WHERE id='$cp'");
	$res=mysql_fetch_array($sql);
	
	$ped=$res["pedido"];
	$cliente=$res["cliente"];
	$operacao="8"; //vendas
		$pag=mysql_query("SELECT * FROM op_pagamento WHERE id='$opc'");
		$rpag=mysql_fetch_array($pag);
			$parce=$rpag["parcelamento"];
	$hj=date("Y-m-d");
	
	if(empty($ped)){
		$sql=mysql_query("INSERT INTO vendas (cliente,pedido,operacao,emissao,parcelamento,faturamento,natureza,frete,frete_tp) VALUES ('$cliente','$cp','$operacao','$hj','$parce','0','$natureza','$res[frete]','$res[frete_tp]')");
			$sql=mysql_query("SELECT MAX(id) AS id FROM vendas");
				$res=mysql_fetch_array($sql);
					$id=$res["id"];
	}else{ $id=$ped; } 
	$sql=mysql_query("INSERT INTO prodserv_sep (compra,pedido,cliente,emissao,sit) VALUES('$cp','$id','$cliente','$data','P')");
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
		$pro1=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
		$pror=mysql_fetch_array($pro1);
	// --- Opcao de pagamento, Adiciona AQUI ---
		$pag=mysql_query("SELECT * FROM op_pagamento WHERE id='$opc'");
		$rpag=mysql_fetch_array($pag);
			$desconto=($total*$rpag["desconto"])/100;
			eval("\$total=$total$rpag[operador]$desconto;");
	if(!empty($produto)){
		$sql=mysql_query("UPDATE prodserv SET ult_venda='$hj' WHERE id='$produto'");
		if(empty($pror["porta"]) and empty($pror["cortina"])){
			$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$produto','$hj','$qtd','2','2')");
		}
	//verifica se tem no estoque agora
		$sql=mysql_query("SELECT SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE prodserv='$produto'");
		$qtd1=mysql_fetch_array($sql); 
		if($qtd1["qtdd"]<=0){ 
			$sit="1";
			$pro1=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
			$pror=mysql_fetch_array($pro1);
			if($pror["tipo"]=="PL" or $pror["tipo"]=="SM"){
				if(empty($pror["porta"]) and empty($pror["cortina"])){
					$sql=mysql_query("INSERT INTO prodserv_ordem (prodserv,compra,pedido,cliente,qtd,tamanho,material,fixacao,sit) VALUES ('$produto','$cp','$id','$cliente','$qtd','$tamanho','$material','$fixacao','A')"); 
				}
			}else{
				$sit="5";
			}
		}else{ 
			$sit="4"; 
		}
		
		//inserir ordem de producao para portas
		if(!empty($pror["porta"])){
		//print "foi";
			$porta=$pror["porta"];
			//Medida
				$dado=explode("X",$tamanho);
					$altura=$dado[0];
					$largura=$dado[1];
				$qtdti=$altura*$largura;
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$produto','$hj','$qtdti','2','2')");

			//Fim medida
			$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
			while($ress=mysql_fetch_array($sqls)){
				$tota+=$ress["val"]*$ress["qtd"];
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','2')");
			}
			$sql=mysql_query("SELECT * FROM portasp WHERE id='$porta'");
			$res=mysql_fetch_array($sql);
			$sql2=mysql_query("SELECT * FROM perfil WHERE id='$res[perfil]'");
			$res2=mysql_fetch_array($sql2);
				$cs=pvccs($porta,$largura,$altura);
				$ci=pvcci($porta,$largura,$altura);
				$cr=pvccr($porta,$largura,$altura);
				$perfil=perfil($res["perfil"],$largura,$altura);
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[pvc_superior]','$hj','$cs','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[pvc_inferior]','$hj','$ci','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[pvc_cristal]','$hj','$cr','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res2[perfil]','$hj','$perfil','2','2')");
				
				
				$sql=mysql_query("INSERT INTO prodserv_ordem (prodserv,compra,pedido,cliente,qtd,tamanho,material,cs,ci,cr,perfil,fixacao,sit) VALUES ('$produto','$cp','$id','$cliente','$qtd','$tamanho','$material','$cs','$ci','$cr','$perfil','$fixacao','A')");
		}
		// FIM
		//inserir ordem de producao para Cortinas
		if(!empty($pror["cortina"])){
		//print "foi";
			$cortina=$pror["cortina"];
			//Medida
				$dado=explode("X",$tamanho);
					$altura=$dado[0];
					$largura=$dado[1];
				$qtdti=$altura*$largura;
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$produto','$hj','$qtdti','2','2')");

			//Fim medida
			$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
			while($ress=mysql_fetch_array($sqls)){
				$tota+=$ress["val"]*$ress["qtd"];
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','2')");
			}
			$sql=mysql_query("SELECT * FROM cortinas WHERE id='$cortina'");
			$res=mysql_fetch_array($sql);
			$a=cortinas($largura,$altura);
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[trilho]','$hj','$a[trilho]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[pvc]','$hj','$a[pvc]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[arrebites]','$hj','$a[arrebites]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[parafusos]','$hj','$a[parafusos]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[buchas]','$hj','$a[buchas]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[penduralg]','$hj','$a[penduralg]','2','2')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$res[penduralp]','$hj','$a[penduralp]','2','2')");
				
				
				$sql=mysql_query("INSERT INTO prodserv_ordem (prodserv,compra,pedido,cliente,qtd,tamanho,material,trilho,pvc,arrebites,parafusos,buchas,fixacao,sit) VALUES ('$produto','$cp','$id','$cliente','$qtd','$tamanho','$material','$a[trilho]','$a[pvc]','$a[arrebites]','$a[parafusos]','$a[buchas]','$fixacao','A')");
		}
		// FIM
		$sql=mysql_query("INSERT INTO prodserv_sep_list (est,prodserv,pedido,qtd,data,sit) VALUES('$id2','$produto','$id','$qtd','$data','$sit')");
	}
	if(empty($ped)){
		if(!empty($produto)){
			$sql=mysql_query("INSERT INTO vendas_list (venda,produto,qtd,unitario,medidas,separado) VALUES ('$id','$produto','$qtd','$total','$tamanho','N')");
		}
	}

	/*$sql2=mysql_query("SELECT MAX(id) AS id FROM vendas_list");
	$res2=mysql_fetch_array($sql2);
	$id2=$res2["id"];*/
	}
//mandar email para o cliente
		$msg="";
		$pedido=$cp;
		$pres=$cp;
		$lines=file("email_templates/email_fat.php");
		foreach($lines as $line){
			$line=str_replace("%PEDIDO%",$pedido,$line);
			$msg.=$line;
		}
		mail($climail,"e-Sinalização - Pedido Aceito","$msg","From: financeiro@e-sinalizacao.com.br\nContent-type: text/html\n");
		mail("domingos@cyber1.com.br","CyberHosting - $res[dominio] criado","$mensagem","From: manager@cyberhosting.com.br\nContent-type: text/html\n");
//mail responsavel
}
/*
	$serasa=data2banco($serasa);
	$sql=mysql_query("UPDATE e_compra SET sit='F',serasa='$serasa',pesq_por='$por',dtbai='$data' WHERE id='$cp'");
	$_SESSION["mensagem"]="Baixa concluída";
*/
header("Location:pedidospendentes.php");
?>