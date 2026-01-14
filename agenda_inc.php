<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$dia=Input::request("dia");
$mes=Input::request("mes");
$dias=Input::request("dias");
$cli=Input::request("cli");
$nome=Input::request("nome");
$texto=Input::request("texto");
$titulo=Input::request("titulo");
$hora=Input::request("hora");
$cal_dia=Input::request("cal_dia");
$cal_mes=Input::request("cal_mes");
$cal_ano=Input::request("cal_ano");
$nivel=$_SESSION["login_nivel"];
$agendador=$_SESSION["login_nome"];
if($acao=="entrar"){
	settype($dia,"string");
	if(strlen($dia)==1) $dia="0$dia";
	settype($mes,"string");
	if(strlen($mes)==1) $mes="0$mes";	
}elseif($acao=="ok"){
	$data=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+$dias,date("Y")));
	$texto=$texto."\n Agendada por: ".$agendador;
	$sql=mysql_query("INSERT INTO agenda (cliente,nome,texto,titulo,data,hora) VALUES ('$cli','$nome','$texto','$titulo','$data','$hora')");
	if($sql){
		$_SESSION["mensagem"]="Compromisso agendado com sucesso!";
		header("Location:crm_infg.php?cli=$cli");
		exit;
	}else{
		$_SESSION["mensagem"]="O compromisso nao pode ser agendado!";
		$acao="entrar";
	}	
}	
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Agenda - ERP System</title>
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
function verifica(cadastro){
	if(cadastro.nome[cadastro.nome.selectedIndex].value==''){
		alert("Informe o Nome");
		cadastro.nome.focus();
		return false;
	}
	if (cadastro.dias.value == ""){
		alert("Informe os Dias");
		cadastro.dias.focus();
		return(false);
    }	
	if (cadastro.hora.value.length != 8){
		alert("Hora Invalida");
		cadastro.hora.focus();
		return(false);
    }
	if (cadastro.hora.value == "00:00:00"){
		alert("Informe a hora");
		cadastro.hora.focus();
		return(false);
    }	
	if (cadastro.titulo.value == ""){
		alert("Informe o Titulo");
		cadastro.titulo.focus();
		return(false);
    }	
	if (cadastro.texto.value == ""){
		alert("Informe a Descricao do Compromisso");
		cadastro.texto.focus();
		return(false);
    }					
	return(true);
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-calendar-alt"></i> Agenda</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <i class="fas fa-plus"></i> Agendar Compromisso
        </h3>
        <form action="" onsubmit="return verifica(this)" method="post" name="form1">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Agendar compromisso para</label>
                        <select name="nome" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php
                            $sql=mysql_query("SELECT clientes.id AS cliente,clientes.nome AS nome FROM clientes,cliente_login,niveis WHERE clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id AND niveis.tipo='F' ORDER BY clientes.nome ASC");
                            while($res=mysql_fetch_array($sql)){
                                $nome=$res["nome"];
                                $ray=explode(" ",$nome);
                                $nome=$ray[0];
                            ?>
                            <option value="<?php echo $nome; ?>"><?php echo $nome; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Dias</label>
                        <input name="dias" type="text" class="erp-form-control" maxlength="8">
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Hora (hh:mm:ss)</label>
                        <input name="hora" type="text" class="erp-form-control" onKeyUp="mhora(this)" value="00:00:00" maxlength="8">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Titulo (maximo 30 caracteres)</label>
                        <input name="titulo" type="text" class="erp-form-control" maxlength="30">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Descricao do Compromisso</label>
                        <textarea name="texto" class="erp-form-control" rows="6"></textarea>
                    </div>
                </div>
            </div>
            <div style="margin-top:20px;">
                <input name="acao" type="hidden" value="ok">
                <input name="cli" type="hidden" value="<?php echo $cli; ?>">
                <button type="submit" class="erp-btn erp-btn-primary">
                    <i class="fas fa-check"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
