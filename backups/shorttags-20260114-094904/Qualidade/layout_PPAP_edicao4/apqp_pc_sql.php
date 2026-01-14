<?
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
// Log do sistema - - - - 
$loc="Cadastro de Peзas";
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
		// cria followup caso altere o cadastro da peзa 
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteraзгo do cadastro da peзa $npc.','O usuбrio $quem1 alterou o cadastro da peзa $npc.','$user')");
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
		$_SESSION["mensagem"]="Peзa cadastrada com sucesso!";
		// cria followup caso inclua uma nova peзa 
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusгo de uma nova peзa.','O usuбrio $quem1 efetuou o cadastro e a inclusгo de peзa $npc.','$user')");
		//
		header("Location:apqp_pc.php?bnum=$numero");
	}else{
		$_SESSION["mensagem"]="Nгo Foi Possнvel Cadastrar a Peзa";
	}
}
header("Location:apqp_pc_inc.php");
?>