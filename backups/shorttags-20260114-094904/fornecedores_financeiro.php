<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Fornecedores";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)){
	$sql=mysql_query("SELECT * FROM fornecedor_financeiro WHERE fornecedor='$id'");
	if(mysql_num_rows($sql)==0){
		$acao="inc";
	}else{
		$acao="alt";
	}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM fornecedor_financeiro WHERE fornecedor='$id'");
	if(mysql_num_rows($sql)!=0){
		$res=mysql_fetch_array($sql);
	}
	$risco=$res["risco"];
	$cond=$res["cond"];
	$compra_mai=number_format($res["compra_mai"],2,",",".");	
	$atraso_med=number_format($res["atraso_med"],2,",",".");
	$atraso_mai=number_format($res["atraso_mai"],2,",",".");		
	$compra_num=$res["compra_num"];
	$compra_pri=banco2data($res["compra_pri"]);
	$compra_ult=banco2data($res["compra_ult"]);
	$dupl_saldo=number_format($res["dupl_saldo"],2,",",".");
	$natureza=$res["natureza"];
	$saldo_moe=number_format($res["saldo_moe"],2,",",".");
	$agencia=$res["agencia"];
	$conta=$res["conta"];
	$tipo=$res["tipo"];
	$iss=$res["iss"];
}elseif($acao=="alterar"){
	$compra_mai=valor2banco($compra_mai);
	$atraso_med=valor2banco($atraso_med);
	$atraso_mai=valor2banco($atraso_mai);
	$dupl_saldo=valor2banco($dupl_saldo);
	$saldo_moe=valor2banco($saldo_moe);			
	$compra_pri=data2banco($compra_pri);
	$compra_ult=data2banco($compra_ult);
	$sql=mysql_query("UPDATE fornecedor_financeiro SET risco='$risco',cond='$cond',compra_mai='$compra_mai',atraso_med='$atraso_med',atraso_mai='$atraso_mai',compra_num='$compra_num',compra_pri='$compra_pri',compra_ult='$compra_ult',dupl_saldo='$dupl_saldo',natureza='$natureza',saldo_moe='$saldo_moe',agencia='$agencia',conta='$conta',tipo='$tipo',iss='$iss' WHERE fornecedor='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro financeiro alterado!";
		header("Location:fornecedores.php?bcod=$bcod&bnome=$bnome");
		exit;				
	}else{
		$_SESSION["mensagem"]="O cadastro financeiro não pôde ser alterado!";
		$compra_mai=baco2valor($compra_mai);
		$atraso_med=baco2valor($atraso_med);
		$atraso_mai=baco2valor($atraso_mai);
		$dupl_saldo=baco2valor($dupl_saldo);
		$saldo_moe=baco2valor($saldo_moe);			
		$compra_pri=banco2data($compra_pri);
		$compra_ult=banco2data($compra_ult);		
		$acao="alt";
	}	
}elseif($acao=="incluir"){
	$compra_mai=valor2banco($compra_mai);
	$atraso_med=valor2banco($atraso_med);
	$atraso_mai=valor2banco($atraso_mai);
	$dupl_saldo=valor2banco($dupl_saldo);
	$saldo_moe=valor2banco($saldo_moe);			
	$compra_pri=data2banco($compra_pri);
	$compra_ult=data2banco($compra_ult);	
	$sql=mysql_query("INSERT INTO fornecedor_financeiro (fornecedor,risco,cond,compra_mai,atraso_med,atraso_mai,compra_num,compra_pri,compra_ult,dupl_saldo,natureza,saldo_moe,agencia,conta,tipo,iss) VALUES ('$id','$risco','$cond','$compra_mai','$atraso_med','$atraso_mai','$compra_num','$compra_pri','$compra_ult','$dupl_saldo','$natureza','$saldo_moe','$agencia','$conta','$tipo','$iss')");
	if($sql){
		$_SESSION["mensagem"]="Cadastro financeiro concluído!";
		//header("Location:clientes_login.php?id=$id&acao=inc&bcod=$bcod&bnome=$bnome");
		//exit;				
	}else{
		$_SESSION["mensagem"]="O cadastro financeiro não pôde ser concluído!";
		$compra_mai=baco2valor($compra_mai);
		$atraso_med=baco2valor($atraso_med);
		$atraso_mai=baco2valor($atraso_mai);
		$dupl_saldo=baco2valor($dupl_saldo);
		$saldo_moe=baco2valor($saldo_moe);			
		$compra_pri=banco2data($compra_pri);
		$compra_ult=banco2data($compra_ult);		
		$acao="inc";
	}	
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
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
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Fornecedores Financeiro </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td><form name="form1" method="post" action="">
        <table width="460" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td height="17" colspan="2" align="center" class="textoboldbranco">Cadastro 
              de Fornecedores - Financeiro</td>
          </tr>
          <tr class="textobold"> 
            <td width="94">&nbsp;Risco:</td>
            <td width="353">
<input name="risco" type="text" class="formulario" id="risco" value="<? print $risco; ?>" size="3" maxlength="1"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Cond. Pagto:</td>
            <td>
<input name="cond" type="text" class="formulario" id="cond" value="<? print $cond; ?>" size="30" maxlength="20"></td>
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
            <td>&nbsp;Maior Atraso:</td>
            <td>
<input name="atraso_mai" type="text" class="formulario" id="atraso_mai" value="<? print $atraso_mai; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
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
            <td>&nbsp;Sld. de Dupl.:</td>
            <td>
<input name="dupl_saldo" type="text" class="formulario" id="dupl_saldo" value="<? print $dupl_saldo; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Natureza:</td>
            <td>
<input name="natureza" type="text" class="formulario" id="natureza" value="<? print $natureza; ?>" size="10" onKeyPress="return validanum(this, event)"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Sld. Moe. Forte:</td>
            <td>
<input name="saldo_moe" type="text" class="formulario" id="saldo_moe" value="<? print $saldo_moe; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Agencia:</td>
            <td>
<input name="agencia" type="text" class="formulario" id="agencia" value="<? print $agencia; ?>" size="20" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Conta:</td>
            <td>
<input name="conta" type="text" class="formulario" id="conta" value="<? print $conta; ?>" size="20" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;Tipo:</td>
            <td>
<input name="tipo" type="text" class="formulario" id="tipo" value="<? print $tipo; ?>" size="20" maxlength="20"> 
              <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066"> 
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">
              <input name="id" type="hidden" id="id" value="<? print $id; ?>">
              </font></td>
          </tr>
          <tr class="textobold"> 
            <td>&nbsp;ISS:</td>
            <td>&nbsp; 
              <input name="iss" type="radio" value="S" <? if($iss=="S" or empty($status)) print "checked"; ?>>
              Sim 
              <input name="iss" type="radio" value="N" <? if($iss=="N") print "checked"; ?>>
              N&atilde;o</td>
          </tr>
          <tr class="textobold"> 
            <td colspan="2" align="center"> 
              <? if($acao=="alt"){ ?>
            
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='fornecedores.php<? if(!empty($bcod) or !empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>'">
         
              <img src="imagens/dot.gif" width="50" height="5"> 
              <? } ?>
              <input name="Submit2" type="submit" class="microtxt" value="Continuar"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
  
</body>
</html>
<? include("mensagem.php"); ?>