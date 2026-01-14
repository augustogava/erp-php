<?php
include("conecta.php");
$apqp=new set_apqp;
//$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$quem=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$hj=date("Y-m-d");
$hora=hora();

if(!empty($acao)){
	$loc="APQP - Fluxo";
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
		$apqp->cliente_apro("apqp_fluxo.php");
		// - - - - - - - -  -
///Tirar Aprovaçõesss
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Diagrama de Fluxo'");
	if(mysql_num_rows($sql)){
			$sqlba=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ<>'Viabilidade'");
			while($resba=mysql_fetch_array($sqlba)){
				$sqle=mysql_query("UPDATE apqp_cron SET perc='95',resp='',fim='' WHERE peca='$pc' AND ativ='$resba[ativ]'");
			}	
				//Sub
				$sqll=mysql_query("UPDATE apqp_sub SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//Sumario
				$sqlk=mysql_query("UPDATE apqp_sum SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dap1='0000-00-00', dap2='0000-00-00', dap3='0000-00-00', dap4='0000-00-00', dap5='0000-00-00', dap6='0000-00-00' WHERE peca='$pc'");
				//Proocesso
				$sql=mysql_query("UPDATE apqp_fmeaproc SET quem='', dtquem='' WHERE peca='$pc'");
				//Dimensional
				$sqlj=mysql_query("UPDATE apqp_endi SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//material
				$sqli=mysql_query("UPDATE apqp_enma SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//CAP
				$sqlh=mysql_query("UPDATE apqp_cap SET sit=0,quem='',dtquem='' WHERE peca='$pc'");
				//RR
				$sqlg=mysql_query("UPDATE apqp_rr SET sit=0,quem='', dtquem='' WHERE peca='$pc'");
				//plano
				$sqlf=mysql_query("UPDATE apqp_plano SET sit='N', quem='', dtquem='' WHERE peca='$pc'");
	}else{
		if(!empty($linha)){
			$sql=mysql_query("UPDATE apqp_cron SET resp='', fim=NOW(), perc='95' WHERE peca='$pc' AND ativ='Diagrama de Fluxo'");
		}
	}
// - - - - - - - - - - - - - - - - - - - - - -  --  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - -

if(!empty($linha)){
	
	foreach($i1 AS $key => $val){
		if(empty($op[$key])){
			$sql=mysql_query("UPDATE apqp_fluxo SET fluxo1='".$i1[$key]."',fluxo2='".$i2[$key]."',op='".$op[$key]."' WHERE id='$key'");
		}else{
			$sql=mysql_query("SELECT * FROM apqp_fluxo WHERE peca='$pc' AND op='".$op[$key]."'");
			if(!mysql_num_rows($sql)){
				$sql=mysql_query("UPDATE apqp_fluxo SET fluxo1='".$i1[$key]."',fluxo2='".$i2[$key]."',op='".$op[$key]."' WHERE id='$key'");	
			}
		}
	}
}

if($acao=="linha"){
	if(!empty($linha)){
		$sql=mysql_query("SELECT ordem FROM apqp_fluxo WHERE id='$linha'");
		$res=mysql_fetch_array($sql);
		$linha=$res["ordem"];
		$sql=mysql_query("UPDATE apqp_fluxo SET ordem=ordem+1 WHERE peca='$pc' AND ordem>=$linha");
	}else{
		$sql=mysql_query("SELECT MAX(ordem) AS ordem FROM apqp_fluxo WHERE peca='$pc'");
		if(mysql_num_rows($sql)){
			$res=mysql_fetch_array($sql);
			$linha=$res["ordem"]+1;
		}else{
			$linha=1;
		}
	}
	$sql=mysql_query("INSERT INTO apqp_fluxo (peca,ordem) VALUES ('$pc','$linha')");
	unset($_SESSION["mensagem"]);
}elseif($acao=="remover"){
	$sql=mysql_query("DELETE FROM apqp_fluxo WHERE id='$linha'");
//	print "DELETE FROM apqp_fluxo WHERE id='$linha'";
	unset($_SESSION["mensagem"]);
}
if(isset($ap)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Diagrama de Fluxo");
		// - - - - - - - -  - - - - - - - - 
	if(empty($quem1)){
	$quem1=$quem;
	}
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Viabilidade'");
	if(!mysql_num_rows($sql)){
		$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
		header("Location:apqp_fluxo.php");
		exit;
	}
	$sql=mysql_query("UPDATE apqp_cron SET resp='$quem1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Diagrama de Fluxo'") or die('Nao foi');
		$_SESSION["mensagem"]="Aprovado com Sucesso!";
		// cria followup caso aprove o diagrama de fluxo
			$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Diagrama de Fluxo da peça $npc.','O usuário $quem aprovou o Diagrama de Fluxo da peça $npc.','$user')");
		//	
		header("Location:apqp_fluxo.php");
		exit;
}elseif(isset($lap)){
		$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
		$res_status=mysql_fetch_array($sql_status);
		if($res_status["status"]=="2"){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Diagrama de Fluxo da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Diagrama de Fluxo.','$user')");
			//	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Diagrama de Fluxo.");
				$apqp->email();
			//
		}else{
		// cria followup caso desaprove o diagrama de fluxo
			$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Diagrama de Fluxo da peça $npc.','O usuário $quem removeu a aprovação do Diagrama de Fluxo da peça $npc.','$user')");
		//	
		}
		$sql=mysql_query("UPDATE apqp_cron SET resp='',perc='95',fim='' WHERE peca='$pc' AND ativ='Diagrama de Fluxo'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
		header("Location:apqp_fluxo.php");
		exit;
}
header("location:apqp_fluxo.php?ope=$ope");
?>