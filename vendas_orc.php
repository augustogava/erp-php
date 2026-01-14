<?php
include("conecta.php");
include("seguranca.php");

$acao=Input::request("acao");
$mot=Input::request("mot");
$id=Input::request("id");
$cliente=Input::request("cliente");
$vendedor=Input::request("vendedor");
$contato=Input::request("contato");
$bde=Input::request("bde");
$bate=Input::request("bate");
$cliente_busca=Input::request("cliente_busca");
$proposta=Input::request("proposta");
$status=Input::request("status");
$representante=Input::request("representante");
$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Vendas Orcamentos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="canc"){
	$data=date("Y-m-d");
	$hora=hora();
	
	$motivos = array(
		1 => "Concorrencia",
		2 => "Investimento futuro",
		3 => "Prazo",
		4 => "Qualidade",
		5 => "Outros"
	);
	$motivo = isset($motivos[$mot]) ? $motivos[$mot] : "Nao especificado";
	
	$sql=mysql_query("UPDATE vendas_orcamento SET sit='2',motivo='$mot' WHERE id='$id'");
	$sql=mysql_query("INSERT INTO followup (cliente,tipo,data,hora,titulo,descricao,contato,vendedor) VALUES ('$cliente','3','$data','$hora','Cancelamento Orcamento $id','Orcamento cancelado: $motivo','$contato','$vendedor')");
	
	if($sql){
		$_SESSION["mensagem"]="Orcamento cancelado com sucesso!";
		header("location:vendas_orc.php");
		exit;
	}
}

if(empty($acao)) $acao="listar";

if($acao=="listar"){
	if(empty($bde)){
		$bde=date("d/m/Y");
		$bate=date("d/m/Y");
	}
	
	$busca=" WHERE vendas_orcamento.cliente=clientes.id ";
	
	if(!empty($bde)){
		$bde_banco=data2banco($bde);
		$busca.="AND vendas_orcamento.emissao>='$bde_banco' ";
		
		if(!empty($bate)){
			$bate_banco=data2banco($bate);
			$busca.="AND vendas_orcamento.emissao<='$bate_banco' ";
		}
	}
	
	if(!empty($cliente_busca)){
		$busca.="AND clientes.nome like '%$cliente_busca%' ";
	}
	
	if(!empty($proposta)){
		$busca.="AND vendas_orcamento.id like '%$proposta%' ";
	}
	
	if(!empty($status)){
		$busca.="AND vendas_orcamento.nivel='$status' ";
	}
	
	if(!empty($representante)){
		$busca.="AND vendas_orcamento.representante='$representante' ";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Orcamentos de Vendas - ERP System</title>
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
            <h1 class="erp-card-title"><i class="fas fa-file-invoice-dollar"></i> Orcamentos de Vendas</h1>
            <div>
                <a href="vendas_orca.php?acao=inc" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Novo Orcamento
                </a>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?php echo (strpos($_SESSION["mensagem"],'sucesso')!==false) ? 'success' : 'danger'; ?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-card">
        <form method="post" action="vendas_orc.php">
            <input type="hidden" name="acao" value="listar">
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Inicial</label>
                        <input type="text" name="bde" class="erp-form-control" value="<?php echo $bde; ?>" placeholder="DD/MM/AAAA">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Final</label>
                        <input type="text" name="bate" class="erp-form-control" value="<?php echo $bate; ?>" placeholder="DD/MM/AAAA">
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cliente</label>
                        <input type="text" name="cliente_busca" class="erp-form-control" value="<?php echo $cliente_busca; ?>" placeholder="Buscar por nome...">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">No Proposta</label>
                        <input type="text" name="proposta" class="erp-form-control" value="<?php echo $proposta; ?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Status</label>
                        <select name="status" class="erp-form-control">
                            <option value="">Todos</option>
                            <option value="1" <?php echo ($status=="1") ? "selected" : ""; ?>>Em Aberto</option>
                            <option value="2" <?php echo ($status=="2") ? "selected" : ""; ?>>Aprovado</option>
                            <option value="3" <?php echo ($status=="3") ? "selected" : ""; ?>>Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Representante</label>
                        <select name="representante" class="erp-form-control">
                            <option value="">Todos</option>
                            <?php
                            $sqlrep=mysql_query("SELECT * FROM vendedores ORDER BY nome ASC");
                            while($resrep=mysql_fetch_array($sqlrep)){
                                $sel = ($representante==$resrep["id"]) ? "selected" : "";
                                echo '<option value="'.$resrep["id"].'" '.$sel.'>'.$resrep["nome"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col" style="flex:0.5;display:flex;align-items:flex-end;">
                    <button type="submit" class="erp-btn erp-btn-primary" style="width:100%;"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="erp-card">
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th width="100">Data</th>
                        <th>Cliente</th>
                        <th width="150">Representante</th>
                        <th width="120" class="erp-text-right">Valor Total</th>
                        <th width="100">Status</th>
                        <th width="150" class="erp-text-center">Acoes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql=mysql_query("SELECT vendas_orcamento.*, clientes.nome as cliente_nome, clientes.fantasia FROM vendas_orcamento, clientes $busca ORDER BY vendas_orcamento.id DESC LIMIT 50");
                    
                    if(mysql_num_rows($sql) > 0){
                        while($res=mysql_fetch_array($sql)){
                            $sqlrep=mysql_query("SELECT nome FROM vendedores WHERE id='".$res["representante"]."'");
                            $resrep=mysql_fetch_array($sqlrep);
                            $rep_nome = $resrep["nome"] ?? "-";
                            
                            switch($res["nivel"]){
                                case "1": $status_texto="Em Aberto"; $status_class="warning"; break;
                                case "2": $status_texto="Aprovado"; $status_class="success"; break;
                                case "3": $status_texto="Cancelado"; $status_class="danger"; break;
                                default: $status_texto="Indefinido"; $status_class="secondary";
                            }
                            
                            $valor_total = number_format($res["valor_total"], 2, ',', '.');
                            $data_emissao = banco2data($res["emissao"]);
                            $cliente_exibir = !empty($res["fantasia"]) ? $res["fantasia"] : $res["cliente_nome"];
                    ?>
                    <tr>
                        <td><strong>#<?php echo $res["id"]; ?></strong></td>
                        <td><?php echo $data_emissao; ?></td>
                        <td><?php echo $cliente_exibir; ?></td>
                        <td><?php echo $rep_nome; ?></td>
                        <td class="erp-text-right"><strong>R$ <?php echo $valor_total; ?></strong></td>
                        <td><span class="erp-badge erp-badge-<?php echo $status_class; ?>"><?php echo $status_texto; ?></span></td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="vendas_orca.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="vendas_orc_imp.php?id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Imprimir" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <?php if($res["nivel"]=="1"): ?>
                                <a href="#" onclick="if(confirm('Deseja cancelar este orcamento?')) window.location='vendas_orc.php?acao=canc&id=<?php echo $res["id"]; ?>&cliente=<?php echo $res["cliente"]; ?>&contato=<?php echo $res["contato"]; ?>&vendedor=<?php echo $res["representante"]; ?>&mot=5'; return false;" class="erp-table-action" title="Cancelar" style="color:#e74c3c;">
                                    <i class="fas fa-times"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="7" style="text-align:center;padding:32px;color:#6c757d;">Nenhum orcamento encontrado</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
