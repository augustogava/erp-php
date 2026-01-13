<?php
include("conecta.php");

$valor = $_REQUEST["valor"];
mysql_query("INSERT INTO grupos (nome) VALUES('$valor')");

?>