<?
include("conecta.php");
include("seguranca.php");
$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Clientes";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($buscar){
	unset($wp);
}

if(!empty($bnome)){
	$cond="WHERE nome like '%$bnome%' OR fantasia like '%$bnome%'";
}

if(!empty($bcod)){
	$cond="WHERE id='$bcod'";
}

if(!empty($bnome) and !empty($bcod)){
	$cond="WHERE nome like '%$bnome%' OR fantasia like '%$bnome%' OR id='$bcod'";
}

if($acao=="exc"){
	$sql=mysql_query("DELETE FROM cliente_cobranca WHERE cliente='$id'");
	$sql=mysql_query("DELETE FROM cliente_entrega WHERE cliente='$id'");
	$sql=mysql_query("DELETE FROM cliente_financeiro WHERE cliente='$id'");
	$sql=mysql_query("DELETE FROM cliente_login WHERE cliente='$id'");
	if($sql){
		$sql=mysql_query("DELETE FROM clientes WHERE id='$id'");
		$_SESSION["mensagem"]="Cliente exclua­do com sucesso!";
	}else{
		$_SESSION["mensagem"]="O cliente nao pa´de ser exclua­do!";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Clientes - ERP System</title>
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
    <!-- Page Header -->
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-users"></i> Clientes</h1>
            <div>
                <a href="clientes_geral.php?acao=inc" target="_parent" class="erp-btn erp-btn-primary">
                    + Novo Cliente
                </a>
            </div>
        </div>
    </div>
    
    <!-- Search Card -->
    <div class="erp-card">
        <form name="form1" method="post" action="">
            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome ou Fantasia</label>
                        <input name="bnome" type="text" class="erp-form-control" placeholder="Digite o nome do cliente...">
                    </div>
                </div>
                <div class="erp-col" style="flex:1;">
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
                        <input name="buscar" type="hidden" value="true">
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
    
    <!-- Data Table -->
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="60">Ca³d</th>
                    <th>Nome</th>
                    <th width="150">Telefone</th>
                    <th width="120">Cidade</th>
                    <th width="80">Status</th>
                    <th width="150" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $pagina_atual=!empty($wp)?$wp:1;
            $inicio=($pagina_atual-1)*$wpaginacao;
            
            $sql=mysql_query("SELECT * FROM clientes $cond ORDER BY nome ASC LIMIT $inicio,$wpaginacao");
            
            if(mysql_num_rows($sql)==0){
                echo '<tr><td colspan="6" class="erp-text-center" style="padding:40px;">Nenhum cliente encontrado</td></tr>';
            }else{
                while($res=mysql_fetch_array($sql)){
                    $status_class = $res["sit"]=="A" ? "success" : "danger";
                    $status_text = $res["sit"]=="A" ? "Ativo" : "Inativo";
                    ?>
                    <tr>
                        <td><strong><?=$res["id"]?></strong></td>
                        <td>
                            <div style="font-weight:600;"><?=$res["nome"]?></div>
                            <?php if(!empty($res["fantasia"])): ?>
                            <div style="font-size:12px;color:#6c757d;"><?=$res["fantasia"]?></div>
                            <?php endif; ?>
                        </td>
                        <td><?=$res["fone1"]?></td>
                        <td><?=$res["cidade"]?></td>
                        <td>
                            <span class="erp-badge erp-badge-<?=$status_class?>"><?=$status_text?></span>
                        </td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="clientes_geral.php?alt=<?=$res["id"]?>" class="erp-table-action" title="Editar">
                                    âï¸
                                </a>
                                <a href="crm_clientes_geral.php?alt=<?=$res["id"]?>" class="erp-table-action" title="CRM">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="cliente_contatos.php?cliente=<?=$res["id"]?>" class="erp-table-action" title="Contatos">
                                    <i class="fas fa-search"></i>
                                </a>
                                <?php if($nivel=="1"): ?>
                                <a href="#" onclick="return pergunta('Confirma exclusao?','clientes.php?acao=exc&id=<?=$res["id"]?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                    <i class="fas fa-search"></i>ï¸
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
    
    <!-- Pagination -->
    <?php
    $sql2=mysql_query("SELECT COUNT(id) AS total FROM clientes $cond");
    $res2=mysql_fetch_array($sql2);
    $total_registros=$res2["total"];
    $total_paginas=ceil($total_registros/$wpaginacao);
    
    if($total_paginas > 1):
    ?>
    <div class="erp-pagination">
        <?php if($pagina_atual > 1): ?>
        <a href="?wp=<?=$pagina_atual-1?>" class="erp-pagination-item">â¹ Anterior</a>
        <?php endif; ?>
        
        <?php for($i=1; $i<=$total_paginas; $i++): ?>
            <?php if($i==$pagina_atual): ?>
                <span class="erp-pagination-item active"><?=$i?></span>
            <?php else: ?>
                <a href="?wp=<?=$i?>" class="erp-pagination-item"><?=$i?></a>
            <?php endif; ?>
        <?php endfor; ?>
        
        <?php if($pagina_atual < $total_paginas): ?>
        <a href="?wp=<?=$pagina_atual+1?>" class="erp-pagination-item">Pra³xima âº</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
</div>

<? include("mensagem.php"); ?>
</body>
</html>
