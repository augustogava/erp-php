<?php
include("conecta.php");
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$hora=hora();
$hj=date("Y-m-d");

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if(!empty($acao)){
	$loc="APQP - Aprovação de aparencia";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="imp"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc";
	header("Location: $end");
	exit;
}
		//verificar Cliente
		$apqp->cliente_apro("apqp_aproc.php");
		// - - - - - - - -  -
if($acao=="email"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc";
	// cria followup caso envie e-mail da tabela do FMEA de projeto
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail da tabela do FMEA de projeto da peça $npc.','O usuário $quem1 enviou um e-mail com o arquivo anexo da tabela do FMEA de projeto da peça $npc para $email.','$user')");
	//				
	header("Location: $end");
	exit;
}
if($acao=="altc"){
	$data=data2banco($data);
	$sql=mysql_query("UPDATE apqp_apro SET local='$localfab', data='$data', comprador='$comprador', razao1='$razao1', razao2='$razao2', aval='$aval', coments='$coments' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da Aprovação de Aparência
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Aprovação de Aparência da peça $npc.','O usuário $quem salvou as alterações da Aprovação de Aparência da peça $npc.','$user')");
		//			
		if(isset($ap)){
			//finalizar tarefa!!! - - - - - - - 
			$apqp->agenda("Relatório de Aprovação de Aparência (Se aplicável)");
			// - - - - - - - -  - - - - - - - - 
				if(empty($quem)){
					$quem2=$quem1;
				}else{ $quem2=$quem; }
			$sql=mysql_query("UPDATE apqp_apro SET sit='S', quem='$quem2', dtquem=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET fim=NOW(),resp='$quem2', perc='100' WHERE ativ='Relatório de Aprovação de Aparência (Se aplicável)' AND peca='$pc'");
			// cria followup caso aprove a Aprovação de Aparência
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Aprovação de Aparência da peça $npc.','O usuário $quem aprovou a Aprovação de Aparência da peça $npc.','$user')");
			//							
		}elseif(isset($lap)){
			$sql=mysql_query("UPDATE apqp_apro SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET fim=NOW(),resp='', perc='95' WHERE ativ='Relatório de Aprovação de Aparência (Se aplicável)' AND peca='$pc'");
			// cria followup caso remove a aprovação da Aprovação de Aparência
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Aprovação de Aparência da peça $npc.','O usuário $quem removeu a aprovação da Aprovação de Aparência da peça $npc.','$user')");
			//				
		}
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	$gt="c";
}elseif($acao=="altt"){
	if(isset($suf)){
		reset($suf);
		foreach($suf AS $linha => $linha2){
			$sql=mysql_query("UPDATE apqp_aprol SET suf='".$suf[$linha]."', dl='".$dl[$linha]."', da='".$da[$linha]."', db='".$db[$linha]."', de='".$de[$linha]."', cmc='".$cmc[$linha]."', num='".$num[$linha]."', data='".$data[$linha]."', tipo='".$tipo[$linha]."', fonte='".$fonte[$linha]."', ent='".$ent[$linha]."' WHERE id='$linha'");
		}
		if($sql){
			$_SESSION["mensagem"]="Alterações salvas com sucesso";
			// cria followup caso salve o conteudo da Aprovação de Aparência
				$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Aprovação de Aparência da peça $npc.','O usuário $quem salvou as alterações da Aprovação de Aparência da peça $npc.','$user')");
			//			
		}else{
			$_SESSION["mensagem"]="As alterações não puderam ser salvas";
		}
	}
	if($maisum==1){
		$sql=mysql_query("SELECT * FROM apqp_apro WHERE peca='$pc'");
		if(mysql_num_rows($sql)){
			$res=mysql_fetch_array($sql);
			$apro=$res["id"];
			$sql=mysql_query("INSERT INTO apqp_aprol (apro) VALUES ('$apro')");
			unset($_SESSION["mensagem"]);
		}
	}
	if($delsel==1){
		if(isset($del)){
			foreach($del AS $linha){
				$sql=mysql_query("DELETE FROM apqp_aprol WHERE id='$linha'");
			}
			$_SESSION["mensagem"]="Linhas excluídas com sucesso";
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
	$gt="t";
}
if($gt=="c"){
	header("location:apqp_aproc.php");
}elseif($gt=="t"){
	header("location:apqp_aprot2.php");
}
?>