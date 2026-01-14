<?php
include("conecta.php");
include("seguranca.php");

$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Empresa Configuracao";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO empresa (nome,apelido_fat,endereco_fat,bairro_fat,cidade_fat,estado_fat,cep_fat,fone_fat,cnpj_fat,ie_fat) VALUES('$nome','$apelido_fat','$endereco_fat','$bairro_fat','$cidade_fat','$estado_fat','$cep_fat','$fone_fat','$cnpj_fat','$ie_fat')");
	
	if($sql){
		$_SESSION["mensagem"]="Empresa cadastrada com sucesso!";
		header("Location:empresa.php");
		exit;
	}else{
		$_SESSION["mensagem"]="Erro ao cadastrar empresa!";
		$acao="inc";
	}
	
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE empresa SET nome='$nome',apelido_fat='$apelido_fat',endereco_fat='$endereco_fat',bairro_fat='$bairro_fat',cidade_fat='$cidade_fat',estado_fat='$estado_fat',cep_fat='$cep_fat',fone_fat='$fone_fat',cnpj_fat='$cnpj_fat',ie_fat='$ie_fat' WHERE id='$id'");
	
	if($sql){
		$_SESSION["mensagem"]="Empresa atualizada com sucesso!";
		header("Location:empresa.php");
		exit;		
	}else{
		$_SESSION["mensagem"]="Erro ao atualizar empresa!";
		$acao="alt";
	}
}elseif($acao=="excluir"){
	$sql=mysql_query("DELETE FROM empresa WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Empresa excluida com sucesso!";
	}else{
		$_SESSION["mensagem"]="Erro ao excluir empresa!";
	}
	header("Location:empresa.php");
	exit;
}

if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM empresa WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$nome=$res["nome"];
	$apelido_fat=$res["apelido_fat"];
	$endereco_fat=$res["endereco_fat"];
	$bairro_fat=$res["bairro_fat"];
	$cidade_fat=$res["cidade_fat"];
	$estado_fat=$res["estado_fat"];
	$cep_fat=$res["cep_fat"];
	$fone_fat=$res["fone_fat"];
	$cnpj_fat=$res["cnpj_fat"];
	$ie_fat=$res["ie_fat"];
}

if(empty($acao)) $acao="listar";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title><?php echo ($acao=="listar") ? "Empresas" : "Configurar Empresa"; ?> - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                <i class="fas fa-building"></i> Empresas do Sistema
                <?php }elseif($acao=="alt"){ ?>
                <i class="fas fa-edit"></i> Editar Empresa
                <?php }else{ ?>
                <i class="fas fa-plus"></i> Nova Empresa
                <?php } ?>
            </h1>
            <?php if($acao=="listar"): ?>
            <div>
                <a href="empresa.php?acao=inc" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Nova Empresa
                </a>
            </div>
            <?php else: ?>
            <div>
                <a href="empresa.php" class="erp-btn erp-btn-outline">
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
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th width="60">Cod</th>
                        <th>Nome / Razao Social</th>
                        <th width="150">CNPJ</th>
                        <th width="150">Cidade</th>
                        <th width="120" class="erp-text-center">Acoes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql=mysql_query("SELECT * FROM empresa ORDER BY nome ASC");
                    if(mysql_num_rows($sql) > 0){
                        while($res=mysql_fetch_array($sql)){
                    ?>
                    <tr>
                        <td><?php echo $res["id"]; ?></td>
                        <td><?php echo $res["nome"]; ?></td>
                        <td><?php echo $res["cnpj_fat"]; ?></td>
                        <td><?php echo $res["cidade_fat"]; ?></td>
                        <td>
                            <div class="erp-table-actions" style="justify-content:center;">
                                <a href="empresa.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" onclick="if(confirm('Deseja excluir esta empresa?')) window.location='empresa.php?acao=excluir&id=<?php echo $res["id"]; ?>'; return false;" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="5" style="text-align:center;padding:32px;color:#6c757d;">Nenhuma empresa cadastrada</td></tr>';
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
                <i class="fas fa-building"></i> Dados da Empresa
            </h3>
            
            <div class="erp-form-group">
                <label class="erp-form-label">Nome / Razao Social *</label>
                <input type="text" name="nome" class="erp-form-control" value="<?php echo $nome; ?>" required>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Apelido para Fatura</label>
                        <input type="text" name="apelido_fat" class="erp-form-control" value="<?php echo $apelido_fat; ?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CNPJ</label>
                        <input type="text" name="cnpj_fat" class="erp-form-control" value="<?php echo $cnpj_fat; ?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">IE</label>
                        <input type="text" name="ie_fat" class="erp-form-control" value="<?php echo $ie_fat; ?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
                <i class="fas fa-map-marker-alt"></i> Endereco
            </h3>
            
            <div class="erp-row">
                <div class="erp-col" style="flex:1;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CEP</label>
                        <input type="text" name="cep_fat" class="erp-form-control" value="<?php echo $cep_fat; ?>">
                    </div>
                </div>
                <div class="erp-col" style="flex:4;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Endereco</label>
                        <input type="text" name="endereco_fat" class="erp-form-control" value="<?php echo $endereco_fat; ?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Bairro</label>
                        <input type="text" name="bairro_fat" class="erp-form-control" value="<?php echo $bairro_fat; ?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cidade</label>
                        <input type="text" name="cidade_fat" class="erp-form-control" value="<?php echo $cidade_fat; ?>">
                    </div>
                </div>
                <div class="erp-col" style="flex:0.5;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">UF</label>
                        <input type="text" name="estado_fat" class="erp-form-control" value="<?php echo $estado_fat; ?>" maxlength="2">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Telefone</label>
                        <input type="text" name="fone_fat" class="erp-form-control" value="<?php echo $fone_fat; ?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="empresa.php" class="erp-btn erp-btn-outline">Cancelar</a>
            <button type="submit" name="acao" value="<?php echo ($acao=="alt") ? "alterar" : "incluir"; ?>" class="erp-btn erp-btn-primary">
                <i class="fas fa-check"></i> <?php echo ($acao=="alt") ? "Salvar Alteracoes" : "Cadastrar Empresa"; ?>
            </button>
        </div>
    </form>
    <?php endif; ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
