<?php
//Usados
$ip=$_SERVER['REMOTE_ADDR'];
$data=date("Y-m-d");
$hora=date("H:i:s");
$iduser=isset($_SESSION["login_codigo"]) ? $_SESSION["login_codigo"] : '';
$funcionario=isset($_SESSION["login_funcionario"]) ? $_SESSION["login_funcionario"] : '';
if($funcionario=="S"){ $tipoo="funcionarios"; }else{ $tipoo="clientes"; }
//banco
$blog=mysql_query("INSERT INTO log (user,funcionario,data,hora,ip,acao,local,pagina) VALUES('$iduser','$funcionario','$data','$hora','$ip','$acao','$loc','$pagina')");
if($blog && !empty($iduser)){
	$sus=mysql_query("SELECT * FROM $tipoo WHERE id='$iduser'"); 
	$rsus=mysql_fetch_array($sus);
}
$data=banco2data($data);
?>
