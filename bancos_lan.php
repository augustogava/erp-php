<?php
include("conecta.php");
include("seguranca.php");

if(empty($setbco) and empty($_SESSION["banco_ativo"])){
	header("Location:bancos.php");
	exit;
}

if(!empty($setbco)) $_SESSION["banco_ativo"]=$setbco;
$setbco=$_SESSION["banco_ativo"];

$sql=mysql_query("SELECT * FROM bancos WHERE id='$setbco'");
$res=mysql_fetch_array($sql);
$bank=$res["apelido"]." / ".$res["conta"];
$sld=banco2valor($res["saldo"]);
$sld2=banco2valor($res["saldo"]+$res["limite"]);

$hj=date("Y-m-d");
if(empty($bdias)) $bdias=0;
$ate=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-$bdias,date("Y")));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Lancamentos Bancarios - ERP System</title>
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
function verifica(cad){
	if(!verifica_data(cad.data.value)){
		alert('Data invalida');
		cad.data.focus();
		return false;
	}
	if(cad.valor.value=='' || cad.valor.value=='0,00'){
		alert('Informe o valor');
		cad.valor.focus();
		return false;
	}
	if(cad.documento.value==''){
		alert('Informe o documento');
		cad.documento.focus();
		return false;
	}
	if(cad.hist.value==''){
		alert('Informe o historico');
		cad.hist.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;" onLoad="enterativa=1;" onkeypress="return ent()">

<div class="erp-container-fluid">
    <!-- Page Header -->
    <div class="erp-card">
        <div class="erp-card-header">
            <div>
                <h1 class="erp-card-title" style="margin-bottom:4px;"><i class="fas fa-exchange-alt"></i> Lancamentos Bancarios</h1>
                <div style="font-size:13px;color:#6c757d;">Conta: <strong><?php echo $bank; ?></strong></div>
            </div>
            <div style="display:flex;gap:12px;align-items:center;">
                <div style="text-align:right;">
                    <div style="font-size:12px;color:#6c757d;">Saldo Atual</div>
                    <div style="font-size:20px;font-weight:700;color:<?php echo ($res["saldo"]>=0) ? '#27AE60' : '#E74C3C'; ?>">R$ <?php echo $sld; ?></div>
                </div>
                <div style="text-align:right;padding-left:16px;border-left:1px solid #e8ebf3;">
                    <div style="font-size:12px;color:#6c757d;">Saldo + Limite</div>
                    <div style="font-size:20px;font-weight:700;color:#4169E1;">R$ <?php echo $sld2; ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Formulario de Lancamento -->
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:16px;color:#2c3e50;"><i class="fas fa-plus-circle"></i> Novo Lancamento</h3>
        <form name="form1" method="post" action="bancos_sql.php?acao=lanc" onSubmit="return verifica(this)">
            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Banco / Conta</label>
                        <input type="text" class="erp-form-control" value="<?php echo $bank; ?>" readonly style="background:#f8f9fa;">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data</label>
                        <input name="data" type="text" class="erp-form-control" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" placeholder="dd/mm/aaaa">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Valor (R$)</label>
                        <input name="valor" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Operacao</label>
                        <select name="operacao" class="erp-form-control">
                            <?php
                            $sqlo=mysql_query("SELECT * FROM operacoes ORDER BY nome ASC");
                            while($reso=mysql_fetch_array($sqlo)){
                                echo '<option value="'.$reso["id"].'">'.$reso["nome"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col" style="flex:1;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Documento</label>
                        <input name="documento" type="text" class="erp-form-control" maxlength="25" placeholder="No do cheque, boleto, etc">
                    </div>
                </div>
                <div class="erp-col" style="flex:3;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Historico</label>
                        <input name="hist" type="text" class="erp-form-control" maxlength="40" placeholder="Descricao do lancamento">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Tipo</label>
                        <div style="display:flex;gap:16px;padding:10px 0;">
                            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                <input type="radio" name="tipo" value="E" checked style="width:18px;height:18px;">
                                <span style="font-weight:500;color:#27AE60;">Entrada</span>
                            </label>
                            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                <input type="radio" name="tipo" value="S" style="width:18px;height:18px;">
                                <span style="font-weight:500;color:#E74C3C;">Saida</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-success" style="height:42px;padding:0 32px;">
                            <i class="fas fa-check"></i> Lancar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Filtro de Periodo -->
    <div class="erp-card">
        <form method="get" style="display:flex;align-items:center;gap:16px;">
            <label class="erp-form-label" style="margin:0;">Exibir lancamentos dos ultimos</label>
            <select name="bdias" class="erp-form-control" style="width:auto;" onchange="this.form.submit()">
                <option value="0" <?php echo ($bdias==0) ? 'selected' : ''; ?>>Hoje</option>
                <option value="7" <?php echo ($bdias==7) ? 'selected' : ''; ?>>7 dias</option>
                <option value="15" <?php echo ($bdias==15) ? 'selected' : ''; ?>>15 dias</option>
                <option value="30" <?php echo ($bdias==30) ? 'selected' : ''; ?>>30 dias</option>
                <option value="60" <?php echo ($bdias==60) ? 'selected' : ''; ?>>60 dias</option>
                <option value="90" <?php echo ($bdias==90) ? 'selected' : ''; ?>>90 dias</option>
            </select>
        </form>
    </div>
    
    <!-- Historico de Lancamentos -->
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">Data</th>
                    <th width="100">Documento</th>
                    <th>Historico</th>
                    <th width="120">Operacao</th>
                    <th width="120" class="erp-text-right">Entrada</th>
                    <th width="120" class="erp-text-right">Saida</th>
                    <th width="120" class="erp-text-right">Saldo</th>
                    <th width="80" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM bancos_lan WHERE banco='$setbco' AND data>='$ate' ORDER BY data DESC, id DESC");
            
            if(mysql_num_rows($sql)==0){
                echo '<tr><td colspan="8" class="erp-text-center" style="padding:40px;">Nenhum lancamento encontrado neste periodo</td></tr>';
            }else{
                $saldo_periodo = $res["saldo"];
                while($rlan=mysql_fetch_array($sql)){
                    ?>
                    <tr>
                        <td><?php echo banco2data($rlan["data"]); ?></td>
                        <td><?php echo $rlan["documento"]; ?></td>
                        <td><?php echo $rlan["hist"]; ?></td>
                        <td>
                            <?php
                            $sqlo=mysql_query("SELECT nome FROM operacoes WHERE id='".$rlan["operacao"]."'");
                            $reso=mysql_fetch_array($sqlo);
                            echo $reso["nome"];
                            ?>
                        </td>
                        <td class="erp-text-right">
                            <?php if($rlan["tipo"]=="E"): ?>
                            <span style="color:#27AE60;font-weight:600;">+ R$ <?php echo banco2valor($rlan["valor"]); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="erp-text-right">
                            <?php if($rlan["tipo"]=="S"): ?>
                            <span style="color:#E74C3C;font-weight:600;">- R$ <?php echo banco2valor($rlan["valor"]); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="erp-text-right">
                            <strong style="color:#2c3e50;">R$ <?php echo banco2valor($saldo_periodo); ?></strong>
                        </td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="bancos_sql.php?acao=exc&id=<?php echo $rlan["id"]; ?>" onclick="return pergunta('Confirma exclusao?',this.href);" class="erp-table-action" style="color:#e74c3c;">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                    if($rlan["tipo"]=="E"){
                        $saldo_periodo -= $rlan["valor"];
                    }else{
                        $saldo_periodo += $rlan["valor"];
                    }
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
