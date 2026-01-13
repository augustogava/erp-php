<?
$sqlas=mysql_query("SELECT * FROM empresa");
$resas=mysql_fetch_array($sqlas);.
$_SESSION["data_i"]=$resas["data"];
if(@fopen("http://www.cyber1.com.br/manager/pmtp.txt",'r') or !empty($chavi)){
	$lines = file ("http://www.cyber1.com.br/manager/pmtp.txt");		  
	foreach($lines as $line){
		$valo=explode(";",$line);
		if(dcrip($valo[2])==$resas["cnpj"]){ $achou="sim"; break; }
	}
	if($achou=="sim"){
		$_SESSION["licencasa"]=$valo[3];
		$_SESSION["chavee"]=(dcrip($valo[2])/date("d")/date("m")/date("y"));
		if(empty($chavi)){
			$_SESSION["chave_res"]=(dcrip($valo[2])/date("d"))/date("d");
		}else{
			$_SESSION["chave_res"]=$chavi;
		}
	}else{
		$_SESSION["errof"]="sim";
	}
}else{
	$_SESSION["codigo"]=($resas["cnpj"]/date("y")/date("d"));
}
	
?>