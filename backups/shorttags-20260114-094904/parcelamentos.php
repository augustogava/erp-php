<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM parcelamentos WHERE id='$id'");
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
<title>Parcelamentos - ERP System</title>
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
function parcel(cad){
	if(cad.parcelado.checked){
		cad.alt[0].disabled=false;
		cad.alt[1].disabled=false;
		cad.parcelas.disabled=false;
		cad.parcelas.style.background="white";
		cad.intervalo.disabled=false;
		cad.intervalo.style.background="white";
		cad.alts.disabled=false;
		cad.alts.style.background="white";
		cad.ent_sn.disabled=false;
		cad.ent_perc.disabled=false;
		cad.ent_perc.style.background="white";
		cad.vencimento[0].disabled=false;
		cad.vencimento[1].disabled=false;
		cad.vencimento[2].disabled=false;
		cad.carencia.disabled=false;
		cad.carencia.style.background="white";
		fixos(cad);
		fnentrada(cad);
	}else{
		cad.alt[0].disabled=true;
		cad.alt[1].disabled=true;
		cad.parcelas.disabled=true;
		cad.parcelas.style.background="silver";
		cad.intervalo.disabled=true;
		cad.intervalo.style.background="silver";
		cad.alts.disabled=true;
		cad.alts.style.background="silver";
		cad.ent_sn.disabled=true;
		cad.ent_perc.disabled=true;
		cad.ent_perc.style.background="silver";
		cad.vencimento[0].disabled=true;
		cad.vencimento[1].disabled=true;
		cad.vencimento[2].disabled=true;
		cad.carencia.disabled=true;
		cad.carencia.style.background="silver";
	}
}
function fixos(cad){
	if(cad.alt[0].checked){
		cad.parcelas.disabled=false;
		cad.parcelas.style.background="white";
		cad.intervalo.disabled=false;
		cad.intervalo.style.background="white";
		cad.alts.disabled=true;
		cad.alts.style.background="silver";
	}else{
		cad.parcelas.disabled=true;
		cad.parcelas.style.background="silver";
		cad.intervalo.disabled=true;
		cad.intervalo.style.background="silver";
		cad.alts.disabled=false;
		cad.alts.style.background="white";
	}
}
function fnentrada(cad){
	if(cad.ent_sn.checked){
		cad.ent_perc.disabled=false;
		cad.ent_perc.style.background="white";
	}else{
		cad.ent_perc.disabled=true;
		cad.ent_perc.style.background="silver";
	}
}
function verifica(cad){
	if(cad.descricao.value==''){
		alert('Informe a descricao');
		cad.descricao.focus();
		return false;
	}
	if(cad.parcelado.checked){
		if(cad.alt[0].checked){
			if(cad.parcelas.value=='' || cad.parcelas.value==0){
				alert('Informe a quantidade de parcelas');
				cad.parcelas.focus();
				return false;
			}
			if(cad.intervalo.value=='' || cad.intervalo.value==0){
				if(cad.parcelas.value!=1){
					alert('Informe o intervalo entre parcelas');
					cad.intervalo.focus();
					return false;
				}
			}
		}
		if(cad.alt[1].checked){
			if(cad.alts.value==''){
				alert('Informe os intervalos separados por virgula\nEx: 10,21,42');
				cad.alts.focus();
				return false;
			}
		}
		if(cad.ent_sn.checked){
			if(cad.ent_perc.value=='' || cad.ent_perc.value=='0,00'){
				alert('Informe o percentual de entrada');
				cad.ent_perc.focus();
				return false;
			}
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
            <h1 class="erp-card-title"><i class="fas fa-credit-card"></i> Parcelamentos</h1>
            <div style="display:flex;gap:8px;">
<?php if($acao=="entrar"){ ?>
                <a href="parcelamentos.php?acao=inc" class="erp-btn erp-btn-primary">
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
$sql=mysql_query("SELECT * FROM parcelamentos ORDER BY descricao ASC");
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
                    <td><strong><?=$res["descricao"]?></strong></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="parcelamentos.php?acao=alt&id=<?=$res["id"]?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir esta forma de pagamento?','parcelamentos_sql.php?acao=exc&id=<?=$res["id"]?>')" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
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
            <form name="form1" method="post" action="parcelamentos_sql.php" onSubmit="return verifica(this);">
                <div class="erp-row">
                    <div class="erp-col">
                        <div class="erp-form-group">
                            <label class="erp-form-label">Descricao</label>
                            <input name="descricao" type="text" class="erp-form-control" value="<?=$res["descricao"]?>" maxlength="50">
                        </div>
                    </div>
                </div>

                <div class="erp-row" style="margin-top:20px;">
                    <div class="erp-col">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input name="parcelado" type="checkbox" value="S" <?php if($res["parcelado"]=="S" or empty($res["parcelado"])) echo "checked"; ?> onclick="parcel(this.form);">
                            <strong>Utilizar forma parcelada</strong>
                        </label>
                    </div>
                </div>

                <div style="border:1px solid #ddd;border-radius:8px;padding:20px;margin-top:15px;background:#fafafa;">
                    <div class="erp-row">
                        <div class="erp-col">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="alt" type="radio" value="N" <?php if($res["alt"]=="N" or empty($res["alt"])) echo "checked"; ?> onclick="fixos(this.form);">
                                <strong>Parcelamento com dias fixos</strong>
                            </label>
                        </div>
                    </div>
                    <div class="erp-row" style="margin-top:10px;padding-left:25px;">
                        <div class="erp-col" style="flex:0 0 120px;">
                            <div class="erp-form-group">
                                <label class="erp-form-label">Parcelas</label>
                                <input name="parcelas" type="text" class="erp-form-control" value="<?=$res["parcelas"]?>" maxlength="3" onKeyPress="return validanum(this, event)">
                            </div>
                        </div>
                        <div class="erp-col" style="flex:0 0 150px;">
                            <div class="erp-form-group">
                                <label class="erp-form-label">Intervalo (dias)</label>
                                <input name="intervalo" type="text" class="erp-form-control" value="<?=$res["intervalo"]?>" maxlength="3" onKeyPress="return validanum(this, event)">
                            </div>
                        </div>
                    </div>

                    <div class="erp-row" style="margin-top:20px;">
                        <div class="erp-col">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="alt" type="radio" value="S" <?php if($res["alt"]=="S") echo "checked"; ?> onclick="fixos(this.form);">
                                <strong>Parcelamento com dias alternados</strong>
                            </label>
                        </div>
                    </div>
                    <div class="erp-row" style="margin-top:10px;padding-left:25px;">
                        <div class="erp-col">
                            <div class="erp-form-group">
                                <label class="erp-form-label">Intervalos (Ex: 10,21,42)</label>
                                <input name="alts" type="text" class="erp-form-control" value="<?=$res["alts"]?>">
                            </div>
                        </div>
                    </div>

                    <hr style="margin:20px 0;border:none;border-top:1px solid #ddd;">

                    <div class="erp-row">
                        <div class="erp-col">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="ent_sn" type="checkbox" value="S" <?php if($res["ent_sn"]=="S") echo "checked"; ?> onclick="fnentrada(this.form);">
                                <strong>Com entrada</strong>
                            </label>
                        </div>
                        <div class="erp-col" style="flex:0 0 150px;">
                            <div class="erp-form-group">
                                <label class="erp-form-label">% Entrada</label>
                                <input name="ent_perc" type="text" class="erp-form-control" value="<?=banco2valor($res["ent_perc"])?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">
                            </div>
                        </div>
                    </div>

                    <hr style="margin:20px 0;border:none;border-top:1px solid #ddd;">

                    <div class="erp-row">
                        <div class="erp-col">
                            <div class="erp-form-group">
                                <label class="erp-form-label">Vencimento</label>
                                <div style="display:flex;gap:15px;">
                                    <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                                        <input name="vencimento" type="radio" value="D" <?php if($res["vencimento"]=="D" or empty($res["vencimento"])) echo "checked"; ?>>
                                        Dia corrido
                                    </label>
                                    <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                                        <input name="vencimento" type="radio" value="U" <?php if($res["vencimento"]=="U") echo "checked"; ?>>
                                        Dia util
                                    </label>
                                    <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                                        <input name="vencimento" type="radio" value="P" <?php if($res["vencimento"]=="P") echo "checked"; ?>>
                                        Proximo dia util
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="erp-row" style="margin-top:15px;">
                        <div class="erp-col" style="flex:0 0 150px;">
                            <div class="erp-form-group">
                                <label class="erp-form-label">Carencia (dias)</label>
                                <input name="carencia" type="text" class="erp-form-control" value="<?=$res["carencia"]?>" maxlength="3" onKeyPress="return validanum(this, event)">
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top:20px;display:flex;gap:10px;justify-content:center;">
                    <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='parcelamentos.php'">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                    <button type="submit" class="erp-btn erp-btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>

                <input name="acao" type="hidden" value="<?=$acao?>">
                <input name="id" type="hidden" value="<?=$id?>">
            </form>
        </div>
    </div>
<?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
