<?php
include("conecta.php");
include("seguranca.php");

$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Clientes Geral";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="incluir"){
	$comissao=valor2banco($comissao);
	if(!empty($cnpj)){
		if(!CalculaCNPJ($cnpj)){
			$_SESSION["mensagem"]="CNPJ Incorreto!";
			header("Location:clientes_geral.php?acao=inc&tipop=$tipop");
			exit;
		}
	}
	if(!empty($cpf)){
		if(!CalculaCpf($cpf)){
			$_SESSION["mensagem"]="CPF Incorreto!";
			header("Location:clientes_geral.php?acao=inc&tipop=$tipop");
			exit;
		}
	}
	
	if(empty($fantasia)) $fantasia=$nome;
	$hj=date("Y-m-d");
	
	$sql=mysql_query("INSERT INTO clientes (loja,transportadora,nome,fantasia,status,tipo,endereco,bairro,cep,cidade,estado,fone,fax,cnpj,cpf,ie,im,vendedor,comissao,regiao,contabil,banco1,banco2,banco3,banco4,banco5,email,site,grupo,porte_che,porte_fun,porte_fat,ramo,complemento,ddd,dddf,origem_cad,data,ddd2,fone2,sit) VALUES ('$loja','$transportadora','$nome','$fantasia','$status','$tipo','$endereco','$bairro','$cep','$cidade','$estado','$fone','$fax','$cnpj','$cpf','$ie','$im','$vendedor','$comissao','$regiao','$contabil','$banco1','$banco2','$banco3','$banco4','$banco5','$email','$site','$grupo','$porte_che','$porte_fun','$porte_fat','$ramo','$complemento','$ddd','$dddf','$origem','$hj','$ddd2','$fone2','A')");
	
	$sql=mysql_query("select max(id)as maxid from clientes");
	$res=mysql_fetch_array($sql);
	$id=$res["maxid"];
	
	$sql=mysql_query("INSERT INTO cliente_cobranca (cliente,endereco,bairro,cep,cidade,estado) values('$id','$endereco_cob','$bairro_cob','$cep_cob','$cidade_cob','$estado_cob')");
	$sql=mysql_query("INSERT INTO cliente_entrega (cliente,endereco,bairro,cep,cidade,estado,endereco_ins,bairro_ins,cep_ins,cidade_ins,estado_ins) VALUES('$id','$endereco_ent','$bairro_ent','$cep_ent','$cidade_ent','$estado_ent','$endereco_ins','$bairro_ins','$cep_ins','$cidade_ins','$estado_ins')");
	
	if($sql){
		$_SESSION["mensagem"]="Cliente cadastrado com sucesso!";
		header("Location:clientes.php");
		exit;
	}
	
}elseif($acao=="alterar"){
	$comissao=valor2banco($comissao);
	if(!empty($cnpj)){
		if(!CalculaCNPJ($cnpj)){
			$_SESSION["mensagem"]="CNPJ Incorreto!";
			header("Location:clientes_geral.php?acao=alt&id=$id");
			exit;
		}
	}
	if(!empty($cpf)){
		if(!CalculaCpf($cpf)){
			$_SESSION["mensagem"]="CPF Incorreto!";
			header("Location:clientes_geral.php?acao=alt&id=$id");
			exit;
		}
	}
	
	if(empty($fantasia)) $fantasia=$nome;
	
	$sql=mysql_query("UPDATE clientes SET loja='$loja',transportadora='$transportadora',nome='$nome',fantasia='$fantasia',status='$status',tipo='$tipo',endereco='$endereco',bairro='$bairro',cep='$cep',cidade='$cidade',estado='$estado',fone='$fone',fax='$fax',cnpj='$cnpj',cpf='$cpf',ie='$ie',im='$im',vendedor='$vendedor',comissao='$comissao',regiao='$regiao',email='$email',site='$site',ramo='$ramo',complemento='$complemento',ddd='$ddd',dddf='$dddf',ddd2='$ddd2',fone2='$fone2',atualizacao=NOW() WHERE id='$id'");
	
	$sqlco=mysql_query("SELECT * FROM cliente_cobranca WHERE cliente='$id'");
	if(mysql_num_rows($sqlco)){
		$sql=mysql_query("UPDATE cliente_cobranca SET endereco='$endereco_cob',bairro='$bairro_cob',cep='$cep_cob',cidade='$cidade_cob',estado='$estado_cob' WHERE cliente='$id'");
	}else{
		$sql=mysql_query("INSERT INTO cliente_cobranca (cliente,endereco,bairro,cep,cidade,estado) values('$id','$endereco_cob','$bairro_cob','$cep_cob','$cidade_cob','$estado_cob')");
	}
	
	$sqlen=mysql_query("SELECT * FROM cliente_entrega WHERE cliente='$id'");
	if(mysql_num_rows($sqlen)){
		$sql=mysql_query("UPDATE cliente_entrega SET endereco='$endereco_ent',bairro='$bairro_ent',cep='$cep_ent',cidade='$cidade_ent',estado='$estado_ent',endereco_ins='$endereco_ins',bairro_ins='$bairro_ins',cep_ins='$cep_ins',cidade_ins='$cidade_ins',estado_ins='$estado_ins' WHERE cliente='$id'");
	}else{
		$sql=mysql_query("INSERT INTO cliente_entrega (cliente,endereco,bairro,cep,cidade,estado,endereco_ins,bairro_ins,cep_ins,cidade_ins,estado_ins) VALUES('$id','$endereco_ent','$bairro_ent','$cep_ent','$cidade_ent','$estado_ent','$endereco_ins','$bairro_ins','$cep_ins','$cidade_ins','$estado_ins')");
	}
	
	if($sql){
		$_SESSION["mensagem"]="Cliente atualizado com sucesso!";
		header("Location:clientes.php");
		exit;		
	}
}

if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM clientes WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	
	if(empty($res["cpf"])){
		$cpfcnpj=$res["cnpj"];
		$tipop="J";
	}else{
		$cpfcnpj=$res["cpf"];
		$tipop="F";
	}
	
	$loja=$res["loja"];
	$transportadora=$res["transportadora"];
	$nome=$res["nome"];
	$fantasia=$res["fantasia"];
	$status=$res["status"];
	$tipo=$res["tipo"];
	$endereco=$res["endereco"];
	$complemento=$res["complemento"];
	$bairro=$res["bairro"];
	$cep=$res["cep"];
	$cidade=$res["cidade"];
	$estado=$res["estado"];
	$ddd=$res["ddd"];
	$ddd2=$res["ddd2"];
	$dddf=$res["dddf"];
	$fone=$res["fone"];
	$fone2=$res["fone2"];
	$fax=$res["fax"];
	$ramo=$res["ramo"];
	$ie=$res["ie"];
	$cpf=$res["cpf"];
	$cnpj=$res["cnpj"];
	$im=$res["im"];
	$vendedor=$res["vendedor"];
	$comissao=banco2valor($res["comissao"]);
	$regiao=$res["regiao"];
	$email=$res["email"];
	$site=$res["site"];
	
	$sqlcob=mysql_query("SELECT * FROM cliente_cobranca WHERE cliente='$id'");
	if(mysql_num_rows($sqlcob)){
		$rescob=mysql_fetch_array($sqlcob);
		$endereco_cob=$rescob["endereco"];
		$bairro_cob=$rescob["bairro"];
		$cep_cob=$rescob["cep"];
		$cidade_cob=$rescob["cidade"];
		$estado_cob=$rescob["estado"];
	}
	
	$sqlent=mysql_query("SELECT * FROM cliente_entrega WHERE cliente='$id'");
	if(mysql_num_rows($sqlent)){
		$resent=mysql_fetch_array($sqlent);
		$endereco_ent=$resent["endereco"];
		$bairro_ent=$resent["bairro"];
		$cep_ent=$resent["cep"];
		$cidade_ent=$resent["cidade"];
		$estado_ent=$resent["estado"];
		$endereco_ins=$resent["endereco_ins"];
		$bairro_ins=$resent["bairro_ins"];
		$cep_ins=$resent["cep_ins"];
		$cidade_ins=$resent["cidade_ins"];
		$estado_ins=$resent["estado_ins"];
	}
}

if(empty($tipop)) $tipop="J";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title><?php echo $acao=="alt"?"Editar":"Novo"?> Cliente - ERP System</title>
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
                <i class="fas fa-<?php echo $acao=="alt"?"edit":"plus-circle"?>"></i>
                <?php echo $acao=="alt"?"Editar":"Novo"?> Cliente
                <?php echo $acao=="alt"?" #".$id:""?>
            </h1>
            <div>
                <a href="clientes.php" class="erp-btn erp-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?php echo strpos($_SESSION["mensagem"],'sucesso')!==false?'success':'danger'?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <form name="form1" method="post" action="">
        <input type="hidden" name="id" value="<?php echo $id?>">
        <input type="hidden" name="tipop" value="<?php echo $tipop?>">
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-clipboard-list"></i> Dados Principais</h3>
            <div class="erp-row">
                <div class="erp-col" style="flex:3;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome / Razao Social *</label>
                        <input type="text" name="nome" class="erp-form-control" value="<?php echo $nome?>" required>
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome Fantasia</label>
                        <input type="text" name="fantasia" class="erp-form-control" value="<?php echo $fantasia?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Tipo Pessoa</label>
                        <select name="tipo" class="erp-form-control">
                            <option value="J" <?php echo $tipo=="J"?"selected":""?>>Juridica</option>
                            <option value="F" <?php echo $tipo=="F"?"selected":""?>>Fisica</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label"><?php echo $tipop=="J"?"CNPJ":"CPF"?></label>
                        <input type="text" name="<?php echo $tipop=="J"?"cnpj":"cpf"?>" class="erp-form-control" value="<?php echo $cpfcnpj?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">IE / RG</label>
                        <input type="text" name="ie" class="erp-form-control" value="<?php echo $ie?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Inscricao Municipal</label>
                        <input type="text" name="im" class="erp-form-control" value="<?php echo $im?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-map-marker-alt"></i> Endereco Principal</h3>
            <div class="erp-row">
                <div class="erp-col" style="flex:1;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CEP</label>
                        <input type="text" name="cep" class="erp-form-control" value="<?php echo $cep?>" maxlength="9" onBlur="busca_cep(this.value,'','');">
                    </div>
                </div>
                <div class="erp-col" style="flex:3;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Endereco</label>
                        <input type="text" name="endereco" id="endereco" class="erp-form-control" value="<?php echo $endereco?>">
                    </div>
                </div>
                <div class="erp-col" style="flex:1;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Complemento</label>
                        <input type="text" name="complemento" class="erp-form-control" value="<?php echo $complemento?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="erp-form-control" value="<?php echo $bairro?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="erp-form-control" value="<?php echo $cidade?>">
                    </div>
                </div>
                <div class="erp-col" style="flex:0.5;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">UF</label>
                        <input type="text" name="estado" id="estado" class="erp-form-control" value="<?php echo $estado?>" maxlength="2">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-phone"></i> Contato</h3>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">DDD</label>
                        <input type="text" name="ddd" class="erp-form-control" value="<?php echo $ddd?>" maxlength="2">
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Telefone</label>
                        <input type="text" name="fone" class="erp-form-control" value="<?php echo $fone?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">DDD 2</label>
                        <input type="text" name="ddd2" class="erp-form-control" value="<?php echo $ddd2?>" maxlength="2">
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Telefone 2</label>
                        <input type="text" name="fone2" class="erp-form-control" value="<?php echo $fone2?>">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">E-mail</label>
                        <input type="email" name="email" class="erp-form-control" value="<?php echo $email?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Website</label>
                        <input type="text" name="site" class="erp-form-control" value="<?php echo $site?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-briefcase"></i> Dados Comerciais</h3>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Vendedor</label>
                        <select name="vendedor" class="erp-form-control">
                            <option value="">Selecione...</option>
                            <?php
                            $sqlv=mysql_query("SELECT * FROM vendedores ORDER BY nome ASC");
                            while($resv=mysql_fetch_array($sqlv)){
                                $sel = ($vendedor==$resv["id"]) ? "selected" : "";
                                echo '<option value="'.$resv["id"].'" '.$sel.'>'.$resv["nome"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Comissao (%)</label>
                        <input type="text" name="comissao" class="erp-form-control" value="<?php echo $comissao?>">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Ramo Atividade</label>
                        <input type="text" name="ramo" class="erp-form-control" value="<?php echo $ramo?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="clientes.php" class="erp-btn erp-btn-secondary">Cancelar</a>
            <button type="submit" name="acao" value="<?php echo $acao=="alt"?"alterar":"incluir"?>" class="erp-btn erp-btn-success">
                <i class="fas fa-<?php echo $acao=="alt"?"save":"check"?>"></i>
                <?php echo $acao=="alt"?"Salvar Alteracoes":"Cadastrar Cliente"?>
            </button>
        </div>
    </form>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
