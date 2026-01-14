<?
if(!empty($_SESSION["mensagem"])){
	print "<script>alert('$_SESSION[mensagem]');</script>";
	unset($_SESSION["mensagem"]);
	$_SESSION["mensagem"]="0";
}
?>