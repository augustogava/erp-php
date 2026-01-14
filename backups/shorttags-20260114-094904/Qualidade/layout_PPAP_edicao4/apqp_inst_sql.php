<?
include("conecta.php");
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$wop=$_SESSION["wop"];
$user=$_SESSION["login_codigo"];
$hj=date("Y-m-d");
$hora=hora();

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if(isset($_GET["id"])){
	$id=$_GET["id"];
}else{
	$id=$_SESSION["iid"];
}
$quem=$_SESSION["login_nome"];
if(!empty($acao)){
	$loc="APQP - Instrução Operador";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="imp"){
	$end="apqp_impressao.php?acao=$acao&local=$local&pc=$pc";
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
		$apqp->cliente_apro("apqp_inst1.php");
		// - - - - - - - -  -
if($acao=="i0"){
	$prep_data=data2banco($prep_data);
	$rev_data=data2banco($rev_data);
	$sql=mysql_query("UPDATE apqp_inst SET nome='$nome',numero='$numero',prep='$prep',prep_data='$prep_data',obs='$obs',rev='$rev',rev_data='$rev_data',rev_alt='$rev_alt' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da Instrução do Operador
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Instrução do Operador da peça $npc.','O usuário $quem salvou as alterações da Instrução do Operador da peça $npc.','$user')");
		//			
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	if(isset($ap)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Instruções do Operador");
		// - - - - - - - -  - - - - - - - - 
		$sql=mysql_query("UPDATE apqp_inst SET quem='$quem',dtquem=NOW(),sit='S' WHERE id='$id'");
		// cria followup caso aprove a Instrução do Operador
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Instrução do Operador da peça $npc.','O usuário $quem aprovou a Instrução do Operador da peça $npc.','$user')");
		//			
	}elseif(isset($lap)){
		$sql=mysql_query("UPDATE apqp_inst SET quem='',dtquem='0000-00-00',sit='N' WHERE id='$id'");
		// cria followup caso limpe a aprovação da Instrução do Operador
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação da Instrução do Operador da peça $npc.','O usuário $quem removeu a aprovação da Instrução do Operador da peça $npc.','$user')");
		//			
	}
	$gt="i1";
}elseif($acao=="i2"){
	if($del){
		$sql=mysql_query("UPDATE apqp_inst SET desenho='N' WHERE id='$id'");
		$arquivo="$patch/apqp_inst/$id.jpg";
		if (file_exists($arquivo)) { 
			unlink($arquivo);
		}
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da Instrução do Operador
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Instrução do Operador da peça $npc.','O usuário $quem salvou as alterações da Instrução do Operador da peça $npc.','$user')");
		//			
	}else{
		if(!empty($_FILES["arquivo"]["name"])){
			$erros=0;
			if($_FILES["arquivo"]["type"]!="image/pjpeg"){
				$erros++;
				$_SESSION["mensagem"].="\\nA imagem deve ter extensão .jpg ou .jpeg";
			}
			if($_FILES["arquivo"]["size"] > 1048576){
				$erros++;
				$_SESSION["mensagem"].="\\nA imagem deve ter no máximo 1Mb";
			}
			if($erros==0){
				$arquivo="$patch/apqp_inst/$id.jpg";
				if (file_exists($arquivo)) { 
					unlink($arquivo);
				}
				$upa=copy($_FILES["arquivo"]["tmp_name"], $arquivo);
				if(!$upa){
					$pau=true;
					$_SESSION["mensagem"].="\\nA imagem não pôde ser carregada";
				}else{
					$sql=mysql_query("UPDATE apqp_inst SET desenho='S' WHERE id='$id'");
					$_SESSION["mensagem"]="Alterações salvas com sucesso";
				}
			}else{
				$pau=true;
			}
			if($pau){
				$_SESSION["mensagem"]="As alteraçoes não puderam ser realizadas".$_SESSION["mensagem"];
			}
		}
	}
	$gt="i2";
}elseif($acao=="altp"){
	if($salva==1){
		reset($tipo);
		foreach($tipo AS $linha => $linha2){
			$sql=mysql_query("UPDATE apqp_instp SET tipo='".$tipo[$linha]."', texto='".$texto[$linha]."' WHERE id='$linha'");
		}
		if($sql){
			$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da Instrução do Operador
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Instrução do Operador da peça $npc.','O usuário $quem salvou as alterações da Instrução do Operador da peça $npc.','$user')");
		//			
		}else{
			$_SESSION["mensagem"]="As alterações não puderam ser salvas";
		}
	}
	if($maisum==1){
		$sql=mysql_query("INSERT INTO apqp_instp (inst) VALUES ('$id')");
		unset($_SESSION["mensagem"]);
	}
	if($delsel==1){
		if(isset($del)){
			foreach($del AS $linha){
				$sql=mysql_query("DELETE FROM apqp_instp WHERE id='$linha'");
			}
			$_SESSION["mensagem"]="Linhas excluídas com sucesso";
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
	$gt="i3";
}elseif($acao=="del"){
	$sql=mysql_query("DELETE FROM apqp_instc WHERE inst='$id'");
	$sql=mysql_query("DELETE FROM apqp_instp WHERE inst='$id'");
	$sql=mysql_query("DELETE FROM apqp_inst WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Instrução excluída com sucesso";
		// cria followup caso exclua a Instrução do Operador
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão da Instrução do Operador da peça $npc.','O usuário $quem excluiu as alterações da Instrução do Operador da peça $npc.','$user')");
		//			
	}else{
		$_SESSION["mensagem"]="A instrução não pôde ser excluída";
	}
	$gt="i";
}elseif($acao=="altc"){
	if($salva==1){
		reset($tecnicas);
		foreach($tecnicas AS $linha => $linha2){
			$sql=mysql_query("UPDATE apqp_instc SET tecnicas='".$tecnicas[$linha]."', tamanho='".$tamanho[$linha]."', freq='".$freq[$linha]."', metodo='".$metodo[$linha]."', reacao='".$reacao[$linha]."' WHERE id='$linha'");
		}
		if($sql){
			$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da Instrução do Operador
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Instrução do Operador da peça $npc.','O usuário $quem salvou as alterações da Instrução do Operador da peça $npc.','$user')");
		//			
		}else{
			$_SESSION["mensagem"]="As alterações não puderam ser salvas";
		}
	}
	if($maisum==1){
		$sql=mysql_query("INSERT INTO apqp_instc (inst,car) VALUES ('$id','$wcar')");
		unset($_SESSION["mensagem"]);
	}
	if($delsel==1){
		if(isset($del)){
			foreach($del AS $linha){
				$sql=mysql_query("DELETE FROM apqp_instc WHERE id='$linha'");
			}
			$_SESSION["mensagem"]="Linhas excluídas com sucesso";
		}else{
			$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
		}
	}
	$gt="i4";
}
if($gt=="i"){
	header("location:apqp_inst.php");
}elseif($gt=="i1"){
	header("location:apqp_inst1.php");
}elseif($gt=="i2"){
	header("location:apqp_inst2.php");
}elseif($gt=="i3"){
	header("location:apqp_inst3_2.php");
}elseif($gt=="i4"){
	header("location:apqp_inst4_2.php");
}
unset($acao);
?>