<?
include("conecta.php");
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$quem=$_SESSION["login_nome"];
$quemc=$_SESSION["login_cargo"];
$user=$_SESSION["login_codigo"];
$hj=date("Y-m-d");
$hora=hora();
$apqp=new set_apqp;

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if(!empty($acao)){
	$loc="APQP - Viabilidade";
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
$sql_ap=mysql_query("SELECT * FROM apqp_viabilidade WHERE peca='$pc' AND (ap1='$quem' OR ap2='$quem' OR ap3='$quem' OR ap4='$quem' OR ap5='$quem' OR ap6='$quem')");
$res_ap=mysql_num_rows($sql_ap);
//print "($res_ap<1) or !($acao==v4)";
if((isset($lap1) or isset($lap2) or isset($lap3) or isset($lap4) or isset($lap5) or isset($lap6)) or ($res_ap<1)){
		//verificar Cliente
		$apqp->cliente_apro("apqp_viabilidade1.php");
		// - - - - - - - -  -


///Tirar Aprovaçõesss
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Viabilidade'");
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
				//Viabilidade
				$sqld=mysql_query("UPDATE apqp_viabilidade SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dt1='0000-00-00',dt2='0000-00-00',dt3='0000-00-00',dt4='0000-00-00',dt5='0000-00-00',dt6='0000-00-00' WHERE peca='$pc'");

	}
}
// - - - - - - - - - - - - - - - - - - - - - -  --  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - -

if($acao=="v1"){
	$sql=mysql_query("UPDATE apqp_viabilidade SET sn1='$sn1',sn2='$sn2',sn3='$sn3',sn4='$sn4',sn5='$sn5',sn6='$sn6',sn7='$sn7',sn8='$sn8',sn9='$sn9',sn10='$sn10',sn11='$sn11',sn12='$sn12',sn13='$sn13' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da viabilidade
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Viabilidade da peça $npc.','O usuário $quem salvou as alterações da Viabilidade da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}	
	header("location:apqp_viabilidade1.php");
}elseif($acao=="v2"){
	$sql=mysql_query("UPDATE apqp_viabilidade SET obs='$obs' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da viabilidade
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Viabilidade da peça $npc.','O usuário $quem salvou as alterações da Viabilidade da peça $npc.','$user')");
		//	
		}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_viabilidade2.php");
}elseif($acao=="v3"){
	$data=data2banco($data);
	$sql=mysql_query("UPDATE apqp_viabilidade SET conclusao='$conclusao', data='$data' WHERE peca='$pc'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da viabilidade
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Viabilidade da peça $npc.','O usuário $quem salvou as alterações da Viabilidade da peça $npc.','$user')");
		//	
		}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_viabilidade3.php");
}elseif($acao=="v4"){
	if(isset($ap1) or isset($ap2) or isset($ap3) or isset($ap4) or isset($ap5) or isset($ap6)){
		$sql=mysql_query("SELECT * FROM apqp_pc WHERE crono_apro='S' AND id='$pc'");
		if(!mysql_num_rows($sql)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_viabilidade4.php");
			exit;
		}
	}	

	
	if(isset($ap1)){
			if($res_ap>0){
				$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
				header("location:apqp_viabilidade4.php");
				exit;
			}
		$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE ap1='' AND dt1='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			if(empty($tap1)){
				$tap1=$quem;
			}
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap1='$tap1', dt1=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Viabilidade'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o conteudo da viabilidade
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Viabilidade da peça $npc.','O usuário $quem aprovou a Viabilidade da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($lap1)){
		$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
		$res_status=mysql_fetch_array($sql_status);
		if($res_status["status"]=="2"){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação da Viabilidade.','$user')");
			//	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Viabilidade.");
				$apqp->email();
			//
		}else{
			// cria followup caso remove a aprovação 1 da viabilidade 
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da Viabilidade da peça $npc.','$user')");
			//	
		}
		$sql=mysql_query("UPDATE apqp_viabilidade SET ap1='', dt1='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		
	}elseif(isset($ap2)){
		if($res_ap>0){
			$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
			header("location:apqp_viabilidade4.php");
			exit;
		}
		if(empty($tap12)){
			$tap12=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE ap2='' AND dt2='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap2='$tap12', dt2=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap12', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Viabilidade'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o conteudo da viabilidade
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Viabilidade da peça $npc.','O usuário $quem aprovou a Viabilidade da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($lap2)){
		$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
		$res_status=mysql_fetch_array($sql_status);
		if($res_status["status"]=="2"){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação da Viabilidade.','$user')");
			//	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Viabilidade.");
				$apqp->email();
			//
		}else{
			// cria followup caso remove a aprovação 2 da viabilidade 
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da Viabilidade da peça $npc.','$user')");
			//	
		}
		$sql=mysql_query("UPDATE apqp_viabilidade SET ap2='', dt2='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";


	}elseif(isset($ap3)){
		if($res_ap>0){
			$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
			header("location:apqp_viabilidade4.php");
			exit;
		}
		if(empty($tap13)){
			$tap13=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE ap3='' AND dt3='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap3='$tap13', dt3=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap13', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Viabilidade'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o conteudo da viabilidade
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Viabilidade da peça $npc.','O usuário $quem aprovou a Viabilidade da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($lap3)){
		$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
		$res_status=mysql_fetch_array($sql_status);
		if($res_status["status"]=="2"){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação da Viabilidade.','$user')");
			//	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Viabilidade.");
				$apqp->email();
			//
		}else{
			// cria followup caso remove a aprovação 3 da viabilidade
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da Viabilidade da peça $npc.','$user')");
			//	
		}
		$sql=mysql_query("UPDATE apqp_viabilidade SET ap3='', dt3='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		

	}elseif(isset($ap4)){
		if($res_ap>0){
			$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
			header("location:apqp_viabilidade4.php");
			exit;
		}
		if(empty($tap14)){
			$tap14=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE ap4='' AND dt4='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap4='$tap14', dt4=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap14', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Viabilidade'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o conteudo da viabilidade
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Viabilidade da peça $npc.','O usuário $quem aprovou a Viabilidade da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($lap4)){
		$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
		$res_status=mysql_fetch_array($sql_status);
		if($res_status["status"]=="2"){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação da Viabilidade.','$user')");
			//	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Viabilidade.");
				$apqp->email();
			//
		}else{
		// cria followup caso remove a aprovação 4 da viabilidade
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da Viabilidade da peça $npc.','$user')");
		//	
		}
		$sql=mysql_query("UPDATE apqp_viabilidade SET ap4='', dt4='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";

	}elseif(isset($ap5)){
		if($res_ap>0){
			$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
			header("location:apqp_viabilidade4.php");
			exit;
		}
		if(empty($tap15)){
			$tap15=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE ap5='' AND dt5='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap5='$tap15', dt5=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap15', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Viabilidade'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o conteudo da viabilidade
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Viabilidade da peça $npc.','O usuário $quem aprovou a Viabilidade da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($lap5)){
		$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
		$res_status=mysql_fetch_array($sql_status);
		if($res_status["status"]=="2"){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação da Viabilidade.','$user')");
			//	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Viabilidade.");
				$apqp->email();
			//
		}else{
		// cria followup caso remove a aprovação 5 da viabilidade
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da Viabilidade da peça $npc.','$user')");
		//	
		}
		$sql=mysql_query("UPDATE apqp_viabilidade SET ap5='', dt5='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";

		
	}elseif(isset($ap6)){
		if($res_ap>0){
			$_SESSION["mensagem"]="O Sistema não permite que um mesmo usuário aprove duas vezes o mesmo Estudo.";
			header("location:apqp_viabilidade4.php");
			exit;
		}
		if(empty($tap16)){
			$tap16=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE ap6='' AND dt6='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap6='$tap16', dt6=NOW() WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap16', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='Viabilidade'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o conteudo da viabilidade
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Viabilidade da peça $npc.','O usuário $quem aprovou a Viabilidade da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($lap6)){
		$sql_status=mysql_query("SELECT status FROM apqp_pc WHERE id='$pc'");
		$res_status=mysql_fetch_array($sql_status);
		if($res_status["status"]=="2"){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação da Viabilidade.','$user')");
			//	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Viabilidade.");
				$apqp->email();
			//
		}else{
		// cria followup caso remove a aprovação 6 da viabilidade
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Viabilidade da peça $npc.','O usuário $quem removeu a aprovação da Viabilidade da peça $npc.','$user')");
		//	
		}
		$sql=mysql_query("UPDATE apqp_viabilidade SET ap6='', dt6='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";

	}else if(isset($hp)){
		$dt1=data2banco($dt1);
		$dt2=data2banco($dt2);
		$dt3=data2banco($dt3);
		$dt4=data2banco($dt4);
		$dt5=data2banco($dt5);
		$dt6=data2banco($dt6);

			$sql=mysql_query("UPDATE apqp_viabilidade SET ap1='$tap1', dt1='$dt1' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap2='$tap12', dt2='$dt2' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap3='$tap13', dt3='$dt3' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap4='$tap14', dt4='$dt4' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap5='$tap15', dt5='$dt5' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_viabilidade SET ap6='$tap16', dt6='$dt6' WHERE peca='$pc'");
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap1', fim=NOW(), perc='95' WHERE peca='$pc' AND ativ='Viabilidade'");

		// cria followup caso salve o conteudo da viabilidade
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Viabilidade da peça $npc.','O usuário $quem salvou as alterações da Viabilidade da peça $npc.','$user')");
		//	
	}
	$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE peca='$pc'");
	$res=mysql_fetch_array($sql);
	if((empty($res["ap1"]))&&(empty($res["ap2"]))&&(empty($res["ap3"]))&&(empty($res["ap4"]))&&(empty($res["ap5"]))&&(empty($res["ap6"]))){
		mysql_query("UPDATE apqp_cron SET resp='', fim='', perc='95' WHERE peca='$pc' AND ativ='Viabilidade'");
	}
	header("location:apqp_viabilidade4.php");
}
?>