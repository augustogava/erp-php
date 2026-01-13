<?
include("conecta.php");
$arquivo=file("followup.txt");
foreach($arquivo as $linha){
	$cont.=$linha;
}
$as=explode("***",$cont);
$a=0;
foreach($as as $linha){
//1   2      3      4   
//id;titulo;tipo;conteudo
	$pt=explode(";",$linha);
	$sel=mysql_query("SELECT * FROM clientes WHERE id='$pt[1]'");
	if(mysql_num_rows($sel)){
		mysql_query("INSERT INTO followup (cliente,titulo,descricao,tipo,data,hora) VALUES('$pt[1]','followup','$pt[4]','5','2006-07-27','08:00:00')") or die("Erro");
	}else{
		print "Nao foi <br> $a"; $a++;
	}
}

?>