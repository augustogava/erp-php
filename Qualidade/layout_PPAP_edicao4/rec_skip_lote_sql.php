<?php
include("conecta.php");
if(empty($acao)) exit;
if(!empty($acao)){
	$loc="Recebimento - Skip Lote";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){

	$sqlskip=mysql_query("SELECT * FROM skip_lote WHERE fornecedor='$idfornecedor' AND item='$iditem'");
	if(mysql_num_rows($sqlskip)){
		$_SESSION["mensagem"]="Já existe este ítem cadastrado para o Fornecedor selecionado acima! Selecione outro ítem ou escolha outro Fornecedor para selecionar este ítem!";
		header("Location:rec_skip_lote.php?acao=inc&id=$id&fornecedor=$fornecedor&idfornecedor=$idfornecedor&sit=$sit&skip_lote=$skip_lote&tempo_limite=$tempo_limite&ref_forn=$ref_forn&papp=$papp&data2=$data2&validade=$validade&status=$status&atualiza=$atualiza&notifica=$notifica&norma=$norma&plano=$plano&nivel=$nivel&nqa=$nqa");	
		exit;		
	}

	$hj=date("Y-m-d");
	$data2=data2banco($data2);
	$validade=data2banco($validade);
	$sql=mysql_query("INSERT INTO skip_lote (emissao,fornecedor,item,sit,skip_lote,tempo_limite,ref_forn,papp,data,validade,status,atualiza,notifica,norma,plano,nivel,nqa,just) VALUES ('$hj','$idfornecedor','$iditem','$sit','$skip_lote','$tempo_limite','$ref_forn','$papp','$data2','$validade','$status','$atualiza','$notifica','$norma','$plano','$nivel','$nqa','$just')");
	if($sql){
	// cria followup caso inclua
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão do cadastro do Skip Lote.','O usuário $quem1 incluiu o cadastro do Skip Lote.','$user')");
	//	
		$_SESSION["mensagem"]="Skip lote incluído com sucesso!";
	} else {
		$_SESSION["mensagem"]="Skip lote não pôde ser incluído!";
	}

}elseif($acao=="alterar"){
		$data2=data2banco($data2);
		$validade=data2banco($validade);
		$sql=mysql_query("UPDATE skip_lote SET fornecedor='$idfornecedor',item='$iditem',sit='$sit',skip_lote='$skip_lote',tempo_limite='$tempo_limite',ref_forn='$ref_forn',papp='$papp',data='$data2',validade='$validade',status='$status',atualiza='$atualiza',notifica='$notifica',norma='$norma',plano='$plano',nivel='$nivel',nqa='$nqa' WHERE id='$id'");
		if($sql){
		// cria followup caso altere
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro do Skip Lote.','O usuário $quem1 alterou o cadastro do Skip Lote $skip.','$user')");
		//	
			$_SESSION["mensagem"]="Skip lote alterado com sucesso!";
		}else{
			$_SESSION["mensagem"]="Skip lote não pôde ser alterado!";
		}
}elseif($acao=="exc"){
//	$sql2=mysql_query("SELECT * FROM skip_lote WHERE id='$id'");
//	$res2-mysql_fetch_array($sql2);
	// cria followup caso delete
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão do cadastro do Skip Lote.','O usuário $quem1 excluiu o cadastro do Skip Lote .','$user')");//$res2[pegar]
	//	
	$sql=mysql_query("DELETE FROM skip_lote WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Skip lote excluído com sucesso!";
	}else{
		$_SESSION["mensagem"]="Skip lote não pôde ser excluído!";
	}
}
header("Location:rec_skip_lote.php?acao=entrar&id=$id");
?>