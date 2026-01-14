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
$apqp=new set_apqp;

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//
// cria followup caso salve o conteudo do Certificado de Submissão
$sql_save=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Certificado de Submissão da peça $npc.','O usuário $quem salvou as alterações do Certificado de Submissão da peça $npc.','$user')");
//	

if(!empty($acao)){
	$loc="APQP - Certificado Submissão";
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
if($acao!="s5"){
		//verificar Cliente
		$apqp->cliente_apro("apqp_sub1.php");
		// - - - - - - - -  -
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc'");
			while($resb=mysql_fetch_array($sqlb)){
				//todos
				$sqlc=mysql_query("UPDATE apqp_cron SET resp='',perc='95',fim='' WHERE peca='$pc' AND ativ='$resb[ativ]'");
			}	
				//Sub
				$sql=mysql_query("UPDATE apqp_sub SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//Sumario
				$sql=mysql_query("UPDATE apqp_sum SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dap1='0000-00-00', dap2='0000-00-00', dap3='0000-00-00', dap4='0000-00-00', dap5='0000-00-00', dap6='0000-00-00' WHERE peca='$pc'");
				//Proocesso
				$sql=mysql_query("UPDATE apqp_fmeaproc SET quem='', dtquem='' WHERE peca='$pc'");
				//Dimensional
				$sql=mysql_query("UPDATE apqp_endi SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//material
				$sql=mysql_query("UPDATE apqp_enma SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
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
}
		
if($acao=="s1"){
	$dteng=data2banco($dteng);
	$dtalteng=data2banco($dtalteng);
	$aux_data=data2banco($aux_data);
	$peso=valor2banco($peso);
	$sql=mysql_query("UPDATE apqp_pc SET nome='$nome',desenhoi='$desenhoi',pecacli='$pecacli',niveleng='$niveleng',dteng='$dteng',alteng='$alteng',dtalteng='$dtalteng',desenhoc='$desenhoc',aplicacao='$aplicacao',peso='$peso',isrg='$isrg',ncompra='$ncompra',aux_num='$aux_num',aux_nivel='$aux_nivel',aux_data='$aux_data',idioma='$idioma',nppap='$nppap' WHERE id='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		$sql_save;
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}	
	header("location:apqp_sub1.php");
}elseif($acao=="s2"){
	$sql=mysql_query("UPDATE apqp_sub SET nota1='$nota1',nota2='$nota2',req1='$req1',req2='$req2',req3='$req3',rela1='$rela1', rela2='$rela2', imds='$imds', razao='$razao', razao_esp='$razao_esp' WHERE peca='$pc'");
	$sql=mysql_query("UPDATE apqp_pc SET cliente='$cliente',comprador='$comprador' WHERE id='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		$sql_save;
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_sub2.php");
}elseif($acao=="s3"){
	if(!empty($nivel4)){
		foreach($nivel4 as $key=>$value){
			$nivela.="$value,";
		}
	}
	$sql=mysql_query("UPDATE apqp_sub SET nivel='$nivel',nivel4='$nivela' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		$sql_save;
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_sub3.php");

}elseif($acao=="s4"){
	$sql=mysql_query("UPDATE apqp_sub SET res1='$res1',res2='$res2',res3='$res3',res4='$res4',atende='$atende',atende_pq='$atende_pq',taxa='$taxa',horas='$horas',ferram='$ferram',coments='$coments',assi_for='$assinatura' WHERE peca='$pc'");
	if($sql){
		if($ir=="sim"){
			if(empty($quem)){
				$tap1=$user;
			}else{ 
				$tap1=$quem; 
			}
		$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Material'");
		if(!mysql_num_rows($sql)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_sub4.php");
			exit;
		}
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Certificado de Submissão");
		// - - - - - - - -  - - - - - - - - 
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Certificado de Submissão'");
			$sql=mysql_query("UPDATE apqp_pc SET status='2' WHERE id='$pc'");
			$sql=mysql_query("UPDATE apqp_sub SET sit='S', quem='$tap1', dtquem=NOW() WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovado com Sucesso!";
		// cria followup caso aprove o Certificado de Submissão
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Certificado de Submissão da peça $npc.','O usuário $quem aprovou o Certificado de Submissão da peça $npc.','$user')");
		//				
		header("Location:apqp_sub4.php");
		exit;
		}elseif(isset($lap)){
		// cria followup caso remova a aprovação do R&R e mude o status
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Certificado de Submissão da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Certificado de Submissão.','$user')");
		//	
		$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Certificado de Submissão.");
		$apqp->email();
		//
		$sql=mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
		$sql=mysql_query("UPDATE apqp_sub SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
		$sql=mysql_query("UPDATE apqp_cron SET resp='', fim=NOW(), perc='95' WHERE peca='$pc' AND ativ='Certificado de Submissão'");
		$_SESSION["mensagem"]="Aprovação excluída com Sucesso!";
		header("Location:apqp_sub4.php");
		exit;
		}
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		$sql_save;
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_sub4.php");
}elseif($acao=="s5"){
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sql)){
		$_SESSION["mensagem"]="Não pode ser alterado pois Certificado de Submissão deve ser aprovado pelo fornecedor primeiro!!";
		header("Location:apqp_sub5.php");
		exit;
	}
	// Cliente Aprovou? se simmm se fudeu
		$sqlv=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
		$resv=mysql_fetch_array($sqlv);
		if($resv["status"]>2){
			$_SESSION["mensagem"]="Não pode ser alterado pois o cliente já aprovou!!";
			header("Location:apqp_sub5.php");
			exit;
		}
	switch($disp){
		case "1":
		$status="2";
		break;
		case "2":
		$status="3";
		break;
		case "3":
		$status="4";
		break;
		case "4":
		$status="5";
		break;
	}
	$hj=date("Y-m-d");
	$sql=mysql_query("UPDATE apqp_pc SET status='$status' WHERE id='$pc'");
	$sql=mysql_query("UPDATE apqp_sub SET disp='$disp',disp_pq='$disp_pq',aprocli_dt='$hj',assi_cli='$assinatura',comentario='$comentario' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		$sql_save;
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_sub5.php");
}
unset($acao);
?>