<?
include("conecta.php");
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$quem=$_SESSION["login_nome"];
$quemc=$_SESSION["login_cargo"];
$user=$_SESSION["login_codigo"];
$hj=date("Y-m-d");
$hora=hora();

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//
// cria followup caso salve o conteudo da Aprovação Interina
$sql_save=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Aprovação Interina da peça $npc.','O usuário $quem salvou as alterações da Aprovação Interina da peça $npc.','$user')");
//	

if(!empty($acao)){
	$loc="APQP - Interina";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="imp"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc";
	header("Location: $end");
	exit;
}
if($acao=="email"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc";
	header("Location: $end");
	exit;
}
		//verificar Cliente
		$apqp->cliente_apro("apqp_apro_int1.php");
		// - - - - - - - -  -
if($acao=="v1"){
	$ate=data2banco($ate);
	$reesubmissao=data2banco($reesubmissao);
	$data=data2banco($data);
	$sql=mysql_query("UPDATE apqp_interina SET ate='$ate',reesubmissao='$reesubmissao',ra='$ra',data='$data',ewo='$ewo',amo_adicionais='$amo_adicionais',amo_numero='$amo_numero',pkg='$pkg',eqf='$eqf' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		$sql_save;
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}	
	header("location:apqp_apro_int1.php");
}elseif($acao=="v2"){
	$sql=mysql_query("UPDATE apqp_interina SET classe='$classe',dim='$dim',apa='$apa',lab='$lab',pro='$pro',eng='$eng' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		$sql_save;
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_apro_int2.php");
}elseif($acao=="v3"){

	$sql=mysql_query("UPDATE apqp_interina SET resumo='$resumo',assunto='$assunto',problemas1='$problemas1',problemas2='$problemas2',plano1='$plano1',plano2='$plano2' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		$sql_save;
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_apro_int3.php");
}elseif($acao=="v4"){
	$data_eng=data2banco($data_eng);
	$data_com=data2banco($data_com);
	$data_engprod=data2banco($data_engprod);
	$data_coor=data2banco($data_coor);
	if(isset($ap1)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Interina");
		// - - - - - - - -  - - - - - - - - 
		$sql=mysql_query("SELECT * FROM apqp_interina WHERE quem='' AND dtquem='0000-00-00' AND peca='$pc'");
			if(empty($tap1)){
			$tap1=$quem;
			}
			$sql=mysql_query("UPDATE apqp_interina SET quem='$tap1',cargo='$cargo',departamento='$departamento',tel='$tel',fax='$fax2',dtquem=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Interina'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove a Aprovação Interina
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Aprovação Interina da peça $npc.','O usuário $quem aprovou a Aprovação Interina da peça $npc.','$user')");
			//					
	}elseif(isset($lap1)){
		$sql=mysql_query("UPDATE apqp_interina SET quem='', dtquem='0000-00-00' WHERE peca='$pc'");
		$sql=mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND ativ='Interina'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação da Aprovação Interina
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Aprovação Interina da peça $npc.','O usuário $quem removeu a aprovação da Aprovação Interina da peça $npc.','$user')");
		//	
	}else{
	$sql=mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND ativ='Interina'") or die("nn");
	$sql=mysql_query("UPDATE apqp_interina SET cargo='$cargo',departamento='$departamento',tel='$tel',fax='$fax2',apro_eng='$apro_eng',apro_com='$apro_com',apro_engprod='$apro_engprod',apro_coor='$apro_coor',data_eng='$data_eng',data_com='$data_com',data_engprod='$data_engprod',data_coor='$data_coor' WHERE peca='$pc'") or die("nao");
	$sql_save;
	}
	header("location:apqp_apro_int4.php");
}
?>