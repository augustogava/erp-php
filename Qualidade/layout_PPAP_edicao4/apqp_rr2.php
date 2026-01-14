<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sqlc=mysql_query("SELECT * FROM apqp_car WHERE id='$car'");
if(mysql_num_rows($sqlc)) $resc=mysql_fetch_array($sqlc);
$sql=mysql_query("SELECT * FROM apqp_rr WHERE peca='$pc' AND car='$car'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	$sql=mysql_query("INSERT INTO apqp_rr (peca,car) VALUES ('$pc','$car')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM apqp_rr");
	$res=mysql_fetch_array($sql);
}


	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de R&R'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de Capabilidade'");
			if(!mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.submit(); } return false;";
			}else{
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){ form1.submit();  } return false;";
			}
		}else{
			$sqlc=mysql_query("SELECT * FROM apqp_car WHERE id='$car' AND quem<>''");
			if(mysql_num_rows($sqlc)){
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.submit(); } return false;";
			}else{
				$btnsalva="";
			}
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){  }else{ return false; } }else{ return false; }";

	}
$id=$res["id"];
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--
function verifica(cad){
	if(cad.a11.value=='0,000' || cad.a11.value==''){
		alert('Os valores não podem ser ZERO');
		cad.a11.focus();
		return false;
	}
	if(cad.dteng2.value==''){
		alert('Preencha a data');
		cad.dteng2.focus();
		return false;
	}
	if(cad.por.value==''){
		alert('Preencha o Relizado Por');
		cad.por.focus();
		return false;
	}
}
function linha(){
		form1.a110.disabled=false;
		form1.a210.disabled=false;
		form1.a310.disabled=false;
		form1.b110.disabled=false;
		form1.b210.disabled=false;
		form1.b310.disabled=false;
		form1.c110.disabled=false;
		form1.c210.disabled=false;
		form1.c310.disabled=false;
		form1.a19.disabled=false;
		form1.a29.disabled=false;
		form1.a39.disabled=false;
		form1.b19.disabled=false;
		form1.b29.disabled=false;
		form1.b39.disabled=false;
		form1.c19.disabled=false;
		form1.c29.disabled=false;
		form1.c39.disabled=false;
		form1.a18.disabled=false;
		form1.a28.disabled=false;
		form1.a38.disabled=false;
		form1.b18.disabled=false;
		form1.b28.disabled=false;
		form1.b38.disabled=false;
		form1.c18.disabled=false;
		form1.c28.disabled=false;
		form1.c38.disabled=false;
		form1.a17.disabled=false;
		form1.a27.disabled=false;
		form1.a37.disabled=false;
		form1.b17.disabled=false;
		form1.b27.disabled=false;
		form1.b37.disabled=false;
		form1.c17.disabled=false;
		form1.c27.disabled=false;
		form1.c37.disabled=false;
		form1.a16.disabled=false;
		form1.a26.disabled=false;
		form1.a36.disabled=false;
		form1.b16.disabled=false;
		form1.b26.disabled=false;
		form1.b36.disabled=false;
		form1.c16.disabled=false;
		form1.c26.disabled=false;
		form1.c36.disabled=false;
		form1.a15.disabled=false;
		form1.a25.disabled=false;
		form1.a35.disabled=false;
		form1.b15.disabled=false;
		form1.b25.disabled=false;
		form1.b35.disabled=false;
		form1.c15.disabled=false;
		form1.c25.disabled=false;
		form1.c35.disabled=false;
		form1.a14.disabled=false;
		form1.a24.disabled=false;
		form1.a34.disabled=false;
		form1.b14.disabled=false;
		form1.b24.disabled=false;
		form1.b34.disabled=false;
		form1.c14.disabled=false;
		form1.c24.disabled=false;
		form1.c34.disabled=false;
		form1.a13.disabled=false;
		form1.a23.disabled=false;
		form1.a33.disabled=false;
		form1.b13.disabled=false;
		form1.b23.disabled=false;
		form1.b33.disabled=false;
		form1.c13.disabled=false;
		form1.c23.disabled=false;
		form1.c33.disabled=false;
		form1.a12.disabled=false;
		form1.a22.disabled=false;
		form1.a32.disabled=false;
		form1.b12.disabled=false;
		form1.b22.disabled=false;
		form1.b32.disabled=false;
		form1.c12.disabled=false;
		form1.c22.disabled=false;
		form1.c32.disabled=false;
		form1.a11.disabled=false;
		form1.a21.disabled=false;
		form1.a31.disabled=false;
		form1.b11.disabled=false;
		form1.b21.disabled=false;
		form1.b31.disabled=false;
		form1.c11.disabled=false;
		form1.c21.disabled=false;
		form1.c31.disabled=false;
	if(form1.npc[form1.npc.selectedIndex].value==9){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
	}
	if(form1.npc[form1.npc.selectedIndex].value==8){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a19.disabled=true;
		form1.a29.disabled=true;
		form1.a39.disabled=true;
		form1.b19.disabled=true;
		form1.b29.disabled=true;
		form1.b39.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
		form1.a19.value='0,000';
		form1.a29.value='0,000';
		form1.a39.value='0,000';
		form1.b19.value='0,000';
		form1.b29.value='0,000';
		form1.b39.value='0,000';
		form1.c19.value='0,000';
		form1.c29.value='0,000';
		form1.c39.value='0,000';
	}
	if(form1.npc[form1.npc.selectedIndex].value==7){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a19.disabled=true;
		form1.a29.disabled=true;
		form1.a39.disabled=true;
		form1.b19.disabled=true;
		form1.b29.disabled=true;
		form1.b39.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.a18.disabled=true;
		form1.a28.disabled=true;
		form1.a38.disabled=true;
		form1.b18.disabled=true;
		form1.b28.disabled=true;
		form1.b38.disabled=true;
		form1.c18.disabled=true;
		form1.c28.disabled=true;
		form1.c38.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
		form1.a19.value='0,000';
		form1.a29.value='0,000';
		form1.a39.value='0,000';
		form1.b19.value='0,000';
		form1.b29.value='0,000';
		form1.b39.value='0,000';
		form1.c19.value='0,000';
		form1.c29.value='0,000';
		form1.c39.value='0,000';
		form1.a18.value='0,000';
		form1.a28.value='0,000';
		form1.a38.value='0,000';
		form1.b18.value='0,000';
		form1.b28.value='0,000';
		form1.b38.value='0,000';
		form1.c18.value='0,000';
		form1.c28.value='0,000';
		form1.c38.value='0,000';
	}
	if(form1.npc[form1.npc.selectedIndex].value==6){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a19.disabled=true;
		form1.a29.disabled=true;
		form1.a39.disabled=true;
		form1.b19.disabled=true;
		form1.b29.disabled=true;
		form1.b39.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.a18.disabled=true;
		form1.a28.disabled=true;
		form1.a38.disabled=true;
		form1.b18.disabled=true;
		form1.b28.disabled=true;
		form1.b38.disabled=true;
		form1.c18.disabled=true;
		form1.c28.disabled=true;
		form1.c38.disabled=true;
		form1.a17.disabled=true;
		form1.a27.disabled=true;
		form1.a37.disabled=true;
		form1.b17.disabled=true;
		form1.b27.disabled=true;
		form1.b37.disabled=true;
		form1.c17.disabled=true;
		form1.c27.disabled=true;
		form1.c37.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
		form1.a19.value='0,000';
		form1.a29.value='0,000';
		form1.a39.value='0,000';
		form1.b19.value='0,000';
		form1.b29.value='0,000';
		form1.b39.value='0,000';
		form1.c19.value='0,000';
		form1.c29.value='0,000';
		form1.c39.value='0,000';
		form1.a18.value='0,000';
		form1.a28.value='0,000';
		form1.a38.value='0,000';
		form1.b18.value='0,000';
		form1.b28.value='0,000';
		form1.b38.value='0,000';
		form1.c18.value='0,000';
		form1.c28.value='0,000';
		form1.c38.value='0,000';
		form1.a17.value='0,000';
		form1.a27.value='0,000';
		form1.a37.value='0,000';
		form1.b17.value='0,000';
		form1.b27.value='0,000';
		form1.b37.value='0,000';
		form1.c17.value='0,000';
		form1.c27.value='0,000';
		form1.c37.value='0,000';
	}
	if(form1.npc[form1.npc.selectedIndex].value==5){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a19.disabled=true;
		form1.a29.disabled=true;
		form1.a39.disabled=true;
		form1.b19.disabled=true;
		form1.b29.disabled=true;
		form1.b39.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.a18.disabled=true;
		form1.a28.disabled=true;
		form1.a38.disabled=true;
		form1.b18.disabled=true;
		form1.b28.disabled=true;
		form1.b38.disabled=true;
		form1.c18.disabled=true;
		form1.c28.disabled=true;
		form1.c38.disabled=true;
		form1.a17.disabled=true;
		form1.a27.disabled=true;
		form1.a37.disabled=true;
		form1.b17.disabled=true;
		form1.b27.disabled=true;
		form1.b37.disabled=true;
		form1.c17.disabled=true;
		form1.c27.disabled=true;
		form1.c37.disabled=true;
		form1.a16.disabled=true;
		form1.a26.disabled=true;
		form1.a36.disabled=true;
		form1.b16.disabled=true;
		form1.b26.disabled=true;
		form1.b36.disabled=true;
		form1.c16.disabled=true;
		form1.c26.disabled=true;
		form1.c36.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
		form1.a19.value='0,000';
		form1.a29.value='0,000';
		form1.a39.value='0,000';
		form1.b19.value='0,000';
		form1.b29.value='0,000';
		form1.b39.value='0,000';
		form1.c19.value='0,000';
		form1.c29.value='0,000';
		form1.c39.value='0,000';
		form1.a18.value='0,000';
		form1.a28.value='0,000';
		form1.a38.value='0,000';
		form1.b18.value='0,000';
		form1.b28.value='0,000';
		form1.b38.value='0,000';
		form1.c18.value='0,000';
		form1.c28.value='0,000';
		form1.c38.value='0,000';
		form1.a17.value='0,000';
		form1.a27.value='0,000';
		form1.a37.value='0,000';
		form1.b17.value='0,000';
		form1.b27.value='0,000';
		form1.b37.value='0,000';
		form1.c17.value='0,000';
		form1.c27.value='0,000';
		form1.c37.value='0,000';
		form1.a16.value='0,000';
		form1.a26.value='0,000';
		form1.a36.value='0,000';
		form1.b16.value='0,000';
		form1.b26.value='0,000';
		form1.b36.value='0,000';
		form1.c16.value='0,000';
		form1.c26.value='0,000';
		form1.c36.value='0,000';
	}
	if(form1.npc[form1.npc.selectedIndex].value==4){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a19.disabled=true;
		form1.a29.disabled=true;
		form1.a39.disabled=true;
		form1.b19.disabled=true;
		form1.b29.disabled=true;
		form1.b39.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.a18.disabled=true;
		form1.a28.disabled=true;
		form1.a38.disabled=true;
		form1.b18.disabled=true;
		form1.b28.disabled=true;
		form1.b38.disabled=true;
		form1.c18.disabled=true;
		form1.c28.disabled=true;
		form1.c38.disabled=true;
		form1.a17.disabled=true;
		form1.a27.disabled=true;
		form1.a37.disabled=true;
		form1.b17.disabled=true;
		form1.b27.disabled=true;
		form1.b37.disabled=true;
		form1.c17.disabled=true;
		form1.c27.disabled=true;
		form1.c37.disabled=true;
		form1.a16.disabled=true;
		form1.a26.disabled=true;
		form1.a36.disabled=true;
		form1.b16.disabled=true;
		form1.b26.disabled=true;
		form1.b36.disabled=true;
		form1.c16.disabled=true;
		form1.c26.disabled=true;
		form1.c36.disabled=true;
		form1.a15.disabled=true;
		form1.a25.disabled=true;
		form1.a35.disabled=true;
		form1.b15.disabled=true;
		form1.b25.disabled=true;
		form1.b35.disabled=true;
		form1.c15.disabled=true;
		form1.c25.disabled=true;
		form1.c35.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
		form1.a19.value='0,000';
		form1.a29.value='0,000';
		form1.a39.value='0,000';
		form1.b19.value='0,000';
		form1.b29.value='0,000';
		form1.b39.value='0,000';
		form1.c19.value='0,000';
		form1.c29.value='0,000';
		form1.c39.value='0,000';
		form1.a18.value='0,000';
		form1.a28.value='0,000';
		form1.a38.value='0,000';
		form1.b18.value='0,000';
		form1.b28.value='0,000';
		form1.b38.value='0,000';
		form1.c18.value='0,000';
		form1.c28.value='0,000';
		form1.c38.value='0,000';
		form1.a17.value='0,000';
		form1.a27.value='0,000';
		form1.a37.value='0,000';
		form1.b17.value='0,000';
		form1.b27.value='0,000';
		form1.b37.value='0,000';
		form1.c17.value='0,000';
		form1.c27.value='0,000';
		form1.c37.value='0,000';
		form1.a16.value='0,000';
		form1.a26.value='0,000';
		form1.a36.value='0,000';
		form1.b16.value='0,000';
		form1.b26.value='0,000';
		form1.b36.value='0,000';
		form1.c16.value='0,000';
		form1.c26.value='0,000';
		form1.c36.value='0,000';
		form1.a15.value='0,000';
		form1.a25.value='0,000';
		form1.a35.value='0,000';
		form1.b15.value='0,000';
		form1.b25.value='0,000';
		form1.b35.value='0,000';
		form1.c15.value='0,000';
		form1.c25.value='0,000';
		form1.c35.value='0,000';
	}
	if(form1.npc[form1.npc.selectedIndex].value==3){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a19.disabled=true;
		form1.a29.disabled=true;
		form1.a39.disabled=true;
		form1.b19.disabled=true;
		form1.b29.disabled=true;
		form1.b39.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.a18.disabled=true;
		form1.a28.disabled=true;
		form1.a38.disabled=true;
		form1.b18.disabled=true;
		form1.b28.disabled=true;
		form1.b38.disabled=true;
		form1.c18.disabled=true;
		form1.c28.disabled=true;
		form1.c38.disabled=true;
		form1.a17.disabled=true;
		form1.a27.disabled=true;
		form1.a37.disabled=true;
		form1.b17.disabled=true;
		form1.b27.disabled=true;
		form1.b37.disabled=true;
		form1.c17.disabled=true;
		form1.c27.disabled=true;
		form1.c37.disabled=true;
		form1.a16.disabled=true;
		form1.a26.disabled=true;
		form1.a36.disabled=true;
		form1.b16.disabled=true;
		form1.b26.disabled=true;
		form1.b36.disabled=true;
		form1.c16.disabled=true;
		form1.c26.disabled=true;
		form1.c36.disabled=true;
		form1.a15.disabled=true;
		form1.a25.disabled=true;
		form1.a35.disabled=true;
		form1.b15.disabled=true;
		form1.b25.disabled=true;
		form1.b35.disabled=true;
		form1.c15.disabled=true;
		form1.c25.disabled=true;
		form1.c35.disabled=true;
		form1.a14.disabled=true;
		form1.a24.disabled=true;
		form1.a34.disabled=true;
		form1.b14.disabled=true;
		form1.b24.disabled=true;
		form1.b34.disabled=true;
		form1.c14.disabled=true;
		form1.c24.disabled=true;
		form1.c34.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
		form1.a19.value='0,000';
		form1.a29.value='0,000';
		form1.a39.value='0,000';
		form1.b19.value='0,000';
		form1.b29.value='0,000';
		form1.b39.value='0,000';
		form1.c19.value='0,000';
		form1.c29.value='0,000';
		form1.c39.value='0,000';
		form1.a18.value='0,000';
		form1.a28.value='0,000';
		form1.a38.value='0,000';
		form1.b18.value='0,000';
		form1.b28.value='0,000';
		form1.b38.value='0,000';
		form1.c18.value='0,000';
		form1.c28.value='0,000';
		form1.c38.value='0,000';
		form1.a17.value='0,000';
		form1.a27.value='0,000';
		form1.a37.value='0,000';
		form1.b17.value='0,000';
		form1.b27.value='0,000';
		form1.b37.value='0,000';
		form1.c17.value='0,000';
		form1.c27.value='0,000';
		form1.c37.value='0,000';
		form1.a16.value='0,000';
		form1.a26.value='0,000';
		form1.a36.value='0,000';
		form1.b16.value='0,000';
		form1.b26.value='0,000';
		form1.b36.value='0,000';
		form1.c16.value='0,000';
		form1.c26.value='0,000';
		form1.c36.value='0,000';
		form1.a15.value='0,000';
		form1.a25.value='0,000';
		form1.a35.value='0,000';
		form1.b15.value='0,000';
		form1.b25.value='0,000';
		form1.b35.value='0,000';
		form1.c15.value='0,000';
		form1.c25.value='0,000';
		form1.c35.value='0,000';
		form1.a14.value='0,000';
		form1.a24.value='0,000';
		form1.a34.value='0,000';
		form1.b14.value='0,000';
		form1.b24.value='0,000';
		form1.b34.value='0,000';
		form1.c14.value='0,000';
		form1.c24.value='0,000';
		form1.c34.value='0,000';
	}
	if(form1.npc[form1.npc.selectedIndex].value==2){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a19.disabled=true;
		form1.a29.disabled=true;
		form1.a39.disabled=true;
		form1.b19.disabled=true;
		form1.b29.disabled=true;
		form1.b39.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.a18.disabled=true;
		form1.a28.disabled=true;
		form1.a38.disabled=true;
		form1.b18.disabled=true;
		form1.b28.disabled=true;
		form1.b38.disabled=true;
		form1.c18.disabled=true;
		form1.c28.disabled=true;
		form1.c38.disabled=true;
		form1.a17.disabled=true;
		form1.a27.disabled=true;
		form1.a37.disabled=true;
		form1.b17.disabled=true;
		form1.b27.disabled=true;
		form1.b37.disabled=true;
		form1.c17.disabled=true;
		form1.c27.disabled=true;
		form1.c37.disabled=true;
		form1.a16.disabled=true;
		form1.a26.disabled=true;
		form1.a36.disabled=true;
		form1.b16.disabled=true;
		form1.b26.disabled=true;
		form1.b36.disabled=true;
		form1.c16.disabled=true;
		form1.c26.disabled=true;
		form1.c36.disabled=true;
		form1.a15.disabled=true;
		form1.a25.disabled=true;
		form1.a35.disabled=true;
		form1.b15.disabled=true;
		form1.b25.disabled=true;
		form1.b35.disabled=true;
		form1.c15.disabled=true;
		form1.c25.disabled=true;
		form1.c35.disabled=true;
		form1.a14.disabled=true;
		form1.a24.disabled=true;
		form1.a34.disabled=true;
		form1.b14.disabled=true;
		form1.b24.disabled=true;
		form1.b34.disabled=true;
		form1.c14.disabled=true;
		form1.c24.disabled=true;
		form1.c34.disabled=true;
		form1.a13.disabled=true;
		form1.a23.disabled=true;
		form1.a33.disabled=true;
		form1.b13.disabled=true;
		form1.b23.disabled=true;
		form1.b33.disabled=true;
		form1.c13.disabled=true;
		form1.c23.disabled=true;
		form1.c33.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
		form1.a19.value='0,000';
		form1.a29.value='0,000';
		form1.a39.value='0,000';
		form1.b19.value='0,000';
		form1.b29.value='0,000';
		form1.b39.value='0,000';
		form1.c19.value='0,000';
		form1.c29.value='0,000';
		form1.c39.value='0,000';
		form1.a18.value='0,000';
		form1.a28.value='0,000';
		form1.a38.value='0,000';
		form1.b18.value='0,000';
		form1.b28.value='0,000';
		form1.b38.value='0,000';
		form1.c18.value='0,000';
		form1.c28.value='0,000';
		form1.c38.value='0,000';
		form1.a17.value='0,000';
		form1.a27.value='0,000';
		form1.a37.value='0,000';
		form1.b17.value='0,000';
		form1.b27.value='0,000';
		form1.b37.value='0,000';
		form1.c17.value='0,000';
		form1.c27.value='0,000';
		form1.c37.value='0,000';
		form1.a16.value='0,000';
		form1.a26.value='0,000';
		form1.a36.value='0,000';
		form1.b16.value='0,000';
		form1.b26.value='0,000';
		form1.b36.value='0,000';
		form1.c16.value='0,000';
		form1.c26.value='0,000';
		form1.c36.value='0,000';
		form1.a15.value='0,000';
		form1.a25.value='0,000';
		form1.a35.value='0,000';
		form1.b15.value='0,000';
		form1.b25.value='0,000';
		form1.b35.value='0,000';
		form1.c15.value='0,000';
		form1.c25.value='0,000';
		form1.c35.value='0,000';
		form1.a14.value='0,000';
		form1.a24.value='0,000';
		form1.a34.value='0,000';
		form1.b14.value='0,000';
		form1.b24.value='0,000';
		form1.b34.value='0,000';
		form1.c14.value='0,000';
		form1.c24.value='0,000';
		form1.c34.value='0,000';
		form1.a13.value='0,000';
		form1.a23.value='0,000';
		form1.a33.value='0,000';
		form1.b13.value='0,000';
		form1.b23.value='0,000';
		form1.b33.value='0,000';
		form1.c13.value='0,000';
		form1.c23.value='0,000';
		form1.c33.value='0,000';
	}
	if(form1.npc[form1.npc.selectedIndex].value==1){
		form1.a110.disabled=true;
		form1.a210.disabled=true;
		form1.a310.disabled=true;
		form1.b110.disabled=true;
		form1.b210.disabled=true;
		form1.b310.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a19.disabled=true;
		form1.a29.disabled=true;
		form1.a39.disabled=true;
		form1.b19.disabled=true;
		form1.b29.disabled=true;
		form1.b39.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.a18.disabled=true;
		form1.a28.disabled=true;
		form1.a38.disabled=true;
		form1.b18.disabled=true;
		form1.b28.disabled=true;
		form1.b38.disabled=true;
		form1.c18.disabled=true;
		form1.c28.disabled=true;
		form1.c38.disabled=true;
		form1.a17.disabled=true;
		form1.a27.disabled=true;
		form1.a37.disabled=true;
		form1.b17.disabled=true;
		form1.b27.disabled=true;
		form1.b37.disabled=true;
		form1.c17.disabled=true;
		form1.c27.disabled=true;
		form1.c37.disabled=true;
		form1.a16.disabled=true;
		form1.a26.disabled=true;
		form1.a36.disabled=true;
		form1.b16.disabled=true;
		form1.b26.disabled=true;
		form1.b36.disabled=true;
		form1.c16.disabled=true;
		form1.c26.disabled=true;
		form1.c36.disabled=true;
		form1.a15.disabled=true;
		form1.a25.disabled=true;
		form1.a35.disabled=true;
		form1.b15.disabled=true;
		form1.b25.disabled=true;
		form1.b35.disabled=true;
		form1.c15.disabled=true;
		form1.c25.disabled=true;
		form1.c35.disabled=true;
		form1.a14.disabled=true;
		form1.a24.disabled=true;
		form1.a34.disabled=true;
		form1.b14.disabled=true;
		form1.b24.disabled=true;
		form1.b34.disabled=true;
		form1.c14.disabled=true;
		form1.c24.disabled=true;
		form1.c34.disabled=true;
		form1.a13.disabled=true;
		form1.a23.disabled=true;
		form1.a33.disabled=true;
		form1.b13.disabled=true;
		form1.b23.disabled=true;
		form1.b33.disabled=true;
		form1.c13.disabled=true;
		form1.c23.disabled=true;
		form1.c33.disabled=true;
		form1.a12.disabled=true;
		form1.a22.disabled=true;
		form1.a32.disabled=true;
		form1.b12.disabled=true;
		form1.b22.disabled=true;
		form1.b32.disabled=true;
		form1.c12.disabled=true;
		form1.c22.disabled=true;
		form1.c32.disabled=true;
		form1.a110.value='0,000';
		form1.a210.value='0,000';
		form1.a310.value='0,000';
		form1.b110.value='0,000';
		form1.b210.value='0,000';
		form1.b310.value='0,000';
		form1.c110.value='0,000';
		form1.c210.value='0,000';
		form1.c310.value='0,000';
		form1.a19.value='0,000';
		form1.a29.value='0,000';
		form1.a39.value='0,000';
		form1.b19.value='0,000';
		form1.b29.value='0,000';
		form1.b39.value='0,000';
		form1.c19.value='0,000';
		form1.c29.value='0,000';
		form1.c39.value='0,000';
		form1.a18.value='0,000';
		form1.a28.value='0,000';
		form1.a38.value='0,000';
		form1.b18.value='0,000';
		form1.b28.value='0,000';
		form1.b38.value='0,000';
		form1.c18.value='0,000';
		form1.c28.value='0,000';
		form1.c38.value='0,000';
		form1.a17.value='0,000';
		form1.a27.value='0,000';
		form1.a37.value='0,000';
		form1.b17.value='0,000';
		form1.b27.value='0,000';
		form1.b37.value='0,000';
		form1.c17.value='0,000';
		form1.c27.value='0,000';
		form1.c37.value='0,000';
		form1.a16.value='0,000';
		form1.a26.value='0,000';
		form1.a36.value='0,000';
		form1.b16.value='0,000';
		form1.b26.value='0,000';
		form1.b36.value='0,000';
		form1.c16.value='0,000';
		form1.c26.value='0,000';
		form1.c36.value='0,000';
		form1.a15.value='0,000';
		form1.a25.value='0,000';
		form1.a35.value='0,000';
		form1.b15.value='0,000';
		form1.b25.value='0,000';
		form1.b35.value='0,000';
		form1.c15.value='0,000';
		form1.c25.value='0,000';
		form1.c35.value='0,000';
		form1.a14.value='0,000';
		form1.a24.value='0,000';
		form1.a34.value='0,000';
		form1.b14.value='0,000';
		form1.b24.value='0,000';
		form1.b34.value='0,000';
		form1.c14.value='0,000';
		form1.c24.value='0,000';
		form1.c34.value='0,000';
		form1.a13.value='0,000';
		form1.a23.value='0,000';
		form1.a33.value='0,000';
		form1.b13.value='0,000';
		form1.b23.value='0,000';
		form1.b33.value='0,000';
		form1.c13.value='0,000';
		form1.c23.value='0,000';
		form1.c33.value='0,000';
		form1.a12.value='0,000';
		form1.a22.value='0,000';
		form1.a32.value='0,000';
		form1.b12.value='0,000';
		form1.b22.value='0,000';
		form1.b32.value='0,000';
		form1.c12.value='0,000';
		form1.c22.value='0,000';
		form1.c32.value='0,000';
	}
	oper();
	cicl();
}
function oper(){
	if(form1.nop[0].checked){
		form1.c11.disabled=true;
		form1.c21.disabled=true;
		form1.c31.disabled=true;
		form1.c12.disabled=true;
		form1.c22.disabled=true;
		form1.c32.disabled=true;
		form1.c13.disabled=true;
		form1.c23.disabled=true;
		form1.c33.disabled=true;
		form1.c14.disabled=true;
		form1.c24.disabled=true;
		form1.c34.disabled=true;
		form1.c15.disabled=true;
		form1.c25.disabled=true;
		form1.c35.disabled=true;
		form1.c16.disabled=true;
		form1.c26.disabled=true;
		form1.c36.disabled=true;
		form1.c17.disabled=true;
		form1.c27.disabled=true;
		form1.c37.disabled=true;
		form1.c18.disabled=true;
		form1.c28.disabled=true;
		form1.c38.disabled=true;
		form1.c19.disabled=true;
		form1.c29.disabled=true;
		form1.c39.disabled=true;
		form1.c110.disabled=true;
		form1.c210.disabled=true;
		form1.c310.disabled=true;
		form1.a31.value='0,000';
		form1.b31.value='0,000';
		form1.c31.value='0,000';
		form1.a32.value='0,000';
		form1.b32.value='0,000';
		form1.c32.value='0,000';
		form1.a33.value='0,000';
		form1.b33.value='0,000';
		form1.c33.value='0,000';
		form1.a34.value='0,000';
		form1.b34.value='0,000';
		form1.c34.value='0,000';
		form1.a35.value='0,000';
		form1.b35.value='0,000';
		form1.c35.value='0,000';
		form1.a36.value='0,000';
		form1.b36.value='0,000';
		form1.c36.value='0,000';
		form1.a37.value='0,000';
		form1.b37.value='0,000';
		form1.c37.value='0,000';
		form1.a38.value='0,000';
		form1.b38.value='0,000';
		form1.c38.value='0,000';
		form1.a39.value='0,000';
		form1.b39.value='0,000';
		form1.c39.value='0,000';
		form1.a310.value='0,000';
		form1.b310.value='0,000';
		form1.c310.value='0,000';
	}else if(form1.nop[1].checked){
		form1.c11.disabled=false;
		form1.c21.disabled=false;
		form1.c31.disabled=false;
		if(form1.npc[form1.npc.selectedIndex].value>=2){
			form1.c12.disabled=false;
			form1.c22.disabled=false;
			form1.c32.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=3){
			form1.c13.disabled=false;
			form1.c23.disabled=false;
			form1.c33.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=4){
			form1.c14.disabled=false;
			form1.c24.disabled=false;
			form1.c34.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=5){
			form1.c15.disabled=false;
			form1.c25.disabled=false;
			form1.c35.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=6){
			form1.c16.disabled=false;
			form1.c26.disabled=false;
			form1.c36.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=7){
			form1.c17.disabled=false;
			form1.c27.disabled=false;
			form1.c37.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=8){
			form1.c18.disabled=false;
			form1.c28.disabled=false;
			form1.c38.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=9){
			form1.c19.disabled=false;
			form1.c29.disabled=false;
			form1.c39.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=10){
			form1.c110.disabled=false;
			form1.c210.disabled=false;
			form1.c310.disabled=false;
		}
		cicl();
	}
}
function cicl(){
	if(form1.ncic[0].checked){
		form1.a31.disabled=true;
		form1.b31.disabled=true;
		form1.c31.disabled=true;
		form1.a32.disabled=true;
		form1.b32.disabled=true;
		form1.c32.disabled=true;
		form1.a33.disabled=true;
		form1.b33.disabled=true;
		form1.c33.disabled=true;
		form1.a34.disabled=true;
		form1.b34.disabled=true;
		form1.c34.disabled=true;
		form1.a35.disabled=true;
		form1.b35.disabled=true;
		form1.c35.disabled=true;
		form1.a36.disabled=true;
		form1.b36.disabled=true;
		form1.c36.disabled=true;
		form1.a37.disabled=true;
		form1.b37.disabled=true;
		form1.c37.disabled=true;
		form1.a38.disabled=true;
		form1.b38.disabled=true;
		form1.c38.disabled=true;
		form1.a39.disabled=true;
		form1.b39.disabled=true;
		form1.c39.disabled=true;
		form1.a310.disabled=true;
		form1.b310.disabled=true;
		form1.c310.disabled=true;
		form1.a31.value='0,000';
		form1.b31.value='0,000';
		form1.c31.value='0,000';
		form1.a32.value='0,000';
		form1.b32.value='0,000';
		form1.c32.value='0,000';
		form1.a33.value='0,000';
		form1.b33.value='0,000';
		form1.c33.value='0,000';
		form1.a34.value='0,000';
		form1.b34.value='0,000';
		form1.c34.value='0,000';
		form1.a35.value='0,000';
		form1.b35.value='0,000';
		form1.c35.value='0,000';
		form1.a36.value='0,000';
		form1.b36.value='0,000';
		form1.c36.value='0,000';
		form1.a37.value='0,000';
		form1.b37.value='0,000';
		form1.c37.value='0,000';
		form1.a38.value='0,000';
		form1.b38.value='0,000';
		form1.c38.value='0,000';
		form1.a39.value='0,000';
		form1.b39.value='0,000';
		form1.c39.value='0,000';
		form1.a310.value='0,000';
		form1.b310.value='0,000';
		form1.c310.value='0,000';
	}else if(form1.ncic[1].checked){
		form1.a31.disabled=false;
		form1.b31.disabled=false;
		form1.c31.disabled=false;
		if(form1.npc[form1.npc.selectedIndex].value>=2){
			form1.a32.disabled=false;
			form1.b32.disabled=false;
			form1.c32.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=3){
			form1.a33.disabled=false;
			form1.b33.disabled=false;
			form1.c33.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=4){
			form1.a34.disabled=false;
			form1.b34.disabled=false;
			form1.c34.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=5){
			form1.a35.disabled=false;
			form1.b35.disabled=false;
			form1.c35.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=6){
			form1.a36.disabled=false;
			form1.b36.disabled=false;
			form1.c36.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=7){
			form1.a37.disabled=false;
			form1.b37.disabled=false;
			form1.c37.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=8){
			form1.a38.disabled=false;
			form1.b38.disabled=false;
			form1.c38.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=9){
			form1.a39.disabled=false;
			form1.b39.disabled=false;
			form1.c39.disabled=false;
		}
		if(form1.npc[form1.npc.selectedIndex].value>=10){
			form1.a310.disabled=false;
			form1.b310.disabled=false;
			form1.c310.disabled=false;
		}
		if(form1.nop[0].checked){
			form1.c31.disabled=true;
			form1.c32.disabled=true;
			form1.c33.disabled=true;
			form1.c34.disabled=true;
			form1.c35.disabled=true;
			form1.c36.disabled=true;
			form1.c37.disabled=true;
			form1.c38.disabled=true;
			form1.c39.disabled=true;
			form1.c310.disabled=true;
			form1.c31.value='0,000';
			form1.c32.value='0,000';
			form1.c33.value='0,000';
			form1.c34.value='0,000';
			form1.c35.value='0,000';
			form1.c36.value='0,000';
			form1.c37.value='0,000';
			form1.c38.value='0,000';
			form1.c39.value='0,000';
			form1.c310.value='0,000';			
		}
	}
}
function sele(el){
	var tr = el.createTextRange();
    tr.select();
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_rr.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de R&R - Tabela '; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Característica - </strong>Característica da peça a ser estudada.<br><strong>Especificação  </strong>Forma ou medida para ser seguida.<br><strong>Disp.Medição - </strong>Dispositivo que foi feito a medição<br><strong>N° disp  </strong>Numero de identificação do dispositivo<br><strong>Realizado por - </strong>Nome do responsável pelo estudo de R&R.<br><strong>Data  </strong>Data do estudo<br><strong>Obs  </strong>algo que deve ser ressaltado ou lembrado.')"></a></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Estudo de R&amp;R <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">estudo</td>
		<?php if(!empty($res["a11"])){ ?><a href="apqp_rr3.php?car=<?php echo  $car; ?>"><?php } ?>
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">resultados</td>
		<?php if(!empty($res["a11"])){ ?></a><?php } ?>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_rr_sql.php" onSubmit="return verifica(this)"><td bgcolor="#FFFFFF">
          <table width="571" border="0" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td width="80" class="textobold">Caracter&iacute;stica</td>
              <td colspan="5"><input name="junk3" type="text" class="formularioselect" id="junk3" value="<?php echo  $resc["numero"]; ?> - <?php echo  $resc["descricao"]; ?>" size="10" readonly=""></td>
              </tr>
            <tr>
              <td class="textobold">Especifica&ccedil;&atilde;o</td>
              <td width="205"><input name="junk2" type="text" class="formularioselect" id="ini4" value="<?php echo  $resc["espec"]; ?>" size="7" readonly=""></td>
              <td width="67" class="textobold">&nbsp;&nbsp;Toler&acirc;ncia</td>
              <td colspan="3"><input name="junk1" type="text" class="formularioselect" id="junk1" value="<?php echo  banco2valor3($resc["tol"]); ?>" size="7" readonly=""></td>
              </tr>
            <tr>
              <td class="textobold">Disp. Medi&ccedil;&atilde;o </td>
              <td><input name="dispno" type="text" class="formularioselect" id="dispno" value="<?php echo  $res["dispno"]; ?>" size="7" maxlength="60"></td>
              <td align="center" class="textobold">N&ordm; disp.</td>
              <td colspan="3"><input name="dispnu" type="text" class="formularioselect" id="dispnu" value="<?php echo  $res["dispnu"]; ?>" size="7" maxlength="20"></td>
            </tr>
            <tr>
              <td class="textobold">Realizado por </td>
              <td colspan="2"><input name="por" type="text" class="formularioselect" id="por" value="<?php echo  $res["por"]; ?>" size="7" maxlength="100"></td>
              <td colspan="2" align="center" class="textobold">Data</td>
              <td><input name="dtpor" type="text" class="formulario" id="dteng2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($res["dtpor"]); ?>" size="15" maxlength="10" data>
                &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_rr2&var_field=dtpor','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
            </tr>
            <tr>
              <td class="textobold">Obs</td>
              <td colspan="5"><input name="obs" type="text" class="formularioselect" id="obs" value="<?php echo  $res["obs"]; ?>" size="7" maxlength="255"></td>
            </tr>
            <tr>
              <td class="textobold">Edi&ccedil;&atilde;o:</td>
              <td colspan="5" class="textobold"><table width="200" border="0" cellpadding="0" cellspacing="0" class="texto">
                <tr>
                  <td><input name="ed" type="radio" id="radio" value="5.15" <?php if($res["ed"]=="5.15" or empty($res["ed"])){ print "checked"; } ?>>
2&ordm; Edi&ccedil;&atilde;o </td>
                  <td><input name="ed" type="radio" value="6" id="radiobutton" <?php if($res["ed"]=="6"){ print "checked"; } ?>>
                    3                    &ordm; Edi&ccedil;&atilde;o </td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td colspan="6"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td colspan="6"><table width="571" border="0" cellpadding="3" cellspacing="1" bgcolor="#003366">
                <tr>
                  <td colspan="4" align="center" class="textoboldbranco">Op&ccedil;&otilde;es</td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="190" align="center" class="textobold">&nbsp;N&ordm; de Operadores
                    <input name="nop" type="radio" value="2" <?php if($res["nop"]==2 or empty($res["nop"])) print "checked"; ?> onClick="oper();">
                    2
                    <input name="nop" type="radio" value="3" <?php if($res["nop"]==3) print "checked"; ?>  onClick="oper();">
                    3</td>
                  <td width="196" align="center" class="textobold">N&ordm; de Ciclos
                    <input name="ncic" type="radio" value="2" <?php if($res["ncic"]==2 or empty($res["ncic"])) print "checked"; ?> onClick="cicl();">
2
<input name="ncic" type="radio" value="3" <?php if($res["ncic"]==3) print "checked"; ?> onClick="cicl();">
3</td>
                  <td width="125" align="center" class="textobold">N&ordm; de Pe&ccedil;as </td>
                  <td width="55" class="textobold"><select name="npc" class="formularioselect" id="npc" onChange="linha();">
					<option value="2" <?php if($res["npc"]==2 or empty($res["npc"])) print "selected"; ?>>2</option>
                    <option value="3" <?php if($res["npc"]==3) print "selected"; ?>>3</option>
                    <option value="4" <?php if($res["npc"]==4) print "selected"; ?>>4</option>
                    <option value="5" <?php if($res["npc"]==5) print "selected"; ?>>5</option>
                    <option value="6" <?php if($res["npc"]==6) print "selected"; ?>>6</option>
                    <option value="7" <?php if($res["npc"]==7) print "selected"; ?>>7</option>
                    <option value="8" <?php if($res["npc"]==8) print "selected"; ?>>8</option>
                    <option value="9" <?php if($res["npc"]==9) print "selected"; ?>>9</option>
                    <option value="10" <?php if($res["npc"]==10) print "selected"; ?>>10</option>
                                                                        </select></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="6"><img src="imagens/dot.gif" width="20" height="8"></td>
              </tr>
            <tr>
              <td colspan="6"><table width="571" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
                <tr class="textobold">
                  <td width="0" rowspan="2" align="center" valign="middle" class="textoboldbranco">P&Ccedil;</td>
                  <td colspan="3" align="center" class="textoboldbranco">Operador A</td>
                  <td colspan="3" align="center" class="textoboldbranco">Operador B </td>
                  <td colspan="3" align="center" class="textoboldbranco">Operador C </td>
                  </tr>
                <tr class="textobold">
                  <td width="60" align="center" class="textoboldbranco">Ciclo 1 </td>
                  <td width="60" align="center" class="textoboldbranco">Ciclo 2 </td>
                  <td width="60" align="center" class="textoboldbranco">Ciclo 3</td>
                  <td width="60" align="center" class="textoboldbranco">Ciclo 1 </td>
                  <td width="60" align="center" class="textoboldbranco">Ciclo 2 </td>
                  <td width="60" align="center" class="textoboldbranco">Ciclo 3</td>
                  <td width="60" align="center" class="textoboldbranco">Ciclo 1 </td>
                  <td width="60" align="center" class="textoboldbranco">Ciclo 2 </td>
                  <td width="60" align="center" class="textoboldbranco">Ciclo 3 </td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">1</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a11" type="text" class="formularioselectsemborda" id="a11"  value="<?php print banco2valor2($res["a11"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a21" type="text" class="formularioselectsemborda" id="a21"  value="<?php print banco2valor2($res["a21"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a31" type="text" class="formularioselectsemborda" id="a31"  value="<?php print banco2valor2($res["a31"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b11" type="text" class="formularioselectsemborda" id="b11"  value="<?php print banco2valor2($res["b11"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b21" type="text" class="formularioselectsemborda" id="b21"  value="<?php print banco2valor2($res["b21"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b31" type="text" class="formularioselectsemborda" id="b31"  value="<?php print banco2valor2($res["b31"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c11" type="text" class="formularioselectsemborda" id="c11"  value="<?php print banco2valor2($res["c11"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c21" type="text" class="formularioselectsemborda" id="c21"  value="<?php print banco2valor2($res["c21"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c31" type="text" class="formularioselectsemborda" id="c31"  value="<?php print banco2valor2($res["c31"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">2</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a12" type="text" class="formularioselectsemborda" id="a12"  value="<?php print banco2valor2($res["a12"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a22" type="text" class="formularioselectsemborda" id="a22"  value="<?php print banco2valor2($res["a22"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a32" type="text" class="formularioselectsemborda" id="a32"  value="<?php print banco2valor2($res["a32"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b12" type="text" class="formularioselectsemborda" id="b12"  value="<?php print banco2valor2($res["b12"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b22" type="text" class="formularioselectsemborda" id="b22"  value="<?php print banco2valor2($res["b22"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b32" type="text" class="formularioselectsemborda" id="b32"  value="<?php print banco2valor2($res["b32"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c12" type="text" class="formularioselectsemborda" id="c12"  value="<?php print banco2valor2($res["c12"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c22" type="text" class="formularioselectsemborda" id="c22"  value="<?php print banco2valor2($res["c22"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c32" type="text" class="formularioselectsemborda" id="c32"  value="<?php print banco2valor2($res["c32"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">3</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a13" type="text" class="formularioselectsemborda" id="a13"  value="<?php print banco2valor2($res["a13"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a23" type="text" class="formularioselectsemborda" id="a23"  value="<?php print banco2valor2($res["a23"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a33" type="text" class="formularioselectsemborda" id="a33"  value="<?php print banco2valor2($res["a33"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b13" type="text" class="formularioselectsemborda" id="b13"  value="<?php print banco2valor2($res["b13"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b23" type="text" class="formularioselectsemborda" id="b23"  value="<?php print banco2valor2($res["b23"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b33" type="text" class="formularioselectsemborda" id="b33"  value="<?php print banco2valor2($res["b33"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c13" type="text" class="formularioselectsemborda" id="c13"  value="<?php print banco2valor2($res["c13"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c23" type="text" class="formularioselectsemborda" id="c23"  value="<?php print banco2valor2($res["c23"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c33" type="text" class="formularioselectsemborda" id="c33"  value="<?php print banco2valor2($res["c33"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">4</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a14" type="text" class="formularioselectsemborda" id="a14"  value="<?php print banco2valor2($res["a14"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a24" type="text" class="formularioselectsemborda" id="a24"  value="<?php print banco2valor2($res["a24"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a34" type="text" class="formularioselectsemborda" id="a34"  value="<?php print banco2valor2($res["a34"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b14" type="text" class="formularioselectsemborda" id="b14"  value="<?php print banco2valor2($res["b14"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b24" type="text" class="formularioselectsemborda" id="b24"  value="<?php print banco2valor2($res["b24"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b34" type="text" class="formularioselectsemborda" id="b34"  value="<?php print banco2valor2($res["b34"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c14" type="text" class="formularioselectsemborda" id="c14"  value="<?php print banco2valor2($res["c14"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c24" type="text" class="formularioselectsemborda" id="c24"  value="<?php print banco2valor2($res["c24"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c34" type="text" class="formularioselectsemborda" id="c34"  value="<?php print banco2valor2($res["c34"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">5</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a15" type="text" class="formularioselectsemborda" id="a15"  value="<?php print banco2valor2($res["a15"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a25" type="text" class="formularioselectsemborda" id="a25"  value="<?php print banco2valor2($res["a25"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a35" type="text" class="formularioselectsemborda" id="a35"  value="<?php print banco2valor2($res["a35"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b15" type="text" class="formularioselectsemborda" id="b15"  value="<?php print banco2valor2($res["b15"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b25" type="text" class="formularioselectsemborda" id="b25"  value="<?php print banco2valor2($res["b25"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b35" type="text" class="formularioselectsemborda" id="b35"  value="<?php print banco2valor2($res["b35"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c15" type="text" class="formularioselectsemborda" id="c15"  value="<?php print banco2valor2($res["c15"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c25" type="text" class="formularioselectsemborda" id="c25"  value="<?php print banco2valor2($res["c25"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c35" type="text" class="formularioselectsemborda" id="c35"  value="<?php print banco2valor2($res["c35"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">6</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a16" type="text" class="formularioselectsemborda" id="a16"  value="<?php print banco2valor2($res["a16"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a26" type="text" class="formularioselectsemborda" id="a26"  value="<?php print banco2valor2($res["a26"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a36" type="text" class="formularioselectsemborda" id="a36"  value="<?php print banco2valor2($res["a36"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b16" type="text" class="formularioselectsemborda" id="b16"  value="<?php print banco2valor2($res["b16"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b26" type="text" class="formularioselectsemborda" id="b26"  value="<?php print banco2valor2($res["b26"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b36" type="text" class="formularioselectsemborda" id="b36"  value="<?php print banco2valor2($res["b36"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c16" type="text" class="formularioselectsemborda" id="c16"  value="<?php print banco2valor2($res["c16"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c26" type="text" class="formularioselectsemborda" id="c26"  value="<?php print banco2valor2($res["c26"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c36" type="text" class="formularioselectsemborda" id="c36"  value="<?php print banco2valor2($res["c36"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">7</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a17" type="text" class="formularioselectsemborda" id="a17"  value="<?php print banco2valor2($res["a17"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a27" type="text" class="formularioselectsemborda" id="a27"  value="<?php print banco2valor2($res["a27"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a37" type="text" class="formularioselectsemborda" id="a37"  value="<?php print banco2valor2($res["a37"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b17" type="text" class="formularioselectsemborda" id="b17"  value="<?php print banco2valor2($res["b17"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b27" type="text" class="formularioselectsemborda" id="b27"  value="<?php print banco2valor2($res["b27"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b37" type="text" class="formularioselectsemborda" id="b37"  value="<?php print banco2valor2($res["b37"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c17" type="text" class="formularioselectsemborda" id="c17"  value="<?php print banco2valor2($res["c17"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c27" type="text" class="formularioselectsemborda" id="c27"  value="<?php print banco2valor2($res["c27"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c37" type="text" class="formularioselectsemborda" id="c37"  value="<?php print banco2valor2($res["c37"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">8</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a18" type="text" class="formularioselectsemborda" id="a18"  value="<?php print banco2valor2($res["a18"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a28" type="text" class="formularioselectsemborda" id="a28"  value="<?php print banco2valor2($res["a28"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a38" type="text" class="formularioselectsemborda" id="a38"  value="<?php print banco2valor2($res["a38"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b18" type="text" class="formularioselectsemborda" id="b18"  value="<?php print banco2valor2($res["b18"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b28" type="text" class="formularioselectsemborda" id="b28"  value="<?php print banco2valor2($res["b28"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b38" type="text" class="formularioselectsemborda" id="b38"  value="<?php print banco2valor2($res["b38"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c18" type="text" class="formularioselectsemborda" id="c18"  value="<?php print banco2valor2($res["c18"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c28" type="text" class="formularioselectsemborda" id="c28"  value="<?php print banco2valor2($res["c28"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c38" type="text" class="formularioselectsemborda" id="c38"  value="<?php print banco2valor2($res["c38"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">9</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a19" type="text" class="formularioselectsemborda" id="a19"  value="<?php print banco2valor2($res["a19"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a29" type="text" class="formularioselectsemborda" id="a29"  value="<?php print banco2valor2($res["a29"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a39" type="text" class="formularioselectsemborda" id="a39"  value="<?php print banco2valor2($res["a39"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b19" type="text" class="formularioselectsemborda" id="b19"  value="<?php print banco2valor2($res["b19"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b29" type="text" class="formularioselectsemborda" id="b29"  value="<?php print banco2valor2($res["b29"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b39" type="text" class="formularioselectsemborda" id="b39"  value="<?php print banco2valor2($res["b39"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c19" type="text" class="formularioselectsemborda" id="c19"  value="<?php print banco2valor2($res["c19"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c29" type="text" class="formularioselectsemborda" id="c29"  value="<?php print banco2valor2($res["c29"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c39" type="text" class="formularioselectsemborda" id="c39"  value="<?php print banco2valor2($res["c39"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
                <tr class="textobold">
                  <td width="0" align="center" class="textoboldbranco">10</td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a110" type="text" class="formularioselectsemborda" id="a110"  value="<?php print banco2valor2($res["a110"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a210" type="text" class="formularioselectsemborda" id="a210"  value="<?php print banco2valor2($res["a210"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="a310" type="text" class="formularioselectsemborda" id="a310"  value="<?php print banco2valor2($res["a310"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b110" type="text" class="formularioselectsemborda" id="b110"  value="<?php print banco2valor2($res["b110"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b210" type="text" class="formularioselectsemborda" id="b210"  value="<?php print banco2valor2($res["b210"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="b310" type="text" class="formularioselectsemborda" id="b310"  value="<?php print banco2valor2($res["b310"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c110" type="text" class="formularioselectsemborda" id="c110"  value="<?php print banco2valor2($res["c110"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c210" type="text" class="formularioselectsemborda" id="c210"  value="<?php print banco2valor2($res["c210"]); ?>" size="4" onFocus="sele(this);"></td>
                  <td width="60" bgcolor="#FFFFFF"><input name="c310" type="text" class="formularioselectsemborda" id="c310"  value="<?php print banco2valor2($res["c310"]); ?>" size="4" onFocus="sele(this);"></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td><img src="imagens/dot.gif" width="20" height="8"></td>
              <td><img src="imagens/dot.gif" width="20" height="8"></td>
              <td><img src="imagens/dot.gif" width="20" height="8"></td>
              <td width="28"><img src="imagens/dot.gif" width="20" height="8"></td>
              <td width="35"><img src="imagens/dot.gif" width="20" height="8"></td>
              <td width="126"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td colspan="6" align="center">
                <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_rr.php';">
                              &nbsp;
                              <input name="button122" type="submit" class="microtxt" value="Salvar" onClick="<?php echo  $btnsalva; ?>">
                <input name="car" type="hidden" id="car" value="<?php echo  $car; ?>">
                <input name="acao" type="hidden" id="acao" value="rr2">
                <input name="id" type="hidden" id="id" value="<?php echo  $res["id"]; ?>"></td>
              </tr>
          </table>
        </td></form>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script>
linha();
</script>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>