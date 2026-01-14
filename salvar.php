<?php
include("conecta.php");

$valor = Input::request("valor");
mysql_query("INSERT INTO grupos (nome) VALUES('$valor')");

?>