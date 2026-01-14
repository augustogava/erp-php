<?
include("conecta.php");
if(empty($acao)) exit;
if($acao=="inc"){
	$sql=mysql_query("INSERT INTO up_pastas (nome,publica,dono) VALUES ('$nome','$publica','$_SESSION[login_codigo]')");
	if($sql){
		$_SESSION["mensagem"]="Pasta criada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Pasta não pôde ser criada!";
		$acao="inc";
	}
}elseif($acao=="alt"){
	$sql=mysql_query("UPDATE up_pastas SET nome='$nome',publica='$publica' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Pasta alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Pasta não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("SELECT * FROM up_pastas WHERE id='$id'");
		$res=mysql_fetch_array($sql);
		if($res["deleta"]=="S"){
			$sql=mysql_query("DELETE FROM up_pastas WHERE id='$id'");
			$sql=mysql_query("SELECT * FROM up_arq WHERE pasta='$id'");
			if (mysql_num_rows($sql)){
				while ($res=mysql_fetch_array($sql)){
					unlink("$patch/up_files/$res[id].mng");
					$sqldel=mysql_query("DELETE FROM up_arq WHERE id='$res[id]'");
				}
			}
			if($sql){
			$_SESSION["mensagem"]="Pasta excluída com sucesso!";
			}else{
			$_SESSION["mensagem"]="A Pasta não pôde ser excluída!";
			}		
		}else{
		$_SESSION["mensagem"]="A Pasta não pôde ser excluída!";
		}
	}
	$acao="entrar";
}
if($acao=="entrar"){
	header("Location:up_pastas.php");
}else{
	header("Location:up_pastas.php?acao=$acao&id=$id");
}
?>