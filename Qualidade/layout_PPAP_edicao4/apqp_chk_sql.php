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
	$loc="APQP - Checklist";
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
		$apqp->cliente_apro("apqp_chk.php");
		// - - - - - - - -  -
if($acao=="altt"){
	//unset($coments);
	foreach($coments AS $linha => $linha2){
		$sql=mysql_query("UPDATE apqp_chk2 SET ok='".$ok[$linha]."', coments='".$coments[$linha]."', resp='".$resp[$linha]."', data='".data2banco($data[$linha])."' WHERE id='$linha'");
	}
}elseif(isset($ap)){
	if(empty($quem2)){
		$quem2=$quem;
	}
	$sql=mysql_query("UPDATE apqp_chk SET sit='S', quem='$quem2', dtquem=NOW() WHERE peca='$pc'");
	// cria followup caso aprove o Checklist APQP
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Checklist APQP da peça $npc.','O usuário $quem aprovou o Checklist APQP da peça $npc.','$user')");
	//				
}elseif(isset($lap)){
	$sql=mysql_query("UPDATE apqp_chk SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
	// cria followup caso remove a aprovação do Checklist APQP
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação do Checklist APQP da peça $npc.','O usuário $quem removeu a aprovação do Checklist APQP da peça $npc.','$user')");
	//	
}
if($sql){
	$_SESSION["mensagem"]="Alterações salvas com sucesso";
	// cria followup caso salve o conteudo do Checklist APQP
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Checklist APQP da peça $npc.','O usuário $quem salvou as alterações do Checklist APQP da peça $npc.','$user')");
	//	
}else{
	$_SESSION["mensagem"]="As alterações não puderam ser salvas";
}
if($acao=="altt"){
	header("Location:apqp_chk2.php");
}else{
	header("Location:apqp_chk.php");
}
?>