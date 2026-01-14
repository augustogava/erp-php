<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="inc";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM prodserv_ordem WHERE id='$id'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
	}
}elseif($acao=="alterar"){
	$previsao=data2banco($previsao);
	$sql=mysql_query("UPDATE prodserv_ordem SET previsao='$previsao',obs='$obs',status='$status' WHERE id='$id'") or die("nao foi");
	header("location:prodserv_ordem.php");
	exit;
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
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Ordem de Produ&ccedil;&atilde;o </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="imagens/dot.gif" width="100" height="5"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco"><?php if($acao=="inc"){ print "Abrir"; }else{ print "Alterar"; }?> Ordem de Produ&ccedil;&atilde;o </td>
          </tr>
        <tr>
          <td class="textobold">Status</td>
          <td><select name="status" id="status">
            <option value="">Selecione</option>
            <option value="1" <?php if($res["status"]=="1") print "selected"; ?>>Na fila</option>
            <option value="2" <?php if($res["status"]=="2") print "selected"; ?>>Em produção</option>
            <option value="3" <?php if($res["status"]=="3") print "selected"; ?>>Produzido</option>
          </select></td>
        </tr>
        <tr>
<?php
if($acao=="inc"){
	$wabre="return abre('prodserv_bus2.php','busca','width=320,height=300,scrollbars=1');";
	$wcan="prodserv_ordem.php";
}elseif($acao=="alt"){
	$wabre="return mensagem('Você não pode alterar o produto desta Ordem de Produção');";
	$wcan="prodserv_sql.php?acao=ordemcan&id=$res[id]\" onclick=\"return confirm('Deseja realmente cancelar esta Ordem de Produção?');";
}
?>
          <td width="71" class="textobold">&nbsp;Previs&atilde;o</td>
          <td width="308"><input name="previsao" type="text" class="formulario" id="emissao4" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($res["previsao"]); ?>" size="15" maxlength="15"></td>
          </tr>
        <tr>
          <td class="textobold">Obs</td>
          <td><textarea name="obs" class="formularioselect" id="obs"><?php echo  $res["obs"]; ?>
          </textarea>            
            <input name="acao" type="hidden" id="acao" value="alterar">
            <input name="id" type="hidden" id="id" value="<?php print $id; ?>"></td>
          </tr>
        <tr>
          <td colspan="2" align="center" class="textobold"><img src="imagens/dot.gif" width="100" height="5"></td>
          </tr>
        <tr>
          <td colspan="2" align="center" class="textobold">
            <input name="Submit22" type="button" class="microtxt" value="Cancelar" onClick="window.location='<?php print $wcan; ?>'">
       <img src="imagens/dot.gif" width="20" height="5">
            <input name="Submit2" type="submit" class="microtxt" value="Continuar"></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>