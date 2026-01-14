<?
include("conecta.php");
if(empty($acao)) exit;
if($acao=="incluir"){
	$sql=mysql_query("SELECT * FROM prodserv WHERE id='$placa'");
	$res=mysql_fetch_array($sql);
//----------
	$sql=mysql_query("INSERT INTO textos (placa,codigo,texto) VALUES ('$placa','$res[apelido]','$texto')");
	if($sql){
		$_SESSION["mensagem"]="Texto Incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Texto não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("SELECT * FROM prodserv WHERE id='$placa'");
	$res=mysql_fetch_array($sql);
//-----------
	$sql=mysql_query("UPDATE textos SET placa='$placa', codigo='$res[apelido]', texto='$texto' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Texto alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O texto não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM textos WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Texto excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O texto não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:textos.php");
}else{
	header("Location:material.php?acao=$acao&id=$id");
}
?>