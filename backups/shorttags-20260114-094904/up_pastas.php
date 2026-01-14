<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM up_pastas WHERE id='$id'");
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
<script>
function verifica(cad){
	if(cad.pasta.value==''){
		alert('Informe o nome da Pasta');
		cad.pasta.focus();
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Pastas</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
<? if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center"><a href="up_pastas.php?acao=inc" class="textobold">Incluir 
              Pasta</a> </div></td>
        </tr>
      </table>
      <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="210">&nbsp;Pastas</td>
          <td width="51" align="center">Publica</td>
          <td width="17">&nbsp;</td>
          <td width="16">&nbsp;</td>
        </tr>
        <?
			  $sql=mysql_query("SELECT * FROM up_pastas WHERE dono='$_SESSION[login_codigo]' ORDER BY nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="4" align="center" class="textobold">NENHUMA PASTA ENCONTRADA
          </td>
        </tr>
        <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td>&nbsp;<? print $res["nome"]; ?></td>
          <td width="51" align="center">&nbsp;<? print $res["publica"]; ?></td>
          <td width="17" align="center"><a href="up_pastas.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="16" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta Pasta?','up_pastas_sql.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
        </tr>
        <?
			  	}
			  }
			  ?>
      </table></td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="up_pastas_sql.php" onSubmit="return verifica(this);">
        <table width="300" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco"> 
              <? if($acao=="inc"){ print"Incluir"; }else{ print"Alterar";} ?> Pasta
            </td>
          </tr>
          <tr> 
            <td width="64" class="textobold">&nbsp;Pasta</td>
            <td width="236" class="textobold"><input name="nome" type="text" class="formularioselect" id="nome2" value="<? print $res["nome"]; ?>" size="20" maxlength="30"></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Publica</td>
            <td class="textobold">
			<input name="publica" type="radio" value="S" <? if($res["publica"]=="S" ) print "checked"; ?>>
		Sim &nbsp;&nbsp;
			<input name="publica" type="radio" value="N" <? if($res["publica"]=="N" or empty($res["publica"])) print "checked"; ?>>
N&atilde;o</td>
          </tr>
          <tr align="center">
            <td colspan="2" class="textobold">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td colspan="2" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='up_pastas.php'">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              <input name="acao" type="hidden" id="acao" value="<? print $acao; ?>"> 
            <input name="id" type="hidden" id="id3" value="<? print $id; ?>"></td>
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