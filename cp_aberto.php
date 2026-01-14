<?php
include("conecta.php");
include("seguranca.php");

if(empty($wsit)) $wsit="N";

if($wsit=="A"){
	$busca=" WHERE cp_itens.conta=cp.id AND cp.sit<>'C' ";
}else{
	$busca=" WHERE cp_itens.conta=cp.id AND cp_itens.pago='$wsit' AND cp.sit<>'C' ";
}

if(!empty($emissao)){
	$emissao_banco=data2banco($emissao);
	$busca.="AND cp.emissao>='$emissao_banco' ";
	if(!empty($emissao2)){
		$emissao2_banco=data2banco($emissao2);
		$busca.="AND cp.emissao<='$emissao2_banco' ";
	}
}

if(!empty($vencimento)){
	$vencimento_banco=data2banco($vencimento);
	$busca.="AND cp_itens.vencimento>='$vencimento_banco' ";
	if(!empty($vencimento2)){
		$vencimento2_banco=data2banco($vencimento2);
		$busca.="AND cp_itens.vencimento<='$vencimento2_banco' ";
	}
}

if(!empty($cliente)){
	$busca.="AND cp.cliente='$cliente' AND cp.cliente_tipo='$cliente_tipo' ";
}

if($banco){
	$busca.="AND cp_itens.banco='$banco' ";
}

$sql=mysql_query("SELECT *,cp_itens.id AS item,cp.id AS conta,cp_itens.valor AS valor FROM cp_itens,cp $busca ORDER BY cp_itens.vencimento ASC");
$hj=mktime(0,0,0,date("n"),date("d"),date("Y"));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Contas a Pagar - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;" onLoad="enterativa=1;" onkeypress="return ent()">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-credit-card"></i> Contas a Pagar</h1>
            <div style="display:flex;gap:8px;">
                <a href="cp.php" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Nova Conta
                </a>
            </div>
        </div>
    </div>
    
    <div class="erp-card">
        <form method="post" action="">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Situacao</label>
                        <select name="wsit" class="erp-form-control">
                            <option value="N" <?php echo ($wsit=="N") ? "selected" : ""; ?>>A Pagar</option>
                            <option value="S" <?php echo ($wsit=="S") ? "selected" : ""; ?>>Pagas</option>
                            <option value="A" <?php echo ($wsit=="A") ? "selected" : ""; ?>>Todas</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Venc. Inicial</label>
                        <input name="vencimento" type="text" class="erp-form-control" value="<?php echo $vencimento; ?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Venc. Final</label>
                        <input name="vencimento2" type="text" class="erp-form-control" value="<?php echo $vencimento2; ?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Conta Bancaria</label>
                        <select name="banco" class="erp-form-control">
                            <option value="">Todas</option>
                            <?php
                            $sqlb=mysql_query("SELECT * FROM bancos ORDER BY apelido ASC");
                            while($resb=mysql_fetch_array($sqlb)){
                                $sel = ($banco==$resb["id"]) ? "selected" : "";
                                echo '<option value="'.$resb["id"].'" '.$sel.'>'.$resb["apelido"].'</option>';
                            }
                            ?>
                        </select>
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
    
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">Vencimento</th>
                    <th>Fornecedor</th>
                    <th width="120">Documento</th>
                    <th width="120" class="erp-text-right">Valor</th>
                    <th width="80">Status</th>
                    <th width="100">Banco</th>
                    <th width="150" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if(mysql_num_rows($sql)==0){
                echo '<tr><td colspan="7" class="erp-text-center" style="padding:40px;">Nenhuma conta encontrada</td></tr>';
            }else{
                $total = 0;
                $total_vencido = 0;
                $total_avencer = 0;
                
                while($res=mysql_fetch_array($sql)){
                    $total += $res["valor"];
                    
                    if($res["cliente_tipo"]=="C"){
                        $sqln=mysql_query("SELECT nome FROM clientes WHERE id='".$res["cliente"]."'");
                    }else{
                        $sqln=mysql_query("SELECT nome FROM fornecedores WHERE id='".$res["cliente"]."'");
                    }
                    $resn=mysql_fetch_array($sqln);
                    $nome = $resn["nome"];
                    
                    $sqlb=mysql_query("SELECT apelido FROM bancos WHERE id='".$res["banco"]."'");
                    $resb=mysql_fetch_array($sqlb);
                    $banco_nome = $resb["apelido"];
                    
                    $venc=mktime(0,0,0,substr($res["vencimento"],5,2),substr($res["vencimento"],8,2),substr($res["vencimento"],0,4));
                    $dias_atraso = floor(($hj-$venc)/86400);
                    
                    if($res["pago"]=="S"){
                        $status_class="success";
                        $status_text="Pago";
                    }elseif($dias_atraso > 0){
                        $status_class="danger";
                        $status_text="Vencido";
                        $total_vencido += $res["valor"];
                    }else{
                        $status_class="warning";
                        $status_text="A Pagar";
                        $total_avencer += $res["valor"];
                    }
                    ?>
                    <tr>
                        <td>
                            <?php echo banco2data($res["vencimento"]); ?>
                            <?php if($dias_atraso > 0 && $res["pago"]=="N"): ?>
                            <div style="font-size:11px;color:#e74c3c;font-weight:600;"><?php echo $dias_atraso; ?> dias</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-weight:600;"><?php echo $nome; ?></div>
                            <div style="font-size:12px;color:#6c757d;">Conta #<?php echo $res["conta"]; ?></div>
                        </td>
                        <td><?php echo $res["documento"]; ?></td>
                        <td class="erp-text-right"><strong>R$ <?php echo banco2valor($res["valor"]); ?></strong></td>
                        <td>
                            <span class="erp-badge erp-badge-<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                        </td>
                        <td><?php echo $banco_nome; ?></td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="cp.php?acao=alt&id=<?php echo $res["conta"]; ?>" class="erp-table-action" title="Visualizar Conta">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if($res["pago"]=="N"): ?>
                                <a href="cp_conf.php?id=<?php echo $res["item"]; ?>" class="erp-table-action" title="Pagar">
                                    <i class="fas fa-dollar-sign"></i>
                                </a>
                                <?php endif; ?>
                                <a href="cp_hist.php?id=<?php echo $res["item"]; ?>" onclick="return abre(this.href,'','width=470,height=300,scrollbars=1');" class="erp-table-action" title="Historico">
                                    <i class="fas fa-history"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr style="background:#f8f9fa;font-weight:600;">
                    <td colspan="3" class="erp-text-right">
                        <div>Total Vencido: <span style="color:#E74C3C;">R$ <?php echo banco2valor($total_vencido); ?></span></div>
                        <div>Total a Vencer: <span style="color:#F39C12;">R$ <?php echo banco2valor($total_avencer); ?></span></div>
                    </td>
                    <td colspan="4" class="erp-text-right" style="font-size:16px;">
                        <div>TOTAL GERAL: <span style="color:#27AE60;">R$ <?php echo banco2valor($total); ?></span></div>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
