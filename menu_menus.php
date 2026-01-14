<?php
include("conecta.php");
include("seguranca.php");

$acao = Input::request('acao', '');
$id = Input::request('id', '');
$texto = Input::request('texto', '');
$url = Input::request('url', '');
if(empty($acao)) $acao="entrar";
if($acao=="exc"){
	$sql=mysql_query("DELETE FROM menus WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Item excluido com sucesso!";
	}else{
		$_SESSION["mensagem"]="O item nao pode ser excluido!";
	}
	$acao="entrar";
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE menus SET texto='$texto',url='$url' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Item alterado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O item nao pode ser alterado!";
	}
	$acao="entrar";
}elseif($acao=="incluir"){
	$sql=mysql_query("INSERT INTO menus (texto,url) VALUES ('$texto','$url')");
	if($sql){
		$_SESSION["mensagem"]="Item adicionado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O item nao pode ser adicionado!";
	}
	$acao="entrar";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Menus - ERP System</title>
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
function verifica(campos){
	if(campos.texto.value==''){
		alert('Informe o texto do menu');
		campos.texto.focus();
		return false;
	}
	if(campos.url.value==''){
		alert('Informe a url do menu');
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
            <h1 class="erp-card-title"><i class="fas fa-bars"></i> Menus</h1>
            <?php if($acao=="entrar"): ?>
            <a href="menu_menus.php?acao=inc" class="erp-btn erp-btn-primary">
                + Novo Menu
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
                    <th>Menu</th>
                    <th>URL</th>
                    <th width="120" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM menus ORDER BY texto ASC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="3" class="erp-text-center" style="padding:40px;">Nenhum item de menu disponivel</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><?php echo $res["texto"]; ?></td>
                    <td><?php echo $res["url"]; ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="menu_menus.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir este item de menu?','menu_menus.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
        if($acao=="alt"){
            $sql=mysql_query("SELECT * FROM menus WHERE id='$id'");
            if($sql && mysql_num_rows($sql) > 0){
                $res=mysql_fetch_array($sql);
            }
        }
    ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <?php echo ($acao=="inc") ? "Incluir Menu" : "Alterar Menu"; ?>
        </h3>
        <form name="form1" method="post" action="" onsubmit="return verifica(this)">
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
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='menu_menus.php'">
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
