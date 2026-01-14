<?
include("conecta.php");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Feriados";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="exc"){
	$sql=mysql_query("DELETE FROM feriados WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Feriado excluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O feriado não pôde ser excluído!";
		$acao="data";
	}
}elseif($acao=="alt"){
	if($anual!="S") $anual="N";
	$diames=substr($dia,0,2).substr($dia,3,2);
	$dia=data2banco($dia);
	$sql=mysql_query("UPDATE feriados SET dia='$dia',descricao='$descricao',anual='$anual',diames='$diames' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Feriado alterado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O feriado não pôde ser alterado!";
	}
	$acao="data";
}elseif($acao=="inc"){
	if($anual!="S") $anual="N";
	$diames=substr($dia,0,2).substr($dia,3,2);
	$dia=data2banco($dia);
	$sql=mysql_query("INSERT INTO feriados (dia,diames,descricao,anual) VALUES ('$dia','$diames','$descricao','$anual')");
	if($sql){
		$_SESSION["mensagem"]="Feriado incluído com sucesso!";
	}else{
		$_SESSION["mensagem"]="O feriado não pôde ser incluído!";
	}
	$acao="data";	
}
if($acao=="entrar"){
	header("Location:feriados.php");
}elseif($acao=="data"){
	header("Location:feriados.php?cal_dia=$cal_dia&cal_mes=$cal_mes&cal_ano=$cal_ano");
}

?>