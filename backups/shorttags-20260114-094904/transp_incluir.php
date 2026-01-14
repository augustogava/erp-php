<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Transportadora";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM transportadora WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Transportadora - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script src="ajax.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o nome Fantasia');
		cad.nome.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-truck"></i> Transportadora</h1>
            <?php if($acao=="entrar"): ?>
            <a href="transp_incluir.php?acao=inc" class="erp-btn erp-btn-primary">
                + Nova Transportadora
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <?php if($acao=="entrar"){ ?>
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="60">Cod</th>
                    <th>Nome</th>
                    <th>Regiao Atuante</th>
                    <th width="120">Telefone</th>
                    <th width="120" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM transportadora ORDER BY nome ASC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="5" class="erp-text-center" style="padding:40px;">Nenhuma transportadora cadastrada</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><?php echo $res["id"]; ?></td>
                    <td><?php echo $res["nome"]; ?></td>
                    <td><?php echo $res["reg_atuante"]; ?></td>
                    <td><?php echo $res["telefone"]; ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="transp_incluir.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir esta Transportadora?','transp_incluir_sql.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php }else{ 
        if($acao!="alt") $res = array();
    ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <?php echo ($acao=="inc") ? "Incluir Transportadora" : "Alterar Transportadora"; ?>
        </h3>
        <form action="transp_incluir_sql.php" method="post" name="form1" onsubmit="return verifica(form1);">
            <div class="erp-row">
                <div class="erp-col" style="max-width:100px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cod. Interno</label>
                        <input name="cod_transport" type="text" class="erp-form-control" value="<?php echo isset($res["id"]) ? $res["id"] : ''; ?>" readonly style="background:#e9ecef;">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Fantasia</label>
                        <input name="nome" type="text" class="erp-form-control" value="<?php echo isset($res["nome"]) ? $res["nome"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Razao Social</label>
                        <input name="razao" type="text" class="erp-form-control" value="<?php echo isset($res["razao"]) ? $res["razao"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CNPJ</label>
                        <input name="cnpj" type="text" class="erp-form-control" value="<?php echo isset($res["cnpj"]) ? $res["cnpj"] : ''; ?>" maxlength="20" onKeyPress="return validanum(this, event)" onKeyUp="mcgc(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">IE</label>
                        <input name="ie" type="text" class="erp-form-control" value="<?php echo isset($res["ie"]) ? $res["ie"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Endereco</label>
                        <input name="endereco" type="text" class="erp-form-control" value="<?php echo isset($res["endereco"]) ? $res["endereco"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col" style="max-width:200px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Complemento</label>
                        <input name="complemento" type="text" class="erp-form-control" value="<?php echo isset($res["complemento"]) ? $res["complemento"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CEP</label>
                        <input name="cep" type="text" class="erp-form-control" value="<?php echo isset($res["cep"]) ? $res["cep"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Bairro</label>
                        <input name="bairro" type="text" class="erp-form-control" value="<?php echo isset($res["bairro"]) ? $res["bairro"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">UF</label>
                        <select name="uf" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php
                            $sql2=mysql_query("SELECT * FROM estado");
                            while($res2=mysql_fetch_array($sql2)){
                            ?>
                            <option value="<?=$res2["id"]?>" <?php if(isset($res["uf"]) && $res2["id"]==$res["uf"]) echo "selected"; ?>><?=$res2["nome"]?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cidade</label>
                        <input name="cidade" type="text" class="erp-form-control" value="<?php echo isset($cidade) ? $cidade : ''; ?>" maxlength="30">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Telefone 1</label>
                        <input name="telefone" type="text" class="erp-form-control" value="<?php echo isset($res["telefone"]) ? $res["telefone"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Telefone 2</label>
                        <input name="tel2" type="text" class="erp-form-control" value="<?php echo isset($res["tel2"]) ? $res["tel2"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Fax 1</label>
                        <input name="fax" type="text" class="erp-form-control" value="<?php echo isset($res["fax"]) ? $res["fax"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Fax 2</label>
                        <input name="fax2" type="text" class="erp-form-control" value="<?php echo isset($res["fax2"]) ? $res["fax2"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Site</label>
                        <input name="site" type="text" class="erp-form-control" value="<?php echo isset($res["site"]) ? $res["site"] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Contato 1</label>
                        <input name="contato" type="text" class="erp-form-control" value="<?php echo isset($res["contato"]) ? $res["contato"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Celular 1</label>
                        <input name="celular" type="text" class="erp-form-control" value="<?php echo isset($res["celular"]) ? $res["celular"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">E-mail 1</label>
                        <input name="email" type="text" class="erp-form-control" value="<?php echo isset($res["email"]) ? $res["email"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Contato 2</label>
                        <input name="contato2" type="text" class="erp-form-control" value="<?php echo isset($res["contato2"]) ? $res["contato2"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Celular 2</label>
                        <input name="celular2" type="text" class="erp-form-control" value="<?php echo isset($res["celular2"]) ? $res["celular2"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">E-mail 2</label>
                        <input name="email2" type="text" class="erp-form-control" value="<?php echo isset($res["email2"]) ? $res["email2"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Coleta</label>
                        <input name="coleta" type="text" class="erp-form-control" value="<?php echo isset($res["coleta"]) ? $res["coleta"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Regiao Atuante</label>
                        <input name="reg_atuante" type="text" class="erp-form-control" value="<?php echo isset($res["reg_atuante"]) ? $res["reg_atuante"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Tempo p/ Coleta</label>
                        <input name="temp_col" type="text" class="erp-form-control" value="<?php echo isset($res["temp_col"]) ? $res["temp_col"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">End. Entrega</label>
                        <input name="end_entrega" type="text" class="erp-form-control" value="<?php echo isset($res["end_entrega"]) ? $res["end_entrega"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Bairro Entrega</label>
                        <input name="bairro_entrega" type="text" class="erp-form-control" value="<?php echo isset($res["bairro_entrega"]) ? $res["bairro_entrega"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cidade Entrega</label>
                        <input name="cid_entrega" type="text" class="erp-form-control" value="<?php echo isset($res["cid_entrega"]) ? $res["cid_entrega"] : ''; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col" style="max-width:200px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Estado Entrega</label>
                        <select name="est_entrega" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php
                            $sql2=mysql_query("SELECT * FROM estado");
                            while($res2=mysql_fetch_array($sql2)){
                            ?>
                            <option value="<?=$res2["id"]?>" <?php if(isset($res["est_entrega"]) && $res2["id"]==$res["est_entrega"]) echo "selected"; ?>><?=$res2["nome"]?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col" style="max-width:200px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Estados Atuantes</label>
                        <select name="est_atuante" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php
                            $sql2=mysql_query("SELECT * FROM estado");
                            while($res2=mysql_fetch_array($sql2)){
                            ?>
                            <option value="<?=$res2["id"]?>" <?php if(isset($res["est_atuante"]) && $res2["id"]==$res["est_atuante"]) echo "selected"; ?>><?=$res2["nome"]?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='transp_incluir.php'">
                    Voltar
                </button>
                <button type="submit" class="erp-btn erp-btn-primary">
                    Salvar
                </button>
            </div>
            <input name="acao" type="hidden" value="<?php echo ($acao=="alt") ? "alt" : "inc"; ?>">
            <input name="id" type="hidden" value="<?php echo $id; ?>">
        </form>
    </div>
    <?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
