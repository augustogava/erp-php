<?
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Clientes Financeiro";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)){
	$sql=mysql_query("SELECT * FROM cliente_financeiro WHERE cliente='$id'");
	if(mysql_num_rows($sql)==0){
		$acao="inc";
	}else{
		$acao="alt";
	}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM cliente_financeiro WHERE cliente='$id'");
	if(mysql_num_rows($sql)!=0){
		$res=mysql_fetch_array($sql);
	}
	$classe=$res["classe"];
	$frete=$res["frete"];
	$cond=$res["cond"];
	$desconto=banco2valor($res["desconto"]);
	$prioridade=$res["prioridade"];
	$risco=$res["risco"];
	$credito_lim=banco2valor($res["credito_lim"]);
	$credito_ven=banco2data($res["credito_ven"]);
	$compra_mai=banco2valor($res["compra_mai"]);
	$atraso_med=banco2valor($res["atraso_med"]);
	$saldo_mai=banco2valor($res["saldo_mai"]);
	$compra_num=$res["compra_num"];
	$compra_pri=banco2data($res["compra_pri"]);
	$compra_ult=banco2data($res["compra_ult"]);
	$visitas_freq=$res["visitas_freq"];
	$visitas_ult=banco2data($res["visitas_ult"]);
	$mens=$res["mensagem"];
	$pagamentos=$res["pagamentos"];
	$saldo_titulo=banco2valor($res["saldo_titulo"]);
	$saldo_lib=banco2valor($res["saldo_lib"]);
	$suframa=$res["suframa"];
	$atrasados=banco2valor($res["atrasados"]);
	$acumulado=banco2valor($res["acumulado"]);
	$saldo_ped=banco2valor($res["saldo_ped"]);
	$protestos_tit=$res["protestos_tit"];
	$protestos_ult=banco2data($res["protestos_ult"]);
	$cheques_dev=$res["cheques_dev"];
	$cheques_ult=banco2data($res["cheques_ult"]);
	$atraso_mai=$res["atraso_mai"];
	$dupl_mai=banco2valor($res["dupl_mai"]);
	$tabela=$res["tabela"];
	$natureza=$res["natureza"];
	$iss=$res["iss"];
	$icms=banco2valor($res["icms"]);
	$agregador=$res["agregador"];
	$saldo_moe=banco2valor($res["saldo_moe"]);
	$pagtos_atras=banco2valor($res["pagtos_atras"]);
	$grupo_cli=$res["grupo_cli"];
	$suframa_desc=$res["suframa_desc"];
}elseif($acao=="alterar"){
	$desconto=valor2banco($desconto);
	$credito_lim=valor2banco($credito_lim);
	$compra_mai=valor2banco($compra_mai);
	$atraso_med=valor2banco($atraso_med);
	$saldo_mai=valor2banco($saldo_mai);
	$saldo_titulo=valor2banco($saldo_titulo);
	$saldo_lib=valor2banco($saldo_lib);
	$atrasados=valor2banco($atrasados);
	$acumulado=valor2banco($acumulado);
	$saldo_ped=valor2banco($saldo_ped);
	$dupl_mai=valor2banco($dupl_mai);
	$saldo_moe=valor2banco($saldo_moe);
	$pagtos_atras=valor2banco($pagtos_atras);
	$icms=valor2banco($icms);
	$credito_ven=data2banco($credito_ven);
	$compra_pri=data2banco($compra_pri);
	$compra_ult=data2banco($compra_ult);
	$visitas_ult=data2banco($visitas_ult);
	$protestos_ult=data2banco($protestos_ult);
	$cheques_ult=data2banco($cheques_ult);
	$sql=mysql_query("UPDATE cliente_financeiro SET classe='$classe',frete='$frete',cond='$cond',desconto='$desconto',prioridade='$prioridade',risco='$risco',credito_lim='$credito_lim',credito_ven='$credito_ven',compra_mai='$compra_mai',atraso_med='$atraso_med',saldo_mai='$saldo_mai',compra_num='$compra_num',compra_pri='$compra_pri',compra_ult='$compra_ult',visitas_freq='$visitas_freq',visitas_ult='$visitas_ult',mensagem='$mens',pagamentos='$pagamentos',saldo_titulo='$saldo_titulo',saldo_lib='$saldo_lib',suframa='$suframa',atrasados='$atrasados',acumulado='$acumulado',saldo_ped='$saldo_ped',protestos_tit='$protestos_tit',protestos_ult='$protestos_ult',cheques_dev='$cheques_dev',cheques_ult='$cheques_ult',atraso_mai='$atraso_mai',dupl_mai='$dupl_mai',tabela='$tabela',natureza='$natureza',iss='$iss',icms='$icms',agregador='$agregador',saldo_moe='$saldo_moe',pagtos_atras='$pagtos_atras',grupo_cli='$grupo_cli',suframa_desc='$suframa_desc' WHERE cliente='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro financeiro alterado!";
		header("Location:clientes.php?bcod=$bcod&bnome=$bnome");
		exit;				
	}else{
		$_SESSION["mensagem"]="O cadastro financeiro n�o p�de ser alterado!";
		$desconto=banco2valor($desconto);
		$credito_lim=banco2valor($credito_lim);
		$compra_mai=banco2valor($compra_mai);
		$atraso_med=banco2valor($atraso_med);
		$saldo_mai=banco2valor($saldo_mai);
		$saldo_titulo=banco2valor($saldo_titulo);
		$saldo_lib=banco2valor($saldo_lib);
		$atrasados=banco2valor($atrasados);
		$acumulado=banco2valor($acumulado);
		$saldo_ped=banco2valor($saldo_ped);
		$dupl_mai=banco2valor($dupl_mai);
		$saldo_moe=banco2valor($saldo_moe);
		$pagtos_atras=banco2valor($pagtos_atras);
		$icms=banco2valor($icms);
		$credito_ven=banco2data($credito_ven);
		$compra_pri=banco2data($compra_pri);
		$compra_ult=banco2data($compra_ult);
		$visitas_ult=banco2data($visitas_ult);
		$protestos_ult=banco2data($protestos_ult);
		$cheques_ult=banco2data($cheques_ult);		
		$acao="alt";
	}	
}elseif($acao=="incluir"){
	$desconto=valor2banco($desconto);
	$credito_lim=valor2banco($credito_lim);
	$compra_mai=valor2banco($compra_mai);
	$atraso_med=valor2banco($atraso_med);
	$saldo_mai=valor2banco($saldo_mai);
	$saldo_titulo=valor2banco($saldo_titulo);
	$saldo_lib=valor2banco($saldo_lib);
	$atrasados=valor2banco($atrasados);
	$acumulado=valor2banco($acumulado);
	$saldo_ped=valor2banco($saldo_ped);
	$icms=valor2banco($icms);
	$dupl_mai=valor2banco($dupl_mai);
	$saldo_moe=valor2banco($saldo_moe);
	$pagtos_atras=valor2banco($pagtos_atras);
	$credito_ven=data2banco($credito_ven);
	$compra_pri=data2banco($compra_pri);
	$compra_ult=data2banco($compra_ult);
	$visitas_ult=data2banco($visitas_ult);
	$protestos_ult=data2banco($protestos_ult);
	$cheques_ult=data2banco($cheques_ult);	
	$sql=mysql_query("INSERT INTO cliente_financeiro (cliente,classe,frete,cond,desconto,prioridade,risco,credito_lim,credito_ven,compra_mai,atraso_med,saldo_mai,compra_num,compra_pri,compra_ult,visitas_freq,visitas_ult,mensagem,pagamentos,saldo_titulo,saldo_lib,suframa,atrasados,acumulado,saldo_ped,protestos_tit,protestos_ult,cheques_dev,cheques_ult,atraso_mai,dupl_mai,tabela,natureza,iss,icms,agregador,saldo_moe,pagtos_atras,grupo_cli,suframa_desc) VALUES ('$id','$classe','$frete','$cond','$desconto','$prioridade','$risco','$credito_lim','$credito_ven','$compra_mai','$atraso_med','$saldo_mai','$compra_num','$compra_pri','$compra_ult','$visitas_freq','$visitas_ult','$mens','$pagamentos','$saldo_titulo','$saldo_lib','$suframa','$atrasados','$acumulado','$saldo_ped','$protestos_tit','$protestos_ult','$cheques_dev','$cheques_ult','$atraso_mai','$dupl_mai','$tabela','$natureza','$iss','$icms','$agregador','$saldo_moe','$pagtos_atras','$grupo_cli','$suframa_desc')");
	if($sql){
		$_SESSION["mensagem"]="Cadastro financeiro conclu�do!";
		header("Location:clientes.php");
		exit;				
	}else{
		$_SESSION["mensagem"]="O cadastro financeiro n�o p�de ser conclu�do!";
		$desconto=banco2valor($desconto);
		$credito_lim=banco2valor($credito_lim);
		$compra_mai=banco2valor($compra_mai);
		$atraso_med=banco2valor($atraso_med);
		$saldo_mai=banco2valor($saldo_mai);
		$saldo_titulo=banco2valor($saldo_titulo);
		$saldo_lib=banco2valor($saldo_lib);
		$atrasados=banco2valor($atrasados);
		$acumulado=banco2valor($acumulado);
		$icms=banco2valor($icms);
		$saldo_ped=banco2valor($saldo_ped);
		$dupl_mai=banco2valor($dupl_mai);
		$saldo_moe=banco2valor($saldo_moe);
		$pagtos_atras=banco2valor($pagtos_atras);
		$credito_ven=banco2data($credito_ven);
		$compra_pri=banco2data($compra_pri);
		$compra_ult=banco2data($compra_ult);
		$visitas_ult=banco2data($visitas_ult);
		$protestos_ult=banco2data($protestos_ult);
		$cheques_ult=banco2data($cheques_ult);				
		$acao="inc";
	}	
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.cond.value==''){
		alert('Informe a condi��o de pagamento');
		cad.cond.focus();
		return false;
	}
	if(cad.icms.value==''){
		alert('Informe o percentual de ICMS');
		cad.icms.focus();
		return false;
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="460" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="17" colspan="2" align="center"><table width="378" border="0" align="left" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td width="25" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                <td width="369" align="right"><div align="left">
                  <p class="textobold style1">Cadastro de Clientes - Financeiro</p>
                </div></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
            </table>              </td>
          </tr>
          <tr class="textobold"> 
            <td width="94">&nbsp;Classe Cred.:</td>
            <td width="353">
<input name="classe" type="text" class="formulario" id="classe" value="<? print $classe; ?>" size="30" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Tipo Frete:</td>
            <td>
<input name="frete" type="text" class="formulario" id="frete" value="<? print $frete; ?>" size="10" maxlength="1"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Cond. Pagto:</td>
            <td>
<input name="cond" type="text" class="formulario" id="cond" value="<? print $cond; ?>" size="30" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Desconto:</td>
            <td>
<input name="desconto" type="text" class="formulario" id="desconto" value="<? print $desconto; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Prioridade:</td>
            <td>
<input name="prioridade" type="text" class="formulario" id="prioridade" value="<? print $prioridade; ?>" size="10" maxlength="1"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Risco:</td>
            <td>
<input name="risco" type="text" class="formulario" id="risco" value="<? print $risco; ?>" size="10" maxlength="1"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Lim. Credito:</td>
            <td>
<input name="credito_lim" type="text" class="formulario" id="credito_lim" value="<? print $credito_lim; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Venc. Lim. Cred.:</td>
            <td>
<input name="credito_ven" type="text" class="formulario" id="credito_ven" value="<? print $credito_ven; ?>" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Maior Compra:</td>
            <td>
<input name="compra_mai" type="text" class="formulario" id="compra_mai" value="<? print $compra_mai; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;M&eacute;dia Atraso:</td>
            <td>
<input name="atraso_med" type="text" class="formulario" id="atraso_med" value="<? print $atraso_med; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Maior Saldo:</td>
            <td>
<input name="saldo_mai" type="text" class="formulario" id="saldo_mai" value="<? print $saldo_mai; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;N&ordm; de Compras:</td>
            <td>
<input name="compra_num" type="text" class="formulario" id="compra_num" value="<? print $compra_num; ?>" size="10" onKeyPress="return validanum(this, event)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;1&ordf; Compra:</td>
            <td>
<input name="compra_pri" type="text" class="formulario" id="compra_pri" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $compra_pri; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;&Uacute;ltima Compra:</td>
            <td>
<input name="compra_ult" type="text" class="formulario" id="compra_ult" value="<? print $compra_ult; ?>" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Freq. Visitas:</td>
            <td>
<input name="visitas_freq" type="text" class="formulario" id="visitas_freq" value="<? print $visitas_freq; ?>" size="10" onKeyPress="return validanum(this, event)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;&Ugrave;ltima Visita:</td>
            <td>
<input name="visitas_ult" type="text" class="formulario" id="visitas_ult" value="<? print $visitas_ult; ?>" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Mensagem:</td>
            <td>
<input name="mens" type="text" class="formulario" id="mens" value="<? print $mens; ?>" size="50" maxlength="100"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;N&ordm; Pagamentos:</td>
            <td>
<input name="pagamentos" type="text" class="formulario" id="pagamentos" value="<? print $pagamentos; ?>" size="10" onKeyPress="return validanum(this, event)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Saldo T&iacute;tulo:</td>
            <td>
<input name="saldo_titulo" type="text" class="formulario" id="saldo_titulo" value="<? print $saldo_titulo; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Sld. Ped. Lib.:</td>
            <td>
<input name="saldo_lib" type="text" class="formulario" id="saldo_lib" value="<? print $saldo_lib; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Suframa:</td>
            <td>
<input name="suframa" type="text" class="formulario" id="suframa" value="<? print $suframa; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Atrasados:</td>
            <td>
<input name="atrasados" type="text" class="formulario" id="atrasados" value="<? print $atrasados; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Vl. Acumulado:</td>
            <td>
<input name="acumulado" type="text" class="formulario" id="acumulado" value="<? print $acumulado; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Saldo Pedido:</td>
            <td>
<input name="saldo_ped" type="text" class="formulario" id="saldo_ped" value="<? print $saldo_ped; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Tit. Protestados:</td>
            <td>
<input name="protestos_tit" type="text" class="formulario" id="protestos_tit" value="<? print $protestos_tit; ?>" size="10" onKeyPress="return validanum(this, event)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;&Uacute;ltimo Protesto:</td>
            <td>
<input name="protestos_ult" type="text" class="formulario" id="protestos_ult" value="<? print $protestos_ult; ?>" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Cheques Dev.:</td>
            <td>
<input name="cheques_dev" type="text" class="formulario" id="cheques_dev" value="<? print $cheques_dev; ?>" size="10" onKeyPress="return validanum(this, event)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;&Uacute;lt. Cheque Dev.::</td>
            <td>
<input name="cheques_ult" type="text" class="formulario" id="cheques_ult" value="<? print $cheques_ult; ?>" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Maior Atraso:</td>
            <td>
<input name="atraso_mai" type="text" class="formulario" id="atraso_mai" value="<? print $atraso_mai; ?>" size="10" onKeyPress="return validanum(this, event)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Maior Dupl.:</td>
            <td>
<input name="dupl_mai" type="text" class="formulario" id="dupl_mai" value="<? print $dupl_mai; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Tabela Pre&ccedil;o:</td>
            <td>
<input name="tabela" type="text" class="formulario" id="tabela" value="<? print $tabela; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Natureza:</td>
            <td>
<input name="natureza" type="text" class="formulario" id="natureza" value="<? print $natureza; ?>" size="10" onKeyPress="return validanum(this, event)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;ISS:</td>
            <td>
<input name="iss" type="text" class="formulario" id="iss" value="<? print $iss; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;ICMS:</td>
            <td>
<input name="icms" type="text" class="formulario" id="icms" value="<? print $icms; ?>" size="20" maxlength="20" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Agre. Liber.:</td>
            <td>
<input name="agregador" type="text" class="formulario" id="agregador" value="<? print $agregador; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Sld. Moe. Forte:</td>
            <td>
<input name="saldo_moe" type="text" class="formulario" id="saldo_moe" value="<? print $saldo_moe; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Pag. Atrasados:</td>
            <td>
<input name="pagtos_atras" type="text" class="formulario" id="pagtos_atras" value="<? print $pagtos_atras; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Grupo Clientes:</td>
            <td>
<input name="grupo_cli" type="text" class="formulario" id="grupo_cli" value="<? print $grupo_cli; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Desc. p/ Suframa:</td>
            <td class="textobold"> Sim 
              <input type="radio" name="suframa_desc" value="S" <? if($suframa_desc=="S") print "checked"; ?>>
              N&atilde;o
              <input type="radio" name="suframa_desc" value="N" <? if($suframa_desc=="N" or empty($suframa_desc)) print "checked"; ?>> 
              <input name="id" type="hidden" id="id" value="<? print $id; ?>"> 
              <input name="acao" type="hidden" id="acao2" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>"></td>
          </tr>
          <tr class="textobold"> 
            <td colspan="2" align="center"> 
              <? if($acao=="alt"){ ?>
              <input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.location='clientes.php<? if(!empty($bcod) or !empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>';">
              &nbsp;&nbsp;&nbsp;&nbsp;
              <? } ?>
              <input name="Submit" type="submit" class="microtxt" value="Continuar"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
&nbsp; 
</body>
</html>
<? include("mensagem.php"); ?>