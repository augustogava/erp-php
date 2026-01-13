<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="exc"){
	$sql=mysql_query("DELETE FROM menus WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Item excluído com sucesso!";
	}else{
		$_SESSION["mensagem"]="O item não pôde ser excluído!";
	}
	$acao="entrar";
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE menus SET texto='$texto',url='$url' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Item alterado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O item não pôde ser alterado!";
	}
	$acao="entrar";
}elseif($acao=="incluir"){
	$sql=mysql_query("INSERT INTO menus (texto,url) VALUES ('$texto','$url')");
	if($sql){
		$_SESSION["mensagem"]="Item adicionado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O item não pôde ser adicionado!";
	}
	$acao="entrar";
}
?>
<html>
<head>
<title>Menus</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
<!--

function verifica(campos){
	if(campos.texto.value==''){
		alert('Informe o texto do menu');
		campos.texto.focus();
		return false;
	}
	if(campos.url.value==''){
		alert('Informe a url do menu');
		campos.url.focus();
		return false;
	}	
	return true;
}
//-->
</script>
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Menus</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <? if($acao=="entrar"){ ?>

  <tr> 
    <td><div align="center"> <a href="menu_menus.php?acao=inc" class="textobold">Adicionar 
        um &Iacute;tem no Menu</a></div>
      <table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="219">&nbsp;Menu</td>
          <td width="333">&nbsp;URL</td>
          <td width="23" align="center">&nbsp;</td>
          <td width="20" align="center">&nbsp;</td>
        </tr>
        <?
		$sql=mysql_query("SELECT * FROM menus ORDER BY texto ASC");
		if(mysql_num_rows($sql)==0){
		?>
        <tr> 
          <td colspan="4" align="center" bgcolor="#FFFFFF" class="textobold">nenhum 
            &iacute;tem de menu dispon&iacute;vel</td>
        </tr>
        <?
		}else{
			while($res=mysql_fetch_array($sql)){
		?>
        <tr onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["texto"]; ?></td>
          <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["url"]; ?></td>
          <td align="center" bgcolor="#FFFFFF"><a href="menu_menus.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" width="14" height="14" border="0"></a></td>
          <td align="center" bgcolor="#FFFFFF"><a href="#" onClick="return pergunta('Deseja excluir este item de menu?','menu_menus.php?acao=exc&id=<? print $res["id"]; ?>');"><img src="imagens/icon14_lixeira.gif" width="14" height="14" border="0"></a></td>
        </tr>
        <?
			}
		}
		?>
      </table></td>
  </tr>
  <? 
  }elseif($acao=="alt" or $acao=="inc"){ 
  	if($acao=="alt"){
		$sql=mysql_query("SELECT * FROM menus WHERE id='$id'");	
		$res=mysql_fetch_array($sql);
	}
  ?>
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="350" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco"> 
              <? if($acao=="inc"){ print"Incluir Menu"; }else{ print"Alterar Menu";} ?>            </td>
          </tr>
          <tr> 
            <td width="49" class="textobold">&nbsp;Texto</td>
            <td width="298"><input name="texto" type="text" class="formularioselect" id="texto" value="<? print $res["texto"]; ?>" size="53" maxlength="50"></td>
          </tr>
          <tr> 
            <td class="textobold">&nbsp;URL</td>
            <td><input name="url" type="text" class="formularioselect" id="url" value="<? print $res["url"]; ?>" size="53" maxlength="100"></td>
          </tr>
          <tr> 
            <td colspan="2" align="center" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='menu_menus.php'">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input name="Submit2" type="submit" class="microtxt" value="Continuar">
           <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print"alterar"; }else{ print"incluir"; } ?>"> 
            <input name="id" type="hidden" id="id" value="<? print $id; ?>"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <? } ?>
</table>
</body>
</html>
<? include("mensagem.php")?>