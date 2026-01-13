<?
include("conecta.php");
include("seguranca.php");
if(empty($wsit)) $wsit="N";
if($wsit=="A"){
	$busca=" WHERE cp_itens.conta=cp.id AND cp.sit<>'C' ";
}else{
	$busca=" WHERE cp_itens.conta=cp.id AND cp_itens.pago='$wsit' AND cp.sit<>'C' ";
}
if(!empty($emissao)){
	$emissao=data2banco($emissao);
	$busca.="AND cp.emissao>='$emissao' ";
	$emissao=banco2data($emissao);
	if(!empty($emissao2)){
		$emissao2=data2banco($emissao2);
		$busca.="AND cp.emissao<='$emissao2' ";
		$emissao2=banco2data($emissao2);
	}
}
if(!empty($vencimento)){
	$vencimento=data2banco($vencimento);
	$busca.="AND cp_itens.vencimento>='$vencimento' ";
	$vencimento=banco2data($vencimento);
	if(!empty($vencimento2)){
		$vencimento2=data2banco($vencimento2);
		$busca.="AND cp_itens.vencimento<='$vencimento2' ";
		$vencimento2=banco2data($vencimento2);
	}
}
if(!empty($cliente)){
	$busca.="AND cp.cliente='$cliente' AND cp.cliente_tipo='$cliente_tipo' ";
}
if($wsit=="S"){
	if($banco){
		$busca.="AND cp_itens.banco='$banco' ";
	}
}
$sql=mysql_query("SELECT *,cp_itens.id AS item,cp.id AS conta,cp_itens.valor AS valor FROM cp_itens,cp $busca ORDER BY cp_itens.vencimento ASC");
$hj=mktime(0,0,0,date("n"),date("d"),date("Y"));
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="titulos"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Pagamentos</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="80" align="center">Emiss&atilde;o</td>
          <td width="80" align="center">Vencto</td>
          <td width="70" align="right">Valor&nbsp;</td>
          <td>&nbsp;Nome</td>
        </tr>
        <?
		if(mysql_num_rows($sql)==0){
		?>
        <tr bgcolor="#FFFFFF" class="texto"> 
          <td colspan="4" align="center">NENHUM PAGAMENTO EM ABERTO</td>
        </tr>
        <?
		}else{
			while($res=mysql_fetch_array($sql)){
				if($res["pago"]=="S"){
					$wconf="return mensagem('Este pagamento já foi efetuado');";
				}else{
					$wconf="return abre('cp_conf.php?id=$res[item]','','width=305,height=190,scrollbars=0');";
				}
				$total+=$res["valor"];
				$d=substr($res["vencimento"],8,2);
				$m=substr($res["vencimento"],5,2);
				$a=substr($res["vencimento"],0,4);
				if(mktime(0,0,0,$m,$d,$a)<$hj){
					$vencidos+=$res["valor"];
					$vencido=true;
				}else{
					$vencido=false;
				}
				if($res["cliente_tipo"]=="C"){
					$sqln=mysql_query("SELECT nome FROM clientes WHERE id='$res[cliente]'");
				}else{
					$sqln=mysql_query("SELECT nome FROM fornecedores WHERE id='$res[cliente]'");
				}
				$resn=mysql_fetch_array($sqln);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td width="80" align="center"><? print banco2data($res["emissao"]); ?></td>
          <td width="80" align="center"><font color="<? if(mktime(0,0,0,$m,$d,$a)<$hj) print "#ff0000"; ?>"><? print banco2data($res["vencimento"]); ?></font></td>
          <td width="70" align="right"><? print banco2valor($res["valor"]); ?>&nbsp;</td>
          <td>&nbsp;<? print $resn["nome"]; ?></td>
        </tr>
        <?
			}
		}
		?>
      </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="imagens/dot.gif" width="50" height="5"></td>
        </tr>
        <tr> 
          <td class="textobold">Documentos vencidos&nbsp; <input name="textfield2" type="text" class="formulario" value="<? print banco2valor($vencidos); ?>" size="15" readonly> 
            &nbsp;&nbsp;Total a pagar&nbsp; <input name="textfield" type="text" class="formulario" value="<? print banco2valor($total); ?>" size="15" readonly></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>