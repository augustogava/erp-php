<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$id=Input::request("id");
$descr=Input::request("descr");
$obs=Input::request("obs");
$apqp=new set_apqp;
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$npc=$_SESSION["npc"];

$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
if(!empty($acao)){
	$loc="APQP - Desenhos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
		//verificar Cliente
		$apqp->cliente_apro("apqp_des.php");
		// - - - - - - - -  -
if($acao=="inc"){
	$sql=mysql_query("INSERT INTO apqp_des (peca,descr,obs) VALUES ('$pc','$descr','$obs')");
	if($sql){
		$pau=false;
		$sql=mysql_query("SELECT MAX(id) AS id FROM apqp_des");
		$res=mysql_fetch_array($sql);
		$id=$res["id"];
		if(!empty($_FILES["arquivo"]["name"])){
			$nome=$_FILES["arquivo"]["name"];
			$erros=0;
			if($_FILES["arquivo"]["size"] > 1048576){
				$erros++;
				$_SESSION["mensagem"].="\\nO desenho deve ter no máximo 1Mb";
			}
			if($erros==0){
				$nomeray=explode(".",$nome);
				$ext=end($nomeray);
				$nome2="$id.$ext";
				$arquivo="$patch/apqp_des/$nome2";
				if (file_exists($arquivo)) { 
					unlink($arquivo);
				}
				$upa=copy($_FILES["arquivo"]["tmp_name"], $arquivo);
				if(!$upa){
					$pau=true;
					$_SESSION["mensagem"].="O desenho não pôde ser carregado";
				}else{
					$sql=mysql_query("UPDATE apqp_des SET original='$nome',atual='$nome2' WHERE id='$id'");
				}
			}else{
				$pau=true;
			}
		}
		if($pau){
			$comp="&acao=alt";
		}else{
			$_SESSION["mensagem"]="Desenho incluído com sucesso";
			// cria followup caso inclua um desenho na peça
				$sql_emp=mysql_query("SELECT fantasia FROM empresa");
				$res_emp=mysql_fetch_array($sql_emp);
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Desenho na peça $npc.','O usuário $quem1 incluiu um desenho $nome na peça $npc.','$user')");
			//
		}
	}else{
		$_SESSION["mensagem"]="O desenho não pôde ser incluído";
		$comp="&acao=inc";
	}
}elseif($acao=="alt"){
	$sql=mysql_query("UPDATE apqp_des SET descr='$descr',obs='$obs' WHERE id='$id'");
	if($sql){
		$pau=false;
		if(!empty($_FILES["arquivo"]["name"])){
			$nome=$_FILES["arquivo"]["name"];
			$erros=0;
			if($_FILES["arquivo"]["size"] > 1048576){
				$erros++;
				$_SESSION["mensagem"].="\\nO desenho deve ter no máximo 1Mb";
			}
			if($erros==0){
				$nomeray=explode(".",$nome);
				$ext=end($nomeray);
				$nome2="$id.$ext";
				$arquivo="$patch/apqp_des/$nome2";
				if (file_exists($arquivo)) { 
					unlink($arquivo);
				}
				$upa=copy($_FILES["arquivo"]["tmp_name"], $arquivo);
				if(!$upa){
					$pau=true;
					$_SESSION["mensagem"].="O desenho não pôde ser carregado";
				}else{
					$sql=mysql_query("UPDATE apqp_des SET original='$nome',atual='$nome2' WHERE id='$id'");
				}
			}else{
				$pau=true;
			}
		}
		if(!$pau){
			$_SESSION["mensagem"]="Desenho alterado com sucesso";
			// cria followup caso alterar um desenho da peça
				$sql_emp=mysql_query("SELECT fantasia FROM empresa");
				$res_emp=mysql_fetch_array($sql_emp);
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração de Desenho da peça $npc.','O usuário $quem1 alterou o Desenho $descr da peça $npc.','$user')");
			//				
			$comp="&acao=entrar";
		}
	}else{
		$_SESSION["mensagem"]="O desenho não pôde ser alterado";
	}
	if(empty($comp)) $comp="&acao=alt";
}elseif($acao=="exc"){
	$sql=mysql_query("SELECT * FROM apqp_des WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$arquivo="apqp_des/$res[atual]";
	if(!empty($res[atual])){
		if (file_exists($arquivo)){
			unlink($arquivo);
		}
	}
	// cria followup caso exclua um desenho da peça
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão de Desenho da peça $npc.','O usuário $quem1 excluiu o Desenho $res[descr] da peça $npc.','$user')");
	//				
	$sql=mysql_query("DELETE FROM apqp_des WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Desenho excluído com sucesso";
	}else{
		$_SESSION["mensagem"]="O desenho não pôde ser excluído";
	}
}
header("Location:apqp_des.php?id=$id$comp");
?>