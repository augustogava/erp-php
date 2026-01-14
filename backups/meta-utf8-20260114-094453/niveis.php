<?php
include("conecta.php");
include("seguranca.php");

$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Niveis de Acesso";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO niveis (nome,tipo) VALUES ('$nome','$tipo')");
	if($sql){
		$_SESSION["mensagem"]="Nivel cadastrado com sucesso!";
		header("Location:niveis.php");
		exit;
	}else{
		$_SESSION["mensagem"]="Erro ao cadastrar nivel!";
		$acao="inc";
	}
	
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE niveis SET nome='$nome',tipo='$tipo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Nivel atualizado com sucesso!";
		header("Location:niveis.php");
		exit;
	}else{
		$_SESSION["mensagem"]="Erro ao atualizar nivel!";
		$acao="alt";
	}
	
}elseif($acao=="excluir"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM niveis WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Nivel excluido com sucesso!";
		}else{
			$_SESSION["mensagem"]="Erro ao excluir nivel!";
		}		
	}
	header("Location:niveis.php");
	exit;
}

if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM niveis WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$nome=$res["nome"];
	$tipo=$res["tipo"];
}

if(empty($acao)) $acao="listar";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title><?php echo ($acao=="listar") ? "Niveis de Acesso" : "Configurar Nivel"; ?> - ERP System</title>
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
            <h1 class="erp-card-title">
                <?php if($acao=="listar"){ ?>
                <i class="fas fa-layer-group"></i> Niveis de Acesso
                <?php }elseif($acao=="alt"){ ?>
                <i class="fas fa-edit"></i> Editar Nivel
                <?php }else{ ?>
                <i class="fas fa-plus"></i> Novo Nivel
                <?php } ?>
            </h1>
            <?php if($acao=="listar"): ?>
            <div>
                <a href="niveis.php?acao=inc" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Novo Nivel
                </a>
            </div>
            <?php else: ?>
            <div>
                <a href="niveis.php" class="erp-btn erp-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?php echo (strpos($_SESSION["mensagem"],'sucesso')!==false) ? 'success' : 'danger'; ?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <?php if($acao=="listar"): ?>
    <div class="erp-card">
        <div class="erp-alert erp-alert-info" style="margin-bottom:24px;">
            <strong><i class="fas fa-info-circle"></i> Sobre Niveis de Acesso:</strong><br>
            Os niveis de acesso controlam as permissoes dos usuarios no sistema. Configure diferentes niveis para diferentes perfis de acesso.
        </div>
        
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th width="80">Cod</th>
                        <th>Nome do Nivel</th>
                        <th width="150">Tipo</th>
                        <th width="120" class="erp-text-center">Acoes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql=mysql_query("SELECT * FROM niveis ORDER BY nome ASC");
                    if(mysql_num_rows($sql) > 0){
                        while($res=mysql_fetch_array($sql)){
                            $tipo_texto = "";
                            $tipo_badge = "secondary";
                            switch($res["tipo"]){
                                case "A": $tipo_texto="Administrador"; $tipo_badge="danger"; break;
                                case "G": $tipo_texto="Gerente"; $tipo_badge="warning"; break;
                                case "U": $tipo_texto="Usuario"; $tipo_badge="primary"; break;
                                case "V": $tipo_texto="Vendedor"; $tipo_badge="info"; break;
                                case "F": $tipo_texto="Funcionario"; $tipo_badge="success"; break;
                                case "O": $tipo_texto="Cliente"; $tipo_badge="secondary"; break;
                                default: $tipo_texto="Indefinido"; $tipo_badge="secondary";
                            }
                    ?>
                    <tr>
                        <td><?php echo $res["id"]; ?></td>
                        <td><?php echo $res["nome"]; ?></td>
                        <td><span class="erp-badge erp-badge-<?php echo $tipo_badge; ?>"><?php echo $tipo_texto; ?></span></td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="niveis.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" onclick="if(confirm('Deseja excluir este nivel?')) window.location='niveis.php?acao=excluir&id=<?php echo $res["id"]; ?>'; return false;" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="4" style="text-align:center;padding:32px;color:#6c757d;">Nenhum nivel cadastrado</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <form name="form1" method="post" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
                <i class="fas fa-cog"></i> Configuracao do Nivel
            </h3>
            
            <div class="erp-form-group">
                <label class="erp-form-label">Nome do Nivel *</label>
                <input type="text" name="nome" class="erp-form-control" value="<?php echo $nome; ?>" required placeholder="Ex: Gerente de Vendas">
            </div>
            
            <div class="erp-form-group">
                <label class="erp-form-label">Tipo de Acesso *</label>
                <select name="tipo" class="erp-form-control" required>
                    <option value="">Selecione...</option>
                    <option value="A" <?php if($tipo=="A") echo "selected"; ?>>Administrador - Acesso Total</option>
                    <option value="G" <?php if($tipo=="G") echo "selected"; ?>>Gerente - Acesso Gerencial</option>
                    <option value="U" <?php if($tipo=="U") echo "selected"; ?>>Usuario - Acesso Padrao</option>
                    <option value="V" <?php if($tipo=="V") echo "selected"; ?>>Vendedor - Acesso Vendas</option>
                    <option value="F" <?php if($tipo=="F") echo "selected"; ?>>Funcionario - Acesso Operacional</option>
                    <option value="O" <?php if($tipo=="O") echo "selected"; ?>>Cliente - Acesso Externo</option>
                </select>
            </div>
            
            <div class="erp-alert erp-alert-warning">
                <strong><i class="fas fa-exclamation-triangle"></i> Atencao:</strong><br>
                <ul style="margin:8px 0 0 16px;padding:0;">
                    <li><strong>Administrador:</strong> Acesso total ao sistema</li>
                    <li><strong>Gerente:</strong> Acesso a relatorios e aprovacoes</li>
                    <li><strong>Usuario:</strong> Acesso limitado as operacoes basicas</li>
                    <li><strong>Vendedor:</strong> Acesso focado em vendas e clientes</li>
                    <li><strong>Funcionario:</strong> Acesso operacional interno</li>
                    <li><strong>Cliente:</strong> Acesso externo limitado</li>
                </ul>
            </div>
        </div>
        
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="niveis.php" class="erp-btn erp-btn-outline">Cancelar</a>
            <button type="submit" name="acao" value="<?php echo ($acao=="alt") ? "alterar" : "incluir"; ?>" class="erp-btn erp-btn-primary">
                <i class="fas fa-check"></i> <?php echo ($acao=="alt") ? "Salvar Alteracoes" : "Cadastrar Nivel"; ?>
            </button>
        </div>
    </form>
    <?php endif; ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
