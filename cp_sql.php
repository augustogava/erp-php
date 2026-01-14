<?php
include("conecta.php");
$acao=Input::request("acao");
$id=Input::request("id");
$cliente=Input::request("cliente");
$cliente_tipo=Input::request("cliente_tipo");
$conta=Input::request("conta");
$parcelamento=Input::request("parcelamento");
$categoria=Input::request("categoria");
$documento=Input::request("documento");
$emissao=Input::request("emissao");
$valor=Input::request("valor");
$competencia=Input::request("competencia");
$fluxo=Input::request("fluxo");
$cartorio=Input::request("cartorio");
$cobranca=Input::request("cobranca");
$demonstrativo=Input::request("demonstrativo");
$historico=Input::request("historico");
$banco=Input::request("banco");
if(empty($acao)) header("Location:cp.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="CP";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
$hojea=date("Y");
$hojem=date("m");
$hojed=date("d");
if($acao=="inc"){
	$emissao=data2banco($emissao);
	$valor=valor2banco($valor);
	if($_SESSION["cpcompra"]){
		$cliente=$_SESSION["cliente"];
		$cliente_tipo=$_SESSION["cliente_tipo"];
		$parcelamento=$_SESSION["parcelamento"];
		$documento=$_SESSION["documento"];
		$emissao=$_SESSION["emissao"];
		$competencia=$_SESSION["competencia"];
		$valor=$_SESSION["valor"];
		unset($_SESSION["cliente"]);
		unset($_SESSION["cliente_tipo"]);
		unset($_SESSION["parcelamento"]);
		unset($_SESSION["documento"]);
		unset($_SESSION["emissao"]);
		unset($_SESSION["competencia"]);
		unset($_SESSION["valor"]);
	}
	if($fluxo!="N") $fluxo="S";
	if($cartorio!="S") $cartorio="N";
	if($cobranca!="S") $cobranca="N";
	if($demonstrativo!="S") $demonstrativo="N";
	$sql=mysql_query("INSERT INTO cp (cliente,cliente_tipo,conta,parcelamento,categoria,documento,emissao,valor,saldo,competencia,fluxo,cartorio,cobranca,demonstrativo,sit,historico) VALUES ('$cliente','$cliente_tipo','$conta','$parcelamento','$categoria','$documento','$emissao','$valor','$valor','$competencia','$fluxo','$cartorio','$cobranca','$demonstrativo','P','$historico')");
	if($sql){
		$sql=mysql_query("SELECT MAX(id) AS conta FROM cp");
		$res=mysql_fetch_array($sql);
		$conta=$res["conta"];
		if($_SESSION["cpcompra"]){
			$sqlcp=mysql_query("UPDATE compras SET cp='$conta' WHERE id='$_SESSION[idcompra]'");
			unset($_SESSION["cpcompra"]);
			unset($_SESSION["idcompra"]);
		}
		//duplicatas
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
		$_SESSION["mensagem"]="Conta incluída com sucesso";
		header("Location:cp.php?acao=alt&id=$conta");		
	}else{
		$_SESSION["mensagem"]="A conta não pôde ser incluída";
		header("Location:cp.php");
	}
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM cp_itens WHERE conta='$id' AND pago='S'");
	if(mysql_num_rows($sql)==0){
		$sql=mysql_query("DELETE FROM cp_itens WHERE conta='$id'");
		$emissao=data2banco($emissao);
		$valor=valor2banco($valor);
		if($fluxo!="N") $fluxo="S";
		if($cartorio!="S") $cartorio="N";
		if($cobranca!="S") $cobranca="N";
		if($demonstrativo!="S") $demonstrativo="N";
		$sql=mysql_query("UPDATE cp SET cliente='$cliente',cliente_tipo='$cliente_tipo',conta='$conta',parcelamento='$parcelamento',categoria='$categoria',documento='$documento',emissao='$emissao',valor='$valor',saldo='$valor',competencia='$competencia',fluxo='$fluxo',cartorio='$cartorio',cobranca='$cobranca',demonstrativo='$demonstrativo',sit='P',historico='$historico' WHERE id='$id'");
		if($sql){
			$conta=$id;
			//duplicatas
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
			$_SESSION["mensagem"]="Conta alterada com sucesso";		
		}else{
			$_SESSION["mensagem"]="A conta não pôde ser alterada";
		}
	}else{
		$_SESSION["mensagem"]="A conta não pôde ser alterada";
	}
	header("Location:cp.php?acao=alt&id=$id");
}elseif($acao=="desf"){
	if(!empty($ct) and !empty($id)){
		$sql=mysql_query("SELECT * FROM cp_itens WHERE id='$id'");
		$res=mysql_fetch_array($sql);
		$banco=$res["banco"];
		$valor=$res["valor"];
		$sql=mysql_query("UPDATE cp_itens SET diferenca=0,pagto='0000-00-00',documento='',operacao=0,pago='N' WHERE id='$id'");
		if($sql){
			//movimentacao bancaria
			$sql=mysql_query("UPDATE bancos SET saldo=(saldo + $valor) WHERE id='$banco'");
			$sql=mysql_query("DELETE FROM bancos_lan WHERE cpi='$id'");
			//movimentacao bancaria
			$_SESSION["mensagem"]="Pagamento desfeito com sucesso!";
		}else{
			$_SESSION["mensagem"]="O pagamento não pôde ser desfeito";
		}
		header("Location:cp.php?acao=alt&id=$ct");
	}else{
		header("Location:cp.php");
	}
}elseif($acao=="can"){
	if(!empty($id)){
		$sql=mysql_query("UPDATE cp SET sit='C' WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Conta cancelada com sucesso!";
		}else{
			$_SESSION["mensagem"]="A conta não pôde ser cancelada";
		}
		header("Location:cp.php?acao=alt&id=$id");		
	}else{
		header("Location:cp.php");
	}
}elseif($acao=="bxitem"){
	if(!empty($id)){
		$diferenca=valor2banco($diferenca);
		$pagto=data2banco($pagto);
		$sql=mysql_query("UPDATE cp_itens SET diferenca='$diferenca',pagto='$pagto',documento='$documento',operacao='$operacao',banco='$banco',pago='S' WHERE id='$id'");
		if($sql){
			//movimentacao bancaria
			$sql=mysql_query("SELECT cp_itens.parcela,cp_itens.valor,cp.cliente,cp.cliente_tipo,cp.documento,cp.fluxo FROM cp_itens,cp WHERE cp_itens.id='$id' AND cp_itens.conta=cp.id");
			$res=mysql_fetch_array($sql);
			$fluxo=$res["fluxo"];
			if($res["cliente_tipo"]=="C"){
				$sqln=mysql_query("SELECT fantasia FROM clientes WHERE id='$res[cliente]'");
			}else{
				$sqln=mysql_query("SELECT fantasia FROM fornecedores WHERE id='$res[cliente]'");
			}
			$res2=mysql_fetch_array($sqln);
			$valor=$res["valor"];
			$hist="Pagto: $res2[fantasia] - $res[documento] $res[parcela]";
			$sql=mysql_query("SELECT saldo FROM bancos WHERE id='$banco'");
			$res=mysql_fetch_array($sql);
			$saldo_ant=$res["saldo"];
			$saldo=$saldo_ant - $valor;
			$sql=mysql_query("INSERT INTO bancos_lan (bco,data,hist,val_sai,operacao,documento,saldo_ant,cpi,fluxo) VALUES ('$banco','$pagto','$hist','$valor','$operacao','$documento','$saldo_ant','$id','$fluxo')");
			$sql=mysql_query("UPDATE bancos SET saldo='$saldo' WHERE id='$banco'");
			//movimentacao bancaria
			$_SESSION["mensagem"]="Pagamento confirmado";
		}else{
			$_SESSION["mensagem"]="Pagamento não confirmado";
		}		
	}else{
		$_SESSION["mensagem"]="Pagamento não confirmado";
	}
	print "<script>opener.location='cp_aberto.php'; window.close();</script>";
}elseif($acao=="ven"){
	//ALTERA DATAS DE VENCIMENTO
	$tbl="cp_itens";
	reset($vencimento); 
	$wmuda=true;
	while (list($key, $val) = each($vencimento)) {  
		$ids[]=$key;
		$val1=explode("/",$val);
		if(empty($val) or !checkdate($val1[1],$val1[0],$val1[2])){
			$wmuda=false;
		}
	}
	if($wmuda){
		reset($ids);
		while (list($key, $val) = each($ids)) {  
			$vencimento1=data2banco($vencimento[$val]);
			$sqlv=mysql_query("SELECT * FROM $tbl WHERE id='$val' AND vencimento='$vencimento1'");
			if(!mysql_num_rows($sqlv)){
				$sqlv=mysql_query("SELECT * FROM $tbl WHERE id='$val'");
				$resv=mysql_fetch_array($sqlv);
				$log="Vencimento alterado de ". banco2data($resv[vencimento])." para ". banco2data($vencimento1)." por $_SESSION[login_nome] em ".date("d/m/Y H:i:s")."\n";
				$sqlv=mysql_query("UPDATE $tbl SET vencimento='$vencimento1',log=CONCAT(log,'$log') WHERE id='$val'");
			}
		}
		$_SESSION["mensagem"]="Datas alteradas com sucesso";
	}else{ 
		$_SESSION["mensagem"]="As datas não puderam ser alteradas\nVerifique e tente novamente";
	}
	header("Location:cp.php?acao=alt&id=$id");
	//ALTERA DATAS DE VENCIMENTO
}
?>