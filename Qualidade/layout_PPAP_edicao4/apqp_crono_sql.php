<?
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$quem1=$_SESSION["login_nome"];
$user_apro=$_SESSION["login_codigo"];
$hora=hora();
$hj=date("Y-m-d");
if(!empty($acao)){
	$loc="APQP - Cronograma";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
//$descricao=htmlspecialchars($descricao);
//$obs=htmlspecialchars($obs);
if($acao=="imp" or $acao=="email"){
		if($acao=="imp"){
		// cria followup caso faça impressão do cronograma
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Cronograma.','O usuário $quem1 efetuou a impressão do Cronograma da peça $npc.','$user_apro')");
		//
		}
	header("Location:apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc");
	exit;
}
		//verificar Cliente
		$apqp->cliente_apro("apqp_crono.php");
		// - - - - - - - -  -
	///Tirar Aprovaçõesss pra frente
	$passa="S";
	$sql=mysql_query("SELECT * FROM apqp_pc WHERE crono_apro='S' AND id='$pc'");
	if(mysql_num_rows($sql)){
			$sqlba=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc'");
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
				//Cronograma
				$sqlh=mysql_query("UPDATE apqp_pc SET crono_apro='N',crono_quem='',crono_dtquem='' WHERE id='$pc'");
				//RR
				$sqlg=mysql_query("UPDATE apqp_rr SET sit=0,quem='', dtquem='' WHERE peca='$pc'");
				//plano
				$sqlf=mysql_query("UPDATE apqp_plano SET sit='N', quem='', dtquem='' WHERE peca='$pc'");
				//Viabilidade
				$sqlv=mysql_query("UPDATE apqp_viabilidade SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dt1='0000-00-00',dt2='0000-00-00',dt3='0000-00-00',dt4='0000-00-00',dt5='0000-00-00',dt6='0000-00-00' WHERE peca='$pc'");
				$passa="N";
				$sql=mysql_query("DELETE FROM agenda WHERE pc='$pc'") or die("nao exc");
	}

if($acao=="inc"){

	// cria followup caso faça inclusão de uma nova atividade no cronograma
	$sql_emp=mysql_query("SELECT fantasia FROM empresa");
	$res_emp=mysql_fetch_array($sql_emp);
	mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de uma nova atividade no Cronograma.','O usuário $quem1 incluiu uma nova atividade no Cronograma da peça $npc.','$user_apro')");
	//

	$ini=data2banco($ini);
	$prazo=data2banco($prazo);
	$fim=data2banco($fim);
	if($pos=="fim"){
		$sql=mysql_query("SELECT MAX(pos) AS pos FROM apqp_cron WHERE peca='$pc'");
		if(mysql_num_rows($sql)==0){
			$pos=0;
		}else{
			$res=mysql_fetch_array($sql);
			$pos=$res["pos"]+1;
		}
	}else{
		$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");
		if(mysql_num_rows($sql)==0){
			$pos=0;
		}else{
			while($res=mysql_fetch_array($sql)){
				if($res["pos"]>$pos){
					$sql2=mysql_query("UPDATE apqp_cron SET pos=(pos+1) WHERE id='$res[id]'");
				}
			}
		}
	}
	$pos++;
	$sql=mysql_query("INSERT INTO apqp_cron (peca,ativ,ini,prazo,fim,perc,obs,pos) VALUES ('$pc','$ativ','$ini','$prazo','$fim','$perc','$obs','$pos')");
	if($sql){
		$_SESSION["mensagem"]="Atividade incluída com sucesso";
	}else{
		$_SESSION["mensagem"]="A atividade não pôde ser incluída";
		$comp="?acao=inc";
	}
}elseif($acao=="alt"){

	// cria followup caso faça alteração no cronograma
	$sql_emp=mysql_query("SELECT fantasia FROM empresa");
	$res_emp=mysql_fetch_array($sql_emp);
	mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do Cronograma.','O usuário $quem1 alterou o Cronograma da peça $npc.','$user_apro')");
	//

	if(isset($ap)){
		if(empty($quem)){
		$user=$quem1;
		}else{ $user=$quem; }
		$sql=mysql_query("UPDATE apqp_pc SET crono_apro='S', crono_quem='$user', crono_dtquem=NOW() WHERE id='$pc'");
		reset($ativ); 
		while (list($key, $val) = each($ativ)) {  
			  $ids[]=$key;
		}
		reset($ids);
		
		// cria followup de aprovação fora do looping
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Agendamento de compromisso $npc.','O usuário $quem1 aprovou o Cronograma da peça $npc.','$user_apro')");
		//
		
		while (list($key, $val) = each($ids)) {  
			$responsavel1=$responsavel[$val];
			$ativ1=$ativ[$val];
			if(empty($ini1)) $ini1="00/00/0000";
			if(empty($prazo1)) $prazo1="00/00/0000";
			if(empty($fim1)) $fim1="00/00/0000";
			$ini1=data2banco($ini[$val]);
			$prazo1=data2banco($prazo[$val]);
			$fim1=data2banco($fim[$val]);
			if(!empty($responsavel1)){
				//envia agenda ao responsável pelo estudo
				$inicio=banco2data($ini1);
				$fim=banco2data($prazo1);
				mysql_query("INSERT INTO agenda (pc,estudo,nome,texto,titulo,data,hora,user_apro,reagendada) VALUES ('$pc','$ativ1','$responsavel1','$responsavel1, você é responsável pela execução do estudo $ativ1 que tem início no dia $inicio com data de término prevista para $fim.','$ativ1 - $npc','$hj','$hora', '$user_apro','S')");
				
				mysql_query("UPDATE apqp_cron SET responsavel='$responsavel1' WHERE id='$val'");
				//

				// cria followup de cada usuário responsável pela atividade
				$sql_emp=mysql_query("SELECT fantasia FROM empresa");
				$res_emp=mysql_fetch_array($sql_emp);
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Agendamento de compromisso $npc.','O usuário $responsavel1 é responsável pela execução do estudo $ativ1 da peça $npc que tem início no dia $inicio com data de término prevista para $fim.','$user_apro')");
				//
								
				// envia e-mail ao responsável pela atividade
				$sql3=mysql_query("SELECT id FROM funcionarios WHERE nome='$responsavel1'");	
				$res3=mysql_fetch_array($sql3);
				$sql4=mysql_query("SELECT * FROM funcionarios WHERE id='$res3[id]'");	
				$res4=mysql_fetch_array($sql4);
				$sql5=mysql_query("SELECT id FROM funcionarios WHERE nome='$quem1'");	
				$res5=mysql_fetch_array($sql5);
				$sql6=mysql_query("SELECT * FROM funcionarios WHERE id='$res5[id]'");	
				$res6=mysql_fetch_array($sql6);
				$mensagem="$responsavel1, você é responsável pela execução da atividade $ativ1 que tem início no dia $inicio com data de término prevista para $fim.";
				$from="From: $quem1<$res6[email]>";
				mail($res4["email"],"$ativ1 - $npc'",$mensagem,$from);
				//
			}
		}
		
		$_SESSION["mensagem"]="Aprovado com Sucesso!";
		header("Location:apqp_crono.php$comp");
		exit;
	}elseif(isset($lap)){
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Cronograma da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Cronograma','$user')");
		$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Cronograma");
		$apqp->email();

		$sql=mysql_query("DELETE FROM agenda WHERE pc='$pc'") or die("nao exc");
		$sql=mysql_query("UPDATE apqp_pc SET crono_apro='N', crono_quem='', crono_dtquem='0000-00-00' WHERE id='$pc'") or die("eRRO");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
		header("Location:apqp_crono.php$comp");
		exit;
	}
	reset($ativ); 
	while (list($key, $val) = each($ativ)) {
		  $ids[]=$key;
	}
	reset($ids);
	while (list($key, $val) = each($ids)) {  
		$ativ1=$ativ[$val];
		$resp1=$resp[$val];
		$responsavel1=$responsavel[$val];
		//if(empty($ini1)) $ini1="00/00/0000";
		//if(empty($prazo1)) $prazo1="00/00/0000";
		$ini1=data2banco($ini[$val]);
		$prazo1=data2banco($prazo[$val]);
		$fim1=data2banco($fim[$val]);
		$perc1=$perc[$val];
		if(empty($fim1)){ $fim1=""; }else{ $perc1="100"; $resp1=$quem1; };
		$obs1=$obs[$val];
		if(empty($responsavel1)){
			$resp1="";
			$perc1="0";
			$fim1="";
			$ini1="";
			$prazo1="";
			$fim1="";
		}
		if($passa=="S"){
			$sql=mysql_query("UPDATE apqp_cron SET ativ='$ativ1',resp='$resp1',responsavel='$responsavel1',ini='$ini1',prazo='$prazo1',fim='$fim1',perc='$perc1',obs='$obs1' WHERE id='$val'");
		}
				
		if($sql) $count2++;
	}
/*
	// Tirar Aprovações
	$sql=mysql_query("SELECT * FROM apqp_pc WHERE crono_apro='S' AND id='$pc'");
	if(mysql_num_rows($sql)){
			$sqlba=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc'");
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
				//Crono
				$sqle=mysql_query("UPDATE apqp_pc SET crono_apro='N', crono_quem='', crono_dtquem='' WHERE id='$pc'");
				//Viabilidade
				$sqld=mysql_query("UPDATE apqp_viabilidade SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dt1='0000-00-00',dt2='0000-00-00',dt3='0000-00-00',dt4='0000-00-00',dt5='0000-00-00',dt6='0000-00-00' WHERE peca='$pc'");

	}
// - - - - - - - - - - - - - - - - - - - - - -  --  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - -
*/
	if(count($ativ)==$count2){
		$_SESSION["mensagem"]="Cronograma alterado com sucesso";
	}else{
		$_SESSION["mensagem"]="O cronograma não pôde ser alterado";
		$comp="?acao=alt";
	}
}elseif($acao=="exc"){
	$sql=mysql_query("DELETE FROM apqp_cron WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Atividade excluída com sucesso";
	}else{
		$_SESSION["mensagem"]="A atividade não pôde ser excluída";
	}
	// cria followup caso exclua o cronograma
	$sql_emp=mysql_query("SELECT fantasia FROM empresa");
	$res_emp=mysql_fetch_array($sql_emp);
	mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão do Cronograma.','O usuário $quem1 excluiu a atividade do Cronograma da peça $npc.','$user_apro')");
	//
}
/*if($acao=="salvar"){
	// cria followup caso salve o relatório do cronograma em disco
	$sql_emp=mysql_query("SELECT fantasia FROM empresa");
	$res_emp=mysql_fetch_array($sql_emp);
	mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvar relatório do Cronograma em disco.','O usuário $quem1 salvou o Cronograma da peça $npc em disco.')");
	print "INSERT INTO followup (empresa,data,hora,titulo,descricao) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvar relatório do Cronograma em disco.','O usuário $quem1 salvou o Cronograma da peça $npc em disco.')";
	//
}*/

header("Location:apqp_crono.php$comp");
exit;
?>