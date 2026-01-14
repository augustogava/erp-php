<?php
include("conecta.php");
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$wop=$_SESSION["wop"];
$quem=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$hj=date("Y-m-d");
$hora=hora();

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if(!empty($acao)){
	$loc="APQP - Fmea de Processo";
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
		$apqp->cliente_apro("apqp_fmeaprocc.php");
		// - - - - - - - -  -
///Tirar Aprovaçõesss
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
	if(mysql_num_rows($sql)){
			$sqlba=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ<>'Viabilidade' AND ativ<>'Diagrama de Fluxo'");
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
		$sql=mysql_query("UPDATE apqp_cron SET resp='$quem1', fim=NOW(), perc='95' WHERE peca='$pc' AND ativ='FMEA de Processo'");
	}
// - - - - - - - - - - - - - - - - - - - - - -  --  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - -

if($acao=="altc"){
	
	$ini=data2banco($ini);
	$rev=data2banco($rev);
	$chv=data2banco($chv);
	$sql=mysql_query("SELECT * FROM apqp_fmeaproc WHERE peca='$pc'");
	if(mysql_num_rows($sql)){
		$sql=mysql_query("UPDATE apqp_fmeaproc SET prep='$prep', resp='$resp', equipe='$equipe', obs='$obs', ini='$ini', rev='$rev', chv='$chv', numero='$numero', quem='$quem1', dtquem=NOW(), op='$op' WHERE peca='$pc'");
	}else{
		$sql=mysql_query("INSERT INTO apqp_fmeaproc (peca,prep,resp,equipe,obs,ini,rev,chv,numero,quem,dtquem,op) VALUES ('$pc','$prep','$resp','$equipe','$obs','$ini','$rev','$chv','$numero','$quem1',NOW(),'$op')");
	}
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso altere da viabilidade
		$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do FMEA de processo da peça $npc.','O usuário $quem salvou as alterações do FMEA de processo da peça $npc.','$user')");
		//
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
if(isset($ap)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("FMEA de Processo");
		// - - - - - - - -  - - - - - - - - 
	if(empty($quem1)){
	$quem1=$quem;
	}
	;$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Diagrama de Fluxo'");
	if(!mysql_num_rows($sql)){
		$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
		header("Location:apqp_fmeaprocc.php");
		exit;
	}
	$sql=mysql_query("UPDATE apqp_cron SET resp='$quem1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='FMEA de Processo'");
	$sql=mysql_query("UPDATE apqp_fmeaproc SET quem='$quem1', dtquem=NOW(), op='$op' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovado com Sucesso!";
		// cria followup caso aprove o FMEA de projeto
			$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do FMEA de processo da peça $npc.','O usuário $quem aprovou o FMEA de processo da peça $npc.','$user')");
		//			
		header("Location:apqp_planoc.php");
		exit;
}elseif(isset($lap)){
		$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
		$res_status=mysql_fetch_array($sql_status);
		if($res_status["status"]=="2"){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do FMEA de Processo da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do FMEA de Processo.','$user')");
			//	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do FMEA de Processo.");
				$apqp->email();
			//
		}else{
		// cria followup caso remova a aprovacao o FMEA de projeto
			$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do FMEA de processo da peça $npc.','O usuário $quem removeu a aprovação do FMEA de processo da peça $npc.','$user')");
		//			
		}
	$sql=mysql_query("UPDATE apqp_cron SET resp='',perc='95' WHERE peca='$pc' AND ativ='FMEA de Processo'");
	$sql=mysql_query("UPDATE apqp_fmeaproc SET quem='', dtquem='', op='$op' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso!";		
		header("Location:apqp_fmeaprocc.php");
		exit;
}
	$gt="c";
}elseif($acao=="altt"){
	if($salva==1){
	if(isset($modo)){
		foreach($modo AS $linha => $linha2){
			$sql=mysql_query("UPDATE apqp_fmeaproci SET modo='".$modo[$linha]."', efeitos='".$efeitos[$linha]."', sev='".$sev[$linha]."', icone='".$simbolo[$linha]."', causa='".$causa[$linha]."', ocor='".$ocor[$linha]."', controle='".$controle[$linha]."', controle2='".$controle2[$linha]."', det='".$det[$linha]."', npr='".$npr[$linha]."', ar='".$ar[$linha]."', resp='".$resp[$linha]."', prazo='".data2banco($prazo[$linha])."', at='".$at[$linha]."', sev2='".$sev2[$linha]."', ocor2='".$ocor2[$linha]."', det2='".$det2[$linha]."', npr2='".$npr2[$linha]."' WHERE id='$linha'");
		}
	}
		if($sql){
			$_SESSION["mensagem"]="Alterações salvas com sucesso";
			// cria followup caso altere da viabilidade
				$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do FMEA de processo da peça $npc.','O usuário $quem salvou as alterações do FMEA de processo da peça $npc.','$user')");
			//
		}else{
			$_SESSION["mensagem"]="As alterações não puderam ser salvas";
		}
		unset($modo);
	}
	if($maisum==1){
		$sql=mysql_query("SELECT * FROM apqp_fmeaproc WHERE peca='$pc'");
		if(mysql_num_rows($sql)){
				$res=mysql_fetch_array($sql);
				$fmea=$res["id"];
			if(!empty($del)){
				foreach($del as $idd=>$value){ $dela=$value; }
				$sqlo=mysql_query("SELECT ordem FROM apqp_fmeaproci WHERE id='$dela'");
				
				$reso=mysql_fetch_array($sqlo);
				$linha=$reso["ordem"];
				$sqlup=mysql_query("UPDATE apqp_fmeaproci SET ordem=ordem+1 WHERE fmea='$fmea' AND item='$wop' AND ordem>$linha");
			}else{
				$sqlb=mysql_query("SELECT MAX(ordem) AS ordem FROM apqp_fmeaproci WHERE fmea='$fmea' AND item='$wop'");
				if(mysql_num_rows($sqlb)){
					$resb=mysql_fetch_array($sqlb);
					$linha=$resb["ordem"]+1;
				}else{
					$linha=1;
				}
			}
				
				$sql=mysql_query("INSERT INTO apqp_fmeaproci (fmea,item,ordem) VALUES ('$fmea','$wop','$linha')");
				unset($_SESSION["mensagem"]);
		}
	}
	if($delsel==1){
		if(isset($del)){
			foreach($del AS $linha){
				$sql=mysql_query("DELETE FROM apqp_fmeaproci WHERE id='$linha'");
			}
			$_SESSION["mensagem"]="Linhas excluídas com sucesso";
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
	$sql=mysql_query("UPDATE apqp_fmeaproc SET quem='$quem1', dtquem=NOW(), op='$op' WHERE peca='$pc'");
	$gt="t";
}
if($gt=="c"){
	header("location:apqp_fmeaprocc.php");
}elseif($gt=="t"){
	header("location:apqp_fmeaproct2.php");
}
?>