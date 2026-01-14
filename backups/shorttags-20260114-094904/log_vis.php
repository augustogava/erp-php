<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Log - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-file-alt"></i> Log</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <i class="fas fa-folder-open"></i> Selecione o arquivo de Log
        </h3>
        <form name="form1" method="post" action="log_vis_sql.php">
            <div class="erp-table-container">
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th width="50" class="erp-text-center">Sel.</th>
                            <th>Arquivo</th>
                            <th width="150">Tamanho</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $found = false;
                    if($pasta=opendir(".")){
                        while (false !== ($arquivo = readdir($pasta))) {
                            if($arquivo!="." && $arquivo!=".."){
                                $ext=extensao($arquivo);
                                if($ext=="txt"){
                                    $found = true;
                                    $size = filesize($arquivo);
                                    if($size >= 1048576) {
                                        $size_str = round($size / 1024 / 1024, 1) . " MB";
                                    } elseif($size >= 1024) {
                                        $size_str = round($size / 1024, 1) . " KB";
                                    } else {
                                        $size_str = $size . " bytes";
                                    }
                    ?>
                        <tr>
                            <td class="erp-text-center">
                                <input name="arquivo" type="radio" value="<?=$arquivo?>" checked>
                            </td>
                            <td><?php echo $arquivo; ?></td>
                            <td><?php echo $size_str; ?></td>
                        </tr>
                    <?php
                                }
                            }
                        }
                        closedir($pasta);
                    }
                    if(!$found){
                    ?>
                        <tr>
                            <td colspan="3" class="erp-text-center" style="padding:40px;">Nenhum arquivo de log encontrado</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($found){ ?>
            <div class="erp-row" style="margin-top:20px;">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Acao</label>
                        <div style="display:flex;gap:20px;margin-top:8px;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="tipo" type="radio" value="dow" checked> Download
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="tipo" type="radio" value="abrir"> Abrir
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="margin-top:20px;">
                <input name="acao" type="hidden" value="ir">
                <button type="submit" class="erp-btn erp-btn-primary">
                    <i class="fas fa-check"></i> Continuar
                </button>
            </div>
            <?php } ?>
        </form>
    </div>
</div>

<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>
</body>
</html>
