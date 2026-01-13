<?
include("conecta.php");
include("seguranca.php");

$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Na­veis de Acesso";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO niveis (nome,tipo) VALUES ('$nome','$tipo')");
	if($sql){
		$_SESSION["mensagem"]="Na­vel cadastrado com sucesso!";
		header("Location:niveis.php");
		exit;
	}else{
		$_SESSION["mensagem"]="Erro ao cadastrar na­vel!";
		$acao="inc";
	}
	
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE niveis SET nome='$nome',tipo='$tipo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Na­vel atualizado com sucesso!";
		header("Location:niveis.php");
		exit;
	}else{
		$_SESSION["mensagem"]="Erro ao atualizar na­vel!";
		$acao="alt";
	}
	
}elseif($acao=="excluir"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM niveis WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Na­vel exclua­do com sucesso!";
		}else{
			$_SESSION["mensagem"]="Erro ao excluir na­vel!";
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
<title><?=$acao=="listar"?"Na­veis de Acesso":"Configurar Na­vel"?> - ERP System</title>
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
                <?=$acao=="listar"?"ð Na­veis de Acesso":($acao=="alt"?"âï¸ Editar Na­vel":"â Novo Na­vel")?>
            </h1>
            <?php if($acao=="listar"): ?>
            <div>
                <a href="niveis.php?acao=inc" class="erp-btn erp-btn-primary">
                    â Novo Na­vel
                </a>
            </div>
            <?php else: ?>
            <div>
                <a href="niveis.php" class="erp-btn erp-btn-outline">
                    â Voltar
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?=strpos($_SESSION["mensagem"],'sucesso')!==false?'success':'danger'?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <?php if($acao=="listar"): ?>
    <div class="erp-card">
        <div class="erp-alert erp-alert-info" style="margin-bottom:24px;">
            <strong>â¹ï¸ Sobre Na­veis de Acesso:</strong><br>
            Os na­veis de acesso controlam as permissaµes dos usua¡rios no sistema. Configure diferentes na­veis para diferentes perfis de acesso.
        </div>
        
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>Ca³d</th>
                        <th>Nome do Na­vel</th>
                        <th>Tipo</th>
                        <th class="erp-table-actions">Acaµes</th>
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
                                case "U": $tipo_texto="Usua¡rio"; $tipo_badge="primary"; break;
                                case "V": $tipo_texto="Vendedor"; $tipo_badge="info"; break;
                                default: $tipo_texto="Indefinido"; $tipo_badge="secondary";
                            }
                    ?>
                    <tr>
                        <td><?=$res["id"]?></td>
                        <td><?=$res["nome"]?></td>
                        <td><span class="erp-badge erp-badge-<?=$tipo_badge?>"><?=$tipo_texto?></span></td>
                        <td class="erp-table-actions">
                            <a href="niveis.php?acao=alt&id=<?=$res["id"]?>" class="erp-btn erp-btn-sm erp-btn-outline" title="Editar">
                                âï¸
                            </a>
                            <a href="#" onclick="if(confirm('Deseja excluir este na­vel?')) window.location='niveis.php?acao=excluir&id=<?=$res["id"]?>'; return false;" class="erp-btn erp-btn-sm erp-btn-danger" title="Excluir">
                                ðï¸
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="4" style="text-align:center;padding:32px;color:#6c757d;">Nenhum na­vel cadastrado</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <form name="form1" method="post" action="">
        <input type="hidden" name="id" value="<?=$id?>">
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">ð Configuracao do Na­vel</h3>
            
            <div class="erp-form-group">
                <label class="erp-form-label">Nome do Na­vel *</label>
                <input type="text" name="nome" class="erp-form-control" value="<?=$nome?>" required placeholder="Ex: Gerente de Vendas">
            </div>
            
            <div class="erp-form-group">
                <label class="erp-form-label">Tipo de Acesso *</label>
                <select name="tipo" class="erp-form-control" required>
                    <option value="">Selecione...</option>
                    <option value="A" <?=$tipo=="A"?"selected":""?>>ð´ Administrador - Acesso Total</option>
                    <option value="G" <?=$tipo=="G"?"selected":""?>>ð¡ Gerente - Acesso Gerencial</option>
                    <option value="U" <?=$tipo=="U"?"selected":""?>>ðµ Usua¡rio - Acesso Padrao</option>
                    <option value="V" <?=$tipo=="V"?"selected":""?>>ð¢ Vendedor - Acesso Vendas</option>
                </select>
            </div>
            
            <div class="erp-alert erp-alert-warning">
                <strong>â ï¸ Atencao:</strong><br>
                â¢ <strong>Administrador:</strong> Acesso total ao sistema<br>
                â¢ <strong>Gerente:</strong> Acesso a relata³rios e aprovacaµes<br>
                â¢ <strong>Usua¡rio:</strong> Acesso limitado a s operacaµes ba¡sicas<br>
                â¢ <strong>Vendedor:</strong> Acesso focado em vendas e clientes
            </div>
        </div>
        
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="niveis.php" class="erp-btn erp-btn-secondary">Cancelar</a>
            <button type="submit" name="acao" value="<?=$acao=="alt"?"alterar":"incluir"?>" class="erp-btn erp-btn-success">
                â <?=$acao=="alt"?"Salvar Alteracaµes":"Cadastrar Na­vel"?>
            </button>
        </div>
    </form>
    <?php endif; ?>
</div>

<? include("mensagem.php"); ?>
</body>
</html>
