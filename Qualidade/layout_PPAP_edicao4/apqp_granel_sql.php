<?php
include("conecta.php");
$acao=Input::request("acao");
$local=Input::request("local");
$email=Input::request("email");
$prazo=Input::request("prazo", []);
$rcli=Input::request("rcli", []);
$rfor=Input::request("rfor", []);
$coments=Input::request("coments", []);
$por=Input::request("por", []);
$ap1=Input::request("ap1");
$ap2=Input::request("ap2");
$ap3=Input::request("ap3");
$lap1=Input::request("lap1");
$lap2=Input::request("lap2");
$lap3=Input::request("lap3");
$tap1=Input::request("tap1");
$tap12=Input::request("tap12");
$tap13=Input::request("tap13");
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
	$loc="APQP - Checklist a Granel";
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
		$apqp->cliente_apro("apqp_granel.php");
		// - - - - - - - -  -
if($acao=="altt"){
	if(isset($prazo)){
		reset($prazo);
		foreach($prazo AS $linha => $linha2){
			$sql=mysql_query("UPDATE apqp_granel2 SET prazo='".$prazo[$linha]."', rcli='".$rcli[$linha]."', rfor='".$rfor[$linha]."', coments='".$coments[$linha]."', por='".$por[$linha]."' WHERE id='$linha'");
		}
		if($sql){
			$_SESSION["mensagem"]="Alterações salvas com sucesso";
			// cria followup caso salve o conteudo do Checklist Material a Granel
				$sql_save=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Checklist Material a Granel da peça $npc.','O usuário $quem salvou as alterações do Checklist Material a Granel da peça $npc.','$user')");
			//	
		}else{
			$_SESSION["mensagem"]="As alterações não puderam ser salvas";
		}
	}
	header("location:apqp_granelt2.php");
}elseif($acao=="g2"){
	if(isset($ap1)){
		$sql=mysql_query("SELECT * FROM apqp_granel WHERE ap1='' AND dap1='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			if(empty($tap1)){
				$tap1=$quem;
			}
			$sql=mysql_query("UPDATE apqp_granel SET ap1='$tap1', dap1=NOW() WHERE peca='$pc'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Checklist Material a Granel
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Checklist Material a Granel da peça $npc.','O usuário $quem aprovou o Checklist Material a Granel da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($ap2)){
		$sql=mysql_query("SELECT * FROM apqp_granel WHERE ap2='' AND dap2='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			if(empty($tap12)){
				$tap12=$quem;
			}
			$sql=mysql_query("UPDATE apqp_granel SET ap2='$tap12', dap2=NOW() WHERE peca='$pc'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Checklist Material a Granel
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Checklist Material a Granel da peça $npc.','O usuário $quem aprovou o Checklist Material a Granel da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($ap3)){
		$sql=mysql_query("SELECT * FROM apqp_granel WHERE ap3='' AND dap3='0000-00-00' AND peca='$pc'");
		if(mysql_num_rows($sql)){
			if(empty($tap13)){
				$tap13=$quem;
			}
			$sql=mysql_query("UPDATE apqp_granel SET ap3='$tap13', dap3=NOW() WHERE peca='$pc'");
			$_SESSION["mensagem"]="Aprovação concluída com sucesso";
			// cria followup caso aprove o Checklist Material a Granel
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Checklist Material a Granel da peça $npc.','O usuário $quem aprovou o Checklist Material a Granel da peça $npc.','$user')");
			//				
		}else{
			$_SESSION["mensagem"]="Esta posição já está ocupada";
		}
	}elseif(isset($lap1)){
		$sql=mysql_query("UPDATE apqp_granel SET ap1='', dap1='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Checklist Material a Granel
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Checklist Material a Granel da peça $npc.','O usuário $quem removeu a aprovação do Checklist Material a Granel da peça $npc.','$user')");
		//	
	}elseif(isset($lap2)){
		$sql=mysql_query("UPDATE apqp_granel SET ap2='', dap2='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Checklist Material a Granel
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Checklist Material a Granel da peça $npc.','O usuário $quem removeu a aprovação do Checklist Material a Granel da peça $npc.','$user')");
		//	
	}elseif(isset($lap3)){
		$sql=mysql_query("UPDATE apqp_granel SET ap3='', dap3='0000-00-00' WHERE peca='$pc'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
		// cria followup caso remove a aprovação do Checklist Material a Granel
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Checklist Material a Granel da peça $npc.','O usuário $quem removeu a aprovação do Checklist Material a Granel da peça $npc.','$user')");
		//	
	}
	header("location:apqp_granel.php");
}
unset($acao);
?>