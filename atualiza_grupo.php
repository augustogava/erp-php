<?php
include("conecta.php");

    print "<select name=\"aba\" class=\"textobold\" id=\"aba\">";
   //busca dados do combo 2
	$sql=mysql_query("select * from grupos");
		print "<option value=\"\">Selecione</option>";
   while($res=mysql_fetch_array($sql)){
	   	print "<option value=\"$res[id]\">$res[nome]</option>";
   }
 	print "</select>";
?> 
