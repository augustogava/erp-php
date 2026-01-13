<?
include("conecta.php");
$apqp=new set_apqp;
if($acao=="sel"){
		//verificar Cliente
		$apqp->cliente_apro("apqp_plano_pop.php");
		// - - - - - - - -  -
	$sql2=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc' AND fase='$fase'");
	if(!mysql_num_rows($sql2)){
		$sql2=mysql_query("INSERT INTO apqp_plano (peca,fase) VALUES ('$pc','$fase')");
	}
	//
	$sql=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc' AND fase='$fase'");
	$res=mysql_fetch_array($sql);
	$plano=$res["id"];
	//
	$sql2=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc' AND fase='$fase2'");
	$res2=mysql_fetch_array($sql2);
	$plano2=$res2["id"];

			$sql2=mysql_query("SELECT * FROM apqp_planoi WHERE plano='$plano2'");
			while($res2=mysql_fetch_array($sql2)){
				$sql3=mysql_query("INSERT INTO apqp_planoi (plano,op,car,tecnicas,tamanho,freq,metodo,reacao) VALUES ('$plano','$res2[op]','$res2[car]','$res2[tecnicas]','$res2[tamanho]','$res2[freq]','$res2[metodo]','$res2[reacao]')");
			}
			unset($_SESSION["mensagem"]);
}
$_SESSION["mensagem"]="Importado com Sucesso!!";
print "<script>opener.location='apqp_planot.php';window.close();</script>";
exit; 
?>