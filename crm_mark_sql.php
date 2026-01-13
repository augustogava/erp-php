<?
include("conecta.php");
include("seguranca.php");
$bd=new set_bd;
$data=date("Y-m-d");
$hora=hora();
if($acao=="email"){
	mysql_query("UPDATE crm_acao SET sit='2' WHERE id='$id'");
	//Arquivo
	$arq=$bd->pega_nome_bd2("crm_acao","arq","$id");
	$nome=$bd->pega_nome_bd2("crm_acao","nome","$id");
	$arq=file("$arq");
	$msg="";
	foreach($arq as $line){
		$msg.=$line;
	}
	//Configurações Email
	$from="From: E-sinalização<esinalizacao@esinalizacao.com.br>\nContent-type: text/html\n";
	$titulo="$nome";
	//Mandar Email
	$sql=mysql_query("SELECT clientes.* FROM clientes,crm_acaor WHERE crm_acaor.acao='$id' AND crm_acaor.cliente=clientes.id");
	$i=0;
	$ee=0;
	while($res=mysql_fetch_array($sql)){
		//FollowUp
		mysql_query("INSERT INTO followup (cliente,data,hora,titulo,descricao,tipo) VALUES('$res[id]','$data','$hora','Ação Marketing','Foi enviado a seguinte Ação de Marketing para este cliente: $nome','3')");
		//print "$res[email],$titulo,$msg,$from";
		if(mail($res["email"],$titulo,$msg,$from)) $i++;
		print "$i - $res[email]<br>";
		$cont=mysql_query("SELECT * FROM cliente_contato WHERE cliente='$res[id]'");
		while($con=mysql_fetch_array($cont)){
			if(mail($con["email"],$titulo,$msg,$from)) $i++;
			print "$i - $con[email]<br>";
			//SCROLLLLLLL
				$ee+="20";
				print "<script>window.scroll(0,$ee);</script>";
				flush();
		}
	}
}
?>