<?
include("conecta.php");
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$quem=$_SESSION["login_nome"];
$wop=$_SESSION["wop"];
$user=$_SESSION["login_codigo"];
$hj=date("Y-m-d");
$hora=hora();

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if(!empty($acao)){
	$loc="APQP - Plano de Controle";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="imp"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc&fase=$fase";
	header("Location: $end");
	exit;
}
if($acao=="email"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc&fase=$fase";
	header("Location: $end");
	exit;
}

$sql_apro=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc' AND fase='$fase' AND (apro1='$quem' OR apro2='$quem' OR apro3='$quem' OR apro4='$quem' OR quem='$quem')");
$res_apro=mysql_num_rows($sql_apro);

///Tirar Aprovaçõesss
		//verificar Cliente
		$apqp->cliente_apro("apqp_planoc.php");
		// - - - - - - - -  -

	$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Plano de Controle'");
	if(mysql_num_rows($sql)){
		$sqlba=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ<>'Viabilidade' AND ativ<>'Diagrama de Fluxo' AND ativ<>'FMEA de Processo' AND ativ<>'Plano de Controle'");
		while($resba=mysql_fetch_array($sqlba)){
			$sqle=mysql_query("UPDATE apqp_cron SET perc='95',resp='',fim='' WHERE peca='$pc' AND ativ='$resba[ativ]'");
		}	

				//Sub
				$sqll=mysql_query("UPDATE apqp_sub SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//Sumario
				$sqlk=mysql_query("UPDATE apqp_sum SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dap1='0000-00-00', dap2='0000-00-00', dap3='0000-00-00', dap4='0000-00-00', dap5='0000-00-00', dap6='0000-00-00' WHERE peca='$pc'");
				//Dimensional
				$sqlj=mysql_query("UPDATE apqp_endi SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//material
				$sqli=mysql_query("UPDATE apqp_enma SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//CAP
				$sqlh=mysql_query("UPDATE apqp_cap SET sit=0,quem='',dtquem='' WHERE peca='$pc'");
				//RR
				$sqlg=mysql_query("UPDATE apqp_rr SET sit=0,quem='', dtquem='' WHERE peca='$pc'");
				//plano
				//$sqlf=mysql_query("UPDATE apqp_plano SET sit='N', quem='', dtquem='' WHERE peca='$pc'");
// - - - - - - - - - - - - - - - - - - - - - -  --  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - -
	}

if($acao=="altc"){
	$ini=data2banco($ini);
	$rev=data2banco($rev);
	$apro1_data=data2banco($apro1_data);
	$apro2_data=data2banco($apro2_data);
	$apro3_data=data2banco($apro3_data);
	$apro4_data=data2banco($apro4_data);
	$dtquem=data2banco($dtquem);
	$sql_sub=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
	$res_sub=mysql_fetch_array($sql_sub);

	$sql_pla=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc' AND fase='$fase'");
	if(!mysql_num_rows($sql_pla)){
		mysql_query("INSERT INTO apqp_plano (peca,fase) VALUES ('$pc','$fase')");
	}
	$sql=mysql_query("UPDATE apqp_plano SET contato='$contato', equipe='$equipe', ini='$ini', rev='$rev', numero='$numero', quem='$quem1', dtquem='$dtquem', apro1='$apro1', apro1_data='$apro1_data', apro2='$apro2', apro2_data='$apro2_data', apro3='$apro3', apro3_data='$apro3_data', apro4='$apro4', apro4_data='$apro4_data' WHERE peca='$pc' AND fase='$fase'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo do Plano de controle
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Plano de Controle da peça $npc.','O usuário $quem salvou as alterações do Plano de Controle da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}

	if(isset($ap)){
			if($res_apro>0){
				$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
				header("location:apqp_planoc.php?fase=$fase");
				exit;
			}
		if(empty($quem1)){
		$quem1=$quem;
		}
		$sql2=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
		if(!mysql_num_rows($sql2)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
		}
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Plano de Controle");
		// - - - - - - - -  - - - - - - - - 
			mysql_query("UPDATE apqp_cron SET resp='$quem1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Plano de Controle'");
			mysql_query("UPDATE apqp_plano SET sit='S', quem='$quem1', dtquem=NOW(), contato='$contato', equipe='$equipe', ini='$ini', rev='$rev', numero='$numero' WHERE peca='$pc' AND fase='$fase'");
			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso aprove o conteudo do Plano de controle
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Plano de Controle da peça $npc.','O usuário $quem aprovou o Plano de Controle da peça $npc.','$user')");
			//	
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
	}elseif(isset($lap)){
			mysql_query("UPDATE apqp_plano SET sit='N', apro1='', apro1_data='', apro2='', apro2_data='', apro3='', apro3_data='', apro4='', apro4_data='', quem='', dtquem='' WHERE peca='$pc' AND fase='$fase'");
			$sql_pla1=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='1'");
			$res_pla1=mysql_fetch_array($sql_pla1);
			$sql_pla2=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='2'");
			$res_pla2=mysql_fetch_array($sql_pla2);
			$sql_pla3=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='3'");
			$res_pla3=mysql_fetch_array($sql_pla3);
			if( (empty($res_pla1["quem"]))&&(empty($res_pla2["quem"]))&&(empty($res_pla3["quem"])) ){	
				mysql_query("UPDATE apqp_cron SET perc='95',resp='',fim='' WHERE peca='$pc' AND ativ='Plano de Controle'");
				// tira o status de "aguardando disposição do cliente"
				$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
				$res_status=mysql_fetch_array($sql_status);
				if($res_status["status"]=="2"){
					mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
					// cria followup caso remova a aprovação do do Plano de controle e mude o status
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Plano de Controle da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Estudo Plano de Controle.','$user')");
					// MANDAR EMAIL
					$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Plano de Controle.");
					$apqp->email();
					//
				}else{
					// cria followup caso remova a aprovação do Plano de controle
					mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Plano de Controle da peça $npc.','O usuário $quem removeu a aprovação do Plano de Controle da peça $npc.','$user')");
					//	
				}
			}	
		$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
		header("Location:apqp_planoc.php?fase=$fase");
		exit;
	
	}else if(isset($ap1)){
				if($res_apro>0){
				$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
				header("location:apqp_planoc.php?fase=$fase");
				exit;
			}
		if(empty($apro1)){
		$apro1=$quem;
		}
		$sql_sub=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(!mysql_num_rows($sql_sub)){
			$_SESSION["mensagem"]="Não pode ser alterado pois Certificado de Submissão deve ser aprovado pelo fornecedor primeiro!!";
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
		}
		$sql_ap1=mysql_query("UPDATE apqp_plano SET sit='S', apro1='$apro1', contato='$contato', equipe='$equipe', ini='$ini', rev='$rev', numero='$numero', apro1_data=NOW() WHERE peca='$pc' AND fase='$fase'");
		if($sql_ap1){
			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso aprove o conteudo do Plano de controle
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Plano de Controle da peça $npc.','O usuário $quem aprovou o Plano de Controle da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="Aprovação não concluída!";
		}
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
	}else if(isset($ap2)){ 
				if($res_apro>0){
				$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
				header("location:apqp_planoc.php?fase=$fase");
				exit;
			}
		if(empty($apro2)){
		$apro2=$quem;
		}
		$sql_sub=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(!mysql_num_rows($sql_sub)){
			$_SESSION["mensagem"]="Não pode ser alterado pois Certificado de Submissão deve ser aprovado pelo fornecedor primeiro!!";
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
		}
		$sql_ap2=mysql_query("UPDATE apqp_plano SET sit='S', apro2='$apro2', contato='$contato', equipe='$equipe', ini='$ini', rev='$rev', numero='$numero', apro2_data=NOW() WHERE peca='$pc' AND fase='$fase'");
		if($sql_ap2){
			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso aprove o conteudo do Plano de controle
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Plano de Controle da peça $npc.','O usuário $quem aprovou o Plano de Controle da peça $npc.','$user')");
			//	
		} else {
			$_SESSION["mensagem"]="Aprovação não concluída!";
		}
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
	}else if(isset($ap3)){
			if($res_apro>0){
				$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
				header("location:apqp_planoc.php?fase=$fase");
				exit;
			}
		if(empty($apro3)){
		$apro3=$quem;
		}
		$sql2=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
		if(!mysql_num_rows($sql2)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
		}
//		mysql_query("UPDATE apqp_cron SET resp='$quem1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Plano de Controle'");
		if(empty($res_pla["apro3"])){
			mysql_query("UPDATE apqp_plano SET sit='S', apro3='$apro3', contato='$contato', equipe='$equipe', ini='$ini', rev='$rev', numero='$numero', apro3_data=NOW() WHERE peca='$pc' AND fase='$fase'");
		} else {
			$_SESSION["mensagem"]="Clique em Limpar primeiro";
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
		}
			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso aprove o conteudo do Plano de controle
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Plano de Controle da peça $npc.','O usuário $quem aprovou o Plano de Controle da peça $npc.','$user')");
			//	
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
	}elseif(isset($lap3)){
				mysql_query("UPDATE apqp_plano SET sit='N',apro3='', apro3_data='' WHERE peca='$pc' AND fase='$fase'");
			$sql_pla1=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='1'");
			$res_pla1=mysql_fetch_array($sql_pla1);
			$sql_pla2=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='2'");
			$res_pla2=mysql_fetch_array($sql_pla2);
			$sql_pla3=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='3'");
			$res_pla3=mysql_fetch_array($sql_pla3);
			if( (empty($res_pla1["quem"]))&&(empty($res_pla2["quem"]))&&(empty($res_pla3["quem"])) ){	
				mysql_query("UPDATE apqp_cron SET perc='95',resp='',fim='' WHERE peca='$pc' AND ativ='Plano de Controle'");
				// tira o status de "aguardando disposição do cliente"
				$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
				$res_status=mysql_fetch_array($sql_status);

				if($res_status["status"]=="2"){
					mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
					// cria followup caso remova a aprovação do do Plano de controle e mude o status
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Plano de Controle da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Estudo Plano de Controle.','$user')");	
					// MANDAR EMAIL
					$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Plano de Controle.");
					$apqp->email();
					//
				} else {
					// cria followup caso remova a aprovação do Plano de controle
					mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Plano de Controle da peça $npc.','O usuário $quem removeu a aprovação do Plano de Controle da peça $npc.','$user')");
					//	
				}
			}	
			$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
			// cria followup caso remova a aprovação do do Plano de controle
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Plano de Controle da peça $npc.','O usuário $quem removeu a aprovação do Plano de Controle da peça $npc.','$user')");
			//	
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
	}


	else if(isset($ap4)){
			if($res_apro>0){
				$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
				header("location:apqp_planoc.php?fase=$fase");
				exit;
			}
		if(empty($apro4)){
		$apro4=$quem;
		}
		$sql2=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
		if(!mysql_num_rows($sql2)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
		}
//		mysql_query("UPDATE apqp_cron SET resp='$quem1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Plano de Controle'");
		if(empty($res_pla["apro4"])){
				mysql_query("UPDATE apqp_plano SET sit='S', apro4='$apro4', apro4_data=NOW(), contato='$contato', equipe='$equipe', ini='$ini', rev='$rev', numero='$numero' WHERE peca='$pc' AND fase='$fase'");
				} else {
			$_SESSION["mensagem"]="Clique em Limpar primeiro";
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
		}

			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso aprove o conteudo do Plano de controle
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Plano de Controle da peça $npc.','O usuário $quem aprovou o Plano de Controle da peça $npc.','$user')");
			//	
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
	}elseif(isset($lap4)){
				mysql_query("UPDATE apqp_plano SET sit='N',apro4='', apro4_data='' WHERE peca='$pc' AND fase='$fase'");
			$sql_pla1=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='1'");
			$res_pla1=mysql_fetch_array($sql_pla1);
			$sql_pla2=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='2'");
			$res_pla2=mysql_fetch_array($sql_pla2);
			$sql_pla3=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='3'");
			$res_pla3=mysql_fetch_array($sql_pla3);
			if( (empty($res_pla1["quem"]))&&(empty($res_pla2["quem"]))&&(empty($res_pla3["quem"])) ){	
				mysql_query("UPDATE apqp_cron SET perc='95',resp='',fim='' WHERE peca='$pc' AND ativ='Plano de Controle'");
				// tira o status de "aguardando disposição do cliente"
				$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
				$res_status=mysql_fetch_array($sql_status);

				if($res_status["status"]=="2"){
					mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
					// cria followup caso remova a aprovação do do Plano de controle e mude o status
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Plano de Controle da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Estudo Plano de Controle.','$user')");
					// MANDAR EMAIL
					$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Plano de Controle.");
					$apqp->email();
					//
				} else {
				
					// cria followup caso remova a aprovação do Plano de controle
					mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Plano de Controle da peça $npc.','O usuário $quem removeu a aprovação do Plano de Controle da peça $npc.','$user')");
					//	
				}
			}	
			$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
			// cria followup caso remova a aprovação do Plano de controle
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Plano de Controle da peça $npc.','O usuário $quem removeu a aprovação do Plano de Controle da peça $npc.','$user')");
			//	
			header("Location:apqp_planoc.php?fase=$fase");
			exit;
	}


	$gt="c";
}elseif($acao=="altt"){
	if($salva==1){
		reset($tecnicas);
		foreach($tecnicas AS $linha => $linha2){
			$sql=mysql_query("UPDATE apqp_planoi SET tecnicas='".$tecnicas[$linha]."', tamanho='".$tamanho[$linha]."', freq='".$freq[$linha]."', metodo='".$metodo[$linha]."', reacao='".$reacao[$linha]."' WHERE id='$linha'");
		}
		if($sql){
			$_SESSION["mensagem"]="Alterações salvas com sucesso";
			// cria followup caso aprove o conteudo do Plano de controle
				$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Plano de Controle da peça $npc.','O usuário $quem aprovou o Plano de Controle da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="As alterações não puderam ser salvas";
		}
	}
	if($maisum==1){
		$sql=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc' AND fase='$fase'");
		if(mysql_num_rows($sql)){
			$res=mysql_fetch_array($sql);
			$plano=$res["id"];
			$sql=mysql_query("INSERT INTO apqp_planoi (plano,op,car) VALUES ('$plano','$wop','$wcar')");
			unset($_SESSION["mensagem"]);
		}
	}
	if($delsel==1){
		if(isset($del)){
			foreach($del AS $linha){
				$sql=mysql_query("DELETE FROM apqp_planoi WHERE id='$linha'");
			}
			$_SESSION["mensagem"]="Linhas excluídas com sucesso";
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
	$gt="t";
}
if($gt=="c"){
	header("location:apqp_planoc.php?fase=$fase");
}elseif($gt=="t"){
	header("location:apqp_planot2.php?fase=$fase");
}
?>