<?php
include("conecta.php");
$acao=Input::request("acao");
$id=Input::request("id");
$parcelado=Input::request("parcelado");
$ent_sn=Input::request("ent_sn");
$ent_perc=Input::request("ent_perc");
$desconto=Input::request("desconto");
$multa=Input::request("multa");
$jurosdia=Input::request("jurosdia");
$descricao=Input::request("descricao");
$parcelas=Input::request("parcelas");
$intervalo=Input::request("intervalo");
$carencia=Input::request("carencia");
$alt=Input::request("alt");
$alts=Input::request("alts");
$vencimento=Input::request("vencimento");
$obs=Input::request("obs");
if(empty($acao)) exit;
if($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM parcelamentos WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Parcelamento excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Parcelamento não pôde ser excluído!";
		}
	}
	$acao="entrar";
}elseif($acao=="inc"){
	if($parcelado!="S") $parcelado="N";
	if($ent_sn!="S") $ent_sn="N";
	$ent_perc=valor2banco($ent_perc);
	$desconto=valor2banco($desconto);
	$multa=valor2banco($multa);
	$jurosdia=valor2banco($jurosdia);
	$sql=mysql_query("INSERT INTO parcelamentos (descricao,parcelado,parcelas,intervalo,carencia,alt,alts,ent_sn,ent_perc,multa,desconto,jurosdia,vencimento,obs) VALUES ('$descricao','$parcelado','$parcelas','$intervalo','$carencia','$alt','$alts','$ent_sn','$ent_perc','$multa','$desconto','$jurosdia','$vencimento','$obs')");
	if($sql){
		$_SESSION["mensagem"]="Parcelamento incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Parcelamento não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alt"){
	if(!empty($id)){
		if($parcelado!="S") $parcelado="N";
		if($ent_sn!="S") $ent_sn="N";
		$ent_perc=valor2banco($ent_perc);
		$desconto=valor2banco($desconto);
		$multa=valor2banco($multa);
		$jurosdia=valor2banco($jurosdia);
		$sql=mysql_query("UPDATE parcelamentos SET descricao='$descricao',parcelado='$parcelado',parcelas='$parcelas',intervalo='$intervalo',carencia='$carencia',alt='$alt',alts='$alts',ent_sn='$ent_sn',ent_perc='$ent_perc',multa='$multa',desconto='$desconto',jurosdia='$jurosdia',vencimento='$vencimento',obs='$obs' WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Parcelamento alterado com sucesso!";
			$acao="entrar";
		}else{
			$_SESSION["mensagem"]="O Parcelamento não pôde ser alterado!";
			$acao="alt";
		}
	}else{
		$acao="entrar";
	}
}
if($acao=="entrar"){
	header("Location:parcelamentos.php");
}elseif($acao=="inc"){
	header("Location:parcelamentos.php?acao=inc");
}elseif($acao=="alt"){
	header("Location:parcelamentos.php?acao=alt&id=$id");
}
?>