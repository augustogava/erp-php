<?
include("conecta.php");
include("seguranca.php");

$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Fornecedores Geral";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="incluir"){
	if(!empty($cnpj)){
		if(!CalculaCNPJ($cnpj)){
			$_SESSION["mensagem"]="CNPJ Incorreto!";
			header("Location:fornecedores_geral.php?acao=inc");
			exit;
		}
	}
	
	if(empty($fantasia)) $fantasia=$nome;
	
	$sql=mysql_query("INSERT INTO fornecedores (loja,nome,fantasia,endereco,bairro,cidade,estado,cep,tipo,cpf,cnpj,fone,fax,ie,im,contato,email,site,celular,fone2,aceita) VALUES ('$loja','$nome','$fantasia','$endereco','$bairro','$cidade','$estado','$cep','$tipo','$cpf','$cnpj','$fone','$fax','$ie','$im','$contato','$email','$site','$celular','$fone2','$aceita')");
	
	if($sql){
		$_SESSION["mensagem"]="Fornecedor cadastrado com sucesso!";
		header("Location:fornecedores.php");
		exit;
	}else{
		$_SESSION["mensagem"]="Erro ao cadastrar fornecedor!";
		$acao="inc";
	}	
	
}elseif($acao=="alterar"){
	if(!empty($cnpj)){
		if(!CalculaCNPJ($cnpj)){
			$_SESSION["mensagem"]="CNPJ Incorreto!";
			header("Location:fornecedores_geral.php?acao=alt&id=$id");
			exit;
		}
	}
	
	if(empty($fantasia)) $fantasia=$nome;
	
	$sql=mysql_query("UPDATE fornecedores SET loja='$loja',nome='$nome',fantasia='$fantasia',endereco='$endereco',bairro='$bairro',cidade='$cidade',estado='$estado',cep='$cep',tipo='$tipo',cpf='$cpf',cnpj='$cnpj',fone='$fone',fax='$fax',ie='$ie',im='$im',contato='$contato',email='$email',site='$site',celular='$celular',fone2='$fone2',aceita='$aceita' WHERE id='$id'");
	
	if($sql){
		$_SESSION["mensagem"]="Fornecedor atualizado com sucesso!";
		header("Location:fornecedores.php");
		exit;		
	}else{
		$_SESSION["mensagem"]="Erro ao atualizar fornecedor!";
		$acao="alt";
	}
}

if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM fornecedores WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	
	$loja=$res["loja"];
	$aceita=$res["aceita"];
	$nome=$res["nome"];
	$fantasia=$res["fantasia"];
	$endereco=$res["endereco"];
	$bairro=$res["bairro"];
	$cidade=$res["cidade"];
	$estado=$res["estado"];
	$cep=$res["cep"];
	$tipo=$res["tipo"];
	$cnpj=$res["cnpj"];
	$cpf=$res["cpf"];
	$fone=$res["fone"];
	$fax=$res["fax"];
	$ie=$res["ie"];
	$im=$res["im"];
	$contato=$res["contato"];
	$email=$res["email"];
	$site=$res["site"];
	$celular=$res["celular"];
	$fone2=$res["fone2"];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title><?=$acao=="alt"?"Editar":"Novo"?> Fornecedor - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script src="cep_re.php"></script>
</head>

<body style="background:#f8f9fa;padding:24px;" onLoad="enterativa=1;" onkeypress="return ent()">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title">
                <i class="fas fa-<?=$acao=="alt"?"edit":"plus"?>"></i> <?=$acao=="alt"?"Editar":"Novo"?> Fornecedor
                <?=$acao=="alt"?" #".$id:""?>
            </h1>
            <div>
                <a href="fornecedores.php" class="erp-btn erp-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
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
        <input type="hidden" name="loja" value="<?=$loja?>">
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-building"></i> Dados Principais</h3>
            <div class="erp-row">
                <div class="erp-col" style="flex:3;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Razao Social *</label>
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
                        <label class="erp-form-label">Tipo</label>
                        <select name="tipo" class="erp-form-control">
                            <option value="J" <?=$tipo=="J"?"selected":""?>>Juridica</option>
                            <option value="F" <?=$tipo=="F"?"selected":""?>>Fisica</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CNPJ</label>
                        <input type="text" name="cnpj" class="erp-form-control" value="<?=$cnpj?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CPF</label>
                        <input type="text" name="cpf" class="erp-form-control" value="<?=$cpf?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">IE</label>
                        <input type="text" name="ie" class="erp-form-control" value="<?=$ie?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">IM</label>
                        <input type="text" name="im" class="erp-form-control" value="<?=$im?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-map-marker-alt"></i> Endereco</h3>
            <div class="erp-row">
                <div class="erp-col" style="flex:1;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CEP</label>
                        <input type="text" name="cep" class="erp-form-control" value="<?=$cep?>" maxlength="9" onBlur="busca_cep(this.value,'','');">
                    </div>
                </div>
                <div class="erp-col" style="flex:4;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Endereco</label>
                        <input type="text" name="endereco" id="endereco" class="erp-form-control" value="<?=$endereco?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="erp-form-control" value="<?=$bairro?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="erp-form-control" value="<?=$cidade?>">
                    </div>
                </div>
                <div class="erp-col" style="flex:0.5;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">UF</label>
                        <input type="text" name="estado" id="estado" class="erp-form-control" value="<?=$estado?>" maxlength="2">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-phone"></i> Contato</h3>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Telefone</label>
                        <input type="text" name="fone" class="erp-form-control" value="<?=$fone?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Telefone 2</label>
                        <input type="text" name="fone2" class="erp-form-control" value="<?=$fone2?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Celular</label>
                        <input type="text" name="celular" class="erp-form-control" value="<?=$celular?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Fax</label>
                        <input type="text" name="fax" class="erp-form-control" value="<?=$fax?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Contato Principal</label>
                        <input type="text" name="contato" class="erp-form-control" value="<?=$contato?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">E-mail</label>
                        <input type="email" name="email" class="erp-form-control" value="<?=$email?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Website</label>
                        <input type="text" name="site" class="erp-form-control" value="<?=$site?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-cog"></i> Configuracoes</h3>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Status</label>
                        <select name="aceita" class="erp-form-control">
                            <option value="S" <?=$aceita=="S"?"selected":""?>>Ativo</option>
                            <option value="N" <?=$aceita=="N"?"selected":""?>>Inativo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="fornecedores.php" class="erp-btn erp-btn-secondary">Cancelar</a>
            <button type="submit" name="acao" value="<?=$acao=="alt"?"alterar":"incluir"?>" class="erp-btn erp-btn-success">
                <i class="fas fa-check"></i> <?=$acao=="alt"?"Salvar Alteracoes":"Cadastrar Fornecedor"?>
            </button>
        </div>
    </form>
</div>

<? include("mensagem.php"); ?>
</body>
</html>
