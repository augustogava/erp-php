<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if(!empty($ps)){
	$_SESSION["ps2"]=$ps;
}else{
	$ps=$_SESSION["ps2"];
}
if($acao=="alt"){
	$sql=mysql_query("SELECT prodserv_item.item,prodserv_item.qtd,prodserv_item.fixo,prodserv_item.item,prodserv.nome FROM prodserv_item,prodserv WHERE prodserv_item.id='$id' AND prodserv_item.item=prodserv.id");
	$res=mysql_fetch_array($sql);
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
function verifica(cad){
	if(cad.nome.value==''){
		alert('Selecione o produto');
		return abre('prodserv_bus.php','busca','width=320,height=300,scrollbars=1');
	}
	if(cad.item.value==''){
		alert('Selecione o produto');
		return abre('prodserv_bus.php','busca','width=320,height=300,scrollbars=1');
	}
	if(cad.qtd.value=='' || cad.qtd.value=='0,00'){
		alert('Informe a quantidade');
		cad.qtd.focus();
		return false;
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Composto</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
<? if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center"><a href="prodserv_item.php?acao=inc" class="textobold">Incluir 
              um Item </a></div></td>
        </tr>
      </table>
      <table width="450" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="0"> &nbsp;&nbsp;Item</td>
          <td width="78" align="right">Qtd.</td>
          <td width="78">&nbsp;Unidade</td>
          <td width="21" align="center">Fix</td>
          <td width="21" align="center">&nbsp;</td>
          <td width="25" align="center">&nbsp;</td>
        </tr>
        <?
			  $sql=mysql_query("SELECT prodserv_item.id,prodserv_item.qtd,prodserv_item.fixo,prodserv.nome,unidades.nome AS unidade FROM prodserv_item,prodserv,unidades WHERE prodserv_item.item=prodserv.id AND prodserv.unidade=unidades.id AND prodserv_item.prodserv=$ps ORDER BY prodserv.nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="6" align="center" class="textobold">NENHUM ITEM INFORMADO </td>
        </tr>
        <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td width="0">&nbsp;<? print $res["nome"]; ?></td>
          <td width="78" align="right"><? print banco2valor($res["qtd"]); ?>&nbsp;</td>
          <td width="78">&nbsp;<? print $res["unidade"]; ?></td>
          <td width="21" align="center"><? print $res["fixo"]; ?></td>
          <td width="21" align="center"><a href="prodserv_item.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="25" align="center"><a href="#" onClick="return pergunta('Deseja excluir este Item?','prodserv_item_sql.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
        </tr>
        <?
			  	}
			  }
			  ?>
      </table>
      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="imagens/dot.gif" width="50" height="8"></td>
        </tr>
        <tr>
          <td><div align="center"><span class="textobold"><a href="prodserv.php"><img src="imagens/c_voltar.gif" border="0"></a></span></div></td>
        </tr>
      </table></td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="prodserv_item_sql.php" onSubmit="return verifica(this);">
        <table width="350" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco"> 
              <? if($acao=="inc"){ print"Incluir Item"; }else{ print"Alterar Item";} ?>            </td>
          </tr>
          <tr> 
            <td width="41" class="textobold">&nbsp;Item</td>
            <td width="359" class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input name="nome" type="text" class="formularioselect" id="nome3" value="<? print $res["nome"]; ?>" size="7" maxlength="50" readonly></td>
                <td width="20" align="center"><a href="#" onClick="return abre('prodserv_bus.php?psb=<? print $ps; ?>','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon14_box.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Qtd</td>
            <td class="textobold"><input name="qtd" type="text" class="formulario" id="qtd" value="<? print banco2valor($res["qtd"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <? if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);"></td>
          </tr>
          
          <tr align="center"> 
            <td colspan="2" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='prodserv_item.php?ps=<? print $ps; ?>'">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>"> 
            <input name="id" type="hidden" id="id3" value="<? print $id; ?>">
            <input name="item" type="hidden" id="item" value="<? print $res["item"]; ?>">
            <input name="ps" type="hidden" id="ps" value="<? print $ps; ?>">
            <input name="psb" type="hidden" id="psb" value="<? print $ps; ?>"></td>
          </tr>
        </table>
      </form>
      
    </td>
	<? } ?>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>