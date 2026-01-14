<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Produtos Cat";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM prodserv_cat WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>E-Categorias - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
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

<body style="background:#f8f9fa;padding:24px;" onLoad="enterativa=1;" onkeypress="return ent()">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-sitemap"></i> E-Categorias</h1>
            <?php if($acao=="entrar"): ?>
            <a href="prodserv_cat.php?acao=inc" class="erp-btn erp-btn-primary">
                <i class="fas fa-plus"></i> Nova Categoria
            </a>
            <?php else: ?>
            <a href="prodserv_cat.php" class="erp-btn erp-btn-outline">
                <i class="fas fa-arrow-left"></i> Voltar
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
                    <th>Codigo / Nome da Categoria</th>
                    <th width="120" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            function lista($idpai){
                $sql=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$idpai' ORDER BY codigo ASC");
                if(mysql_num_rows($sql)!=0){
                    while($res=mysql_fetch_array($sql)){
                        $sql2=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$res[id]' ORDER BY texto ASC");
                        $widpai=$res["id"];
                        $esp=0;
                        while($widpai!=0){
                            $sql3=mysql_query("SELECT idpai FROM prodserv_cat WHERE id='$widpai'");
                            $res3=mysql_fetch_array($sql3);
                            $widpai=$res3["idpai"];
                            if($widpai!=0) $esp++;
                        }
                        $esps=str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $esp);
                        $icon = ($esp > 0) ? '<i class="fas fa-level-up-alt fa-rotate-90" style="color:#ccc;margin-right:8px;"></i>' : '<i class="fas fa-folder" style="color:#f1c40f;margin-right:8px;"></i>';
                        ?>
                        <tr>
                            <td><?php echo $esps . $icon . "<strong>$res[codigo]</strong> $res[texto]"; ?></td>
                            <td>
                                <div class="erp-table-actions" style="justify-content:center;">
                                    <a href="prodserv_cat.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Alterar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="return pergunta('Deseja excluir esta Categoria?','prodserv_cat_sql.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        if(mysql_fetch_array($sql2)){
                            lista($res["id"]);
                        }
                    }
                }
            }
            $sqlw=mysql_query("SELECT * FROM prodserv_cat");
            if(!mysql_num_rows($sqlw)){
            ?>
                <tr>
                    <td colspan="2" class="erp-text-center" style="padding:40px;">Nenhuma categoria cadastrada</td>
                </tr>
            <?php
            }else{
                lista(0);
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php }else{ ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <?php if($acao=="inc"){ echo "<i class='fas fa-plus'></i> Incluir"; }else{ echo "<i class='fas fa-edit'></i> Alterar";} ?> Categoria
        </h3>
        <form name="form1" method="post" action="prodserv_cat_sql.php" onSubmit="return verifica(this);">
            <div class="erp-row">
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Codigo</label>
                        <input name="codigo" type="text" class="erp-form-control" value="<?php echo $res["codigo"]; ?>" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Titulo</label>
                        <input name="texto" type="text" class="erp-form-control" value="<?php echo $res["texto"]; ?>" maxlength="255">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Dentro de</label>
                        <select name="idpai" class="erp-form-control">
                            <option value="0" <?php if($res["idpai"]==0) echo "selected"; ?>>Raiz</option>
                            <?php
                            function no($idpai,$wcat){
                                $sql=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$idpai' ORDER BY texto ASC");
                                if(mysql_num_rows($sql)!=0){
                                    while($res=mysql_fetch_array($sql)){
                                        $sql2=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$res[id]' ORDER BY texto ASC");
                                        $widpai=$res["id"];
                                        $esp=0;
                                        while($widpai!=0){
                                            $sql3=mysql_query("SELECT idpai FROM prodserv_cat WHERE id='$widpai'");
                                            $res3=mysql_fetch_array($sql3);
                                            $widpai=$res3["idpai"];
                                            if($widpai!=0) $esp++;
                                        }
                                        if($res["id"]==$wcat){
                                            $selsel="selected";
                                        }else{
                                            $selsel="";
                                        }
                                        echo "<option value=\"$res[id]\" $selsel>".str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $esp)."$res[texto]</option>\n";
                                        if(mysql_fetch_array($sql2)){
                                            no($res["id"],$wcat);
                                        }
                                    }
                                }
                            }
                            no(0,$res["idpai"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Ativo</label>
                        <div style="display:flex;gap:20px;margin-top:8px;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="ativo" type="radio" value="1" <?php if($res["ativo"]) echo "checked"; ?>> Sim
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="ativo" type="radio" value="0" <?php if(!$res["ativo"]) echo "checked"; ?>> Nao
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='prodserv_cat.php'">
                    Voltar
                </button>
                <button type="submit" class="erp-btn erp-btn-primary">
                    <i class="fas fa-check"></i> Salvar
                </button>
            </div>
            <input name="acao" type="hidden" value="<?php echo $acao; ?>">
            <input name="id" type="hidden" value="<?php echo $id; ?>">
        </form>
    </div>
    <?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
