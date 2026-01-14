<?php
include("conecta.php");
include("seguranca.php");

if(empty($emissao)){
	$emissao_de = date("Y-m-01");
	$emissao_ate = date("Y-m-t");
}else{
	$emissao_de = data2banco($emissao_de);
	$emissao_ate = data2banco($emissao_ate);
}

$sql_entrada = mysql_query("SELECT SUM(valor) as total FROM cr_itens,cr WHERE cr_itens.conta=cr.id AND cr_itens.pago='S' AND cr_itens.pagto>='$emissao_de' AND cr_itens.pagto<='$emissao_ate'");
$res_entrada = mysql_fetch_array($sql_entrada);
$total_entrada = $res_entrada["total"];

$sql_saida = mysql_query("SELECT SUM(valor) as total FROM cp_itens,cp WHERE cp_itens.conta=cp.id AND cp_itens.pago='S' AND cp_itens.pagto>='$emissao_de' AND cp_itens.pagto<='$emissao_ate'");
$res_saida = mysql_fetch_array($sql_saida);
$total_saida = $res_saida["total"];

$saldo = $total_entrada - $total_saida;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Fluxo de Caixa - ERP System</title>
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
            <h1 class="erp-card-title"><i class="fas fa-money-bill-wave"></i> Fluxo de Caixa</h1>
        </div>
    </div>
    
    <div class="erp-card">
        <form method="post" action="">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Inicial</label>
                        <input name="emissao_de" type="text" class="erp-form-control" value="<?php echo banco2data($emissao_de); ?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Final</label>
                        <input name="emissao_ate" type="text" class="erp-form-control" value="<?php echo banco2data($emissao_ate); ?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
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
    
    <div class="dashboard-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin-bottom:24px;">
        <div class="stat-card green" style="background:linear-gradient(135deg,#27AE60,#229954);color:white;padding:32px;border-radius:12px;">
            <div style="font-size:14px;opacity:0.9;margin-bottom:8px;"><i class="fas fa-arrow-circle-down"></i> Total de Entradas</div>
            <div style="font-size:36px;font-weight:700;">R$ <?php echo banco2valor($total_entrada); ?></div>
            <div style="font-size:12px;opacity:0.8;">Periodo selecionado</div>
        </div>
        
        <div class="stat-card red" style="background:linear-gradient(135deg,#E74C3C,#C0392B);color:white;padding:32px;border-radius:12px;">
            <div style="font-size:14px;opacity:0.9;margin-bottom:8px;"><i class="fas fa-arrow-circle-up"></i> Total de Saidas</div>
            <div style="font-size:36px;font-weight:700;">R$ <?php echo banco2valor($total_saida); ?></div>
            <div style="font-size:12px;opacity:0.8;">Periodo selecionado</div>
        </div>
        
        <div class="stat-card" style="background:linear-gradient(135deg,<?php echo ($saldo>=0) ? '#4169E1' : '#F39C12'; ?>,<?php echo ($saldo>=0) ? '#2E4FC7' : '#E67E22'; ?>);color:white;padding:32px;border-radius:12px;">
            <div style="font-size:14px;opacity:0.9;margin-bottom:8px;"><i class="fas fa-chart-line"></i> Saldo do Periodo</div>
            <div style="font-size:36px;font-weight:700;">R$ <?php echo banco2valor($saldo); ?></div>
            <div style="font-size:12px;opacity:0.8;"><?php echo ($saldo>=0) ? 'Positivo' : 'Negativo'; ?></div>
        </div>
    </div>
    
    <div class="erp-row">
        <div class="erp-col">
            <div class="erp-card">
                <div class="erp-card-header">
                    <h3 style="font-size:16px;font-weight:600;"><i class="fas fa-arrow-circle-down" style="color:#27AE60;"></i> Entradas (Contas a Receber)</h3>
                </div>
                <div class="erp-table-container" style="max-height:400px;overflow-y:auto;">
                    <table class="erp-table">
                        <thead style="position:sticky;top:0;background:#f8f9fa;">
                            <tr>
                                <th width="90">Data Pgto</th>
                                <th>Cliente</th>
                                <th width="120" class="erp-text-right">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql=mysql_query("SELECT cr_itens.*,cr.cliente FROM cr_itens,cr WHERE cr_itens.conta=cr.id AND cr_itens.pago='S' AND cr_itens.pagto>='$emissao_de' AND cr_itens.pagto<='$emissao_ate' ORDER BY cr_itens.pagto DESC");
                        while($res=mysql_fetch_array($sql)){
                            $sqln=mysql_query("SELECT nome FROM clientes WHERE id='".$res["cliente"]."'");
                            $resn=mysql_fetch_array($sqln);
                            ?>
                            <tr>
                                <td><?php echo banco2data($res["pagto"]); ?></td>
                                <td><?php echo $resn["nome"]; ?></td>
                                <td class="erp-text-right" style="color:#27AE60;font-weight:600;">R$ <?php echo banco2valor($res["valor"]); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="erp-col">
            <div class="erp-card">
                <div class="erp-card-header">
                    <h3 style="font-size:16px;font-weight:600;"><i class="fas fa-arrow-circle-up" style="color:#E74C3C;"></i> Saidas (Contas a Pagar)</h3>
                </div>
                <div class="erp-table-container" style="max-height:400px;overflow-y:auto;">
                    <table class="erp-table">
                        <thead style="position:sticky;top:0;background:#f8f9fa;">
                            <tr>
                                <th width="90">Data Pgto</th>
                                <th>Fornecedor</th>
                                <th width="120" class="erp-text-right">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql=mysql_query("SELECT cp_itens.*,cp.cliente,cp.cliente_tipo FROM cp_itens,cp WHERE cp_itens.conta=cp.id AND cp_itens.pago='S' AND cp_itens.pagto>='$emissao_de' AND cp_itens.pagto<='$emissao_ate' ORDER BY cp_itens.pagto DESC");
                        while($res=mysql_fetch_array($sql)){
                            if($res["cliente_tipo"]=="C"){
                                $sqln=mysql_query("SELECT nome FROM clientes WHERE id='".$res["cliente"]."'");
                            }else{
                                $sqln=mysql_query("SELECT nome FROM fornecedores WHERE id='".$res["cliente"]."'");
                            }
                            $resn=mysql_fetch_array($sqln);
                            ?>
                            <tr>
                                <td><?php echo banco2data($res["pagto"]); ?></td>
                                <td><?php echo $resn["nome"]; ?></td>
                                <td class="erp-text-right" style="color:#E74C3C;font-weight:600;">R$ <?php echo banco2valor($res["valor"]); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
