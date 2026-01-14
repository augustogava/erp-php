<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="entrar"){
	if(empty($emissao)){
		$emissao=date("d/m/Y");
		$emissao2=date("d/m/Y");
	}
	if(!isset($wsit)){
		$busca=" WHERE vendas.cliente=clientes.id AND vendas.faturamento='1'";
	}elseif($wsit=="1"){
		$busca=" WHERE vendas.cliente=clientes.id AND vendas.faturado=0 AND vendas.faturamento='1' ";
	}elseif($wsit=="2"){
		$busca=" WHERE vendas.cliente=clientes.id AND vendas.faturado=1 AND vendas.faturamento='1' ";
	}elseif($wsit=="3"){
		$busca=" WHERE vendas.cliente=clientes.id AND vendas.faturado=0 AND vendas.faturamento='0' ";
	}
	if(!empty($emissao)){
		$emissao=data2banco($emissao);
		$busca.="AND vendas.emissao>='$emissao' ";
		$emissao=banco2data($emissao);
		if(!empty($emissao2)){
			$emissao2=data2banco($emissao2);
			$busca.="AND vendas.emissao<='$emissao2' ";
			$emissao2=banco2data($emissao2);
		}
	}
	$sql=mysql_query("SELECT vendas.*,clientes.fantasia FROM vendas,clientes $busca ORDER BY vendas.emissao ASC, vendas.id ASC");
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verificabusca(cad){
	if(cad.emissao.value!=''){
		if(!verifica_data(cad.emissao.value)){
			alert('Data de emissão incorreta');
			cad.emissao.focus();
			return false;
		}
		if(!verifica_data(cad.emissao2.value)){
			cad.emissao2.value='';
		}
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Faturamento</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><form name="formbus" method="post" action="" onSubmit="return verificabusca(this);">
      <table width="347" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="3" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
        </tr>
        <tr>
          <td width="70" class="textobold">Situa&ccedil;&atilde;o</td>
          <td width="277" colspan="2" class="textobold"><input name="wsit" type="radio" value="1" <? if($wsit=="1") print "checked"; ?>>
        pendentes
          <input name="wsit" type="radio" value="2" <? if($wsit=="2") print "checked"; ?>>
        faturadas
        <input name="wsit" type="radio" value="3" <? if($wsit=="3") print "checked"; ?>>
        bloqueadas</td>
        </tr>
        <tr>
          <td class="textobold">Emiss&atilde;o</td>
          <td colspan="2" class="textobold"><input name="emissao" type="text" class="formulario" id="emissao" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $emissao; ?>" size="10" maxlength="10" <? if($block) print "readonly"; ?>>
&nbsp;&agrave;
        <input name="emissao2" type="text" class="formulario" id="emissao3" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $emissao2; ?>" size="10" maxlength="10" <? if($block) print "readonly"; ?>><img src="imagens/dot.gif" width="10" height="5">
        <input name="Submit22" type="submit" class="microtxt" value="Buscar"></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <form action="vendas_fat_sql.php" method="post">
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="47" align="center">pedido</td>
        <td width="68" align="right">valor&nbsp;</td>
        <td width="285">&nbsp;cliente</td>
        <td width="67" align="center">entrega</td>
        <td width="70" align="center">bloqueado</td>
        <td width="50" align="center">faturar</td>
      </tr>
<?
if(!mysql_num_rows($sql)){
?>	  
      <tr bgcolor="#FFFFFF">
        <td colspan="6" align="center" class="textobold">nenhum pedido de venda encontrado </td>
        </tr>
<?
}else{
	while($res=mysql_fetch_array($sql)){
		$sqlv=mysql_query("SELECT SUM((qtd*unitario)-(qtd*unitario*desconto)/100) AS valor FROM vendas_list WHERE venda='$res[id]'");
		if(mysql_num_rows($sqlv)){
			$resv=mysql_fetch_array($sqlv);
		}
?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td align="center"><?= $res["id"]; ?></td>
        <td align="right"><?= banco2valor($resv["valor"]); ?>&nbsp;</td>
        <td width="285">&nbsp;<?= $res["fantasia"]; ?></td>
        <td align="center"><?= banco2data($res["entrega"]); ?></td>
        <td align="center"><? if($res["faturamento"]=="0"){ print "sim"; }else{ print "não"; } ?></td>
        <td width="50" align="center"><input name="faturamento[<?= $res["id"]; ?>]" type="hidden" id="faturamento[<?= $res["id"]; ?>]" value="<?= $res["faturamento"]; ?>">
        <input type="checkbox" name="faturar[<?= $res["id"]; ?>]" value="<?= $res["id"]; ?>" <? if($res["faturado"]) print "checked"; ?>></td>
      </tr>
<?
	}
}
?>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td align="center" valign="top"><span class="textobold">
      <input name="Submit2" type="submit" class="microtxt" value="Continuar">
      <input name="acao" type="hidden" id="acao" value="alt">
    </span></td>
  </tr>
  </form>
</table>
</body>
</html>
<? include("mensagem.php"); ?>