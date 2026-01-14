<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Cargos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO cargos (nome) VALUES ('$nome')");
	if($sql){
		$_SESSION["mensagem"]="Cargo incluido com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O cargo nao pode ser incluido!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE cargos SET nome='$nome' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cargo alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O cargo nao pode ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM cargos WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Cargo excluido com sucesso!";
		}else{
			$_SESSION["mensagem"]="O cargo nao pode ser excluido!";
		}		
	}
	$acao="entrar";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Cargos - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
		alert('Informe o Cargo');
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
            <h1 class="erp-card-title"><i class="fas fa-user-tie"></i> Cargos</h1>
            <?php if($acao=="entrar"): ?>
            <a href="cargos.php?acao=inc" class="erp-btn erp-btn-primary">
                + Novo Cargo
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
                    <th>Cargo</th>
                    <th width="120" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM cargos ORDER BY nome ASC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="2" class="erp-text-center" style="padding:40px;">Nenhum cargo cadastrado</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><?php echo $res["nome"]; ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="cargos.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir este cargo?','cargos.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
            $sql=mysql_query("SELECT * FROM cargos WHERE id='$id'");
            if($sql && mysql_num_rows($sql) > 0){
                $res=mysql_fetch_array($sql);
            }
        }
    ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <?php echo ($acao=="inc") ? "Incluir Cargo" : "Alterar Cargo"; ?>
        </h3>
        <form name="form1" method="post" action="" onsubmit="return verifica(this)">
            <?php if($acao=="alt"){ ?>
            <div class="erp-row">
                <div class="erp-col" style="max-width:100px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">ID</label>
                        <input type="text" class="erp-form-control" value="<?php echo $res["id"]; ?>" readonly style="background:#e9ecef;">
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cargo</label>
                        <input name="nome" type="text" class="erp-form-control" value="<?php echo isset($res["nome"]) ? $res["nome"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='cargos.php'">
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
