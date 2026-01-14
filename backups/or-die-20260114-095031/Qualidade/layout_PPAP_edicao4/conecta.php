<?php
include("configuracoes.php");
$cnx = mysql_connect($host,$user,$pwd) or die ("Não foi possível a conectar ao BD");
$bnc = mysql_select_db($bd, $cnx) or die ("O BD não foi Localizado");
// método de segurança para camuflar os nomes dos campos enviados diretamente pela URL
foreach($_REQUEST as $name=>$valor){
  $$name=$valor;
}
//
?>