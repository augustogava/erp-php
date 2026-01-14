<?php
include("conecta.php");
$hj=date("Y-m-d");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Vendas Faturar";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="alt"){
	if(isset($faturar)){
		foreach($faturar AS $ids => $idss){
			if($faturamento[$ids]){
					$sql=mysql_query("SELECT * FROM prodserv_sep WHERE pedido='$ids'");
					$res=mysql_fetch_array($sql);

				$sql=mysql_query("UPDATE vendas SET faturado=1 WHERE id='$ids'");
					$sql=mysql_query("SELECT * FROM vendas WHERE id='$ids' AND cr=0");
					if(!mysql_num_rows($sql)){
						$_SESSION["mensagem"]="Não foi possivel gerar o Contas a Receber\\nVerifique se o mesmo não foi gerado anteriormente";
					}else{
						$res=mysql_fetch_array($sql);
						$_SESSION["cliente"]=$res["cliente"];
						$_SESSION["cliente_tipo"]="C";
						$_SESSION["parcelamento"]=$res["parcelamento"];
						$_SESSION["documento"]="Venda ".$res["id"];
						$_SESSION["emissao"]=date("d/m/Y");
						$_SESSION["competencia"]=date("m/Y");
						$_SESSION["crvenda"]=1;
						$_SESSION["idvenda"]=$ids;
						$sql=mysql_query("SELECT SUM((qtd * unitario) - ((qtd * unitario)* desconto / 100)) AS valor FROM vendas_list WHERE venda='$ids'");
						if(mysql_num_rows($sql)){
							$res=mysql_fetch_array($sql);
							$_SESSION["valor"]=banco2valor($res["valor"]);
						}

						header("Location:cr_sql.php?acao=inc");
						exit;
	//<<<=========------- ACABA AKI
					}
				}		
			}	
		$_SESSION["mensagem"]="Vendas faturadas com sucesso!";
	}else{
		$_SESSION["mensagem"]="Selecione alguma venda para fatur";
	}
}
header("Location:vendas_fat.php");
?>