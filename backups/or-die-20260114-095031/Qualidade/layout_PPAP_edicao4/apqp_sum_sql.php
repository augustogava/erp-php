<?php
include("conecta.php");
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$quem=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$hj=date("Y-m-d");
$hora=hora();

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if(!empty($acao)){
	$loc="APQP - Sumário e Aprovação";
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
		$apqp->cliente_apro("apqp_sum1.php");
		// - - - - - - - -  -
if($acao=="s1"){

	$data=data2banco($data);
	$pca_dt=data2banco($pca_dt);
	$sql=mysql_query("UPDATE apqp_sum SET data='$data',ppk_req='$ppk_req',ppk_ace='$ppk_ace',ppk_pen='$ppk_pen',pca='$pca',pca_dt='$pca_dt',dim_amo='$dim_amo',dim_car='$dim_car',dim_ace='$dim_ace',dim_pen='$dim_pen',vis_amo='$vis_amo',vis_car='$vis_car',vis_ace='$vis_ace',vis_pen='$vis_pen',lab_amo='$lab_amo',lab_car='$lab_car',lab_ace='$lab_ace',lab_pen='$lab_pen',des_amo='$des_amo',des_car='$des_car',des_ace='$des_ace',des_pen='$des_pen' WHERE peca='$pc'") or die("Nao foii1");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Sumário de Aprovação da peça $npc.','O usuário $quem salvou as alterações do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}	
	header("location:apqp_sum1.php");
}elseif($acao=="s2"){
	$sql=mysql_query("UPDATE apqp_sum SET care_req='$care_req',care_ace='$care_ace',care_pen='$care_pen',instm_req='$instm_req',instm_ace='$instm_ace',instm_pen='$instm_pen',folha_req='$folha_req',folha_ace='$folha_ace',folha_pen='$folha_pen',instv_req='$instv_req',instv_ace='$instv_ace',instv_pen='$instv_pen',apro_req='$apro_req',apro_ace='$apro_ace',apro_pen='$apro_pen',teste_req='$teste_req',teste_ace='$teste_ace',teste_pen='$teste_pen' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Sumário de Aprovação da peça $npc.','O usuário $quem salvou as alterações do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_sum2.php");
}elseif($acao=="s3"){
	$sql=mysql_query("UPDATE apqp_sum SET plano='$plano' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Sumário de Aprovação da peça $npc.','O usuário $quem salvou as alterações do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_sum3.php");
}elseif($acao=="s4"){
	if(isset($ap1) or isset($ap2) or isset($ap3) or isset($ap4) or isset($ap5) or isset($ap6)){
		$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(!mysql_num_rows($sql)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_sum4.php");
			exit;
		}
	}
	if(isset($ap1)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Sumario de Aprovação do APQP (Validação final)");
		// - - - - - - - -  - - - - - - - - 
		if(empty($tap11)){
		$tap11=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_sum WHERE ap1='' AND dap1='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_sum SET ap1='$tap11', dap1=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap11', fim=NOW(), perc='100' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')") or die("Nao foi");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Sumário de Aprovação
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem aprovou o Sumário de Aprovação da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($ap2)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Sumario de Aprovação do APQP (Validação final)");
		// - - - - - - - -  - - - - - - - - 
		$sql=mysql_query("SELECT * FROM apqp_sum WHERE ap2='' AND dap2='0000-00-00' AND peca='$pc'");
		if(empty($tap12)){
		$tap12=$quem;
		}
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_sum SET ap2='$tap12', dap2=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap12', fim=NOW(), perc='100' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Sumário de Aprovação
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem aprovou o Sumário de Aprovação da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($ap3)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Sumario de Aprovação do APQP (Validação final)");
		// - - - - - - - -  - - - - - - - - 
		$sql=mysql_query("SELECT * FROM apqp_sum WHERE ap3='' AND dap3='0000-00-00' AND peca='$pc'");
		if(empty($tap13)){
		$tap13=$quem;
		}
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_sum SET ap3='$tap13', dap3=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap13', fim=NOW(), perc='100' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Sumário de Aprovação
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem aprovou o Sumário de Aprovação da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($ap4)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Sumario de Aprovação do APQP (Validação final)");
		// - - - - - - - -  - - - - - - - - 
		if(empty($tap14)){
		$tap14=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_sum WHERE ap4='' AND dap4='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_sum SET ap4='$tap14', dap4=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap14', fim=NOW(), perc='100' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Sumário de Aprovação
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem aprovou o Sumário de Aprovação da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($ap5)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Sumario de Aprovação do APQP (Validação final)");
		// - - - - - - - -  - - - - - - - - 
		if(empty($tap15)){
		$tap15=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_sum WHERE ap5='' AND dap5='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_sum SET ap5='$tap15', dap5=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap15', fim=NOW(), perc='100' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Sumário de Aprovação
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem aprovou o Sumário de Aprovação da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($ap6)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Sumario de Aprovação do APQP (Validação final)");
		// - - - - - - - -  - - - - - - - - 
		if(empty($tap16)){
		$tap16=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_sum WHERE ap6='' AND dap6='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_sum SET ap6='$tap16', dap6=NOW() WHERE peca='$pc'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Sumário de Aprovação
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem aprovou o Sumário de Aprovação da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}else if(isset($hp)){
		$dap1=data2banco($dap1);
		$dap2=data2banco($dap2);
		$dap3=data2banco($dap3);
		$dap4=data2banco($dap4);
		$dap5=data2banco($dap5);
		$dap6=data2banco($dap6);

			$sql=mysql_query("UPDATE apqp_sum SET ap1='$tap1', dap1='$dap1' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_sum SET ap2='$tap12', dap2='$dap2' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_sum SET ap3='$tap13', dap3='$dap3' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_sum SET ap4='$tap14', dap4='$dap4' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_sum SET ap5='$tap15', dap5='$dap5' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_sum SET ap6='$tap16', dap6='$dap6' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap1', fim=NOW(), perc='95' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
	$_SESSION["mensagem"]="Alterações salvas com sucesso";
	// cria followup caso salve o conteudo do Sumário de Aprovação
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Sumário de Aprovação da peça $npc.','O usuário $quem salvou as alterações do Sumário de Aprovação da peça $npc.','$user')");
	//	
		
	}elseif(isset($lap1)){
		$sql=mysql_query("UPDATE apqp_sum SET ap1='', dap1='0000-00-00' WHERE peca='$pc'");
		$sql=mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem removeu a aprovação do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}elseif(isset($lap2)){
		$sql=mysql_query("UPDATE apqp_sum SET ap2='', dap2='0000-00-00' WHERE peca='$pc'");
		$sql=mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem removeu a aprovação do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}elseif(isset($lap3)){
		$sql=mysql_query("UPDATE apqp_sum SET ap3='', dap3='0000-00-00' WHERE peca='$pc'");
		$sql=mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem removeu a aprovação do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}elseif(isset($lap4)){
		$sql=mysql_query("UPDATE apqp_sum SET ap4='', dap4='0000-00-00' WHERE peca='$pc'");
		$sql=mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem removeu a aprovação do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}elseif(isset($lap5)){
		$sql=mysql_query("UPDATE apqp_sum SET ap5='', dap5='0000-00-00' WHERE peca='$pc'");
		$sql=mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem removeu a aprovação do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}elseif(isset($lap6)){
		$sql=mysql_query("UPDATE apqp_sum SET ap6='', dap6='0000-00-00' WHERE peca='$pc'");
		$sql=mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND (ativ='Sumário e Aprovação do APQP' or ativ='Sumario de Aprovação do APQP (Validação final)')");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Sumário de Aprovação
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Sumário de Aprovação da peça $npc.','O usuário $quem removeu a aprovação do Sumário de Aprovação da peça $npc.','$user')");
		//	
	}
	header("location:apqp_sum4.php");
}
?>