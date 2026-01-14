<?php
include("conecta.php");
$arquivo=file("contatos.txt");
$pro=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
foreach($arquivo as $linha){
//0    1  
//id;nome;
	$pt=explode(";",$linha);
	$cli=str_replace($pro,"",$pt["0"]);
	array_shift($pt);
	array_pop($pt);
	foreach($pt as $val){
		if(!empty($val)){
			$sel=mysql_query("SELECT * FROM clientes WHERE id='$cli'");
			if(mysql_num_rows($sel)){
				$nome=addslashes($val);
				$sel=mysql_query("SELECT * FROM cliente_contato WHERE cliente='$cli'");
				if(!mysql_num_rows($sel)){
					print "foi <br>";
					mysql_query("INSERT INTO cliente_contato (cliente,nome) VALUES('$cli','$nome')") or erp_db_fail();
				}
			}else{
				print "nao foi <br>";
			}
		}
			
	}
}
?>