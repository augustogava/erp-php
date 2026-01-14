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
	$loc="APQP - Ensaio Desempenho";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="imp"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc";
	unset($acao);
	header("Location: $end");
	exit;
}
if($acao=="email"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc";
	unset($acao);
	header("Location: $end");
	exit;
}
		//verificar Cliente
		if($_SESSION["login_funcionario"]=="S"){
			$apqp->cliente_apro("apqp_ende.php");
		}
		// - - - - - - - -  -
if($acao=="alt"){
	$dtrep=data2banco($dtrep);
	$sql=mysql_query("UPDATE apqp_ende SET local='$locall', rep='$rep', dtrep='$dtrep', forncod='$forncod' WHERE peca='$pc'");
	if(empty($quem1)){
		$sql=mysql_query("UPDATE apqp_cron SET resp='$quem1',fim=NOW(), perc='95' WHERE ativ='Ensaio Desempenho' AND peca='$pc'");
	}
	if(isset($forn)){
		reset($forn);
		foreach($forn AS $linha => $linha2){
			$sql=mysql_query("UPDATE apqp_endel SET forn='".$forn[$linha]."', cli='".$cli[$linha]."', ok='".$ok[$linha]."', data_t='".data2banco($data_t[$linha])."', quant_test='".$quant_test[$linha]."' WHERE id='$linha'");
		}
	}
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo do Ensaio de Desempenho
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Ensaio de Desempenho da peça $npc.','O usuário $quem salvou as alterações do Ensaio de Desempenho da peça $npc.','$user')");
		//		
		
		if(isset($ap)){
			//finalizar tarefa!!! - - - - - - - 
			$apqp->agenda("Ensaio Desempenho");
			// - - - - - - - -  - - - - - - - - 
			if(empty($quem1)){
			$quem1=$quem;
			}
			$sql2=mysql_query("UPDATE apqp_ende SET sit='S', quem='$quem1', dtquem=NOW() WHERE peca='$pc'");
			$sql3=mysql_query("UPDATE apqp_cron SET resp='$quem1',fim=NOW(), perc='100' WHERE ativ='Ensaio Desempenho' AND peca='$pc'");
			// cria followup caso aprove o Ensaio de Desempenho
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Ensaio de Desempenho da peça $npc.','O usuário $quem aprovou o Ensaio de Desempenho da peça $npc.','$user')");
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
			//print "$res_status[status]";
			// cria followup caso remove a aprovação do Ensaio de Desempenho
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Ensaio de Desempenho da peça $npc.','O usuário $quem removeu a aprovação do Ensaio de Desempenho da peça $npc.','$user')");
			//	
			}
			$sql2=mysql_query("UPDATE apqp_ende SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
			$sql3=mysql_query("UPDATE apqp_sub SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
			$sql4=mysql_query("UPDATE apqp_cron SET resp='',fim='', perc='95' WHERE ativ='Ensaio Desempenho' AND peca='$pc'");
			$sql5=mysql_query("UPDATE apqp_cron SET resp='',fim='', perc='95' WHERE ativ='Certificado de Submissão' AND peca='$pc'");			
			if($sql2 && $sql3 && $sql4 && $sql5){
				$_SESSION["mensagem"]="Aprovação removida com Sucesso!";
				header("Location:apqp_ende.php");
				exit;
			}else{
				$_SESSION["mensagem"]="Remoção da aprovação não concluída!";
				header("Location:apqp_ende.php");
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
			$sql2=mysql_query("UPDATE apqp_ende SET rep='$rep1', dtrep=NOW() WHERE peca='$pc'");
			$sql3=mysql_query("UPDATE apqp_cron SET resp='$quem1',fim=NOW(), perc='100' WHERE ativ='Ensaio Dimensional' AND peca='$pc'");
			// cria followup caso aprove o conteudo do ensaio dimensional
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Ensaio de Desempenho da peça $npc.','O cliente $quem aprovou o Ensaio de Desempenho da peça $npc.','$user')");
			//		
			if($sql2 && $sql3){
				$_SESSION["mensagem"]="Aprovado com Sucesso!";
			}else{
				$_SESSION["mensagem"]="Aprovação não concluída!";
			}

		}elseif($maisum!=0){
			$sql=mysql_query("SELECT * FROM apqp_endel WHERE ensaio='$id' AND car='$maisum'");
			if(!mysql_num_rows($sql)){
				$sql=mysql_query("INSERT INTO apqp_endel (ensaio,car) VALUES ('$id','$maisum')");
				unset($_SESSION["mensagem"]);
			}else{
				$_SESSION["mensagem"]="Característica já selecionada!";
			}
		}elseif($delsel==1){
			if(isset($del)){
				foreach($del AS $linha){
					$sql=mysql_query("DELETE FROM apqp_endel WHERE id='$linha'");
				}
				$_SESSION["mensagem"]="Linhas excluídas com sucesso";
			}else{
				$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
			}
		}
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
}elseif($acao=="auto"){
	$sql=mysql_query("SELECT * FROM apqp_ende WHERE peca='$pc'");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("DELETE FROM apqp_endel WHERE ensaio='$id'");
	$sql=mysql_query("SELECT * FROM apqp_car WHERE peca='$pc' AND tipo='Des' ORDER BY tipo ASC,numero ASC");
	if(mysql_num_rows($sql)){
		while($res=mysql_fetch_array($sql)){
			$sql1=mysql_query("INSERT INTO apqp_endel (ensaio,car) VALUES ('$id','$res[id]')");
		}
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo do Ensaio de Desempenho
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Ensaio de Desempenho da peça $npc.','O usuário $quem salvou as alterações do Ensaio de Desempenho da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="Nenhuma característica encontrada";
	}
}
unset($acao);
header("location:apqp_ende.php");
?>