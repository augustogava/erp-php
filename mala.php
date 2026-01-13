<? 
include("conecta.php");
include("seguranca.php");
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
	$i=0;
	$j=0;
	while($res=mysql_fetch_array($sql)){
		$j++;
		if(checaEmail($res["email"]) and !empty($res["email"])){
$res["email"]="webmaster@cyber1.com.br";
			$msg=stripcslashes ($msg);
			mail("$res[nome]<$res[email]>",$assunto,$msg,"From: $de\nContent-type: text/html\n");
			$i++;
		}
	}
}
$lines = file ('mala_ass.php');
foreach($lines as $line){
	//$line = addslashes ($line);
	$line=str_replace("\"","'",$line);
	$mens.=$line;
}
?>
<HTML>
<HEAD>
<TITLE>CyberManager</TITLE>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="editor.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; UTF-8"><meta name="webmaster" content="Christian Paul Pach">
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</HEAD>
<script src="editor.js"></script>
<script src="scripts.js"></script>
<script>
var formnumber=0; //numero do formulario na pagina
var enviado=false;
function assinatura(){
	 if(confirm('Adicionar assinatura padrão?')){
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
		alert('Digite a mensagem ou cole o código HTML');
		iView.focus();
		return false;
	}
	if(enviado){
		alert('Aguarde, este processo é demorado');
		return false;
	}else{
		enviado=true;
	}
	return true;
}
</script>
<BODY bgColor=#FFFFFF background="imagens/mdagua.gif" leftMargin=0 topMargin=0 marginwidth="0" marginheight="0" onLoad="iniciar(); assinatura();">
<input type="hidden" name="imp" value="<? print $mens; ?>">
<table width="594" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Mala Direta </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this);">
        <table width="415" border="0" cellspacing="0" cellpadding="0">
          <? if($acao=="ok"){ ?>
          <tr> 
            <td colspan="2" class="textobold"><? print $j; ?> emails foram encontrados<br> 
              <? print $i; ?> emails eram v&aacute;lidos</td>
          </tr>
          <? } ?>
          <tr> 
            <td width="81" class="textobold">De:</td>
            <td width="419"><input name="de" type="text" class="formselect" id="de"></td>
          </tr>
          <tr> 
            <td class="textobold">Assunto:</td>
            <td><input name="assunto" type="text" class="formselect" id="assunto"></td>
          </tr>
          <tr> 
            <td class="textobold">Filtro:</td>
            <td><select name="filtro" class="formulario" id="filtro">
                <option value="tudo" selected>Todos</option>
                <option value="cli">Clientes</option>
                <option value="fun">Funcion&aacute;rios</option>
                <option value="fis">Pessoas F&iacute;sicas</option>
                <option value="jur">Pessoas Jur&iacute;dicas</option>
              </select></td>
          </tr>
          <tr> 
            <td class="textobold">Mensagem:</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"><table id="tblCtrls" width="415px" height="30px" border="0" cellspacing="0" cellpadding="0" bgcolor="#D6D3CE">
                <tr> 
                  <td colspan="2" class="tdClass"> <img alt="Negrito" class="butClass" src="imagens/ed_bold.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doBold()"> 
                    <img alt="It&aacute;lico" class="butClass" src="imagens/ed_italic.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doItalic()"> 
                    <img alt="Sublinhado" class="butClass" src="imagens/ed_underline.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doUnderline()"> 
                    <img alt="Alinhar &agrave; esquerda" class="butClass" src="imagens/ed_left.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doLeft()"> 
                    <img alt="Centralizar" class="butClass" src="imagens/ed_center.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCenter()"> 
                    <img alt="Alinhar &agrave; direita" class="butClass" src="imagens/ed_right.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doRight()"> 
                    <img alt="Numera&ccedil;&atilde;o" class="butClass" src="imagens/ed_ordlist.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doOrdList()"> 
                    <img alt="Marcadores" class="butClass" src="imagens/ed_bullist.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doBulList()"> 
                    <img alt="Cor do texto" class="butClass" src="imagens/ed_forecol.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doForeCol()"> 
                    <img alt="Cor do fundo" class="butClass" src="imagens/ed_bgcol.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doBackCol()"> 
                    <img alt="Hyperlink" class="butClass" src="imagens/ed_link.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doLink()"> 
                    <img alt="Imagem" class="butClass" src="imagens/ed_image.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="return abre('imagebank.php','banco','width=520,height=300,scrollbars=1');"> 
                    <img alt="R&eacute;gua horizontal" class="butClass" src="imagens/ed_rule.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doRule()"> 
                    <input type="hidden" name="colourp" value="#000000"></td>
                </tr>
                <tr valign="top"> 
                  <td width="214" align="center" class="tdClass"> <table width="206" border="1" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td bgcolor="#33CCCC" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#33CCCC')"></td>
                        <td bgcolor="#339966" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#339966')"></td>
                        <td bgcolor="#FFCC00" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FFCC00')"></td>
                        <td bgcolor="#800080" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#800080')"></td>
                        <td bgcolor="#FF6600" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FF6600')"></td>
                        <td bgcolor="#FF00FF" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FF00FF')"></td>
                        <td bgcolor="#00FFFF" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#00FFFF')"></td>
                        <td bgcolor="#FFFF00" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FFFF00')"></td>
                        <td bgcolor="#0000FF" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#0000FF')"></td>
                        <td bgcolor="#00FF00" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#00FF00')"></td>
                        <td bgcolor="#FF0000" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FF0000')"></td>
                        <td bgcolor="#FFFFFF" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FFFFFF')"></td>
                        <td bgcolor="#CCCCCC" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#CCCCCC')"></td>
                        <td bgcolor="#999999" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#999999')"></td>
                        <td bgcolor="#666666" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#666666')"></td>
                        <td bgcolor="#333333" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#333333')"></td>
                        <td bgcolor="#000000" width="10"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#000000')"></td>
                      </tr>
                      <tr> 
                        <td width="10" bgcolor="#9966CC"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#9966CC')"></td>
                        <td width="10" bgcolor="#9966FF"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#9966FF')"></td>
                        <td width="10" bgcolor="#FF9999"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FF9999')"></td>
                        <td width="10" bgcolor="#FF9933"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FF9933')"></td>
                        <td width="10" bgcolor="#FF9900"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FF9900')"></td>
                        <td width="10" bgcolor="#CCFFFF"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#CCFFFF')"></td>
                        <td width="10" bgcolor="#00CCFF"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#00CCFF')"></td>
                        <td width="10" bgcolor="#3366FF"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#3366FF')"></td>
                        <td width="10" bgcolor="#666699"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#666699')"></td>
                        <td width="10" bgcolor="#333399"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#333399')"></td>
                        <td width="10" bgcolor="#003366"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#003366')"></td>
                        <td width="10" bgcolor="#993366"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#993366')"></td>
                        <td width="10" bgcolor="#993300"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#993300')"></td>
                        <td width="10" bgcolor="#FFCC99"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#FFCC99')"></td>
                        <td width="10" bgcolor="#CCFF00"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#CCFF00')"></td>
                        <td width="10" bgcolor="#99CC00"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#99CC00')"></td>
                        <td width="10" bgcolor="#808000"><img height="8" src="imagens/dot.gif" width="10" class="clsCursor" onClick="ColorPalette_OnClick('#808000')"></td>
                      </tr>
                    </table></td>
                  <td width="201" class="tdClass"><table width="60" border="1" cellspacing="0" cellpadding="0" height="22">
                      <tr> 
                        <td width="101" id="cpick" bgcolor="#000000">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
              </table>
              <iframe id="iView" style="width: 415px; height:205px"></iframe> 
              <table width="415" height="30px" border="0" cellspacing="0" cellpadding="0" bgcolor="#D6D3CE">
                <tr> 
                  <td width="100" colspan="1" class="tdClass"><select name="selFont" class="formselect" onChange="doFont(this.options[this.selectedIndex].value)">
                      <option value="">-- Fonte --</option>
                      <option value="Arial">Arial</option>
                      <option value="Courier">Courier</option>
                      <option value="Sans Serif">Sans Serif</option>
                      <option value="Tahoma">Tahoma</option>
                      <option value="Verdana">Verdana</option>
                      <option value="Wingdings">Wingdings</option>
                    </select> </td>
                  <td width="124" class="tdClass"><select name="selSize" class="formselect" onChange="doSize(this.options[this.selectedIndex].value)">
                      <option value="">-- Tamanho --</option>
                      <option value="1">Muito pequeno</option>
                      <option value="2">Pequeno</option>
                      <option value="3">M&eacute;dio</option>
                      <option value="4">Grande</option>
                      <option value="5">Muito Grande</option>
                      <option value="6">Super Grande</option>
                    </select></td>
                  <td width="110" align="right" class="tdClass"><a href="#" onClick="return abre('mala_vis.php','mala','width=670,height=500,scrollbars=1');"><img src="imagens/ed_14_visu.gif" alt="Visualizar" width="14" height="20" border="0" class="butClass" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" ></a></td>
                  <td width="81" colspan="1" align="center" class="tdClass"> <a href="#"><img src="imagens/ed_html.gif" alt="Mudar Vis&atilde;o" width="42" height="13" border="0" class="butClass" onClick="doToggleView()"></a>                  </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><span class="textobold">
              <input name="Submit2" type="submit" class="microtxt" value="Enviar">
              </span>
              <input name="acao" type="hidden" id="acao" value="ok"> <input name="msg" type="hidden" id="msg" value="empty"></td></tr>
        </table>
      </form></td>
  </tr>
</table>
</BODY>
</HTML>