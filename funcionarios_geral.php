<?
include("conecta.php");
include("seguranca.php");

$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Funcionarios Geral";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="incluir"){
	$nascimento=data2banco($nascimento);
	$admissao=data2banco($admissao);
	
	$sql=mysql_query("INSERT INTO funcionarios (nome,rg,carteira,nascimento,admissao,cargo,org,filial,centro,cooperado,grupo,email,fantasia) VALUES ('$nome','$rg','$carteira','$nascimento','$admissao','$cargo','$org','$filial','$centro','$cooperado','$grupo','$email','$fantasia')");
	
	if($sql){
		$_SESSION["mensagem"]="Funciona¡rio cadastrado com sucesso!";
		header("Location:funcionarios.php");
		exit;
	}else{
		$_SESSION["mensagem"]="Erro ao cadastrar funciona¡rio!";
		$nascimento=banco2data($nascimento);
		$admissao=banco2data($admissao);
		$acao="inc";
	}
	
}elseif($acao=="alterar"){
	$nascimento=data2banco($nascimento);
	$admissao=data2banco($admissao);
	
	$sql=mysql_query("UPDATE funcionarios SET nome='$nome',rg='$rg',carteira='$carteira',nascimento='$nascimento',admissao='$admissao',cargo='$cargo',org='$org',filial='$filial',centro='$centro',cooperado='$cooperado',grupo='$grupo',email='$email',fantasia='$fantasia' WHERE id='$id'");
	
	if($sql){
		$_SESSION["mensagem"]="Funciona¡rio atualizado com sucesso!";
		header("Location:funcionarios.php");
		exit;		
	}else{
		$_SESSION["mensagem"]="Erro ao atualizar funciona¡rio!";
		$nascimento=banco2data($nascimento);
		$admissao=banco2data($admissao);
		$acao="alt";
	}
}

if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM funcionarios WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	
	$nascimento=banco2data($res["nascimento"]);
	$nome=$res["nome"];
	$rg=$res["rg"];
	$carteira=$res["carteira"];
	$admissao=banco2data($res["admissao"]);
	$cargo=$res["cargo"];
	$org=$res["org"];
	$filial=$res["filial"];
	$centro=$res["centro"];
	$cooperado=$res["cooperado"];
	$grupo=$res["grupo"];
	$email=$res["email"];
	$fantasia=$res["fantasia"];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title><?=$acao=="alt"?"Editar":"Novo"?> Funciona¡rio - ERP System</title>
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
            <h1 class="erp-card-title">
                <?=$acao=="alt"?"âï¸ Editar":"â Novo"?> Funciona¡rio
                <?=$acao=="alt"?" #".$id:""?>
            </h1>
            <div>
                <a href="funcionarios.php" class="erp-btn erp-btn-outline">
                    â Voltar
                </a>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?=strpos($_SESSION["mensagem"],'sucesso')!==false?'success':'danger'?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <form name="form1" method="post" action="">
        <input type="hidden" name="id" value="<?=$id?>">
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">ð Dados Pessoais</h3>
            <div class="erp-row">
                <div class="erp-col" style="flex:3;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome Completo *</label>
                        <input type="text" name="nome" class="erp-form-control" value="<?=$nome?>" required>
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome Fantasia</label>
                        <input type="text" name="fantasia" class="erp-form-control" value="<?=$fantasia?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Nascimento</label>
                        <input type="text" name="nascimento" class="erp-form-control" value="<?=$nascimento?>" placeholder="DD/MM/AAAA">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">RG</label>
                        <input type="text" name="rg" class="erp-form-control" value="<?=$rg?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Carteira Profissional</label>
                        <input type="text" name="carteira" class="erp-form-control" value="<?=$carteira?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">ð¼ Dados Funcionais</h3>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Admissao</label>
                        <input type="text" name="admissao" class="erp-form-control" value="<?=$admissao?>" placeholder="DD/MM/AAAA">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cargo</label>
                        <select name="cargo" class="erp-form-control">
                            <option value="">Selecione...</option>
                            <?php
                            $sqlc=mysql_query("SELECT * FROM cargos ORDER BY cargo ASC");
                            while($resc=mysql_fetch_array($sqlc)){
                                $sel = ($cargo==$resc["id"]) ? "selected" : "";
                                echo '<option value="'.$resc["id"].'" '.$sel.'>'.$resc["cargo"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">argao</label>
                        <input type="text" name="org" class="erp-form-control" value="<?=$org?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Filial</label>
                        <input type="text" name="filial" class="erp-form-control" value="<?=$filial?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Centro de Custo</label>
                        <input type="text" name="centro" class="erp-form-control" value="<?=$centro?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cooperado</label>
                        <select name="cooperado" class="erp-form-control">
                            <option value="">Selecione...</option>
                            <option value="S" <?=$cooperado=="S"?"selected":""?>>Sim</option>
                            <option value="N" <?=$cooperado=="N"?"selected":""?>>Nao</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Grupo</label>
                        <input type="text" name="grupo" class="erp-form-control" value="<?=$grupo?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">ð§ Contato</h3>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">E-mail</label>
                        <input type="email" name="email" class="erp-form-control" value="<?=$email?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="funcionarios.php" class="erp-btn erp-btn-secondary">Cancelar</a>
            <button type="submit" name="acao" value="<?=$acao=="alt"?"alterar":"incluir"?>" class="erp-btn erp-btn-success">
                â <?=$acao=="alt"?"Salvar Alteracaµes":"Cadastrar Funciona¡rio"?>
            </button>
        </div>
    </form>
</div>

<? include("mensagem.php"); ?>
</body>
</html>
