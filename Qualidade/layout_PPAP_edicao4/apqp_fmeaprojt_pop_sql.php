<?php
include("conecta.php");
$acao=Input::request("acao");
$peca=Input::request("peca");
$op=Input::request("op");
$del=Input::request("del", []);
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
if($acao=="sel"){
	$sql=mysql_query("SELECT * FROM apqp_fmeaproj WHERE peca='$peca'");
	$res=mysql_fetch_array($sql);
	$fmea=$res["id"];
		//verificar Cliente
		$apqp->cliente_apro("apqp_fmeaprojt_pop.php");
		// - - - - - - - -  -
	foreach($del as $key=>$valor){
		$ord="";
		$sql2=mysql_query("SELECT apqp_fmeaproji.* FROM apqp_fmeaproji,apqp_fmeaproj WHERE apqp_fmeaproj.peca='$pc' AND apqp_fmeaproji.fmea=apqp_fmeaproj.id AND apqp_fmeaproji.item='$key'");
		$sql3=mysql_query("SELECT max(ordem) as ordem FROM apqp_fmeaproji,apqp_fmeaproj WHERE apqp_fmeaproj.peca='$pc' AND apqp_fmeaproji.fmea=apqp_fmeaproj.id AND apqp_fmeaproji.item='$key'");
		$res3=mysql_fetch_array($sql3);
		$ord=$res3["ordem"];
		while($res2=mysql_fetch_array($sql2)){
			$ord++;
			$sql3=mysql_query("INSERT INTO apqp_fmeaproji (fmea,item,modo,efeitos,sev,icone,causa,ocor,controle,controle2,det,npr,ar,resp,prazo,at,sev2,ocor2,det2,npr2,ordem) VALUES ('$fmea','$op','$res2[modo]','$res2[efeitos]','$res2[sev]','$res2[icone]','$res2[causa]','$res2[ocor]','$res2[controle]','$res2[controle2]','$res2[det]','$res2[npr]','$res2[ar]','$res2[resp]','$res2[prazo]','$res2[at]','$res2[sev2]','$res2[ocor2]','$res2[det2]','$res2[npr2]','$ord')");
		}
	}
}

$_SESSION["mensagem"]="Importado com Sucesso!!";
print "<script>opener.location='apqp_fmeaprojt.php';window.close();</script>";
exit;

?>