<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Vendas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if(empty($bde)){
	$bde=date("d/m/Y");
	$bate=date("d/m/Y");
}

$busca=" WHERE vendas.cliente=clientes.id ";

if(!empty($bde)){
	$bde_banco=data2banco($bde);
	$busca.="AND vendas.emissao>='$bde_banco' ";
	if(!empty($bate)){
		$bate_banco=data2banco($bate);
		$busca.="AND vendas.emissao<='$bate_banco' ";
	}
}

if(!empty($vendedor_a)){
	$busca.="AND vendas.vendedor='$vendedor_a' ";
}

if(!empty($proposta)){
	$busca.="AND vendas.id like '%$proposta%' ";
}

if(!empty($status)){
	$busca.="AND vendas.nivel='$status' ";
}

if($acao=="exc"){
	$sql=mysql_query("DELETE FROM vendas_list WHERE vendas='$id'");
	$sql=mysql_query("DELETE FROM vendas WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Venda excluada com sucesso!";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Vendas - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-shopping-cart"></i> Vendas</h1>
            <div style="display:flex;gap:8px;">
                <a href="vendas_orc.php" class="erp-btn erp-btn-outline">
                    <i class="fas fa-clipboard-list"></i> Orcamentos
                </a>
                <a href="vendas_sql.php?acao=inc" class="erp-btn erp-btn-primary">
                    + Nova Venda
                </a>
            </div>
        </div>
    </div>
    
    <div class="erp-card">
        <form method="post" action="">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Inicial</label>
                        <input name="bde" type="text" class="erp-form-control" value="<?=$bde?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Final</label>
                        <input name="bate" type="text" class="erp-form-control" value="<?=$bate?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Vendedor</label>
                        <select name="vendedor_a" class="erp-form-control">
                            <option value="">Todos</option>
                            <?php
                            $sqlv=mysql_query("SELECT * FROM vendedores ORDER BY nome ASC");
                            while($resv=mysql_fetch_array($sqlv)){
                                $sel = ($vendedor_a==$resv["id"]) ? "selected" : "";
                                echo '<option value="'.$resv["id"].'" '.$sel.'>'.$resv["nome"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Status</label>
                        <select name="status" class="erp-form-control">
                            <option value="">Todos</option>
                            <option value="1" <?=$status=="1"?"selected":""?>>Pendente</option>
                            <option value="2" <?=$status=="2"?"selected":""?>>Em Producao</option>
                            <option value="3" <?=$status=="3"?"selected":""?>>Faturado</option>
                            <option value="4" <?=$status=="4"?"selected":""?>>Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col" style="flex:0.5;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nr Pedido</label>
                        <input name="proposta" type="text" class="erp-form-control" value="<?=$proposta?>">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Filtrar
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
                    <th width="60">Pedido</th>
                    <th width="90">Emissao</th>
                    <th>Cliente</th>
                    <th width="120">Vendedor</th>
                    <th width="120" class="erp-text-right">Valor Total</th>
                    <th width="100">Status</th>
                    <th width="200" class="erp-text-center">Acaes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT vendas.*, clientes.fantasia, vendedores.nome as vendedor_nome FROM vendas, clientes LEFT JOIN vendedores ON vendas.vendedor=vendedores.id $busca ORDER BY vendas.id DESC");
            
            if(mysql_num_rows($sql)==0){
                echo '<tr><td colspan="7" class="erp-text-center" style="padding:40px;">Nenhuma venda encontrada</td></tr>';
            }else{
                $total_geral = 0;
                while($res=mysql_fetch_array($sql)){
                    $valor_total = banco2valor($res["valor"]);
                    $total_geral += $res["valor"];
                    
                    switch($res["nivel"]){
                        case "1": $status_class="warning"; $status_text="Pendente"; break;
                        case "2": $status_class="info"; $status_text="Producao"; break;
                        case "3": $status_class="success"; $status_text="Faturado"; break;
                        case "4": $status_class="danger"; $status_text="Cancelado"; break;
                        default: $status_class="info"; $status_text="Novo";
                    }
                    ?>
                    <tr>
                        <td><strong>#<?=$res["id"]?></strong></td>
                        <td><?=banco2data($res["emissao"])?></td>
                        <td>
                            <div style="font-weight:600;"><?=$res["fantasia"]?></div>
                        </td>
                        <td><?=$res["vendedor_nome"]?></td>
                        <td class="erp-text-right"><strong>R$ <?=$valor_total?></strong></td>
                        <td>
                            <span class="erp-badge erp-badge-<?=$status_class?>"><?=$status_text?></span>
                        </td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="vendas_sql.php?acao=alt&id=<?=$res["id"]?>" class="erp-table-action" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="vendas_prodserv.php?vendas=<?=$res["id"]?>" class="erp-table-action" title="Produtos">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                                <a href="vendas_fat.php?id=<?=$res["id"]?>" class="erp-table-action" title="Faturar">
                                    <i class="fas fa-dollar-sign"></i>
                                </a>
                                <a href="#" onclick="window.open('vendas_sql.php?acao=imp&id=<?=$res["id"]?>','','width=800,height=600');" class="erp-table-action" title="Imprimir">
                                    <i class="fas fa-print"></i>
                                </a>
                                <?php if($nivel=="1"): ?>
                                <a href="#" onclick="return pergunta('Confirma exclusao?','vendas.php?acao=exc&id=<?=$res["id"]?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr style="background:#f8f9fa;font-weight:600;">
                    <td colspan="4" class="erp-text-right">TOTAL GERAL:</td>
                    <td class="erp-text-right" style="color:#27AE60;font-size:16px;">R$ <?=banco2valor($total_geral)?></td>
                    <td colspan="2"></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<? include("mensagem.php"); ?>
</body>
</html>
