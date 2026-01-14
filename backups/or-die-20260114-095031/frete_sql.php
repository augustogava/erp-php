<?php
include("conecta.php");
function valor2banco2($vl){
	$vl=str_replace(".",".",$vl);
	return str_replace(",",".",$vl);
}
if(empty($acao)) exit;
if($acao=="incluir"){
for($i=1; $i<=31; $i++){
	eval("\$peso_preco$i=valor2banco2(\$peso_preco$i);");
	eval("\$peso_ini$i=valor2banco2(\$peso_ini$i);");
	eval("\$peso_fin$i=valor2banco2(\$peso_fin$i);");
	$ali.=",peso_ini$i"; 
	$ali.=",peso_fin$i"; 
	$ali.=",peso_preco$i"; 
	eval("\$a.=\",'\$peso_ini$i'\";");
	eval("\$a.=\",'\$peso_fin$i'\";");
	eval("\$a.=\",'\$peso_preco$i'\";");
}
	$sql=mysql_query("INSERT INTO frete (regiao,cep_inicial,cep_final".$ali.") VALUES ('$regiao','$cep_inicial','$cep_final'".$a.")") or die("nao foi");
if($sql){
		$_SESSION["mensagem"]="Frete Incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Frete não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
for($i=1; $i<=31; $i++){
	eval("\$peso_preco$i=valor2banco2(\$peso_preco$i);");
	eval("\$peso_ini$i=valor2banco2(\$peso_ini$i);");
	eval("\$peso_fin$i=valor2banco2(\$peso_fin$i);");
	eval("\$a.=\",peso_ini$i='\$peso_ini$i'\";");
	eval("\$a.=\",peso_fin$i='\$peso_fin$i'\";");
	eval("\$a.=\",peso_preco$i='\$peso_preco$i'\";");
}
	$sql=mysql_query("UPDATE frete SET regiao='$regiao'".$a." WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Frete alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Frete não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM frete WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Frete excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Frete não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:frete.php");
}else{
	header("Location:frete.php?acao=$acao&id=$id");
}
?>