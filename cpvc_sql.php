<?php
include("conecta.php");
$acao=Input::request("acao");
$id=Input::request("id");
$perfil=Input::request("perfil");
$inferior=Input::request("inferior");
$superior=Input::request("superior");
$cristal=Input::request("cristal");
$nome=Input::request("nome");
$b1=Input::request("b1");
$b2=Input::request("b2");
$b3=Input::request("b3");
$co1=Input::request("co1");
$co2=Input::request("co2");
$ps=Input::request("ps");
if(empty($acao)) exit;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Portas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$b1=valor2banco($b1);
	$b2=valor2banco($b2);
	$b3=valor2banco($b3);
	$co1=valor2banco($co1);
	$co2=valor2banco($co2);
	$sql=mysql_query("INSERT INTO portasp (perfil,pvc_inferior,pvc_superior,pvc_cristal,nome,b1,b2,b3,co1,co2) VALUES ('$perfil','$inferior','$superior','$cristal','$nome','$b1','$b2','$b3','$co1','$co2')");
	if($sql){
		$_SESSION["mensagem"]="Perfilincluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Perfil não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$b1=valor2banco($b1);
	$b2=valor2banco($b2);
	$b3=valor2banco($b3);
	$co1=valor2banco($co1);
	$co2=valor2banco($co2);
	$sql=mysql_query("UPDATE portasp SET perfil='$perfil',pvc_inferior='$inferior',pvc_superior='$superior',pvc_cristal='$cristal',nome='$nome',b1='$b1',b2='$b2',b3='$b3',co1='$co1',co2='$co2' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Perfil alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Perfil não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM portasp WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Perfil excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Perfil não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
header("Location:cpvc.php?acao=$acao&id=$id&ps=$ps");
?>