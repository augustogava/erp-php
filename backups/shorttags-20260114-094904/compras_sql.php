<?
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Compras";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO compras (emissao) VALUES ('$hj')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM compras");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("INSERT INTO compras_list (compra) VALUES ('$id')");
}elseif($acao=="cp"){
	$sql=mysql_query("SELECT * FROM compras WHERE id='$id' AND cp=0");
	if(!mysql_num_rows($sql)){
		$_SESSION["mensagem"]="Não foi possivel gerar o Contas a Pagar\\nVerifique se o mesmo não foi gerado anteriormente";
	}else{

		$res=mysql_fetch_array($sql);
		$_SESSION["cliente"]=$res["fornecedor"];
		$_SESSION["cliente_tipo"]="F";
		$_SESSION["parcelamento"]=$res["parcelamento"];
		$_SESSION["documento"]="Compra ".$res["id"];
		$_SESSION["emissao"]=date("d/m/Y");
		$_SESSION["competencia"]=date("m/Y");
		$_SESSION["cpcompra"]=1;
		$_SESSION["idcompra"]=$id;
		$sql=mysql_query("SELECT SUM((qtd * unitario) - ((qtd * unitario)* desconto / 100)) AS valor FROM compras_list WHERE compra='$id'");
		if(mysql_num_rows($sql)){
			$res=mysql_fetch_array($sql);
			$_SESSION["valor"]=banco2valor($res["valor"]);
		}
		header("Location:cp_sql.php?acao=inc");
		exit;
	}
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM compras WHERE id='$id' AND entregue='S'");
	if(mysql_num_rows($sql)){
		$_SESSION["mensagem"]="Este pedido de compra já foi entregue e não pode mais ser alterado";		
	}else{
		$hj=date("Y-m-d");
		$emissao=data2banco($emissao);
		$previsao=data2banco($previsao);
		$entrega=data2banco($entregaa);
		$pliq=valor2banco($pliq);
		$pbruto=valor2banco($pbruto);
		$frete=valor2banco($frete);
		$seguro=valor2banco($seguro);
		$despesas=valor2banco($despesas);

		$sql=mysql_query("UPDATE compras SET faturamento='$faturamento',dentrega='$dentrega',dentregan='$dentregan',tipo='$tipo',tipo_pedido='$pedido',fornecedor='$fornecedor',nf='$nf',emissao='$emissao',previsao='$previsao',entrega='$entrega',entregue='$entregue',responsavel='$responsavel',recebimento='$recebimento',operacao='$operacao',parcelamento='$parcelamento',transportadora='$transportadora',pliq='$pliq',pbruto='$pbruto',frete='$frete',seguro='$seguro',despesas='$despesas',fretepor='$fretepor',obs='$obs' WHERE id='$id'");
		if(isset($qtd)){
			foreach($qtd AS $ids => $idss){
				$prodserv2=$prodserv[$ids];
				$qtd2=valor2banco($qtd[$ids]);
				$unitario2=valor2banco($unitario[$ids]);
				$desconto2=valor2banco($desconto[$ids]);
				$ipi2=valor2banco($ipi[$ids]);
				$qtd_ent2=valor2banco($qtd_ent[$ids]);
				$operacao2=$oper[$ids];
				$ent2=$ent[$ids];
				$sql=mysql_query("UPDATE compras_list SET produto='$prodserv2',qtd='$qtd2',unitario='$unitario2',ipi='$ipi2',desconto='$desconto2',operacao='$operacao2' WHERE id='$ids'");
					if($ent2=="S"){
						$sql=mysql_query("UPDATE compras_list SET qtd_ent='$qtd_ent2' WHERE id='$ids'");
					}
			}			
		}
		if($entregue=="S"){
		//inserir estoque
		$sql2=mysql_query("SELECT * FROM compras_list WHERE compra='$id'") or die("Naun foi");
			//$frete=$frete/mysql_num_rows($sql2);
			while($res=mysql_fetch_array($sql2)){
				$ipi=$res["ipi"];
				$produto=$res["produto"];
				$tario=$res["unitario"];
				$count++;
				//Atualizar preco prodserv
				$totall="0";
				$sql3=mysql_query("SELECT produto,unitario FROM compras_list WHERE produto='$produto'");
				$lin=mysql_num_rows($sql3);
				$ipi1=$ipi/$res["qtd"];
				
					while($res3=mysql_fetch_array($sql3)){
						$frete1+=$frete / $lin;
						$despesas1+=$despesas / $lin;
						$totall+=$res3["unitario"] / $lin;			
						$unit=$res3["unitario"];
					}
				$sql4=mysql_query("SELECT margem,valorizado,frete FROM prodserv WHERE id='$produto'");
				$resr=mysql_fetch_array($sql4);
				if($resr["frete"]=="sif"){ $frete1=""; }
				if($resr["valorizado"]=="M"){
					$pv=($totall+$frete1+$despesas1+$ipi1)*$resr["margem"];
					$cs=$totall+$frete1+$despesas1+$ipi1;
				}else{
					$pv=$tario*$resr["margem"];
					$cs=$tario+$frete1+$despesas1;
				}
			//Tira valores maiores
			$ex=explode(".",$totall);
			$ex1=substr($ex[1],0,2);
			$totall=$ex[0].".".$ex1;

				
			$sql4=mysql_query("UPDATE prodserv SET cod_ult_forn='$fornecedor',est='$esto[qtdt]', pv='$pv', preco_ult_compra='$unit', cs='$unit',cm='$cs', ultima_entrega='$entrega' WHERE id='$produto'");
			//termina e volta
			$qtd=$res["qtd"];
			$total=banco2valor($qtd*$res["unitario"]);
			$total=valor2banco($total);
			$unita=$res["unitario"];
			$sql=mysql_query("UPDATE compras SET sit='1' WHERE id='$id'");
			$sql=mysql_query("UPDATE compras_list SET entregue='S',qtd_ent='$qtd' WHERE id='$res[id]'");
			$sql=mysql_query("SELECT SUM(qtde) as qtd FROM prodserv_est WHERE prodserv='$produto'") or die("nao foi");

					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,cp,data,qtde,valor,origem,tipomov) VALUES('$produto','$id','$hj','$qtd','$unita','2','5')") or die("Nao foi");
//Calculo estoque
				$sqlestoque=mysql_query("SELECT SUM(qtde-qtds) AS qtdt FROM prodserv_est WHERE prodserv='$produto'");
				$esto=mysql_fetch_array($sqlestoque);
				$sql5=mysql_query("UPDATE prodserv SET est='$esto[qtdt]' WHERE id='$produto'");
			}
		}
//entrega parcialll ------------
		if($entregue=="P"){
			$sql2=mysql_query("SELECT * FROM compras_list WHERE compra='$id'") or die("Naun foi");
				while($res=mysql_fetch_array($sql2)){
					//Inserir estoque
					if(!empty($res["qtd_ent"]) and $res["entregue"]=="N"){
						$produto=$res["produto"];
						$unitario=$res["unitario"];
						$qtd=$res["qtd_ent"];
						$sql=mysql_query("INSERT INTO prodserv_est (prodserv,cp,data,qtde,valor,origem,tipomov) VALUES('$produto','$id','$hj','$qtd','$unitario','2','5')");
						$sql=mysql_query("UPDATE compras_list SET entregue='S'  WHERE compra='$id'");
					}else if(!empty($res["qtd_ent"]) and $res["entregue"]=="S"){
						$produto=$res["produto"];
						$unitario=$res["unitario"];
						$qtd_ent=$res["qtd_ent"];
						$sql=mysql_query("SELECT * FROM prodserv_est WHERE prodserv='$produto' AND cp='$id'") or die("nao foi");
						if(mysql_num_rows($sql)){
							$est=mysql_fetch_array($sql);
							$qtd=$est["qtde"];
							$nqtd=$qtd_ent-$qtd;
							if(!empty($nqtd)){
								$sql=mysql_query("INSERT INTO prodserv_est (prodserv,cp,data,qtde,valor,origem,tipomov) VALUES('$produto','$cp','$hj','$nqtd','$unitario','2','5')");
							}
						}
					}
					//Fim - Inicio Calculo de PV desse negocio / / / / / / / / / / / / / / / / / / / /
					
				$ipi=$res["ipi"];
				$produto=$res["produto"];
				$tario=$res["unitario"];
				$count++;
				//Atualizar preco prodserv
				$totall="0";
				$sql3=mysql_query("SELECT produto,unitario FROM compras_list WHERE produto='$produto'");
				$lin=mysql_num_rows($sql3);
				$ipi1=$ipi/$res["qtd_ent"];
				
				while($res3=mysql_fetch_array($sql3)){
					$frete1+=$frete / $lin;
					$despesas1+=$despesas / $lin;
					$totall+=$res3["unitario"] / $lin;			
					$unit=$res3["unitario"];
				}
				$sql4=mysql_query("SELECT margem,valorizado,frete FROM prodserv WHERE id='$produto'");
				$resr=mysql_fetch_array($sql4);
				if($resr["frete"]=="sif"){ $frete1=""; }
				if($resr["valorizado"]=="M"){
					$pv=($totall+$frete1+$despesas1+$ipi1)*$resr["margem"];
					$cs=$totall+$frete1+$despesas1+$ipi1;
				}else{
					$pv=$tario*$resr["margem"];
					$cs=$tario+$frete1+$despesas1;
				}
				//Tira valores maiores
				$ex=explode(".",$totall);
				$ex1=substr($ex[1],0,2);
				$totall=$ex[0].".".$ex1;

				
				$sql4=mysql_query("UPDATE prodserv SET cod_ult_forn='$fornecedor',est='$esto[qtdt]', pv='$pv', preco_ult_compra='$unit', cs='$unit',cm='$cs', ultima_entrega='$entrega' WHERE id='$produto'");
					
					//FIM - - - - -- - / / / / / / / / / / / / / / / / / / / / / / / / /
				}
		}
//caboooo entrega parcialll
		if($sql){
			$_SESSION["mensagem"]="Pedido de compra alterado com sucesso!";
		}else{
			$_SESSION["mensagem"]="O pedido de compra não pôde ser alterado!";
		}
		if($maisum){
			$sql=mysql_query("INSERT INTO compras_list (compra) VALUES ('$id')");
			unset($_SESSION["mensagem"]);
		}
		if($delsel){
			if(isset($del)){
				foreach($del AS $ids => $idss){
					$sql=mysql_query("DELETE FROM compras_list WHERE id='$ids'");
				}
				unset($_SESSION["mensagem"]);
			}else{
				$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
			}
		}
	}
}elseif($acao=="exc"){
	$sql=mysql_query("DELETE FROM compras WHERE id='$id'");
	if($sql){
		$sql=mysql_query("DELETE FROM compras_list WHERE compra='$id'");
		$_SESSION["mensagem"]="Pedido de compra excluído com sucesso!";
	}else{
		$_SESSION["mensagem"]="O pedido de compra não pôde ser excluído!";
	}
	header("Location:compras.php");
	exit;
}
header("Location:compras.php?acao=alt&id=$id&count=$count");
?>