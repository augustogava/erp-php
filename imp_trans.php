<?
include("conecta.php");
$arquivo=file("trans.txt");
foreach($arquivo as $linha){
//0    1      2      3     4      5       6      7   8   9   
//id;nome;endereco;placa;cidade;estado;loc_entr;cnpj;ie;fone
	$pt=explode(";",$linha);
	mysql_query("INSERT INTO transportadora (id,nome,cnpj,ie,endereco,cidade,uf,telefone,loc_entr) VALUES('$pt[0]','$pt[1]','$pt[7]','$pt[8]','$pt[2]','$pt[4]','$pt[5]','$pt[9]','$pt[6]')");
}
?>