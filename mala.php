<?php 
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$filtro=Input::request("filtro");
$msg=Input::request("msg");
$assunto=Input::request("assunto");
$de=Input::request("de");
function checaEmail($email) {
    $e = explode("@",$email);
    if(count($e) <= 1) {
        return FALSE;
    } elseif(count($e) == 2) {
        $ip = gethostbyname($e[1]);
        if($ip == $e[1]) {
            return FALSE;
        } elseif($ip != $e[1]) {
            return TRUE;
        }
    }
}
$i = 0;
$j = 0;
if($acao=="ok"){
	$quer="SELECT clientes.email,clientes.nome FROM clientes,cliente_login,niveis";
	$cond="WHERE cliente_login.cliente=clientes.id AND niveis.id=cliente_login.nivel ";
	if($filtro=="cli"){
		$cond.="AND niveis.tipo='O'";
	}elseif($filtro=="fun"){
		$cond.="AND niveis.tipo='F'";
	}elseif($filtro=="fis"){
		$cond="WHERE cpf<>''";
		$quer="SELECT email,nome FROM clientes";
	}elseif($filtro=="jur"){
		$cond="WHERE cnpj<>''";
		$quer="SELECT email,nome FROM clientes";
	}elseif($filtro=="tudo"){
		$cond="";
		$quer="SELECT email,nome FROM clientes";
	}
	$sql=mysql_query("$quer $cond");
	while($res=mysql_fetch_array($sql)){
		$j++;
		if(checaEmail($res["email"]) and !empty($res["email"])){
			$msg=stripcslashes($msg);
			mail("$res[nome]<$res[email]>",$assunto,$msg,"From: $de\nContent-type: text/html\n");
			$i++;
		}
	}
}
$mens = "";
$lines = file('mala_ass.php');
foreach($lines as $line){
	$line=str_replace("\"","'",$line);
	$mens.=$line;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Mala Direta - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<link href="editor.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="editor.js"></script>
<script>
var formnumber=0;
var enviado=false;
function assinatura(){
	if(confirm('Adicionar assinatura padrao?')){
		iView.document.body.innerHTML = imp.value;
		iView.focus();
	}
}
function verifica(cad){
	cad.msg.value=iView.document.body.innerHTML;
	if(cad.de.value==''){
		alert('Informe o remetente\nex:meunome<email@cybermanager.com.br>');
		cad.de.focus();
		return false;
	}
	if(cad.assunto.value==''){
		alert('Informe o assunto');
		cad.assunto.focus();
		return false;
	}
	if(cad.msg.value==''){
		alert('Digite a mensagem ou cole o codigo HTML');
		iView.focus();
		return false;
	}
	if(enviado){
		alert('Aguarde, este processo e demorado');
		return false;
	}else{
		enviado=true;
	}
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;" onload="iniciar(); assinatura();">
<input type="hidden" name="imp" value="<?php echo $mens; ?>">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-mail-bulk"></i> Mala Direta</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-card">
        <form name="form1" method="post" action="" onsubmit="return verifica(this);">
            <?php if($acao=="ok"){ ?>
            <div class="erp-alert erp-alert-info" style="margin-bottom:20px;">
                <strong><i class="fas fa-info-circle"></i> Resultado do envio:</strong><br>
                <?php echo $j; ?> emails foram encontrados<br>
                <?php echo $i; ?> emails eram validos e foram enviados
            </div>
            <?php } ?>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">De (Remetente)</label>
                        <input name="de" type="text" class="erp-form-control" placeholder="Nome<email@dominio.com.br>">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Assunto</label>
                        <input name="assunto" type="text" class="erp-form-control">
                    </div>
                </div>
                <div class="erp-col" style="max-width:200px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Filtro</label>
                        <select name="filtro" class="erp-form-control">
                            <option value="tudo" selected>Todos</option>
                            <option value="cli">Clientes</option>
                            <option value="fun">Funcionarios</option>
                            <option value="fis">Pessoas Fisicas</option>
                            <option value="jur">Pessoas Juridicas</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="erp-form-group">
                <label class="erp-form-label">Mensagem</label>
                <div style="border:1px solid #dee2e6;border-radius:8px;overflow:hidden;">
                    <table id="tblCtrls" width="100%" height="30px" border="0" cellspacing="0" cellpadding="0" bgcolor="#f8f9fa">
                        <tr>
                            <td colspan="2" style="padding:8px;">
                                <img alt="Negrito" class="butClass" src="imagens/ed_bold.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doBold()" style="cursor:pointer;">
                                <img alt="Italico" class="butClass" src="imagens/ed_italic.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doItalic()" style="cursor:pointer;">
                                <img alt="Sublinhado" class="butClass" src="imagens/ed_underline.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doUnderline()" style="cursor:pointer;">
                                <img alt="Alinhar a esquerda" class="butClass" src="imagens/ed_left.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doLeft()" style="cursor:pointer;">
                                <img alt="Centralizar" class="butClass" src="imagens/ed_center.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCenter()" style="cursor:pointer;">
                                <img alt="Alinhar a direita" class="butClass" src="imagens/ed_right.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doRight()" style="cursor:pointer;">
                                <img alt="Numeracao" class="butClass" src="imagens/ed_ordlist.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doOrdList()" style="cursor:pointer;">
                                <img alt="Marcadores" class="butClass" src="imagens/ed_bullist.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doBulList()" style="cursor:pointer;">
                                <img alt="Cor do texto" class="butClass" src="imagens/ed_forecol.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doForeCol()" style="cursor:pointer;">
                                <img alt="Cor do fundo" class="butClass" src="imagens/ed_bgcol.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doBackCol()" style="cursor:pointer;">
                                <img alt="Hyperlink" class="butClass" src="imagens/ed_link.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doLink()" style="cursor:pointer;">
                                <img alt="Imagem" class="butClass" src="imagens/ed_image.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="return abre('imagebank.php','banco','width=520,height=300,scrollbars=1');" style="cursor:pointer;">
                                <img alt="Regua horizontal" class="butClass" src="imagens/ed_rule.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doRule()" style="cursor:pointer;">
                                <input type="hidden" name="colourp" value="#000000">
                            </td>
                        </tr>
                        <tr valign="top">
                            <td style="padding:8px;">
                                <table width="206" border="1" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td bgcolor="#33CCCC" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#33CCCC')"></td>
                                        <td bgcolor="#339966" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#339966')"></td>
                                        <td bgcolor="#FFCC00" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#FFCC00')"></td>
                                        <td bgcolor="#800080" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#800080')"></td>
                                        <td bgcolor="#FF6600" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#FF6600')"></td>
                                        <td bgcolor="#FF00FF" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#FF00FF')"></td>
                                        <td bgcolor="#00FFFF" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#00FFFF')"></td>
                                        <td bgcolor="#FFFF00" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#FFFF00')"></td>
                                        <td bgcolor="#0000FF" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#0000FF')"></td>
                                        <td bgcolor="#00FF00" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#00FF00')"></td>
                                        <td bgcolor="#FF0000" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#FF0000')"></td>
                                        <td bgcolor="#FFFFFF" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#FFFFFF')"></td>
                                        <td bgcolor="#CCCCCC" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#CCCCCC')"></td>
                                        <td bgcolor="#999999" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#999999')"></td>
                                        <td bgcolor="#666666" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#666666')"></td>
                                        <td bgcolor="#333333" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#333333')"></td>
                                        <td bgcolor="#000000" width="10"><img height="8" src="imagens/dot.gif" width="10" style="cursor:pointer;" onClick="ColorPalette_OnClick('#000000')"></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="padding:8px;">
                                <table width="60" border="1" cellspacing="0" cellpadding="0" height="22">
                                    <tr>
                                        <td width="101" id="cpick" bgcolor="#000000">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <iframe id="iView" style="width:100%;height:250px;border:none;"></iframe>
                    <div style="background:#f8f9fa;padding:8px;display:flex;gap:8px;align-items:center;">
                        <select name="selFont" class="erp-form-control" style="width:auto;" onchange="doFont(this.options[this.selectedIndex].value)">
                            <option value="">-- Fonte --</option>
                            <option value="Arial">Arial</option>
                            <option value="Courier">Courier</option>
                            <option value="Sans Serif">Sans Serif</option>
                            <option value="Tahoma">Tahoma</option>
                            <option value="Verdana">Verdana</option>
                        </select>
                        <select name="selSize" class="erp-form-control" style="width:auto;" onchange="doSize(this.options[this.selectedIndex].value)">
                            <option value="">-- Tamanho --</option>
                            <option value="1">Muito pequeno</option>
                            <option value="2">Pequeno</option>
                            <option value="3">Medio</option>
                            <option value="4">Grande</option>
                            <option value="5">Muito Grande</option>
                            <option value="6">Super Grande</option>
                        </select>
                        <a href="#" onclick="return abre('mala_vis.php','mala','width=670,height=500,scrollbars=1');" class="erp-btn erp-btn-outline" style="margin-left:auto;">
                            <i class="fas fa-eye"></i> Visualizar
                        </a>
                        <a href="#" onclick="doToggleView();" class="erp-btn erp-btn-outline">
                            <i class="fas fa-code"></i> HTML
                        </a>
                    </div>
                </div>
            </div>
            
            <div style="margin-top:20px;">
                <input name="acao" type="hidden" value="ok">
                <input name="msg" type="hidden" value="empty">
                <button type="submit" class="erp-btn erp-btn-primary">
                    <i class="fas fa-paper-plane"></i> Enviar
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
