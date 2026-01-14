<?php
include("conecta.php");
include("seguranca.php");
$codigo=$_SESSION["login_codigo"];
$nivel=$_SESSION["login_nivel"];

$data =date("Y-m-d");
$wdata =date("d/m/Y"); 

$sql=mysql_query("SELECT * FROM agenda WHERE data<'$data' AND sit='N'");
if(mysql_num_rows($sql)!=0){
	while($res=mysql_fetch_array($sql)){
		$wnum=$res["numero"];
		$wtxt=$res["texto"];
		$wdata2=$res["data"];
		$wdata2=banco2data($wdata2);
		$wtxt.="\n\r Reagendamento automatico $wdata2 - $wdata";
		$muda=mysql_query("UPDATE agenda SET texto='$wtxt',data='$data',reagendada='S' WHERE numero='$wnum'");
	}
}

if(!empty($conf)){
	$sql=mysql_query("UPDATE agenda SET sit='S',reagendada='N' WHERE numero='$conf'");
	unset($conf);
}

if(!empty($exc)){
	$sql=mysql_query("DELETE FROM agenda WHERE numero='$exc'");
	unset($exc);
}

if (!empty($_GET['cal_dia'])) $cal_dia = $_GET['cal_dia'];
	else $cal_dia = date("d",time());
if (!empty($_GET['cal_mes'])) $cal_mes = $_GET['cal_mes'];
	else  $cal_mes = date("m",time());
if (!empty($_GET['cal_ano'])) $cal_ano = $_GET['cal_ano'];
	else $cal_ano = date("Y",time());
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Dashboard - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
}

.stat-card {
    background: linear-gradient(135deg, #4169E1, #2E4FC7);
    color: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(65, 105, 225, 0.2);
}

.stat-card.green {
    background: linear-gradient(135deg, #27AE60, #229954);
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
}

.stat-card.orange {
    background: linear-gradient(135deg, #F39C12, #E67E22);
    box-shadow: 0 4px 12px rgba(243, 156, 18, 0.2);
}

.stat-card.red {
    background: linear-gradient(135deg, #E74C3C, #C0392B);
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);
}

.stat-label {
    font-size: 13px;
    opacity: 0.9;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 4px;
}

.stat-change {
    font-size: 12px;
    opacity: 0.8;
}
</style>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card" style="margin-bottom:24px;">
        <div style="padding:24px;">
            <h1 style="font-size:28px;font-weight:700;color:#2c3e50;margin-bottom:8px;">
                <i class="fas fa-hand-wave"></i> Bem-vindo, <?=htmlspecialchars($_SESSION["login_nome"])?>!
            </h1>
            <p style="color:#6c757d;font-size:14px;">
                <?php
  $sql=mysql_query("SELECT COUNT(id) AS nacesso FROM acessos WHERE usuario='$codigo'");
  $res=mysql_fetch_array($sql);
                echo "Este e seu acesso numero ".$res["nacesso"]." ao sistema";
                ?>
            </p>
        </div>
    </div>
    
    <div class="dashboard-grid">
        <?php
        $hoje = date("Y-m-d");
        
        $sql_vendas=mysql_query("SELECT COUNT(*) as total, SUM(valor) as valor FROM vendas WHERE emissao='$hoje'");
        $res_vendas=mysql_fetch_array($sql_vendas);
        
        $sql_cp=mysql_query("SELECT COUNT(*) as total, SUM(valor) as valor FROM cp_itens WHERE vencimento='$hoje' AND pago='N'");
        $res_cp=mysql_fetch_array($sql_cp);
        
        $sql_cr=mysql_query("SELECT COUNT(*) as total, SUM(valor) as valor FROM cr_itens WHERE vencimento='$hoje' AND pago='N'");
        $res_cr=mysql_fetch_array($sql_cr);
        
        $sql_clientes=mysql_query("SELECT COUNT(*) as total FROM clientes WHERE sit='A'");
        $res_clientes=mysql_fetch_array($sql_clientes);
  ?>
        
        <div class="stat-card">
            <div class="stat-label"><i class="fas fa-shopping-cart"></i> Vendas Hoje</div>
            <div class="stat-value">R$ <?=banco2valor($res_vendas["valor"])?></div>
            <div class="stat-change"><?=$res_vendas["total"]?> pedidos</div>
        </div>
        
        <div class="stat-card green">
            <div class="stat-label"><i class="fas fa-arrow-up"></i> A Receber Hoje</div>
            <div class="stat-value">R$ <?=banco2valor($res_cr["valor"])?></div>
            <div class="stat-change"><?=$res_cr["total"]?> titulos</div>
        </div>
        
        <div class="stat-card orange">
            <div class="stat-label"><i class="fas fa-arrow-down"></i> A Pagar Hoje</div>
            <div class="stat-value">R$ <?=banco2valor($res_cp["valor"])?></div>
            <div class="stat-change"><?=$res_cp["total"]?> titulos</div>
        </div>
        
        <div class="stat-card red">
            <div class="stat-label"><i class="fas fa-users"></i> Clientes Ativos</div>
            <div class="stat-value"><?=$res_clientes["total"]?></div>
            <div class="stat-change">Total cadastrado</div>
        </div>
    </div>
    
    <div class="erp-row">
        <div class="erp-col">
            <div class="erp-card">
                <div class="erp-card-header" style="border-bottom:none;padding-bottom:0;">
                    <h2 style="font-size:18px;font-weight:600;color:#2c3e50;"><i class="fas fa-calendar-alt"></i> Agenda do Dia</h2>
                    <a href="agenda_inc.php?dia=<?=$cal_dia?>&mes=<?=$cal_mes?>&ano=<?=$cal_ano?>" class="erp-btn erp-btn-sm erp-btn-outline">
                        + Novo
                    </a>
                </div>
                <div class="erp-card-body">
                    <?php 
						$bdata=$cal_ano."-".$cal_mes."-".$cal_dia;
						$sql=mysql_query("SELECT * FROM agenda WHERE data='$bdata' ORDER BY hora ASC");
                    
                    if(mysql_num_rows($sql)==0){ ?>
                        <p style="text-align:center;padding:40px;color:#95a5a6;">
                            Nenhum compromisso agendado para hoje
                        </p>
                    <?php }else{
                        echo '<div style="display:flex;flex-direction:column;gap:12px;">';
			$nome=$_SESSION["login_nome"];
			$ray=explode(" ",$nome);
 	        $nome=$ray[0];
                        
			while($res=mysql_fetch_array($sql)){
				$cli=mysql_query("SELECT * FROM clientes WHERE id='$res[cliente]'");
				$rcli=mysql_fetch_array($cli);
                            
                            $status_color = $res["sit"]=="S" ? "#27AE60" : ($res["reagendada"]=="S" ? "#E74C3C" : "#F39C12");
                            ?>
                            <div style="padding:16px;background:#f8f9fa;border-radius:8px;border-left:4px solid <?=$status_color?>;">
                                <div style="display:flex;justify-content:space-between;align-items:start;">
                                    <div>
                                        <div style="font-weight:600;color:#2c3e50;margin-bottom:4px;">
                                            <?=$res["hora"]?> - <?=htmlspecialchars($res["titulo"])?>
                                        </div>
                                        <div style="font-size:13px;color:#6c757d;">
                                            Cliente: <?=htmlspecialchars($rcli["nome"])?> | Por: <?=htmlspecialchars($res["nome"])?>
                                        </div>
                                    </div>
                                    <div style="display:flex;gap:8px;">
                                        <?php if($res["sit"]=="N" && ($res["nome"]==$nome || $nivel==1)): ?>
                                        <a href="corpo.php?conf=<?=$res["numero"]?>&cal_dia=<?=$cal_dia?>&cal_mes=<?=$cal_mes?>&cal_ano=<?=$cal_ano?>" onclick="return confirm('Marcar como realizado?');" title="Concluir" style="color:#27AE60;">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <?php endif; ?>
                                        <a href="agenda_alt.php?alt=<?=$res["numero"]?>&cal_dia=<?=$cal_dia?>&cal_mes=<?=$cal_mes?>&cal_ano=<?=$cal_ano?>" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        echo '</div>';
                    } ?>
                </div>
            </div>
        </div>
        
        <div class="erp-col">
            <div class="erp-card">
                <div class="erp-card-header" style="border-bottom:none;padding-bottom:0;">
                    <h2 style="font-size:18px;font-weight:600;color:#2c3e50;"><i class="fas fa-bolt"></i> Atalhos Rapidos</h2>
                </div>
                <div class="erp-card-body">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <a href="vendas_sql.php?acao=inc" class="erp-btn erp-btn-outline" style="height:auto;padding:16px;flex-direction:column;gap:8px;">
                            <span style="font-size:24px;"><i class="fas fa-cart-plus"></i></span>
                            <span>Nova Venda</span>
                        </a>
                        <a href="compras_sql.php?acao=inc" class="erp-btn erp-btn-outline" style="height:auto;padding:16px;flex-direction:column;gap:8px;">
                            <span style="font-size:24px;"><i class="fas fa-box"></i></span>
                            <span>Nova Compra</span>
                        </a>
                        <a href="cp.php" class="erp-btn erp-btn-outline" style="height:auto;padding:16px;flex-direction:column;gap:8px;">
                            <span style="font-size:24px;"><i class="fas fa-credit-card"></i></span>
                            <span>Contas a Pagar</span>
                        </a>
                        <a href="cr.php" class="erp-btn erp-btn-outline" style="height:auto;padding:16px;flex-direction:column;gap:8px;">
                            <span style="font-size:24px;"><i class="fas fa-hand-holding-usd"></i></span>
                            <span>Contas a Receber</span>
                        </a>
                        <a href="clientes_geral.php?acao=inc" class="erp-btn erp-btn-outline" style="height:auto;padding:16px;flex-direction:column;gap:8px;">
                            <span style="font-size:24px;"><i class="fas fa-user-plus"></i></span>
                            <span>Novo Cliente</span>
                        </a>
                        <a href="prodserv_sql.php?acao=inc" class="erp-btn erp-btn-outline" style="height:auto;padding:16px;flex-direction:column;gap:8px;">
                            <span style="font-size:24px;"><i class="fas fa-cube"></i></span>
                            <span>Novo Produto</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
