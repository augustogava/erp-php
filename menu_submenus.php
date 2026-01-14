<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="exc"){
	$sql=mysql_query("DELETE FROM submenus WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Submenu excluido com sucesso!";
	}else{
		$_SESSION["mensagem"]="O Submenu nao pode ser excluido!";
	}
	$acao="entrar";
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE submenus SET menu='$menu',texto='$texto',url='$url' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Submenu alterado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O Submenu nao pode ser alterado!";
	}
	$acao="entrar";
}elseif($acao=="incluir"){
	$sql=mysql_query("INSERT INTO submenus (menu,texto,url) VALUES ('$menu','$texto','$url')");
	if($sql){
		$_SESSION["mensagem"]="Submenu adicionado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O Submenu nao pode ser adicionado!";
	}
	$acao="entrar";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Submenus - ERP System</title>
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
function verifica(campos){
	if(campos.menu[campos.menu.selectedIndex].value==''){
		alert('Informe a qual menu pertence este submenu');
		campos.menu.focus();
		return false;
	}
	if(campos.texto.value==''){
		alert('Informe o texto do submenu');
		campos.texto.focus();
		return false;
	}
	if(campos.url.value==''){
		alert('Informe a url do submenu');
		campos.url.focus();
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
            <h1 class="erp-card-title"><i class="fas fa-sitemap"></i> Submenus</h1>
            <?php if($acao=="entrar"): ?>
            <a href="menu_submenus.php?acao=inc" class="erp-btn erp-btn-primary">
                + Novo Submenu
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
                    <th width="80">Menu</th>
                    <th>Submenu</th>
                    <th>URL</th>
                    <th width="120" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM submenus ORDER BY menu ASC,texto ASC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="4" class="erp-text-center" style="padding:40px;">Nenhum submenu disponivel</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><?php echo $res["menu"]; ?></td>
                    <td><?php echo $res["texto"]; ?></td>
                    <td><?php echo $res["url"]; ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="menu_submenus.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir este submenu?','menu_submenus.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
    <?php }elseif($acao=="alt" or $acao=="inc"){ 
        $res = array();
        $wmen = "";
        if($acao=="alt"){
            $sql=mysql_query("SELECT * FROM submenus WHERE id='$id'");
            if($sql && mysql_num_rows($sql) > 0){
                $res=mysql_fetch_array($sql);
                $wmen=$res["menu"];
            }
        }
    ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <?php echo ($acao=="inc") ? "Incluir Submenu" : "Alterar Submenu"; ?>
        </h3>
        <form name="form1" method="post" action="" onsubmit="return verifica(this)">
            <div class="erp-row">
                <div class="erp-col" style="max-width:300px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Menu</label>
                        <select name="menu" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php 
                            $sqlmen=mysql_query("SELECT * FROM menus ORDER BY texto ASC");
                            while($resmen=mysql_fetch_array($sqlmen)){
                            ?>
                            <option value="<?php echo $resmen["id"]; ?>"<?php if($wmen==$resmen["id"]) echo " selected"; ?>><?php echo $resmen["texto"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Texto</label>
                        <input name="texto" type="text" class="erp-form-control" value="<?php echo isset($res["texto"]) ? $res["texto"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">URL</label>
                        <input name="url" type="text" class="erp-form-control" value="<?php echo isset($res["url"]) ? $res["url"] : ''; ?>" maxlength="100">
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='menu_submenus.php'">
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
