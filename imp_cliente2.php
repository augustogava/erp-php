<?php
include("conecta.php");
$arquivo=file("clientes.txt");
foreach($arquivo as $linha){
//  0    1         2         3        4        5        6     7  
//cnpj;Nome;tp_logadouro;logadouro;numero;complemento;bairro;cep;
//  8       9    10   11     12   13   14    15       16
//cidade;estado;ddd1;fone1;ddd2;fone2;ramo;origem;nu_funci;
/*
	$qtd=explode("-",$pt[14]);
	//print count($qtd);
	//print $pt[14]."<br>";
	if((count($qtd)-1)>=2){ print strpos($pt[14],'-')."<br>"; } 
*/
	$pt=explode(";",$linha);
	//ramo
	$sql=mysql_query("SELECT id FROM ramo WHERE nome='$pt[14]'");
	$res=mysql_fetch_array($sql);
	$ramo=$res["id"];
	//estado
	$sql=mysql_query("SELECT id FROM estado WHERE nome='$pt[9]'");
	$res=mysql_fetch_array($sql);
	$estado=$res["id"];
	$nome=addslashes($pt[1]);
	$cidade=addslashes($pt[8]);
	$endereco=$pt[2]." ".addslashes($pt[3])." ".addslashes($pt[4]);
	if($pt[16]>=1 and $pt[3]<20){
		$porte="1";
	}else if($pt[16]>=20 and $pt[3]<100){
		$porte="2";
	}else{
		$porte="3";
	}
		mysql_query("INSERT INTO clientes (nome,porte_fun,ramo,endereco,complemento,bairro,cep,estado,cidade,ddd,ddd2,fone,fone2,cnpj,origem,status,origem_cad) VALUES('$nome','$porte','$ramo','$endereco','$pt[5]','$pt[6]','$pt[7]','$estado','$pt[8]','$pt[10]','$pt[12]','$pt[11]','$pt[13]','$pt[0]','mkr','P','bd')") or erp_db_fail();
		//acao
		$sql=mysql_query("SELECT MAX(id) as id FROM clientes");
		$res=mysql_fetch_array($sql);
		mysql_query("INSERT INTO crm_acaor (acao,cliente) VALUES('19','$res[id]')") or erp_db_fail();	
}
?>