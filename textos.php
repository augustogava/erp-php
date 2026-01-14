<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$where="";
if(!empty($texto)){
	$where="WHERE texto like '%$texto%'";
}
if(!empty($placa)){
	$where="WHERE codigo LIKE '%$placa%'";
}
if(!empty($texto) and !empty($placa)){
	$where="WHERE texto like '%$texto%' and codigo LIKE '%$placa%'";
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM textos WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Textos - ERP System</title>
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
	if(cad.texto.value==''){
		alert('Informe o Texto');
		cad.texto.focus();
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
            <h1 class="erp-card-title"><i class="fas fa-font"></i> Textos</h1>
            <?php if($acao=="entrar"): ?>
            <a href="textos.php?acao=inc" class="erp-btn erp-btn-primary">
                + Novo Texto
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
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:16px;color:#2c3e50;"><i class="fas fa-search"></i> Busca</h3>
        <form name="form2" method="post" action="">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Texto</label>
                        <input name="texto" type="text" class="erp-form-control" value="<?php echo isset($texto) ? $texto : ''; ?>">
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Placa</label>
                        <input name="placa" type="text" class="erp-form-control" maxlength="10">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <input name="buscar" type="hidden" value="true">
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="120">Placa</th>
                    <th>Texto</th>
                    <th width="120" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM textos $where ORDER BY texto ASC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="3" class="erp-text-center" style="padding:40px;">Nenhum texto encontrado</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><?php echo $res["codigo"]; ?></td>
                    <td><?php echo $res["texto"]; ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="textos.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir este texto?','textos_sql.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
            <?php echo ($acao=="inc") ? "Incluir Texto" : "Alterar Texto"; ?>
        </h3>
        <form name="form1" method="post" action="textos_sql.php" onsubmit="return verifica(this)">
            <div class="erp-row">
                <div class="erp-col" style="max-width:300px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Placa</label>
                        <select name="placa" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php
                            $sqlmaterial=mysql_query("SELECT * FROM prodserv WHERE tip_material='1' ORDER BY id ASC");
                            while($resmaterial=mysql_fetch_array($sqlmaterial)){
                            ?>
                            <option value="<?php echo $resmaterial["id"]; ?>"<?php if(isset($res["placa"]) && $res["placa"]==$resmaterial["id"]) echo " selected"; ?>><?php echo $resmaterial["apelido"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Texto</label>
                        <input name="texto" type="text" class="erp-form-control" value="<?php echo isset($res["texto"]) ? $res["texto"] : ''; ?>" maxlength="20">
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='textos.php'">
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
