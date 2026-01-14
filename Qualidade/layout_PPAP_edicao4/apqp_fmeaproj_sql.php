<?php
include("conecta.php");
$acao=Input::request("acao");
$local=Input::request("local");
$email=Input::request("email");
$ini=Input::request("ini");
$rev=Input::request("rev");
$chv=Input::request("chv");
$prep=Input::request("prep");
$resp=Input::request("resp");
$equipe=Input::request("equipe");
$obs=Input::request("obs");
$numero=Input::request("numero");
$op=Input::request("op");
$ap=Input::request("ap");
$lap=Input::request("lap");
$salva=Input::request("salva");
$maisum=Input::request("maisum");
$delsel=Input::request("delsel");
$del=Input::request("del", []);
$modo=Input::request("modo", []);
$efeitos=Input::request("efeitos", []);
$sev=Input::request("sev", []);
$simbolo=Input::request("simbolo", []);
$causa=Input::request("causa", []);
$ocor=Input::request("ocor", []);
$controle=Input::request("controle", []);
$controle2=Input::request("controle2", []);
$det=Input::request("det", []);
$npr=Input::request("npr", []);
$ar=Input::request("ar", []);
$prazo=Input::request("prazo", []);
$at=Input::request("at", []);
$sev2=Input::request("sev2", []);
$ocor2=Input::request("ocor2", []);
$det2=Input::request("det2", []);
$npr2=Input::request("npr2", []);
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$wop=$_SESSION["wop"];
$quem=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$hora=hora();
$hj=date("Y-m-d");
// buscar nome da empresa para usar no followup
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if(!empty($acao)){
	$loc="APQP - Fmea de Projeto";
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
		$apqp->cliente_apro("apqp_fmeaprojc.php");
		// - - - - - - - -  -
if($acao=="altc"){
	$sql=mysql_query("UPDATE apqp_cron SET resp='$quem1', fim=NOW(), perc='95' WHERE peca='$pc' AND ativ='FMEA de Projeto (Se aplicável)'");
	$ini=data2banco($ini);
	$rev=data2banco($rev);
	$chv=data2banco($chv);
	$sql=mysql_query("SELECT * FROM apqp_fmeaproj WHERE peca='$pc'");
	if(mysql_num_rows($sql)){
		$sql=mysql_query("UPDATE apqp_fmeaproj SET prep='$prep', resp='$resp', equipe='$equipe', obs='$obs', ini='$ini', rev='$rev', chv='$chv', numero='$numero', quem='$quem', dtquem=NOW(), op='$op' WHERE peca='$pc'");
	}else{
		$sql=mysql_query("INSERT INTO apqp_fmeaproj (peca,prep,resp,equipe,obs,ini,rev,chv,numero,quem,dtquem,op) VALUES ('$pc','$prep','$resp','$equipe','$obs','$ini','$rev','$chv','$numero','$quem',NOW(),'$op')");
	}
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve as alterações do FMEA de projeto
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando o FMEA de projeto da peça $npc.','O usuário $quem salvou as alterações do FMEA de projeto da peça $npc.','$user')");
		//
	}else{
		$_SESSION["mensagem"]="As alterações não poderam ser salvas";
	}
	if(isset($ap)){
		if(empty($quem1)){
		$quem1=$quem;
		}
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("FMEA de Projeto (Se aplicável)");
		// - - - - - - - -  - - - - - - - - 
		$sql=mysql_query("UPDATE apqp_cron SET resp='$quem1', fim=NOW(), perc='100' WHERE peca='$pc' AND ativ='FMEA de Projeto (Se aplicável)'") or erp_db_fail();
		$sql=mysql_query("UPDATE apqp_fmeaproj SET sit='S', quem='$quem1', dtquem=NOW(), op='$op' WHERE peca='$pc'") or erp_db_fail();
			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso o FMEA de projeto seja aprovado 
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do FMEA de projeto da peça $npc.','O usuário $quem aprovou o FMEA de projeto da peça $npc.','$user')");
			//		
			header("Location:apqp_fmeaprojc.php");
			exit;
	}elseif(isset($lap)){
		$sql=mysql_query("UPDATE apqp_cron SET resp='' WHERE peca='$pc' AND ativ='FMEA de Projeto (Se aplicável)'");
		$sql=mysql_query("UPDATE apqp_fmeaproj SET sit='N', quem='', dtquem='', op='$op' WHERE peca='$pc'");
			$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
			// cria followup caso o FMEA de projeto seja aprovado 
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do FMEA de projeto da peça $npc.','O usuário $quem removeu a aprovação do FMEA de projeto da peça $npc.','$user')");
			//		
			header("Location:apqp_fmeaprojc.php");
			exit;
	}
	$gt="c";
}elseif($acao=="altt"){
	if($salva==1){
		reset($modo);
		foreach($modo AS $linha => $linha2){
			$sql=mysql_query("UPDATE apqp_fmeaproji SET modo='".$modo[$linha]."', efeitos='".$efeitos[$linha]."', sev='".$sev[$linha]."', icone='".$simbolo[$linha]."', causa='".$causa[$linha]."', ocor='".$ocor[$linha]."', controle='".$controle[$linha]."', controle2='".$controle2[$linha]."', det='".$det[$linha]."', npr='".$npr[$linha]."', ar='".$ar[$linha]."', resp='".$resp[$linha]."', prazo='".data2banco($prazo[$linha])."', at='".$at[$linha]."', sev2='".$sev2[$linha]."', ocor2='".$ocor2[$linha]."', det2='".$det2[$linha]."', npr2='".$npr2[$linha]."' WHERE id='$linha'");
		}
		if($sql){
			$_SESSION["mensagem"]="Alterações salvas com sucesso";
			// cria followup caso salve as alterações do cabeçalho do FMEA de projeto
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando o FMEA de projeto da peça $npc.','O usuário $quem salvou as alterações do FMEA de projeto da peça $npc.','$user')");
			//							
		}else{
			$_SESSION["mensagem"]="As alterações não puderam ser salvas";
		}
	}
	if($maisum==1){
		$sql=mysql_query("SELECT * FROM apqp_fmeaproj WHERE peca='$pc'");
		if(mysql_num_rows($sql)){
				$res=mysql_fetch_array($sql);
				$fmea=$res["id"];
			if(!empty($del)){
				foreach($del as $idd=>$value){ $dela=$value; }
				$sqlo=mysql_query("SELECT ordem FROM apqp_fmeaproji WHERE id='$dela'");
				
				$reso=mysql_fetch_array($sqlo);
				$linha=$reso["ordem"];
				$sqlup=mysql_query("UPDATE apqp_fmeaproji SET ordem=ordem+1 WHERE fmea='$fmea' AND item='$wop' AND ordem>$linha");
				
			}else{
				$sqlb=mysql_query("SELECT MAX(ordem) AS ordem FROM apqp_fmeaproji WHERE fmea='$fmea' AND item='$wop'");
				if(mysql_num_rows($sqlb)){
					$resb=mysql_fetch_array($sqlb);
					$linha=$resb["ordem"]+1;
				}else{
					$linha=1;
				}
			}
				
				$sql=mysql_query("INSERT INTO apqp_fmeaproji (fmea,item,ordem) VALUES ('$fmea','$wop','$linha')");
				unset($_SESSION["mensagem"]);
		}
	}
	if($delsel==1){
		if(isset($del)){
			foreach($del AS $linha){
				$sql=mysql_query("DELETE FROM apqp_fmeaproji WHERE id='$linha'");
			}
			$_SESSION["mensagem"]="Linhas excluídas com sucesso";
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
	$sql=mysql_query("UPDATE apqp_fmeaproj SET quem='$quem', dtquem=NOW(), op='$op' WHERE peca='$pc'");
	$gt="t";
}
if($gt=="c"){
	header("location:apqp_fmeaprojc.php");
}elseif($gt=="t"){
	header("location:apqp_fmeaprojt2.php");
}
unset($acao);
?>