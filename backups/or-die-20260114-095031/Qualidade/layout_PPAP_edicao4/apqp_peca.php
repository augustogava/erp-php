<?php
include("conecta.php");
if(empty($peca)){ exit; }
if(!empty($acao)){
	$loc="APQP - Caracteristicas Importar";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="sel"){
	foreach($del as $key=>$valor){
		$sql=mysql_query("SELECT * FROM apqp_car WHERE id='$key'");
		$res=mysql_fetch_array($sql);
			$sql_r=mysql_query("SELECT * FROM apqp_car WHERE peca='$peca' AND tipo='$res[tipo]' AND numero='$res[numero]'");
			if(!mysql_num_rows($sql_r)){
				$sql2=mysql_query("INSERT INTO apqp_car (peca,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$peca','$res[descricao]','$res[espec]','$res[numero]','$res[pc]','$res[simbolo]','$res[tipo]','$res[lie]','$res[lse]','$res[tol]','$res[nominal]')") or die("Akii tb nao foi");
			}
	}
}else if($acao=="tudo"){
	
	$sql=mysql_query("SELECT * FROM apqp_car WHERE peca='$id'") or die("Erro");
		while($res=mysql_fetch_array($sql)){
			$sql_r=mysql_query("SELECT * FROM apqp_car WHERE peca='$peca' AND tipo='$res[tipo]' AND numero='$res[numero]'");
			if(!mysql_num_rows($sql_r)){
				$sql2=mysql_query("INSERT INTO apqp_car (peca,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$peca','$res[descricao]','$res[espec]','$res[numero]','$res[pc]','$res[simbolo]','$res[tipo]','$res[lie]','$res[lse]','$res[tol]','$res[nominal]')") or die("Nao ta indo aki");
			}
		}
}
	if($sql2){
		$_SESSION["mensagem"]="Importado com Sucesso!!";
		print "<script>opener.location='apqp_car.php?id=$peca&acao=inc';window.close();</script>";
	}else{
		$_SESSION["mensagem"]="Não pode ser Importado";
		print "<script>opener.location='apqp_car.php?id=$peca&acao=inc';window.close();</script>";
	}
?>