<?php
include("conecta.php");
include("seguranca.php");
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$npc=$_SESSION["npc"];

if(!empty($acao)){
	$loc="APQP - Caracteristicas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	if($pc=="S"){
		$lie=valor2banco2($lie);
		$lse=valor2banco2($lse);
		$tol=valor2banco2($tol);
	}else{
		$pc="N";
		$lie=0;
		$lse=0;
		$tol=0;
		$simbolo=999;
	}
	if(!empty($descricao)){
	$sql=mysql_query("SELECT * FROM apqp_desc WHERE txt='$descricao'");
	if(mysql_num_rows($sql)==0){
		$sql=mysql_query("INSERT INTO apqp_desc (txt) VALUES ('$descricao')");
	}
	}
	$descricao3=$descricao2." ".$descricao;
		$sql=mysql_query("INSERT INTO apqp_car (peca,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol) VALUES ('$id','$descricao3','$espec','$numero','$pc','$simbolo','$tipo','$lie','$lse','$tol')");
	if($sql){
	// cria followup caso inclua uma característica na peça
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Característica $numero na peça $npc.','O usuário $quem1 incluiu uma nova Característica $numero na peça $npc.','$user')");
	//	
		header("Location:apqp_car.php?id=$id&acao=inc");
	}else{
		$_SESSION["mensagem"]="A característica não pôde ser incluída";
		
	}
}elseif($acao=="alt"){
	if($pc=="S"){
		$lie=valor2banco2($lie);
		$lse=valor2banco2($lse);
		$tol=valor2banco2($tol);
	}else{
		$pc="N";
		$lie=0;
		$lse=0;
		$tol=0;
		$simbolo=999;
	}
	$sql=mysql_query("SELECT * FROM apqp_desc WHERE txt='$descricao'");
	if(mysql_num_rows($sql)==0){
		$sql=mysql_query("INSERT INTO apqp_desc (txt) VALUES ('$descricao')");
	}
	$descricao3=$descricao2." ".$descricao;
	$sql=mysql_query("UPDATE apqp_car SET peca='$id',descricao='$descricao3',espec='$espec',numero='$numero',pc='$pc',simbolo='$simbolo',tipo='$tipo',lie='$lie',lse='$lse',tol='$tol' WHERE id='$car'");
	if($sql){
		$_SESSION["mensagem"]="Característica alterada com sucesso";
	// cria followup caso altere uma característica da peça
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração de Característica $numero da peça $npc.','O usuário $quem1 alterou a Característica $numero da peça $npc.','$user')");
	//	
		
		header("Location:apqp_car.php?id=$id&acao=inc");
	}else{
		$_SESSION["mensagem"]="A característica não pôde ser alterada";
		$comp="&acao=alt&car=$car";
	}
}elseif($acao=="exc"){
	// cria followup caso exclua uma característica da peça
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		$sql_num=mysql_query("SELECT numero FROM apqp_car WHERE id='$key'");
		$res_num=mysql_fetch_array($sql_num);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão de Característica $res_num[numero] da peça $npc.','O usuário $quem1 excluiu a Característica $res_num[numero] da peça $npc.','$user')");
	//	

	foreach($del as $key=>$valor){
	$sql=mysql_query("DELETE FROM apqp_car WHERE id='$key'");
	}
	if($sql){
		$_SESSION["mensagem"]="Característica excluída com sucesso";
		header("Location:apqp_car.php?id=$id&acao=inc");
	}else{
		$_SESSION["mensagem"]="A característica não pôde ser excluída";
	}
}
?>