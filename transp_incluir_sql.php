<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$cod_transport=Input::request("cod_transport");
$nome=Input::request("nome");
$razao=Input::request("razao");
$cnpj=Input::request("cnpj");
$ie=Input::request("ie");
$endereco=Input::request("endereco");
$complemento=Input::request("complemento");
$cep=Input::request("cep");
$bairro=Input::request("bairro");
$cidade=Input::request("cidade");
$uf=Input::request("uf");
$contato=Input::request("contato");
$telefone=Input::request("telefone");
$fax=Input::request("fax");
$celular=Input::request("celular");
$email=Input::request("email");
$contato2=Input::request("contato2");
$fax2=Input::request("fax2");
$tel2=Input::request("tel2");
$celular2=Input::request("celular2");
$email2=Input::request("email2");
$site=Input::request("site");
$coleta=Input::request("coleta");
$end_entrega=Input::request("end_entrega");
$bairro_entrega=Input::request("bairro_entrega");
$cid_entrega=Input::request("cid_entrega");
$est_entrega=Input::request("est_entrega");
$reg_atuante=Input::request("reg_atuante");
$est_atuante=Input::request("est_atuante");
$temp_col=Input::request("temp_col");
$id=Input::request("id");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Transportadora";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) exit;
if($acao=="inc"){
		if(!CalculaCNPJ($cnpj)){
					$_SESSION["mensagem"]="CNPJ Incorreto!";
					header("Location:transp_incluir.php");
					exit;
		}
			$sql=mysql_query("INSERT INTO transportadora (cod_transport,nome,razao,cnpj,ie,endereco,complemento,cep,bairro,cidade,uf,contato,telefone,fax,celular,email,contato2,fax2,tel2,celular2,email2,site,coleta,end_entrega,bairro_entrega,cid_entrega,est_entrega,reg_atuante,est_atuante,temp_col) VALUES ('$cod_transport','$nome','$razao','$cnpj','$ie','$endereco','$complemento','$cep','$bairro','$cidade','$uf','$contato','$telefone','$fax','$celular','$email','$contato2','$fax2','$tel2','$celular2','$email2','$site','$coleta','$end_entrega','$bairro_entrega','$cid_entrega','$est_entrega','$reg_atuante','$est_atuante','$temp_col')");
	if($sql){
		$_SESSION["mensagem"]="Transportadora incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Transportadora não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alt"){
		if(!CalculaCNPJ($cnpj)){
					$_SESSION["mensagem"]="CNPJ Incorreto!";
					header("Location:transp_incluir.php");
					exit;
		}
	$sql=mysql_query("UPDATE transportadora SET cod_transport='$cod_transport',nome='$nome',razao='$razao',cnpj='$cnpj',ie='$ie',endereco='$endereco',complemento='$complemento',cep='$cep',bairro='$bairro',cidade='$cidade',uf='$uf',contato='$contato',telefone='$telefone',fax='$fax',celular='$celular',email='$email',contato2='$contato2',fax2='$fax2',tel2='$tel2',celular2='$celular2',email2='$email2',site='$site',coleta='$coleta',end_entrega='$end_entrega',bairro_entrega='$bairro_entrega',cid_entrega='$cid_entrega',est_entrega='$est_entrega',reg_atuante='$reg_atuante',est_atuante='$est_atuante',temp_col='$temp_col' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Transportadora alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Transportadora não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM transportadora WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Transportadora excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A Transportadora não pôde ser excluída!";
		}		
	}
	$acao="entrar";
}
header("Location:transp_incluir.php?acao=$acao&id=$id");
?>