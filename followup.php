<?php
include("conecta.php");
include("seguranca.php");
$fwcli=7;
$wtitulo = "";
$wdesc = "";

$bid = Input::request('bid', '');
$bdata = Input::request('bdata', '');
$bpal = Input::request('bpal', '');
if(!empty($bid)){
	$sql=mysql_query("SELECT * FROM followup WHERE id='$bid'");
	$res=mysql_fetch_array($sql);
	$wtitulo=$res["titulo"];
	$wdesc=$res["descricao"];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Followup - ERP System</title>
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
function fw(caixa){
	window.location=caixa.options[caixa.selectedIndex].value;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-comments"></i> Followup</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:16px;color:#2c3e50;"><i class="fas fa-search"></i> Busca</h3>
        <form action="" method="post" name="frmcad">
            <div class="erp-row">
                <div class="erp-col" style="max-width:200px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Buscar por data</label>
                        <input name="bdata" type="text" class="erp-form-control" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Por palavra chave</label>
                        <div style="display:flex;gap:8px;">
                            <input name="bpal" type="text" class="erp-form-control">
                            <button type="submit" class="erp-btn erp-btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="erp-form-group" style="margin-top:16px;">
            <label class="erp-form-label">Ou selecione na caixa abaixo</label>
            <select name="select" size="5" class="erp-form-control" onclick="fw(this);" style="height:150px;">
                <?php
                $busca="";
                $lim="LIMIT 0, 10";
                if(!empty($bdata)){
                    $busca.=" AND data='".data2banco($bdata)."'";
                    $lim="";
                }
                if(!empty($bpal)){
                    $busca.=" AND (titulo LIKE '%$bpal%' OR descricao LIKE '%$bpal%')";
                    $lim="";
                }
                $sql=mysql_query("SELECT * FROM followup WHERE cliente='$fwcli' $busca ORDER BY data DESC, hora DESC $lim");
                while($res=mysql_fetch_array($sql)){
                    $data=banco2data($res["data"])." ".$res["hora"];
                    $titulo=$res["titulo"];
                    $id=$res["id"];
                ?>
                <option value="followup.php?bid=<?php echo $id; ?>&bdata=<?php echo $bdata; ?>&bpal=<?php echo $bpal; ?>"><?php echo "$data - $titulo"; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:16px;color:#2c3e50;"><i class="fas fa-file-alt"></i> Detalhes</h3>
        <div class="erp-form-group">
            <label class="erp-form-label">Titulo</label>
            <input type="text" class="erp-form-control" value="<?php echo $wtitulo; ?>" readonly style="background:#e9ecef;">
        </div>
        <div class="erp-form-group">
            <label class="erp-form-label">Descricao</label>
            <textarea class="erp-form-control" rows="6" readonly style="background:#e9ecef;"><?php echo $wdesc; ?></textarea>
        </div>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
