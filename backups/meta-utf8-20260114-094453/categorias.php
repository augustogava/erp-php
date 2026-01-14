<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Categorias";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM categorias WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Categorias - ERP System</title>
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
		alert('Informe a Categoria');
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
            <h1 class="erp-card-title"><i class="fas fa-folder"></i> Categorias</h1>
            <?php if($acao=="entrar"): ?>
            <a href="categorias.php?acao=inc" class="erp-btn erp-btn-primary">
                + Nova Categoria
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
                    <th>Categoria</th>
                    <th width="120" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM categorias ORDER BY nome ASC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="2" class="erp-text-center" style="padding:40px;">Nenhuma categoria cadastrada</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><?php echo $res["nome"]; ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="categorias.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir esta Categoria?','categorias_sql.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
    <?php }else{ 
        if($acao!="alt") $res = array();
    ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <?php echo ($acao=="inc") ? "Incluir Categoria" : "Alterar Categoria"; ?>
        </h3>
        <form name="form1" method="post" action="categorias_sql.php" onsubmit="return verifica(this)">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Categoria</label>
                        <input name="nome" type="text" class="erp-form-control" value="<?php echo isset($res["nome"]) ? $res["nome"] : ''; ?>" maxlength="80">
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='categorias.php'">
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
