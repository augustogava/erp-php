<?php
include("conecta.php");
$categoria=Input::request("categoria");
$acao=Input::request("acao");

    print "<select name=\"cidade_ent\" id=\"cidade_ent\" class=\"formulario\">";
   //busca dados do combo 2
   $sql=mysql_query("SELECT * FROM cidade WHERE estado='$categoria' ORDER By nome ASC");
   while($res=mysql_fetch_array($sql)){
	   	print "<option value=\"$res[id]\">$res[nome] $acao</option>";
   }
 	print "</select>";
?> 
