<?php
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
// Log do sistema - - - - 
$loc="Cadastro de Peças";
$pagina=$_SERVER['SCRIPT_FILENAME'];
include("log.php");
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$npc=$_SESSION["npc"];

//if(empty($acao)) exit;
if($acao=="alt"){
		//verificar Cliente
		$apqp->cliente_apro("apqp_pc2.php");
		// - - - - - - - -  -
	$dtrev=data2banco($dtrev);
	$dteng=data2banco($dteng);
	$dtproj=data2banco($dtproj);
//print "UPDATE apqp_pc SET numero='$numero',rev='$rev',dtrev='$dtrev',nome='$nome',cliente='$cliente',desenhoi='$desenhoi',desenhoc='$desenhoc',pecacli='$pecacli',aplicacao='$aplicacao',niveleng='$niveleng',dteng='$dteng',historico='$historico',idioma='$idioma' WHERE id='$id'";
	$sql=mysql_query("UPDATE apqp_pc SET numero='$numero',rev='$rev',dtrev='$dtrev',nome='$nome',cliente='$cliente',desenhoi='$desenhoi',desenhoc='$desenhoc',pecacli='$pecacli',aplicacao='$aplicacao',niveleng='$niveleng',dteng='$dteng',nivelproj='$nivelproj', dtproj='$dtproj',historico='$historico',idioma='$idioma',num_ferram='$num_ferram' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro alterado com sucesso!";
		// cria followup caso altere o cadastro da peça 
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro da peça $npc.','O usuário $quem1 alterou o cadastro da peça $npc.','$user')");
		//

		header("Location:apqp_pc2.php?acao=alt&id=$id");
		exit;
	}
}
if($acao=="add"){
	$dtrev=data2banco($dtrev);
	$dteng=data2banco($dteng);
	$dtproj=data2banco($dtproj);
	$sql=mysql_query("insert into apqp_pc(numero,rev,dtrev,nome,cliente,nomecli,desenhoi,pecacli,desenhoc,aplicacao,niveleng,dteng,nivelproj,dtproj,historico,num_ferram) values('$numero','$rev','$dtrev','$nome','$cliente','$nomecli','$desenhoi','$pecacli','$desenhoc','$aplicacao','$niveleng','$dteng','$nivelproj','dtproj','$historico','$num_ferram')");
	if($sql){
		$_SESSION["mensagem"]="Peça cadastrada com sucesso!";
		// cria followup caso inclua uma nova peça 
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de uma nova peça.','O usuário $quem1 efetuou o cadastro e a inclusão de peça $npc.','$user')");
		//
		header("Location:apqp_pc.php?bnum=$numero");
	}else{
		$_SESSION["mensagem"]="Não Foi Possível Cadastrar a Peça";
	}
}
header("Location:apqp_pc_inc.php");
?>