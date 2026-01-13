<?
include("conecta.php");
include("seguranca.php");
unset($_SESSION["ps"]);
$acao=verifi($permi,$acao);
$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Cadastro Produtos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if(!empty($cat)){
	$where="WHERE ecat='$cat'";
}

if(!empty($nome)){
	$where="WHERE nome LIKE '%$nome%' OR codprod LIKE '%$nome%'";
}

if($acao=="exc"){
	$sql=mysql_query("DELETE FROM prodserv WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Produto exclua­do com sucesso!";
	}else{
		$_SESSION["mensagem"]="Erro ao excluir produto!";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Produtos/Servicos - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title">ð¦ Produtos e Servicos</h1>
            <div style="display:flex;gap:8px;">
                <a href="prodserv_cat.php" class="erp-btn erp-btn-outline">
                    ð Categorias
                </a>
                <a href="prodserv_sql.php?acao=inc" class="erp-btn erp-btn-primary">
                    + Novo Produto
                </a>
            </div>
        </div>
    </div>
    
    <div class="erp-card">
        <form name="form1" method="post" action="">
            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome ou Ca³digo</label>
                        <input name="nome" type="text" class="erp-form-control" placeholder="Digite o nome ou ca³digo do produto...">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Categoria</label>
                        <select name="cat" class="erp-form-control">
                            <option value="">Todas</option>
                            <?php
                            $sqlcat=mysql_query("SELECT * FROM ecats ORDER BY nome ASC");
                            while($rescat=mysql_fetch_array($sqlcat)){
                                $selected = ($cat==$rescat["id"]) ? "selected" : "";
                                echo '<option value="'.$rescat["id"].'" '.$selected.'>'.$rescat["nome"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            ð Buscar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">Ca³digo</th>
                    <th>Produto</th>
                    <th width="120">Categoria</th>
                    <th width="100" class="erp-text-right">Preco</th>
                    <th width="80" class="erp-text-center">Estoque</th>
                    <th width="80">Tipo</th>
                    <th width="200" class="erp-text-center">Acaµes</th>
        </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT prodserv.*, ecats.nome as cat_nome FROM prodserv LEFT JOIN ecats ON prodserv.ecat=ecats.id $where ORDER BY prodserv.nome ASC");
            
			  if(mysql_num_rows($sql)==0){
                echo '<tr><td colspan="7" class="erp-text-center" style="padding:40px;">Nenhum produto encontrado</td></tr>';
			  }else{
			  	while($res=mysql_fetch_array($sql)){
                    $tipo_badge = $res["servico"]=="S" ? "info" : "success";
                    $tipo_text = $res["servico"]=="S" ? "Servico" : "Produto";
                    $preco = banco2valor($res["pv1"]);
                    ?>
                    <tr>
                        <td><strong><?=$res["codprod"]?></strong></td>
                        <td>
                            <div style="font-weight:600;"><?=$res["nome"]?></div>
                            <?php if(!empty($res["apelido"]) && $res["apelido"] != $res["nome"]): ?>
                            <div style="font-size:12px;color:#6c757d;"><?=$res["apelido"]?></div>
                            <?php endif; ?>
                        </td>
                        <td><?=$res["cat_nome"]?></td>
                        <td class="erp-text-right"><strong>R$ <?=$preco?></strong></td>
                        <td class="erp-text-center">
                            <?php if($res["servico"]=="N"): ?>
                            <?=$res["estoque"]?>
                            <?php else: ?>
                            <span style="color:#95a5a6;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="erp-badge erp-badge-<?=$tipo_badge?>"><?=$tipo_text?></span>
                        </td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="prodserv_sql.php?acao=alt&id=<?=$res["id"]?>" class="erp-table-action" title="Editar">
                                    âï¸
                                </a>
                                <a href="prodserv_est.php?id=<?=$res["id"]?>" class="erp-table-action" title="Estoque">
                                    ð
                                </a>
                                <a href="prodserv_custo.php?id=<?=$res["id"]?>" class="erp-table-action" title="Custo">
                                    ðµ
                                </a>
                                <a href="prodserv_item.php?id=<?=$res["id"]?>" class="erp-table-action" title="Composicao">
                                    ð§
                                </a>
                                <?php if($nivel=="1"): ?>
                                <a href="#" onclick="return pergunta('Confirma exclusao?','prodserv.php?acao=exc&id=<?=$res["id"]?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                    ðï¸
                                </a>
                                <?php endif; ?>
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
</div>

<? include("mensagem.php"); ?>
</body>
</html>
