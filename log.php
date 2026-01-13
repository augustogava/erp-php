<?
//Usados
$ip=$_SERVER['REMOTE_ADDR'];
$data=date("Y-m-d");
$hora=date("H:i:s");
$iduser=$_SESSION["login_codigo"];
$funcionario=$_SESSION["login_funcionario"];
if($funcionario=="S"){ $tipoo="funcionarios"; }else{ $tipoo="clientes"; }
//banco
$blog=mysql_query("INSERT INTO log (user,funcionario,data,hora,ip,acao,local,pagina) VALUES('$iduser','$funcionario','$data','$hora','$ip','$acao','$loc','$pagina')") or die("nun foi");
$sus=mysql_query("SELECT * FROM $tipoo WHERE id='$iduser'"); $rsus=mysql_fetch_array($sus);
$data=banco2data($data);
/*
if($blog){
	$mes=date("m_Y");
	$arquivo="log_$mes.txt";
	if(file_exists($arquivo)){
		$abrir = fopen($arquivo, 'a+');
		$linhas=file($arquivo);
			foreach($linhas as $line){
				$linhab++;
			}
			$linhab-=3;
		fwrite($abrir,"\n$linhab $rsus[nome] $data $hora $ip $acao : $id $loc $pagina");
	}else{
		$abrir = fopen($arquivo, 'a+');
		fwrite($abrir,"=====================");
		fwrite($abrir,"\nLOG $mes");
		fwrite($abrir,"\n=====================");
		fwrite($abrir,"\n1 $rsus[nome] $data $hora $ip $acao : $id $loc $pagina");
	}

	
	fclose($abrir);
}
*/
?>