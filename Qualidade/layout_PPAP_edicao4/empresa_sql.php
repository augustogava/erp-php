<?php
include("conecta.php");
if(!empty($acao)){
	$loc="Empresa";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="inc"){
	$sql=mysql_query("INSERT INTO empresa (fantasia,razao,endereco,cidade,estado,pais,cep,tel,fax,cnpj) VALUES ('$fantasia','$razao','$endereco','$cidade','$estado','$pais','$cep','$tel','$fax','$cnpj')");
	$_SESSION["mensagem"]="Informações inseridas com sucesso";
}elseif($acao=="alt"){
	$sql=mysql_query("UPDATE empresa SET fantasia='$fantasia',razao='$razao',endereco='$endereco',cidade='$cidade',estado='$estado',pais='$pais',cep='$cep',tel='$tel',fax='$fax',cnpj='$cnpj'");
	$_SESSION["mensagem"]="Informações alteradas com sucesso";
}

if(!empty($_FILES["foto"]["name"])){
	$erros=0;
	if($_FILES["foto"]["type"]!="image/pjpeg"){
		$erros++;
		$_SESSION["mensagem"]="O logo deve ter extensão .jpg ou .jpeg";
	}
	if($_FILES["foto"]["size"] > 51200){
		$erros++;
		$_SESSION["mensagem"].="\\nO logo deve ter menos que 50Kb";			
	}
	if($erros==0){
		$arquivo="$patch/empresa_logo/logo.jpg";
		if (file_exists($arquivo)) { 
			unlink($arquivo);
		}
		$upa=copy($_FILES["foto"]["tmp_name"], $arquivo);
	}
}
header("Location:empresa.php");
?>