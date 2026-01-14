<?php
include("configuracoes.php");
$cnx = mysql_connect($host,$user,$pwd) or erp_db_fail();
$bnc = mysql_select_db($bd, $cnx) or erp_db_fail();
// método de segurança para camuflar os nomes dos campos enviados diretamente pela URL
foreach($_REQUEST as $name=>$valor){
  $$name=$valor;
}
//
?>