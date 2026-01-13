<?php
include("conecta.php");
$pc=$_SESSION["mpc"];
$texto = $_REQUEST["login"];
$tipo = $_REQUEST["tipo"];
$sqla=mysql_query("SELECT * FROM apqp_car WHERE numero='$texto' AND peca='$pc' AND tipo='$tipo'");
if(mysql_num_rows($sqla)){
   echo 1;
}else{
   echo 0;
}    
//print "SELECT * FROM apqp_car WHERE numero='$texto' AND peca='$pc'";
?>