<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);

if(!isset($_SESSION["login_nome"]) || empty($_SESSION["login_nome"]) || !isset($_SESSION["login_nivel"]) || empty($_SESSION["login_nivel"])){
	$_SESSION["lerro"]="Acesso Restrito";
	header("Location:login_page.php");
	exit;
}
if(isset($_SESSION["login_menus"])){
	$wndp=explode("/",$_SERVER['PHP_SELF']);
	$wndp2=$wndp[sizeof($wndp)-1];
	if(!in_array($wndp2,$_SESSION["login_menus"])){
	}
}
?>