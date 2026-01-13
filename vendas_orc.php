<?
include("conecta.php");
include("seguranca.php");

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
		1 => "Concorraªncia",
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

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title">ð Orcamentos de Vendas</h1>
            <div>
                <a href="vendas_orca.php?acao=inc" class="erp-btn erp-btn-primary">
                    â Novo Orcamento
                </a>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?=strpos($_SESSION["mensagem"],'sucesso')!==false?'success':'danger'?>">
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
                        <input type="text" name="bde" class="erp-form-control" value="<?=$bde?>" placeholder="DD/MM/AAAA">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Final</label>
                        <input type="text" name="bate" class="erp-form-control" value="<?=$bate?>" placeholder="DD/MM/AAAA">
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cliente</label>
                        <input type="text" name="cliente_busca" class="erp-form-control" value="<?=$cliente_busca?>" placeholder="Buscar por nome...">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">NÂº Proposta</label>
                        <input type="text" name="proposta" class="erp-form-control" value="<?=$proposta?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Status</label>
                        <select name="status" class="erp-form-control">
                            <option value="">Todos</option>
                            <option value="1" <?=$status=="1"?"selected":""?>>Em Aberto</option>
                            <option value="2" <?=$status=="2"?"selected":""?>>Aprovado</option>
                            <option value="3" <?=$status=="3"?"selected":""?>>Cancelado</option>
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
                    <button type="submit" class="erp-btn erp-btn-primary" style="width:100%;">ð Buscar</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="erp-card">
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>NÂº</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Representante</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th class="erp-table-actions">Acaµes</th>
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
                        <td><?=$res["id"]?></td>
                        <td><?=$data_emissao?></td>
                        <td><?=$cliente_exibir?></td>
                        <td><?=$rep_nome?></td>
                        <td>R$ <?=$valor_total?></td>
                        <td><span class="erp-badge erp-badge-<?=$status_class?>"><?=$status_texto?></span></td>
                        <td class="erp-table-actions">
                            <a href="vendas_orca.php?acao=alt&id=<?=$res["id"]?>" class="erp-btn erp-btn-sm erp-btn-outline" title="Editar">
                                âï¸
                            </a>
                            <a href="vendas_orc_imp.php?id=<?=$res["id"]?>" class="erp-btn erp-btn-sm erp-btn-outline" title="Imprimir" target="_blank">
                                ð¨ï¸
                            </a>
                            <?php if($res["nivel"]=="1"): ?>
                            <a href="#" onclick="if(confirm('Deseja cancelar este orcamento?')) window.location='vendas_orc.php?acao=canc&id=<?=$res["id"]?>&cliente=<?=$res["cliente"]?>&contato=<?=$res["contato"]?>&vendedor=<?=$res["representante"]?>&mot=5'; return false;" class="erp-btn erp-btn-sm erp-btn-danger" title="Cancelar">
                                â
                            </a>
                            <?php endif; ?>
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

<? include("mensagem.php"); ?>
</body>
</html>
