<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Natureza";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO natureza (nome,codigo) VALUES ('$nome','$codigo')");
	if($sql){
		$_SESSION["mensagem"]="Natureza incluida com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A natureza nao pode ser incluida!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE natureza SET nome='$nome',codigo='$codigo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Natureza alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A natureza nao pode ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM natureza WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Natureza excluida com sucesso!";
		}else{
			$_SESSION["mensagem"]="A Natureza nao pode ser excluida!";
		}		
	}
	$acao="entrar";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Natureza - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe a Natureza');
		cad.nome.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-tags"></i> Natureza</h1>
            <?php if($acao=="entrar"): ?>
            <a href="natureza.php?acao=inc" class="erp-btn erp-btn-primary">
                + Nova Natureza
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <?php if($acao=="entrar"){ ?>
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">Codigo</th>
                    <th>Nome</th>
                    <th width="120" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM natureza ORDER BY nome ASC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="3" class="erp-text-center" style="padding:40px;">Nenhuma natureza cadastrada</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><?php echo $res["codigo"]; ?></td>
                    <td><?php echo $res["nome"]; ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="natureza.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir esta natureza?','natureza.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php }elseif($acao=="inc" or $acao=="alt"){ 
        $res = array();
        if($acao=="alt"){
            $sql=mysql_query("SELECT * FROM natureza WHERE id='$id'");
            if($sql && mysql_num_rows($sql) > 0){
                $res=mysql_fetch_array($sql);
            }
        }
    ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <?php echo ($acao=="inc") ? "Incluir Natureza" : "Alterar Natureza"; ?>
        </h3>
        <form name="form1" method="post" action="" onsubmit="return verifica(this)">
            <div class="erp-row">
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Codigo</label>
                        <input name="codigo" type="text" class="erp-form-control" value="<?php echo isset($res["codigo"]) ? $res["codigo"] : ''; ?>" size="10">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome</label>
                        <input name="nome" type="text" class="erp-form-control" value="<?php echo isset($res["nome"]) ? $res["nome"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='natureza.php'">
                    Voltar
                </button>
                <button type="submit" class="erp-btn erp-btn-primary">
                    Salvar
                </button>
            </div>
            <input name="acao" type="hidden" value="<?php echo ($acao=="alt") ? "alterar" : "incluir"; ?>">
            <input name="id" type="hidden" value="<?php echo $id; ?>">
        </form>
    </div>
    <?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
