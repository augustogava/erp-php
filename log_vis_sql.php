<?php
include("conecta.php");
$acao=Input::request("acao");
$tipo=Input::request("tipo");
$arquivo=Input::request("arquivo");

if($acao=="ir"){
	if($tipo=="abrir"){
		print "<script>window.open('$arquivo');window.location='log_vis.php';</script>";
	}else{
		header("Content-type: text/css; charset: UTF-8");
		header("Content-Disposition: attachment; filename=" . basename($arquivo));
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		print file_get_contents($arquivo);
	}
}
if(!empty($acao)){
	$loc="Log Visualizar";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
?>