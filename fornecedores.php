<?
include("conecta.php");
include("seguranca.php");
$nivel=$_SESSION["login_nivel"];
$acao=verifi($permi,$acao);

if(!empty($acao)){
	$loc="Fornecedores";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if(!empty($bnome)){
	$cond="WHERE nome like '%$bnome%' OR fantasia like '%$bnome%'";
}

if(!empty($bcod)){
	$cond="WHERE id='$bcod'";
}

if(!empty($bnome) and !empty($bcod)){
	$cond="WHERE nome like '%$bnome%' OR id='$bcod'";
}

if($acao=="exc"){
	$sql=mysql_query("DELETE FROM fornecedores WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Fornecedor excluido com sucesso!";
	}else{
		$_SESSION["mensagem"]="Erro ao excluir fornecedor!";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Fornecedores - ERP System</title>
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
            <h1 class="erp-card-title"><i class="fas fa-industry"></i> Fornecedores</h1>
            <div>
                <a href="fornecedores_geral.php?acao=inc" class="erp-btn erp-btn-primary">
                    + Novo Fornecedor
                </a>
            </div>
        </div>
    </div>
    
    <div class="erp-card">
        <form name="form1" method="post" action="">
            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome ou Fantasia</label>
                        <input name="bnome" type="text" class="erp-form-control" placeholder="Digite o nome do fornecedor...">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Codigo</label>
                        <input name="bcod" type="text" class="erp-form-control" placeholder="000">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Buscar
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
                    <th width="60">Cod</th>
                    <th>Nome Fantasia</th>
                    <th width="150">Telefone</th>
                    <th width="120">Cidade</th>
                    <th width="150" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM fornecedores $cond ORDER BY fantasia ASC");
            
            if(mysql_num_rows($sql)==0){
                echo '<tr><td colspan="5" class="erp-text-center" style="padding:40px;">Nenhum fornecedor encontrado</td></tr>';
            }else{
                while($res=mysql_fetch_array($sql)){
                    ?>
                    <tr>
                        <td><strong><?=$res["id"]?></strong></td>
                        <td>
                            <div style="font-weight:600;"><?=$res["fantasia"]?></div>
                            <?php if(!empty($res["nome"]) && $res["nome"] != $res["fantasia"]): ?>
                            <div style="font-size:12px;color:#6c757d;"><?=$res["nome"]?></div>
                            <?php endif; ?>
                        </td>
                        <td><?=$res["fone1"]?></td>
                        <td><?=$res["cidade"]?></td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="fornecedores_geral.php?acao=alt&id=<?=$res["id"]?>&bcod=<?=$bcod?>&bnome=<?=$bnome?>" class="erp-table-action" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="fornecedores_financeiro.php?id=<?=$res["id"]?>&bcod=<?=$bcod?>&bnome=<?=$bnome?>" class="erp-table-action" title="Financeiro">
                                    <i class="fas fa-dollar-sign"></i>
                                </a>
                                <a href="fornecedores_site_list.php?id=<?=$res["id"]?>" class="erp-table-action" title="Website">
                                    <i class="fas fa-globe"></i>
                                </a>
                                <a href="#" onclick="return pergunta('Confirma exclusao?','fornecedores.php?acao=exc&id=<?=$res["id"]?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
</div>

<? include("mensagem.php"); ?>
</body>
</html>
