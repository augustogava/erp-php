<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Produtos Cat";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM prodserv_cat WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.texto.value==''){
		alert('Informe o Texto');
		cad.texto.focus();
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
        <td width="563" align="right"><div align="left" class="titulos">E-Categorias</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="0">
      <? if($acao=="entrar"){ ?>
      <tr>
        <td align="left" valign="top"><table width="500" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textoNegrito">
                <div align="center"><a href="prodserv_cat.php?acao=inc" class="textobold">Incluir uma Categoria</a></div></td>
            </tr>
          </table>
            <table width="500" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr bgcolor="#FFFFFF">
                <td colspan="3" align="center" bgcolor="#003366" class="textoboldbranco">Listagem das Categorias</td>
              </tr>
              <?
function lista($idpai){
	$sql=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$idpai' ORDER BY codigo ASC");
	if(mysql_num_rows($sql)!=0){
		while($res=mysql_fetch_array($sql)){
			$sql2=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$res[id]' ORDER BY texto ASC");
			$widpai=$res["id"];
			$esp=0;
			while($widpai!=0){
				$sql3=mysql_query("SELECT idpai FROM prodserv_cat WHERE id='$widpai'");
				$res3=mysql_fetch_array($sql3);
				$widpai=$res3["idpai"];
				if($widpai!=0) $esp++;
			}
			$esps=str_repeat("&nbsp;", $esp*4);
			//aki
        print"
		<tr bgcolor=\"#FFFFFF\" class=\"texto\" onMouseover=\"changeto('#CCCCCC')\" onMouseout=\"changeback('#FFFFFF')\"> 
          <td width=\"406\">&nbsp;$esps$res[codigo] $res[texto]</td>
          <td width=\"20\" align=\"center\"><a href=\"prodserv_cat.php?acao=alt&id=$res[id]\"><img src=\"imagens/icon14_alterar.gif\" alt=\"Alterar\" width=\"14\" height=\"14\" border=\"0\"></a></td>
          <td width=\"20\" align=\"center\"><a href=\"#\" onClick=\"return pergunta('Deseja excluir esta Categoria?','prodserv_cat_sql.php?acao=exc&id=$res[id]')\"><img src=\"imagens/icon14_lixeira.gif\" alt=\"Excluir\" width=\"14\" height=\"14\" border=\"0\"></a></td>
        </tr>
		";
			//aki
			if(mysql_fetch_array($sql2)){
				lista($res["id"]);
			}
		}
	}
}
$sqlw=mysql_query("SELECT * FROM prodserv_cat");
if(!mysql_num_rows($sqlw)){
?>
              <tr bgcolor="#FFFFFF">
                <td colspan="3" align="center" class="textobold">NENHUM MENU CADASTRADO</td>
              </tr>
              <?
	}else{
		lista(0);
	}
?>
          </table></td>
      </tr>
      <? }else{ ?>
      <tr>
        <td align="left" valign="top"><form name="form1" method="post" action="prodserv_cat_sql.php" onSubmit="return verifica(this);">
            <table width="500" border="0" cellpadding="0" cellspacing="0">
              <tr bgcolor="#003366">
                <td colspan="2" align="center" class="textoboldbranco">
                  <? if($acao=="inc"){ print"Incluir"; }else{ print"Alterar";} ?>
              Categoria</td>
              </tr>
              <tr>
                <td class="textobold">&nbsp;C&oacute;digo:</td>
                <td class="textobold"><input name="codigo" type="text" class="formularioselect" id="texto2" value="<?= $res["codigo"]; ?>" size="10" maxlength="255"></td>
              </tr>
              <tr>
                <td width="67" class="textobold">&nbsp;T&iacute;tulo:</td>
                <td width="433" class="textobold"><input name="texto" type="text" class="formularioselect" id="texto2" value="<?= $res["texto"]; ?>" size="10" maxlength="255"></td>
              </tr>
              <tr>
                <td class="textobold">&nbsp;Dentro de: </td>
                <td class="textobold"><select name="idpai" class="formularioselect" id="idpai">
                    <option value="0" <? if($res["idpai"]==0) print "selected"; ?>>Raiz</option>
                    <?
function no($idpai,$wcat){
	$sql=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$idpai' ORDER BY texto ASC");
	if(mysql_num_rows($sql)!=0){
		while($res=mysql_fetch_array($sql)){
			$sql2=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$res[id]' ORDER BY texto ASC");
			$widpai=$res["id"];
			$esp=0;
			while($widpai!=0){
				$sql3=mysql_query("SELECT idpai FROM prodserv_cat WHERE id='$widpai'");
				$res3=mysql_fetch_array($sql3);
				$widpai=$res3["idpai"];
				if($widpai!=0) $esp++;
			}
			if($res["id"]==$wcat){
				$selsel="selected";
			}else{
				$selsel="";
			}
			print "<option value=\"$res[id]\" $selsel>".str_repeat("&nbsp;", $esp*4)."$res[texto]</option>\n";
			if(mysql_fetch_array($sql2)){
				no($res["id"],$wcat);
			}
		}
	}
}
no(0,$res["idpai"]);
?>
                </select></td>
              </tr>
              <tr>
                <td valign="top" class="textobold">&nbsp;Ativo:</td>
                <td class="textobold"><input name="ativo" type="radio" value="1" <? if($res["ativo"]) print "checked"; ?>>
                  sim
                    <input name="ativo" type="radio" value="0" <? if(!$res["ativo"]) print "checked"; ?>> 
                  n&atilde;o </td>
              </tr>
              <tr>
                <td class="textobold">&nbsp;</td>
                <td class="textobold">&nbsp;</td>
              </tr>
              <tr align="center">
                <td colspan="2" class="textobold">             
                  <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='prodserv_cat.php'">
             <img src="imagens/dot.gif" width="20" height="5">
                  <input name="Submit2" type="submit" class="microtxt" value="Continuar">
                  <input name="acao" type="hidden" id="acao" value="<?= $acao; ?>">
                  <input name="id" type="hidden" id="id3" value="<? print $id; ?>"></td>
              </tr>
            </table>
        </form></td>
        <? } ?>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>