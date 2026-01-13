<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) exit;
if(!empty($acao)){
	$loc="Funcionarios";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
				$nascimento=data2banco($nascimento);
				$admissao=data2banco($admissao);
				$sql=mysql_query("INSERT INTO funcionarios (nome,nascimento,rg,carteira,admissao,cargo,org,filial,centro,cooperado,grupo,email) VALUES('$nome','$nascimento','$rg','$carteira','$admissao','$cargo','$org','$filial','$centro','$cooperado','$grupo','$email')");
				header("Location:funcionarios.php");
				exit;
}elseif($acao=="alterar"){
	$nascimento=data2banco($nascimento);
	$admissao=data2banco($admissao);
	$sql=mysql_query("UPDATE funcionarios SET nome='$nome',email='$email',nascimento='$nascimento',rg='$rg',carteira='$carteira',admissao='$admissao',cargo='$cargo',org='$org',filial='$filial',cooperado='$cooperado',grupo='$grupo',centro='$centro' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro geral alterado!";
		header("Location:funcionarios.php?bcod=$bcod&bnome=$bnome");
		exit;		
	}else{
		$_SESSION["mensagem"]="O cadastro geral não pôde ser alterado!";
		$nascimento=banco2data($nascimento);
		$admissao=banco2data($admissao);				
		$acao="alt";
	}
}
?>