<?php
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$npc=$_SESSION["npc"];

$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
if(!empty($acao)){
	$loc="APQP - Documentos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
		//verificar Cliente
		$apqp->cliente_apro("apqp_doc.php");
		// - - - - - - - -  -
if($acao=="inc"){
	$sql=mysql_query("INSERT INTO apqp_doc (peca,descr,forma,tipo,resp,origem,obs) VALUES ('$pc','$descr','$forma','$tipo','$resp','$origem','$obs')");
	if($sql){
		$pau=false;
		$sql=mysql_query("SELECT MAX(id) AS id FROM apqp_doc");
		$res=mysql_fetch_array($sql);
		$id=$res["id"];
		if($forma=="A"){
			if(!empty($_FILES["arquivo"]["name"])){
				$nome=$_FILES["arquivo"]["name"];
				$erros=0;
				if($_FILES["arquivo"]["size"] > 1048576){
					$erros++;
					$_SESSION["mensagem"].="\\nO documento deve ter no máximo 1Mb";
				}
				if($erros==0){
					$nomeray=explode(".",$nome);
					$ext=end($nomeray);
					$nome2="$id.$ext";
					$arquivo="$patch/apqp_doc/$nome2";
					if (file_exists($arquivo)) { 
						unlink($arquivo);
					}
					$upa=copy($_FILES["arquivo"]["tmp_name"], $arquivo);
					if(!$upa){
						$pau=true;
						$_SESSION["mensagem"].="O documento não pôde ser carregado";
					}else{
						$sql=mysql_query("UPDATE apqp_doc SET original='$nome',atual='$nome2' WHERE id='$id'");
					}
				}else{
					$pau=true;
				}
			}
		}else{
			$sql=mysql_query("UPDATE apqp_doc SET original='$local' WHERE id='$id'");
		}
		if($pau){
			$comp="&acao=alt";
		}else{
			$_SESSION["mensagem"]="Documento incluído com sucesso";
			// cria followup caso inclua um documento na peça
				$sql_emp=mysql_query("SELECT fantasia FROM empresa");
				$res_emp=mysql_fetch_array($sql_emp);
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Documento na peça $npc.','O usuário $quem1 incluiu um documento $descr na peça $npc.','$user')");
			//				
		}
	}else{
		$_SESSION["mensagem"]="O documento não pôde ser incluído";
		$comp="&acao=inc";
	}
}elseif($acao=="alt"){
	$sql=mysql_query("UPDATE apqp_doc SET descr='$descr',forma='$forma',tipo='$tipo',resp='$resp',origem='$origem',obs='$obs' WHERE id='$id'");
	if($sql){
		$pau=false;
		if($forma=="A"){
			if(!empty($_FILES["arquivo"]["name"])){
				$nome=$_FILES["arquivo"]["name"];
				$erros=0;
				if($_FILES["arquivo"]["size"] > 1048576){
					$erros++;
					$_SESSION["mensagem"].="\\nO documento deve ter no máximo 1Mb";
				}
				if($erros==0){
					$nomeray=explode(".",$nome);
					$ext=end($nomeray);
					$nome2="$id.$ext";
					$arquivo="$patch/apqp_doc/$nome2";
					if (file_exists($arquivo)) { 
						unlink($arquivo);
					}
					$upa=copy($_FILES["arquivo"]["tmp_name"], $arquivo);
					if(!$upa){
						$pau=true;
						$_SESSION["mensagem"].="O documento não pôde ser carregado";
					}else{
						$sql=mysql_query("UPDATE apqp_doc SET original='$nome',atual='$nome2' WHERE id='$id'");
					}
				}else{
					$pau=true;
				}
			}
		}else{
			$sql=mysql_query("UPDATE apqp_doc SET original='$local' WHERE id='$id'");
		}
		if(!$pau){
			$_SESSION["mensagem"]="Documento alterado com sucesso";
			// cria followup caso altere um documento da peça
				$sql_emp=mysql_query("SELECT fantasia FROM empresa");
				$res_emp=mysql_fetch_array($sql_emp);
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração de Documento da peça $npc.','O usuário $quem1 alterou o documento $descr da peça $npc.','$user')");
			//				
			$comp="&acao=entrar";
		}
	}else{
		$_SESSION["mensagem"]="O documento não pôde ser alterado";
	}
	if(empty($comp)) $comp="&acao=alt";
}elseif($acao=="exc"){
	// cria followup caso exclua um documento na peça
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		$sql_doc=mysql_query("SELECT descr FROM apqp_doc WHERE id='$id'");
		$res_doc=mysql_fetch_array($sql_doc);		
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão de Documento da peça $npc.','O usuário $quem1 excluiu o documento $res_doc[descr] da peça $npc.','$user')");
	//				

	$sql=mysql_query("SELECT * FROM apqp_doc WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	if(!empty($res[atual])){
		$arquivo="apqp_doc/$res[atual]";
		if (file_exists($arquivo)){
			unlink($arquivo);
		}
	}
	$sql=mysql_query("DELETE FROM apqp_doc WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Documento excluído com sucesso";
	}else{
		$_SESSION["mensagem"]="O documento não pôde ser excluído";
	}
}
header("Location:apqp_doc.php?id=$id$comp");
?>