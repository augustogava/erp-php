<?
include("conecta.php");
//include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="AF";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM af WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>

<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">AF</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <? if($acao=="entrar"){ ?>
  <tr>
    <td align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center"><a href="af.php?acao=inc" class="textobold">Incluir uma AF </a></div></td>
        </tr>
      </table>
        <table width="400" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
          <tr align="center" class="textoboldbranco">
            <td align="left"> &nbsp;N&ordm;</td>
            <td align="left">&nbsp;Situa&ccedil;&atilde;o</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?
			  $sql=mysql_query("SELECT * FROM af ORDER BY af ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
          <tr bgcolor="#FFFFFF">
            <td colspan="4" align="center" class="textobold">NENHUMA AF CADASTRADA </td>
          </tr>
          <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
          <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
            <td width="65">&nbsp;<? print $res["af"]; ?></td>
            <td width="271"><? print $res["situacao"]; ?></td>
            <td width="26" align="center"><a href="af.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
            <td width="33" align="center"><a href="#" onClick="return pergunta('Deseja excluir este AF?','af_sql.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
          </tr>
          <?
			  	}
			  }
			  ?>
      </table></td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form action="af_sql.php" method="post" name="form1" onSubmit="return verifica(form1);">
        <table width="550" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366">
            <td colspan="2" align="center" class="textoboldbranco">
              <? if($acao=="inc"){ print"Incluir AF"; }else{ print"Alterar AF";} ?>            </td>
          </tr>
          <tr>
            <td width="179" align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;N&ordm; AF </td>
            <td width="371" class="textobold"><input name="af" type="text" class="formularioselect" id="af" value="<? print $res["af"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold"> &nbsp;Data do &nbsp;Recebimento </td>
            <td align="left" class="textobold"><input name="recebimento" type="text" class="texto" id="nome12" value="<? print banco2data($res["recebimento"]); ?>" size="12" maxlength="12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold"> &nbsp;Pendente de Anexo</td>
            <td align="left" class="textobold"><input name="anexo" type="radio" value="S" <? if($res["anexo"]=="S"){ print "Checked"; } ?>> 
              Sim 
              <input name="anexo" type="radio" value="N" <? if($res["anexo"]=="N"){ print "Checked"; } ?>>
              n&atilde;o</td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold"> &nbsp;Data do Recebimento do Anexo</td>
            <td align="left" class="textobold"><input name="recebimento_anexo" type="text" class="texto" id="nome12" value="<? print banco2data($res["recebimento_anexo"]); ?>" size="12" maxlength="12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold"> &nbsp;Previs&atilde;o de entrega da AF </td>
            <td align="left" class="textobold"><input name="entrega" type="text" class="texto" id="nome12" value="<? print banco2data($res["entrega"]); ?>" size="12" maxlength="12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold"> &nbsp;Atualiza&ccedil;&atilde;o </td>
            <td align="left" class="textobold"><input name="atualizacao" type="text" class="texto" id="nome12" value="<? print banco2data($res["atualizacao"]); ?>" size="12" maxlength="12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold"> &nbsp;Situa&ccedil;&atilde;o da AF </td>
            <td align="left" class="textobold"><select name="situacao" id="situacao">
              <option value="Produto em Estoque" <? if($res["situacao"]=="Produto em Estoque"){ print "Selected"; } ?>>Disponivel no Estoque</option>
              <option value="Em Produção" <? if($res["situacao"]=="Em Produção"){ print "Selected"; } ?>>Em Produ&ccedil;&atilde;o</option>
              <option value="Aguardando Mat. Prima" <? if($res["situacao"]=="Aguardando Mat. Prima"){ print "Selected"; } ?>>Aguardando Mat. Prima</option>
              <option value="Aguardando Anexo" <? if($res["situacao"]=="Aguardando Anexo"){ print "Selected"; } ?>>Aguardando Anexo</option>
              <option value="Aguardando Aprovação Lay-out" <? if($res["situacao"]=="Aguardando Aprovação Lay-out"){ print "Selected"; } ?>>Aguardando Aprovação Lay-out</option>
              <option value="Agendado Entrega" <? if($res["situacao"]=="Agendado Entrega"){ print "Selected"; } ?>>Agendado Entrega</option>
              <option value="Entregue CD" <? if($res["situacao"]=="Entregue CD"){ print "Selected"; } ?>>Entregue CD</option>
            </select></td>
          </tr>
          <tr align="center">
            <td colspan="2" class="textobold">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="2" class="textobold">
              <input name="Submit222" type="button" class="microtxt" value="voltar" onClick="window.location='transp_incluir.php'">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print "alt"; }else{ print "inc"; } ?>">
            <input name="id" type="hidden" id="id3" value="<? print $id; ?>"></td>
          </tr>
        </table>
    </form></td>
    <? } ?>
  </tr>
</table>
</body>
</html>