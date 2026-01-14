<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$id=Input::request("id");
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT id FROM tamanho WHERE id='$id'");
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
	if(cad.nome.value==''){
		alert('Informe o Tamanho');
		cad.nome.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">

<?php if($acao=="entrar"){ ?>
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Tamanho</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center"><a href="tamanho.php?acao=inc" class="textobold">Incluir 
              um Tamanho</a> </div></td>
        </tr>
      </table>
      <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="406">&nbsp;Tamanho</td>
          <td width="20">&nbsp;</td>
          <td width="20">&nbsp;</td>
        </tr>
        <?php
			  $sql=mysql_query("SELECT * FROM tamanho ORDER BY nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="3" align="center" class="textobold">NENHUM TAMANHO CADASTRADO          </td>
        </tr>
        <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td>&nbsp;<?php print $res["nome"]; ?></td>
          <td width="20" align="center"><a href="tamanho.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir este Tamanho?','tamanho_sql.php?acao=exc&id=<?php print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
        </tr>
        <?php
			  	}
			  }
			  ?>
      </table></td>
  </tr>
  <?php }else{ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="tamanho_sql.php" onSubmit="return verifica(this);">
        <table width="300" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco"> 
              <?php if($acao=="inc"){ print"Incluir"; }else{ print"Alterar";} ?> Tamanho            </td>
          </tr>
          <tr> 
            <td width="39" class="textobold">&nbsp;Tamanho</td>
            <td width="258" class="textobold"><input name="nome" type="text" class="formularioselect" id="nome2" value="<?php print $res["nome"]; ?>" size="45" maxlength="30"></td>
          </tr>
          <tr align="center"> 
            <td colspan="2" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='tamanho.php'">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              <input name="acao" type="hidden" id="acao" value="<?php if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>"> 
            <input name="id" type="hidden" id="id3" value="<?php print $id; ?>"></td>
          </tr>
        </table>
      </form>    </td>
	<?php } ?>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>