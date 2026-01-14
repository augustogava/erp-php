<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM op_pagamento WHERE id='$id'");
	if(mysql_num_rows($sql)==0){
		$acao="inc";
	}else{
		$res=mysql_fetch_array($sql);
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Formas de Pagamento - ERP System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o nome');
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
            <h1 class="erp-card-title"><i class="fas fa-money-check-alt"></i> Formas de Pagamento</h1>
            <div style="display:flex;gap:8px;">
<?php if($acao=="entrar"){ ?>
                <a href="op_pagamento.php?acao=inc" class="erp-btn erp-btn-primary">
                    <i class="fas fa-plus"></i> Nova Forma
                </a>
<?php } ?>
            </div>
        </div>
    </div>

<?php if($acao=="entrar"){ ?>
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th>Forma de Pagamento</th>
                    <th width="100" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
<?php
$sql=mysql_query("SELECT * FROM op_pagamento ORDER BY nome ASC");
if(mysql_num_rows($sql)==0){
?>
                <tr>
                    <td colspan="2" class="erp-text-center" style="padding:40px;">Nenhuma forma de pagamento cadastrada</td>
                </tr>
<?php
}else{
    while($res=mysql_fetch_array($sql)){
?>
                <tr>
                    <td><strong><?=$res["nome"]?></strong></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="op_pagamento.php?acao=alt&id=<?=$res["id"]?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir esta forma de pagamento?','op_pagamento_sql.php?acao=exc&id=<?=$res["id"]?>')" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
            <h3><i class="fas fa-edit"></i> <?php if($acao=="inc"){ echo "Incluir"; }else{ echo "Alterar"; } ?> Forma de Pagamento</h3>
        </div>
        <div class="erp-card-body">
            <form name="form1" method="post" action="op_pagamento_sql.php" onSubmit="return verifica(this);">
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Nome</label>
                            <input name="nome" type="text" class="erp-form-control" value="<?=$res["nome"]?>" maxlength="50">
                        </div>
                    </div>
                </div>
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Parcelamento</label>
                            <select name="parcelamento" class="erp-form-control">
                                <option value="">Selecione</option>
<?php
$sqlr=mysql_query("SELECT * FROM parcelamentos ORDER BY id ASC");
while($resr=mysql_fetch_array($sqlr)){
?>
                                <option value="<?=$resr["id"]?>" <?php if($res["parcelamento"]==$resr["id"]) echo "selected"; ?>><?=$resr["descricao"]?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Tipo</label>
                            <div style="display:flex;gap:20px;padding-top:5px;">
                                <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                                    <input name="op" type="radio" value="-" <?php if($res["operador"]=="-") echo "checked"; ?>>
                                    Desconto
                                </label>
                                <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                                    <input name="op" type="radio" value="+" <?php if($res["operador"]=="+") echo "checked"; ?>>
                                    Acrescimo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="erp-col" style="flex:0 0 150px;">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Valor (%)</label>
                            <input name="desconto" type="text" class="erp-form-control" value="<?=banco2valor($res["desconto"])?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" maxlength="10">
                        </div>
                    </div>
                </div>

                <div style="margin-top:20px;display:flex;gap:10px;justify-content:center;">
                    <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='op_pagamento.php'">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                    <button type="submit" class="erp-btn erp-btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>

                <input name="acao" type="hidden" value="<?=$acao?>">
                <input name="id" type="hidden" value="<?=$res["id"]?>">
            </form>
        </div>
    </div>
<?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
