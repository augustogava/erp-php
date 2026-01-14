<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) exit;
if($acao=="inc"){
	if($arquivos <> 'none') {
		if($arquivos_size==0){
			$_SESSION["mensagem"]="O arquivo deve ter até 2Mb";
			$acao="inc";
		}else{
			$sql=mysql_query("SELECT * FROM up_arq WHERE nome='$arquivos_name' AND pasta='$pasta'");
			if(mysql_num_rows($sql)){
				$_SESSION["mensagem"]="O arquivo já existe!";
				$acao="inc";
			}else{
				$data=date("Y-m-d");
				$hora=hora();
				$sql = mysql_query("INSERT INTO up_arq (nome,pasta,data,hora,tamanho) VALUES ('$arquivos_name','$pasta','$data','$hora','$arquivos_size')");
				if($sql){
					$sql2=mysql_query("SELECT MAX(id) AS id FROM up_arq");
					$res=mysql_fetch_array($sql2);
					$arquivo = "$patch/up_files/$res[id].mng";
					copy($arquivos, $arquivo);
					$_SESSION["mensagem"]="Arquivo carregado com sucesso";
					$acao="abre_pasta2";
				}else{
					$_SESSION["mensagem"]="O arquivo não pôde ser carregado";
					$acao="inc";
				}
			}
		}
	}
}elseif($acao=="down"){
	$sql=mysql_query("SELECT * FROM up_arq WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	header('Content-Type: application/octetstream');
	header("Content-Disposition: attachment; filename=$res[nome]");
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	readfile("up_files/$res[id].mng");
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM up_arq WHERE nome='$nome' AND pasta='$pasta' AND id<>'$id'");
	if(mysql_num_rows($sql)==0){
		$sql=mysql_query("UPDATE up_arq SET nome='$nome',pasta='$pasta' WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Arquivo alterado com sucesso!";
			$acao="abre_pasta2";
		}else{
			$_SESSION["mensagem"]="O arquivo não pôde ser alterado!";
			$acao="alt";
		}
	}else{
		$_SESSION["mensagem"]="O arquivo já existe!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
			$sql=mysql_query("DELETE FROM up_arq WHERE id='$id'");
			if($sql){
				unlink("$patch/up_files/$id.mng");
				$_SESSION["mensagem"]="Arquivo excluído com sucesso!";
			}else{
				$_SESSION["mensagem"]="O Arquivo não pôde ser excluído!";
			}		
	}
	$acao="abre_pasta";
}
if($acao=="entrar"){
	header("Location:up_arq.php");
}elseif($acao=="abre_pasta2"){
	header("Location:up_arq.php?acao=abre_pasta&id=$pasta");
}else{
	header("Location:up_arq.php?acao=$acao");
}
?>