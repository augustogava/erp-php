<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="alt";
if($acao=="alterar"){
	$afastamento_ini=data2banco($afastamento_ini);
	$afastamento_fim=data2banco($afastamento_fim);
	$res_data=data2banco($res_data);
	$ferias_ini=data2banco($ferias_ini);
	$ferias_fim=data2banco($ferias_fim);
	$cracha_prov_ini=data2banco($cracha_prov_ini);
	$cracha_prov_fim=data2banco($cracha_prov_fim);
	$sql=mysql_query("UPDATE funcionario_outros SET situacao='$situacao',afastamento_ini='$afastamento_ini',afastamento_fim='$afastamento_fim',res_causa='$res_causa',res_data='$res_data',ferias_ini='$ferias_ini',ferias_fim='$ferias_fim',cracha_prov='$cracha_prov',cracha_prov_ini='$cracha_prov_ini',cracha_prov_fim='$cracha_prov_fim' WHERE cliente='$id'");
	if($sql){
		$_SESSION["mensagem"]="cadastro de outros dados alterado!";
		header("Location:funcionarios.php?bcod=$bcod&bnome=$bnome");
		exit;		
	}else{
		$_SESSION["mensagem"]="O cadastro de outros dados nao pode ser alterado!";
		$afastamento_ini=banco2data($afastamento_ini);
		$afastamento_fim=banco2data($afastamento_fim);
		$res_data=banco2data($res_data);
		$ferias_ini=banco2data($ferias_ini);
		$ferias_fim=banco2data($ferias_fim);
		$cracha_prov_ini=banco2data($cracha_prov_ini);
		$cracha_prov_fim=banco2data($cracha_prov_fim);				
		$acao="alt";
	}
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM funcionario_outros,clientes WHERE funcionario_outros.cliente='$id' AND clientes.id='$id'");
	$res=mysql_fetch_array($sql);
	$situacao=$res["situacao"];
	$afastamento_ini=banco2data($res["afastamento_ini"]);
	$afastamento_fim=banco2data($res["afastamento_fim"]);
	$res_causa=$res["res_causa"];
	$res_data=banco2data($res["res_data"]);
	$ferias_ini=banco2data($res["ferias_ini"]);
	$ferias_fim=banco2data($res["ferias_fim"]);
	$cracha_prov=$res["cracha_prov"];
	$cracha_prov_ini=banco2data($res["cracha_prov_ini"]);
	$cracha_prov_fim=banco2data($res["cracha_prov_fim"]);
	$fantasia=$res["fantasia"];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Funcionarios - Outros Dados</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script>
function verifica(cad){
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;" onLoad="enterativa=1;" onkeypress="return ent()">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-id-card"></i> Funcionarios - Outros Dados</h1>
            <div>
                <a href="funcionarios.php?bcod=<?=$bcod?>&bnome=<?=$bnome?>" class="erp-btn erp-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?=strpos($_SESSION["mensagem"],'alterado')!==false||strpos($_SESSION["mensagem"],'sucesso')!==false?'success':'danger'?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>

    <form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <input name="id" type="hidden" value="<? print $id; ?>">
        <input name="bcod" type="hidden" value="<? print $bcod; ?>">
        <input name="bnome" type="hidden" value="<? print $bnome; ?>">
        <input name="acao" type="hidden" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">

        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-user"></i> Dados</h3>

            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome</label>
                        <input type="text" class="erp-form-control" value="<? print $fantasia; ?>" disabled>
                    </div>
                </div>
                <div class="erp-col" style="flex:1;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Situacao</label>
                        <input name="situacao" type="text" class="erp-form-control" id="situacao" value="<? print $situacao; ?>" maxlength="20">
                    </div>
                </div>
            </div>

            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Ini. Afastamento</label>
                        <input name="afastamento_ini" type="text" class="erp-form-control" id="afastamento_ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $afastamento_ini; ?>" maxlength="10">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Fim Afastamento</label>
                        <input name="afastamento_fim" type="text" class="erp-form-control" id="afastamento_fim" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $afastamento_fim; ?>" maxlength="10">
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Causa Rescisao</label>
                        <input name="res_causa" type="text" class="erp-form-control" id="res_causa" value="<? print $res_causa; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Rescisao</label>
                        <input name="res_data" type="text" class="erp-form-control" id="res_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $res_data; ?>" maxlength="10">
                    </div>
                </div>
            </div>

            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Inicio Ferias</label>
                        <input name="ferias_ini" type="text" class="erp-form-control" id="ferias_ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $ferias_ini; ?>" maxlength="10">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Fim Ferias</label>
                        <input name="ferias_fim" type="text" class="erp-form-control" id="ferias_fim" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $ferias_fim; ?>" maxlength="10">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cracha Provisorio</label>
                        <input name="cracha_prov" type="text" class="erp-form-control" id="cracha_prov" value="<? print $cracha_prov; ?>" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Ini. Cracha Prov.</label>
                        <input name="cracha_prov_ini" type="text" class="erp-form-control" id="cracha_prov_ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $cracha_prov_ini; ?>" maxlength="10">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Fim Cracha Prov.</label>
                        <input name="cracha_prov_fim" type="text" class="erp-form-control" id="cracha_prov_fim" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $cracha_prov_fim; ?>" maxlength="10">
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="funcionarios.php?bcod=<?=$bcod?>&bnome=<?=$bnome?>" class="erp-btn erp-btn-secondary">Cancelar</a>
            <button type="submit" class="erp-btn erp-btn-success">Continuar</button>
        </div>
    </form>
</div>

<? include("mensagem.php"); ?>
</body>
</html>