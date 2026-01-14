<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$bde=Input::request("bde");
$bate=Input::request("bate");
$id=Input::request("id");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Compras Cotacoes";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="entrar"){
	if(empty($bde)){
		$bde=date("d/m/Y");
		$bate=date("d/m/Y");
	}
	$busca=" WHERE compras_cotacao.fornecedor=fornecedores.id ";
	if(!empty($bde)){
		$bde_b=data2banco($bde);
		$busca.="AND compras_cotacao.data>='$bde_b' ";
		if(!empty($bate)){
			$bate_b=data2banco($bate);
			$busca.="AND compras_cotacao.data<='$bate_b' ";
		}
	}
	$sql=mysql_query("SELECT compras_cotacao.*,fornecedores.fantasia FROM compras_cotacao,fornecedores $busca ORDER BY compras_cotacao.data ASC, compras_cotacao.id ASC");
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM compras_cotacao WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$sql=mysql_query("SELECT fantasia FROM fornecedores WHERE id='$res[fornecedor]'");
	if(mysql_num_rows($sql)){
		$rest=mysql_fetch_array($sql);
		$res["fantasia"]=$rest["fantasia"];
	}	
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Cotacoes - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verificabusca(cad){
	if(cad.bde.value!=''){
		if(!verifica_data(cad.bde.value)){
			alert('Data de inicio incorreta');
			cad.bde.focus();
			return false;
		}
		if(!verifica_data(cad.bate.value)){
			cad.bate.value='';
		}
	}
	return true;
}
</script>
</head>
<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-file-invoice-dollar"></i> Cotacoes</h1>
            <div style="display:flex;gap:8px;">
                <a href="compras_cot_sql.php?acao=inc" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Nova Cotacao
                </a>
            </div>
        </div>
    </div>

<?php if($acao=="entrar"){ ?>
    <div class="erp-card">
        <form method="post" action="" name="formbus" onSubmit="return verificabusca(this)">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Inicial</label>
                        <input name="bde" type="text" class="erp-form-control" value="<?php echo $bde?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Final</label>
                        <input name="bate" type="text" class="erp-form-control" value="<?php echo $bate?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">Cotacao</th>
                    <th>Fornecedor</th>
                    <th width="100" class="erp-text-right">Valor</th>
                    <th width="100">Prazo</th>
                    <th width="150" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
<?php
if(mysql_num_rows($sql)==0){
?>
                <tr>
                    <td colspan="5" class="erp-text-center" style="padding:40px;">Nenhuma cotacao encontrada</td>
                </tr>
<?php
}else{
    while($res=mysql_fetch_array($sql)){
?>
                <tr>
                    <td><strong>#<?php echo $res["id"]?></strong></td>
                    <td><?php echo $res["fantasia"]?></td>
                    <td class="erp-text-right"><strong>R$ <?php echo banco2valor($res["valor"])?></strong></td>
                    <td><?php echo $res["prazo"]?> dias</td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="compras_cot.php?acao=alt&id=<?php echo $res["id"]?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir esta Cotacao?','compras_cot_sql.php?acao=exc&id=<?php echo $res["id"]?>')" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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

<?php }else{ ?>
    <div class="erp-card">
        <div class="erp-card-header">
            <h3><i class="fas fa-edit"></i> <?php if($acao=="inc"){ echo "Incluir"; }else{ echo "Alterar";} ?> Cotacao</h3>
        </div>
        <div class="erp-card-body">
            <form name="form1" method="post" action="compras_cot_sql.php">
                <div class="erp-row">
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Numero</label>
                            <input type="text" class="erp-form-control" value="<?php echo $res["id"]?>" readonly>
                        </div>
                    </div>
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Fornecedor</label>
                            <input type="text" class="erp-form-control" value="<?php echo $res["fantasia"]?>" readonly>
                        </div>
                    </div>
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Data</label>
                            <input name="data" type="text" class="erp-form-control" value="<?php echo banco2data($res["data"])?>" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                        </div>
                    </div>
                </div>
                <div class="erp-row">
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Valor</label>
                            <input name="valor" type="text" class="erp-form-control" value="<?php echo banco2valor($res["valor"])?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">
                        </div>
                    </div>
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Prazo (dias)</label>
                            <input name="prazo" type="text" class="erp-form-control" value="<?php echo $res["prazo"]?>">
                        </div>
                    </div>
                </div>
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Observacoes</label>
                            <textarea name="obs" class="erp-form-control" rows="3"><?php echo $res["obs"]?></textarea>
                        </div>
                    </div>
                </div>

                <div style="margin-top:20px;display:flex;gap:10px;justify-content:center;">
                    <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='compras_cot.php'">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                    <button type="submit" class="erp-btn erp-btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>

                <input name="acao" type="hidden" value="<?php echo $acao?>">
                <input name="id" type="hidden" value="<?php echo $id?>">
                <input name="fornecedor" type="hidden" value="<?php echo $res["fornecedor"]?>">
            </form>
        </div>
    </div>
<?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
