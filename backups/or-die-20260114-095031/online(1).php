<?php
include("conecta.php");
$ip=$_SERVER['REMOTE_ADDR'];
$data=date("Y-m-d H:i:s");
$desde=date("Y-m-d H:i:s");
$iduser=$_SESSION["login_codigo"];
$funcionario=$_SESSION["login_funcionario"];
if($funcionario=="S"){ $tipo="funcionario"; }else{ $tipo="cliente"; }

	$pip=explode(".",$ip);
	if($pip[0]!="192") $ext=true; else $ext=false;
	

		$sql=mysql_query("SELECT * FROM online WHERE user='$iduser'");
		if(mysql_num_rows($sql)){
			$res=mysql_fetch_array($sql);
				$sql2=mysql_query("UPDATE online SET data='$data',funcionario='$funcionario' WHERE id='$res[id]'");
		}else{
			$sql=mysql_query("INSERT INTO online (user,funcionario,ip,data,desde) VALUES ('$iduser','$funcionario','$ip','$data','$desde')");		
			$sql=mysql_query("SELECT MAX(id) AS id FROM online");
			$res=mysql_fetch_array($sql);
			$_SESSION["logado"]=$res["id"];	
		}

$sql=mysql_query("SELECT * FROM online WHERE (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(data)) > 50") or die("nao");
while($res=mysql_fetch_array($sql)){
	$sql2=mysql_query("DELETE FROM online WHERE id='$res[id]'");
}
//MENSAGEMM ------ - - - - -- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$sqlt=mysql_query("SELECT * FROM msg WHERE user='$iduser' AND enviado='N'") or die("nao foi");
if(mysql_num_rows($sqlt)){
	$res=mysql_fetch_array($sqlt);
	$sql2=mysql_query("UPDATE msg SET enviado='S' WHERE id='$res[id]'") or die("tb nao foi");
	print "<script>window.alert('$res[msg]');</script>";
}
//------========== MSG PRA TODOS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$sqlt=mysql_query("SELECT * FROM msg WHERE user='666666' AND enviado='N'") or die("nao foi");
if(mysql_num_rows($sqlt)){
	$res=mysql_fetch_array($sqlt);
	$sql2=mysql_query("UPDATE msg SET enviado='S' WHERE id='$res[id]'") or die("tb nao foi");
	print "<script>window.alert('$res[msg]');</script>";
}
// - - - - - - - -BLOQUEAR - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
if($ext){
	$sqll=mysql_query("SELECT * FROM cliente_login WHERE $tipo=$iduser AND blok_externo='1'");
}else{
	$sqll=mysql_query("SELECT * FROM cliente_login WHERE $tipo=$iduser AND blok='1'");
}
if(mysql_num_rows($sqll)){
		$_SESSION["login_funcionario"]="";
		$_SESSION["login_codigo"]="";
		$_SESSION["login_nome"]="";
		$_SESSION["login_cargo"]="";
		$_SESSION["login_nivel_nome"]="";
		$_SESSION["login_nivel"]="";
		$_SESSION["login_c1"]="";
		print "<script>window.alert('Administrador Bloqueou seu acesso ao sistema');parent.window.location='index.php';</script>";
}
?>

<script>window.setTimeout("location.href='online.php'",40000);</script>