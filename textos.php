<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if(!empty($texto)){
	$where="WHERE texto like '%$texto%'";
}
if(!empty($placa)){
	$where="WHERE codigo LIKE '%$placa%'";
}
if(!empty($texto) and !empty($placa)){
	$where="WHERE texto like '%$texto%' and codigo LIKE '%$placa%'";
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM textos WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o Material');
		cad.nome.focus();
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Texto</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
<? if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><form name="form2" method="post" action="">
      <table width="250" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#003366">
          <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Texto:</td>
          <td><input name="texto" type="text" class="formularioselect" id="texto" size="36"></td>
        </tr>
        <tr class="textobold">
          <td width="46">&nbsp;Placa:</td>
          <td width="254"><input name="placa" type="text" class="formulario" id="placa" size="10" maxlength="10">
&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="imageField2" type="image" src="imagens/c_buscar.gif" border="0">
      <input name="buscar" type="hidden" id="buscar" value="true"></td>
        </tr>
      </table>
    </form>
      <br>  
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center"><a href="textos.php?acao=inc" class="textobold">Incluir 
              um Texto </a> </div></td>
        </tr>
      </table>
      <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="77">&nbsp;Placa</td>
          <td width="183"> &nbsp;Texto </td>
          <td width="17">&nbsp;</td>
          <td width="18">&nbsp;</td>
        </tr>
        <?
			  $sql=mysql_query("SELECT * FROM textos $where ORDER BY texto ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="4" align="center" class="textobold">NENHUM TEXTO ENCONTRADO 
          </td>
        </tr>
        <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td>&nbsp;<? print $res["codigo"]; ?></td>
          <td>&nbsp;<? print $res["texto"]; ?></td>
          <td width="17" align="center"><a href="textos.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="18" align="center"><a href="#" onClick="return pergunta('Deseja excluir este texto?','textos_sql.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
        </tr>
        <?
			  	}
			  }
			  ?>
      </table></td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="textos_sql.php" onSubmit="return verifica(this);">
        <table width="300" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco"> 
              <? if($acao=="inc"){ print"Incluir"; }else{ print"Alterar";} ?> Texto
            </td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Placa</td>
            <td class="textobold"><select name="placa" class="formularioselect" id="placa">
              <option value="">Selecione</option>
              <?
				$sqlmaterial=mysql_query("SELECT * FROM prodserv WHERE tip_material='1' ORDER BY id ASC");
				while($resmaterial=mysql_fetch_array($sqlmaterial)){
				?>
              <option value="<? print $resmaterial["id"]; ?>"<? if($res["placa"]==$resmaterial["id"]) print "selected"; ?>><? print $resmaterial["apelido"]; ?></option>
              <?
				}
				?>
            </select></td>
          </tr>
          <tr> 
            <td width="39" class="textobold">&nbsp;Texto</td>
            <td width="258" class="textobold"><input name="texto" type="text" class="formularioselect" id="nome2" value="<? print $res["texto"]; ?>"  size="45" maxlength="20"></td>
          </tr>
          <tr align="center"> 
            <td colspan="2" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='material.php'">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>"> 
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