<?
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Requisiчуo de Compra";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO compras_requisicao (responsavel) VALUES ('$_SESSION[login_nome]')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM compras_requisicao");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("INSERT INTO compras_requisicao_list (requisicao) VALUES ('$id')");
	header("Location:compras_req.php?acao=alt&id=$id");
	exit;
}elseif($acao=="alt"){
		$data=data2banco($data);
		mysql_query("UPDATE compras_requisicao SET data='$data' WHERE id='$id'");
		if(isset($qtd)){
			foreach($qtd AS $ids => $idss){
				$prodserv2=$prodserv[$ids];
				$qtd2=valor2banco($qtd[$ids]);
				$unitario2=valor2banco($unitario[$ids]);
				$unidade2=$unidade[$ids];
				$motivo2=$motivo[$ids];
				$solicitante2=$solicitante[$ids];
				
				$sql=mysql_query("UPDATE compras_requisicao_list SET produto='$prodserv2',qtd='$qtd2',unidade='$unidade2',valor='$unitario2',motivo='$motivo2',solicitante='$solicitante2' WHERE id='$ids'");
			}			
		}
			

		if($maisum){
			$sql=mysql_query("INSERT INTO compras_requisicao_list (requisicao) VALUES ('$id')");
			unset($_SESSION["mensagem"]);
		}
		if($delsel){
			if(isset($del)){
				foreach($del AS $ids => $idss){
					$sql=mysql_query("DELETE FROM compras_requisicao_list WHERE id='$ids'");
				}
				unset($_SESSION["mensagem"]);
			}else{
				$_SESSION["mensagem"]="Selecione as linhas que deseja excluir";
			}
		}		
	if($sql){
		$_SESSION["mensagem"]="Requisiчуo alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A requisiчуo nуo pєde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="fechar"){
	$hj=date("Y-m-d");
	mysql_query("UPDATE compras_requisicao SET fechar='1' WHERE id='$id'");
	
	$sql=mysql_query("SELECT * FROM compras_requisicao_list  WHERE requisicao='$id'");
	while($res=mysql_fetch_array($sql)){
		mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,origem,tipomov) VALUES('$res[produto]','$hj','$res[qtd]','$res[valor]','2','6')");
	}
	if($sql){
		$_SESSION["mensagem"]="Requisiчуo Fechada com sucesso!";
	}else{
		$_SESSION["mensagem"]="A requisiчуo nуo pєde ser fechada!";
	}		
	header("Location:compras_req.php");
	exit;
}
header("Location:compras_req.php?acao=alt&id=$id");
?>