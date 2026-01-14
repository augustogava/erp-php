<?php
include("conecta.php");
$acao=Input::request("acao");
$id=Input::request("id");
$numero=Input::request("numero");
$es=Input::request("es");
$operacao=Input::request("operacao");
$natureza=Input::request("natureza");
$cfop=Input::request("cfop");
$cliente=Input::request("cliente");
$cliente_tipo=Input::request("cliente_tipo");
$emissao=Input::request("emissao");
$dtes=Input::request("dtes");
$hs=Input::request("hs");
$servicos=Input::request("servicos");
$im=Input::request("im");
$issval=Input::request("issval");
$issper=Input::request("issper");
$servicosval=Input::request("servicosval");
$baseicms=Input::request("baseicms");
$valicms=Input::request("valicms");
$baseicmss=Input::request("baseicmss");
$valicmss=Input::request("valicmss");
$produtos=Input::request("produtos");
$frete=Input::request("frete");
$seguro=Input::request("seguro");
$outros=Input::request("outros");
$ipi=Input::request("ipi");
$total=Input::request("total");
$transp=Input::request("transp");
$fretepor=Input::request("fretepor");
$placa=Input::request("placa");
$placauf=Input::request("placauf");
$tcnpj=Input::request("tcnpj");
$tend=Input::request("tend");
$tcid=Input::request("tcid");
$tuf=Input::request("tuf");
$tie=Input::request("tie");
$qtd=Input::request("qtd");
$especie=Input::request("especie");
$marca=Input::request("marca");
$tnum=Input::request("tnum");
$pbruto=Input::request("pbruto");
$pliquido=Input::request("pliquido");
$adicionais=Input::request("adicionais");
$parcelamento=Input::request("parcelamento");
$categoria=Input::request("categoria");
$conta=Input::request("conta");
$fluxo=Input::request("fluxo");
$cartorio=Input::request("cartorio");
$cobranca=Input::request("cobranca");
$demonstrativo=Input::request("demonstrativo");
$prodserv=Input::request("prodserv", []);
$pdescricao=Input::request("pdescricao", []);
$punidade=Input::request("punidade", []);
$pclafis=Input::request("pclafis", []);
$psitri=Input::request("psitri", []);
$pqtd=Input::request("pqtd", []);
$punitario=Input::request("punitario", []);
$picms=Input::request("picms", []);
$pipi=Input::request("pipi", []);
$picmss=Input::request("picmss", []);
$pbase=Input::request("pbase", []);
$pir=Input::request("pir", []);
$banco=Input::request("banco");
$pedido=Input::request("pedido");
$quem=$_SESSION["login_nome"];
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Notas Fiscais";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="nfe"){
	$emissao=data2banco($emissao);
	$dtes=data2banco($dtes);
	$issval=valor2banco($issval);
	$issper=valor2banco($issper);
	$servicosval=valor2banco($servicosval);
	$baseicms=valor2banco($baseicms);
	$valicms=valor2banco($valicms);
	$baseicmss=valor2banco($baseicmss);
	$valicmss=valor2banco($valicmss);
	$produtos=valor2banco($produtos);
	$frete=valor2banco($frete);
	$seguro=valor2banco($seguro);
	$outros=valor2banco($outros);
	$ipi=valor2banco($ipi);
	$total=valor2banco($total);
	$qtd=valor2banco($qtd);
	$tnum=valor2banco($tnum);
	$pbruto=valor2banco($pbruto);
	$pliquido=valor2banco($pliquido);
	if($fluxo!="N") $fluxo="S";
	if($cartorio!="S") $cartorio="N";
	if($cobranca!="S") $cobranca="N";
	if($demonstrativo!="S") $demonstrativo="N";
	$sql=mysql_query("INSERT INTO nf (numero,es,operacao,natureza,cfop,cliente,cliente_tipo,emissao,dtes,hs,servicos,im,issval,issper,servicosval,baseicms,valicms,baseicmss,valicmss,produtos,frete,seguro,outros,ipi,total,transp,fretepor,placa,placauf,tcnpj,tend,tcid,tuf,tie,qtd,especie,marca,tnum,pbruto,pliquido,adicionais,parcelamento,categoria,conta,fluxo,cartorio,cobranca,demonstrativo) VALUES ('$numero','$es','$operacao','$natureza','$cfop','$cliente','$cliente_tipo','$emissao','$dtes','$hs','$servicos','$im','$issval','$issper','$servicosval','$baseicms','$valicms','$baseicmss','$valicmss','$produtos','$frete','$seguro','$outros','$ipi','$total','$transp','$fretepor','$placa','$placauf','$tcnpj','$tend','$tcid','$tuf','$tie','$qtd','$especie','$marca','$tnum','$pbruto','$pliquido','$adicionais','$parcelamento','$categoria','$conta','$fluxo','$cartorio','$cobranca','$demonstrativo')");
	if($sql){
		$sql=mysql_query("SELECT MAX(id) AS nota FROM nf");
		$res=mysql_fetch_array($sql);
		$nota=$res["nota"];
		if(isset($prodserv)){
			for($i=0;$i<sizeof($prodserv);$i++){
				if(!empty($prodserv[$i])){
					$pcod=$prodserv[$i];
					$pdesc=$pdescricao[$i];
					$puni=$punidade[$i];
					$pcla=$pclafis[$i];
					$psit=$psitri[$i];
					$pqtde=valor2banco($pqtd[$i]);
					$punit=valor2banco($punitario[$i]);
					$picm=valor2banco($picms[$i]);
					$pip=valor2banco($pipi[$i]);
					$picm2=valor2banco($picmss[$i]);
					$pbas=valor2banco($pbase[$i]);
					$pi=valor2banco($pir[$i]);
					$sql=mysql_query("INSERT INTO nf_prod (nota,prodserv,descricao,unidade,clafis,sitri,qtd,unitario,icms,ipi,icmss,base,ir) VALUES ('$nota','$pcod','$pdesc','$puni','$pcla','$psit','$pqtde','$punit','$picm','$pip','$picm2','$pbas','$pi')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtde,valor,doc,origem,tipomov,quem) VALUES ('$pcod',NOW(),'$pqtde','$punit','$numero',3,5,'$quem')");
				}
			}
		}
		$competencia=substr(banco2data($emissao),3);
		$sql=mysql_query("INSERT INTO cp (cliente,cliente_tipo,conta,parcelamento,categoria,documento,emissao,valor,saldo,competencia,fluxo,cartorio,cobranca,demonstrativo,sit) VALUES ('$cliente','$cliente_tipo','$conta','$parcelamento','$categoria','$numero','$emissao','$total','$total','$competencia','$fluxo','$cartorio','$cobranca','$demonstrativo','P')");
		if($sql){
			$sql=mysql_query("SELECT MAX(id) AS conta FROM cp");
			$res=mysql_fetch_array($sql);
			$conta=$res["conta"];
			$sql=mysql_query("UPDATE nf SET cpr='$conta' WHERE id='$nota'");
			//duplicatas
			$valor=$total;
			$sqlp=mysql_query("SELECT * FROM parcelamentos WHERE id='$parcelamento'");
			$resp=mysql_fetch_array($sqlp);
			if($resp["parcelado"]=="N"){
				$sql=mysql_query("INSERT INTO cp_itens (parcela,conta,vencimento,valor,pagto,banco) VALUES ('1/1','$conta','$emissao','$valor','$emissao','$banco')");
			}else{
				if($resp["alt"]=="S"){
					$alts=explode(",",$resp["alts"]);
					$parcelas=count($alts);
				}else{
					$parcelas=$resp["parcelas"];
				}
				$entre=0;
				for($i=1;$i<=$parcelas;$i++){
					if($resp["alt"]=="N"){
						$entre+=$resp["intervalo"];
					}else{
						$entre=$alts[$i-1];
					}
					if($i==1 and $resp["carencia"]!=0){
						$mk=mktime(0,0,0,substr($emissao,5,2),substr($emissao,8,2)+$resp["carencia"],substr($emissao,0,4));
						if($resp["vencimento"]=="A"){
							$ok=false;
							while(!$ok){
								$dtf=date("Y-m-d",$mk);
								$dtf2=date("dm",$mk);
								$sqlf=mysql_query("SELECT * FROM feriados WHERE dia='$dtf' or (diames='$dtf2' and anual='S')");
								if(date("w",$mk)==0 or date("w",$mk)==6 or mysql_num_rows($sqlf)!=0){
									$mk-=86400;
								}else{
									$ok=true;
								}
							}
						}elseif($resp["vencimento"]=="P"){
							$ok=false;
							while(!$ok){
								$dtf=date("Y-m-d",$mk);
								$dtf2=date("dm",$mk);
								$sqlf=mysql_query("SELECT * FROM feriados WHERE dia='$dtf' or (diames='$dtf2' and anual='S')");
								if(date("w",$mk)==0 or date("w",$mk)==6 or mysql_num_rows($sqlf)!=0){
									$mk+=86400;
								}else{
									$ok=true;
								}
							}					
						}
					}else{
						$mk=mktime(0,0,0,substr($emissao,5,2),substr($emissao,8,2)+$entre,substr($emissao,0,4));
						if($resp["vencimento"]=="A"){
							$ok=false;
							while(!$ok){
								$dtf=date("Y-m-d",$mk);
								$dtf2=date("dm",$mk);
								$sqlf=mysql_query("SELECT * FROM feriados WHERE dia='$dtf' or (diames='$dtf2' and anual='S')");
								if(date("w",$mk)==0 or date("w",$mk)==6 or mysql_num_rows($sqlf)!=0){
									$mk-=86400;
								}else{
									$ok=true;
								}
							}
						}elseif($resp["vencimento"]=="P"){
							$ok=false;
							while(!$ok){
								$dtf=date("Y-m-d",$mk);
								$dtf2=date("dm",$mk);
								$sqlf=mysql_query("SELECT * FROM feriados WHERE dia='$dtf' or (diames='$dtf2' and anual='S')");
								if(date("w",$mk)==0 or date("w",$mk)==6 or mysql_num_rows($sqlf)!=0){
									$mk+=86400;
								}else{
									$ok=true;
								}
							}					
						}
					}
					$vencimento=date("Y-m-d",$mk);
					if($resp["ent_sn"]=="S"){
						if($i==1){
							$val=$valor*$resp["ent_perc"]/100;
						}else{
							$val=($valor-($valor*$resp["ent_perc"]/100))/($parcelas-1);
						}
					}else{
						$val=$valor/$parcelas;
					}
					$pcla=$i."/".$parcelas;
					$sql=mysql_query("INSERT INTO cp_itens (parcela,conta,vencimento,valor,banco) VALUES ('$pcla','$conta','$vencimento','$val','$banco')");
				}
			}
			//duplicatas fim
		}
		$_SESSION["mensagem"]="NF de Entrada registrada com sucesso!";
		$hd="nf";
	}else{
		$_SESSION["mensagem"]="A NF de entrada não pôde ser registrada!";
		$hd="nfe";
	}
}elseif($acao=="nfs"){
	$emissao=data2banco($emissao);
	$dtes=data2banco($dtes);
	$issval=valor2banco($issval);
	$issper=valor2banco($issper);
	$servicosval=valor2banco($servicosval);
	$baseicms=valor2banco($baseicms);
	$valicms=valor2banco($valicms);
	$baseicmss=valor2banco($baseicmss);
	$valicmss=valor2banco($valicmss);
	$produtos=valor2banco($produtos);
	$frete=valor2banco($frete);
	$seguro=valor2banco($seguro);
	$outros=valor2banco($outros);
	$ipi=valor2banco($ipi);
	$total=valor2banco($total);
	$qtd=valor2banco($qtd);
	$tnum=valor2banco($tnum);
	$pbruto=valor2banco($pbruto);
	$pliquido=valor2banco($pliquido);
	if($fluxo!="N") $fluxo="S";
	if($cartorio!="S") $cartorio="N";
	if($cobranca!="S") $cobranca="N";
	if($demonstrativo!="S") $demonstrativo="N";
	$sql=mysql_query("INSERT INTO nf (numero,es,operacao,natureza,cfop,cliente,cliente_tipo,emissao,dtes,hs,servicos,im,issval,issper,servicosval,baseicms,valicms,baseicmss,valicmss,produtos,frete,seguro,outros,ipi,total,transp,fretepor,placa,placauf,tcnpj,tend,tcid,tuf,tie,qtd,especie,marca,tnum,pbruto,pliquido,adicionais,parcelamento,categoria,conta,fluxo,cartorio,cobranca,demonstrativo) VALUES ('$numero','$es','$operacao','$natureza','$cfop','$cliente','$cliente_tipo','$emissao','$dtes','$hs','$servicos','$im','$issval','$issper','$servicosval','$baseicms','$valicms','$baseicmss','$valicmss','$produtos','$frete','$seguro','$outros','$ipi','$total','$transp','$fretepor','$placa','$placauf','$tcnpj','$tend','$tcid','$tuf','$tie','$qtd','$especie','$marca','$tnum','$pbruto','$pliquido','$adicionais','$parcelamento','$categoria','$conta','$fluxo','$cartorio','$cobranca','$demonstrativo')");
	if($sql){
		$sql=mysql_query("SELECT MAX(id) AS nota FROM nf");
		$res=mysql_fetch_array($sql);
		$nota=$res["nota"];
		if(isset($prodserv)){
			for($i=0;$i<sizeof($prodserv);$i++){
				if(!empty($prodserv[$i])){
					$pcod=$prodserv[$i];
					$pdesc=$pdescricao[$i];
					$puni=$punidade[$i];
					$pcla=$pclafis[$i];
					$psit=$psitri[$i];
					$pqtde=valor2banco($pqtd[$i]);
					$punit=valor2banco($punitario[$i]);
					$picm=valor2banco($picms[$i]);
					$pip=valor2banco($pipi[$i]);
					$picm2=valor2banco($picmss[$i]);
					$pbas=valor2banco($pbase[$i]);
					$pi=valor2banco($pir[$i]);
					$sql=mysql_query("INSERT INTO nf_prod (nota,prodserv,descricao,unidade,clafis,sitri,qtd,unitario,icms,ipi,icmss,base,ir) VALUES ('$nota','$pcod','$pdesc','$puni','$pcla','$psit','$pqtde','$punit','$picm','$pip','$picm2','$pbas','$pi')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtde,valor,doc,origem,tipomov,quem) VALUES ('$pcod',NOW(),'$pqtde','$punit','$numero',3,5,'$quem')");
				}
			}
		}
		$competencia=substr(banco2data($emissao),3);
		$sql=mysql_query("INSERT INTO cp (cliente,cliente_tipo,conta,parcelamento,categoria,documento,emissao,valor,saldo,competencia,fluxo,cartorio,cobranca,demonstrativo,sit) VALUES ('$cliente','$cliente_tipo','$conta','$parcelamento','$categoria','$numero','$emissao','$total','$total','$competencia','$fluxo','$cartorio','$cobranca','$demonstrativo','P')");
		if($sql){
			$sql=mysql_query("SELECT MAX(id) AS conta FROM cp");
			$res=mysql_fetch_array($sql);
			$conta=$res["conta"];
			$sql=mysql_query("UPDATE nf SET cpr='$conta' WHERE id='$nota'");
			//duplicatas
			$valor=$total;
			$sqlp=mysql_query("SELECT * FROM parcelamentos WHERE id='$parcelamento'");
			$resp=mysql_fetch_array($sqlp);
			if($resp["parcelado"]=="N"){
				$sql=mysql_query("INSERT INTO cp_itens (parcela,conta,vencimento,valor,pagto,banco) VALUES ('1/1','$conta','$emissao','$valor','$emissao','$banco')");
			}else{
				if($resp["alt"]=="S"){
					$alts=explode(",",$resp["alts"]);
					$parcelas=count($alts);
				}else{
					$parcelas=$resp["parcelas"];
				}
				$entre=0;
				for($i=1;$i<=$parcelas;$i++){
					if($resp["alt"]=="N"){
						$entre+=$resp["intervalo"];
					}else{
						$entre=$alts[$i-1];
					}
					if($i==1 and $resp["carencia"]!=0){
						$mk=mktime(0,0,0,substr($emissao,5,2),substr($emissao,8,2)+$resp["carencia"],substr($emissao,0,4));
						if($resp["vencimento"]=="A"){
							$ok=false;
							while(!$ok){
								$dtf=date("Y-m-d",$mk);
								$dtf2=date("dm",$mk);
								$sqlf=mysql_query("SELECT * FROM feriados WHERE dia='$dtf' or (diames='$dtf2' and anual='S')");
								if(date("w",$mk)==0 or date("w",$mk)==6 or mysql_num_rows($sqlf)!=0){
									$mk-=86400;
								}else{
									$ok=true;
								}
							}
						}elseif($resp["vencimento"]=="P"){
							$ok=false;
							while(!$ok){
								$dtf=date("Y-m-d",$mk);
								$dtf2=date("dm",$mk);
								$sqlf=mysql_query("SELECT * FROM feriados WHERE dia='$dtf' or (diames='$dtf2' and anual='S')");
								if(date("w",$mk)==0 or date("w",$mk)==6 or mysql_num_rows($sqlf)!=0){
									$mk+=86400;
								}else{
									$ok=true;
								}
							}					
						}
					}else{
						$mk=mktime(0,0,0,substr($emissao,5,2),substr($emissao,8,2)+$entre,substr($emissao,0,4));
						if($resp["vencimento"]=="A"){
							$ok=false;
							while(!$ok){
								$dtf=date("Y-m-d",$mk);
								$dtf2=date("dm",$mk);
								$sqlf=mysql_query("SELECT * FROM feriados WHERE dia='$dtf' or (diames='$dtf2' and anual='S')");
								if(date("w",$mk)==0 or date("w",$mk)==6 or mysql_num_rows($sqlf)!=0){
									$mk-=86400;
								}else{
									$ok=true;
								}
							}
						}elseif($resp["vencimento"]=="P"){
							$ok=false;
							while(!$ok){
								$dtf=date("Y-m-d",$mk);
								$dtf2=date("dm",$mk);
								$sqlf=mysql_query("SELECT * FROM feriados WHERE dia='$dtf' or (diames='$dtf2' and anual='S')");
								if(date("w",$mk)==0 or date("w",$mk)==6 or mysql_num_rows($sqlf)!=0){
									$mk+=86400;
								}else{
									$ok=true;
								}
							}					
						}
					}
					$vencimento=date("Y-m-d",$mk);
					if($resp["ent_sn"]=="S"){
						if($i==1){
							$val=$valor*$resp["ent_perc"]/100;
						}else{
							$val=($valor-($valor*$resp["ent_perc"]/100))/($parcelas-1);
						}
					}else{
						$val=$valor/$parcelas;
					}
					$pcla=$i."/".$parcelas;
					$sql=mysql_query("INSERT INTO cp_itens (parcela,conta,vencimento,valor,banco) VALUES ('$pcla','$conta','$vencimento','$val','$banco')");
				}
			}
			//duplicatas fim
		}
		$_SESSION["mensagem"]="NF de Entrada registrada com sucesso!";
		$hd="nf";
	}else{
		$_SESSION["mensagem"]="A NF de entrada não pôde ser registrada!";
		$hd="nfe";
	}
}
if($hd=="nf"){
	header("Location:nf.php");
}elseif($hd=="nfe"){
	header("Location:nfe.php");
}
?>