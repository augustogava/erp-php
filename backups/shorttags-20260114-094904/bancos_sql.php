<?
include("conecta.php");
if(empty($acao)) header("Location:bancos.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Bancos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="inc"){
	$abertura=data2banco($abertura);
	$inicial=valor2banco($inicial);
	$limite=valor2banco($limite);
	$sql=mysql_query("INSERT INTO bancos (bco,apelido,agencia,conta,abertura,inicial,limite,saldo,obs) VALUES ('$bco','$apelido','$agencia','$conta','$abertura','$inicial','$limite','$inicial','$obs')");
	if($sql){
		$sql=mysql_query("SELECT MAX(id) AS id FROM bancos");
		$res=mysql_fetch_array($sql);
		$id=$res["id"];
		$hist="Abertura da conta $apelido $agencia-$conta";
		$sql=mysql_query("INSERT INTO bancos_lan (bco,data,hist,val_ent,val_sai,operacao,documento,saldo_ant) VALUES ('$id',NOW(),'$hist','$inicial','0','2','','0')");
		$_SESSION["mensagem"]="Banco incluído com sucesso";
		header("Location:bancos.php?acao=alt&id=$id");	
	}else{
		$_SESSION["mensagem"]="O banco não pôde ser incluído";
		header("Location:bancos.php?acao=inc");
	}
}elseif($acao=="alt"){
	$abertura=data2banco($abertura);
	$limite=valor2banco($limite);
	$sql=mysql_query("UPDATE bancos SET bco='$bco',apelido='$apelido',agencia='$agencia',conta='$conta',abertura='$abertura',limite='$limite',obs='$obs' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Banco alterado com sucesso";
	}else{
		$_SESSION["mensagem"]="O banco não pôde ser alterado";
	}
	header("Location:bancos.php?acao=alt&id=$id");
}elseif($acao=="exc"){
	$sql=mysql_query("DELETE FROM bancos WHERE id='$id'");
	//excluir lançamentos
	if($sql){
		$_SESSION["mensagem"]="Banco excluído com sucesso";
	}else{
		$_SESSION["mensagem"]="O banco não pôde ser excluído";
	}
	header("Location:bancos.php");
}elseif($acao=="lanc"){
	$bco=$_SESSION["banco_ativo"];
	if(!empty($bco)){
		$data=data2banco($data);
		if($tipo=="E"){
			$val_ent=valor2banco($valor);
			$val_sai=0;
		}else{
			$val_sai=valor2banco($valor);
			$val_ent=0;
		}
		$sql=mysql_query("SELECT saldo FROM bancos WHERE id='$bco'");
		$res=mysql_fetch_array($sql);
		$saldo_ant=$res["saldo"];
		$sql=mysql_query("INSERT INTO bancos_lan (bco,data,hist,val_ent,val_sai,operacao,documento,saldo_ant) VALUES ('$bco','$data','$hist','$val_ent','$val_sai','$operacao','$documento','$saldo_ant')");
		if($sql){
			$saldo=$saldo_ant-$val_sai+$val_ent;
			$sql=mysql_query("UPDATE bancos SET saldo='$saldo' WHERE id='$bco'");
			$_SESSION["mensagem"]="Lançamento efetuado com sucesso";
			header("Location:bancos_lan.php?setbco=$bco");
			exit;
		}else{
			$_SESSION["mensagem"]="O lançamento não pôde ser efetuado";
		}
	}else{
		$_SESSION["mensagem"]="O lançamento não pôde ser efetuado";
	}
	header("Location:bancos.php");
}
?>