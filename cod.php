<?php
include("conecta.php");
/*
$sql=mysql_query("SELECT * FROM prodserv");
while($res=mysql_fetch_array($sql)){
	$ult=explode(".",$res["codprod"]);
	$n="$ult[0].$ult[1].$ult[3]";
	//$sql2=mysql_query("UPDATE prodserv SET codprod='$n' WHERE id='$res[id]'");
	print "UPDATE prodserv SET codprod='$n' WHERE id='$res[id]' <br>";
}
*/
print $vencimento=date("d/m/Y",time()+(86400*1));
?>