<?php
include("conecta.php");
$acao=Input::request("acao");
$local=Input::request("local");
$email=Input::request("email");
$locall=Input::request("locall");
$rep=Input::request("rep");
$dtrep=Input::request("dtrep");
$forn_mat=Input::request("forn_mat");
$forncod=Input::request("forncod");
$rep1=Input::request("rep1");
$maisum=Input::request("maisum");
$delsel=Input::request("delsel");
$del=Input::request("del", []);
$ap=Input::request("ap");
$lap=Input::request("lap");
$ap2=Input::request("ap2");
$forn=Input::request("forn", []);
$cli=Input::request("cli", []);
$ok=Input::request("ok", []);
$data_t=Input::request("data_t", []);
$quant_test=Input::request("quant_test", []);
$id=Input::request("id");
$fase=Input::request("fase");
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
	$loc="APQP - Ensaio Material";
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
		if($_SESSION["login_funcionario"]=="S"){
			$apqp->cliente_apro("apqp_enma.php");
		}
		// - - - - - - - -  -
if($acao=="alt"){
///Tirar Aprovaçõesss
	if($_SESSION["login_funcionario"]=="S"){
		$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Material'");
		if(mysql_num_rows($sql)){
				$sqlba=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ<>'Viabilidade' AND ativ<>'Diagrama de Fluxo' AND ativ<>'FMEA de Processo' AND ativ<>'Plano de Controle' AND ativ<>'Estudos de R&R' AND ativ<>'Estudos de Capabilidade' AND ativ<>'Ensaio Dimensional'");
				while($resba=mysql_fetch_array($sqlba)){
					$sqle=mysql_query("UPDATE apqp_cron SET perc='95',resp='',fim='' WHERE peca='$pc' AND ativ='$resba[ativ]'");
				}	
					//Sub
					$sqll=mysql_query("UPDATE apqp_sub SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
					//Sumario
					$sqlk=mysql_query("UPDATE apqp_sum SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dap1='0000-00-00', dap2='0000-00-00', dap3='0000-00-00', dap4='0000-00-00', dap5='0000-00-00', dap6='0000-00-00' WHERE peca='$pc'");
					//material
					$sqli=mysql_query("UPDATE apqp_enma SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
		}else{
			if(empty($quem1)){
				$sql=mysql_query("UPDATE apqp_cron SET resp='$quem1',fim=NOW(), perc='95' WHERE ativ='Ensaio Material' AND peca='$pc'");
			}
		}
	}
// - - - - - - - - - - - - - - - - - - - - - -  --  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - -

	$dtrep=data2banco($dtrep);
	$sql=mysql_query("UPDATE apqp_enma SET local='$locall', rep='$rep', dtrep='$dtrep', forn_mat='$forn_mat', forncod='$forncod' WHERE peca='$pc'") or erp_db_fail();
	if(isset($forn)){
		reset($forn);
		foreach($forn AS $linha => $linha2){
		// foi excluído o tipo='".$tipo[$linha]."',
			$sql=mysql_query("UPDATE apqp_enmal SET forn='".$forn[$linha]."', cli='".$cli[$linha]."', ok='".$ok[$linha]."', data_t='".data2banco($data_t[$linha])."', quant_test='".$quant_test[$linha]."' WHERE id='$linha'");
		}
	}
	if($sql){
		if(isset($ap)){
			//finalizar tarefa!!! - - - - - - - 
			$apqp->agenda("Ensaio Material");
			// - - - - - - - -  - - - - - - - - 
			if(empty($quem1)){
			$quem1=$quem;
			}
			$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Dimensional'");
			if(!mysql_num_rows($sql)){
				$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
				header("Location:apqp_enma.php");
				exit;
			}
			$sql2=mysql_query("UPDATE apqp_enma SET sit='S', quem='$quem1', dtquem=NOW() WHERE peca='$pc'");
			$sql3=mysql_query("UPDATE apqp_cron SET resp='$quem1',fim=NOW(), perc='100' WHERE ativ='Ensaio Material' AND peca='$pc'");
			// cria followup caso aprove o Ensaio Material
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Ensaio Material da peça $npc.','O usuário $quem aprovou o Ensaio Material da peça $npc.','$user')");
			//	
			if($sql2 && $sql3){
				$_SESSION["mensagem"]="Aprovado com Sucesso!";
			}else{
				$_SESSION["mensagem"]="Aprovação não concluída!";
			}			
		}elseif(isset($lap)){
			$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
			$res_status=mysql_fetch_array($sql_status);
			if($res_status["status"]=="2"){
				mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
				// cria followup caso remova a aprovação do R&R e mude o status
					mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Ensaio Material da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Ensaio Material.','$user')");
				//	
					$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Ensaio Material.");
					$apqp->email();
				//
			}else{
			// cria followup caso remove a aprovação do Ensaio Material
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Ensaio Material da peça $npc.','O usuário $quem removeu a aprovação do Ensaio Material da peça $npc.','$user')");
			//	
			}
			$sql2=mysql_query("UPDATE apqp_enma SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
			$sql3=mysql_query("UPDATE apqp_cron SET resp=' ',fim='', perc='95' WHERE ativ='Ensaio Material' AND peca='$pc'");
			if($sql2 && $sql3){
				$_SESSION["mensagem"]="Aprovação removida com Sucesso!";
				header("Location:apqp_enma.php");
				exit;
			}else{
				$_SESSION["mensagem"]="Remoção da aprovação não concluída!";
				header("Location:apqp_enma.php");
				exit;
			}
		}else if(isset($ap2)){
			if(empty($rep1)){
			$rep1=$quem;
			}
			$sql_sub=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
			if(!mysql_num_rows($sql_sub)){
				$_SESSION["mensagem"]="Não pode ser alterado pois Certificado de Submissão deve ser aprovado pelo fornecedor primeiro!!";
				header("Location:apqp_planoc.php?fase=$fase");
				exit;
			}
			$sql2=mysql_query("UPDATE apqp_enma SET rep='$rep1', dtrep=NOW() WHERE peca='$pc'");
			$sql3=mysql_query("UPDATE apqp_cron SET resp='$quem1',fim=NOW(), perc='100' WHERE ativ='Ensaio Dimensional' AND peca='$pc'");
			// cria followup caso aprove o conteudo do ensaio dimensional
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Ensaio Material da peça $npc.','O cliente $quem aprovou o Ensaio Material da peça $npc.','$user')");
			//		
			if($sql2 && $sql3){
				$_SESSION["mensagem"]="Aprovado com Sucesso!";
			}else{
				$_SESSION["mensagem"]="Aprovação não concluída!";
			}
		}elseif($maisum!=0){
			$sql=mysql_query("SELECT * FROM apqp_enmal WHERE ensaio='$id' AND car='$maisum'");
			if(!mysql_num_rows($sql)){
				$sql=mysql_query("INSERT INTO apqp_enmal (ensaio,car) VALUES ('$id','$maisum')");
				unset($_SESSION["mensagem"]);
			}else{
				$_SESSION["mensagem"]="Característica já selecionada!";
			}
		}elseif($delsel==1){
			if(isset($del)){
				foreach($del AS $linha){
					$sql=mysql_query("DELETE FROM apqp_enmal WHERE id='$linha'");
				}
				$_SESSION["mensagem"]="Linhas excluídas com sucesso";
			}else{
				$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
			}
		}
	// cria followup caso salve o conteudo do Ensaio Material
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Ensaio Material da peça $npc.','O usuário $quem salvou as alterações do Ensaio Material da peça $npc.','$user')");
	//	
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
}elseif($acao=="auto"){
	$sql=mysql_query("SELECT * FROM apqp_enma WHERE peca='$pc'");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("DELETE FROM apqp_enmal WHERE ensaio='$id'");
	$sql=mysql_query("SELECT * FROM apqp_car WHERE peca='$pc' AND tipo='Mat' ORDER BY tipo ASC,numero ASC");
	if(mysql_num_rows($sql)){
		while($res=mysql_fetch_array($sql)){
			$sql1=mysql_query("INSERT INTO apqp_enmal (ensaio,car) VALUES ('$id','$res[id]')");
		}
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo do Ensaio Material
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Ensaio Material da peça $npc.','O usuário $quem salvou as alterações do Ensaio Material da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="Nenhuma característica encontrada";
	}
}
unset($acao);
header("location:apqp_enma.php");
?>