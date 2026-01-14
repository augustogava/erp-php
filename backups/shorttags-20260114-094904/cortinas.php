<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Cortinas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM cortinas where id='$id'");
	$res=mysql_fetch_array($sql);
}else if($acao=="exc"){
	$sql=mysql_query("DELETE FROM cortinas WHERE id='$id'");
	if($sql){
			$_SESSION["mensagem"]="Cortina excluída com sucesso!";
	}else{
			$_SESSION["mensagem"]="A Cortina não pôde ser excluída!";
	}	
	$acao="entrar";
}
?>
<html>
<head>
<title>
<MMString:LoadString id="insertbar/formsHidden" />
</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Cortinas</div></td>
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
        <td><div align="center"><a href="cortinas.php?acao=inc" class="textobold">Incluir 
          uma Cortina</a></div></td>
      </tr>
    </table>
      <table width="450" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="408">&nbsp; Nome </td>
          <td width="18" align="center">&nbsp;</td>
          <td width="20" align="center">&nbsp;</td>
        </tr>
        <?
			  $sql=mysql_query("SELECT * FROM cortinas ORDER By nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF">
          <td colspan="3" align="center" class="textobold">NENHUMA CORTINA</td>
        </tr>
        <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td width="408">&nbsp;<? print $res["nome"]; ?></td>
          <td width="18" align="center"><a href="cortinas.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta Cortina?','cortinas.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
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
          <td><div align="center"><span class="textobold">
            <input name="Submit222" type="button" class="microtxt" value="voltar" onClick="window.location='prodserv.php'">
         </span></div></td>
        </tr>
      </table></td>
  </tr>
  <? }else if($acao=="alt" or $acao=="inc"){ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="cortinas_sql.php" onSubmit="return verifica(this);">
        <table width="350" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco"> 
              <? if($acao=="inc"){ print"Incluir Cortina"; }else{ print"Configurar Cortina";} ?>            </td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Nome</td>
            <td class="textobold"><input name="nome" type="text" class="formulario" id="nome" value="<? print ($res["nome"]); ?>" size="35" ></td>
          </tr>
          <tr>
            <td width="71" class="textobold">&nbsp;Trilho
            <input name="trilho" type="hidden" id="trilho" value="<?= $res["trilho"]; ?>"></td>
            <td width="279" class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[trilho]'"); $res2=mysql_fetch_array($sql2);
				?>
                <td><input name="trilhon" type="text" class="formularioselect" id="trilhon" value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                <td width="20" align="center"><a href="#" onClick="return abre('cortinas_prod.php?pag=trilho','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td valign="middle" class="textobold">&nbsp;PVC



              <input name="pvc" type="hidden" id="pvc" value="<?= $res["pvc"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[pvc]'"); $res2=mysql_fetch_array($sql2);
				?>
                <td><input name="pvcn" type="text" class="formularioselect" id="pvcn" value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                <td width="20" align="center"><a href="#" onClick="return abre('cortinas_prod.php?pag=pvc','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="middle" class="textobold">&nbsp;Arrebites
              <input name="arrebites" type="hidden" id="arrebites" value="<?= $res["arrebites"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[arrebites]'"); $res2=mysql_fetch_array($sql2);
				?>
                  <td><input name="arrebitesn" type="text" class="formularioselect" id="arrebitesn"  value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                  <td width="20" align="center"><a href="#" onClick="return abre('cortinas_prod.php?pag=arrebites','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="middle" class="textobold">&nbsp;Parafusos
              <input name="parafusos" type="hidden" id="parafusos" value="<?= $res["parafusos"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[parafusos]'"); $res2=mysql_fetch_array($sql2);
				?>
                  <td><input name="parafusosn" type="text" class="formularioselect" id="parafusosn"  value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                  <td width="20" align="center"><a href="#" onClick="return abre('cortinas_prod.php?pag=parafusos','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Buchas
              <input name="buchas" type="hidden" id="buchas" value="<?= $res["buchas"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[buchas]'"); $res2=mysql_fetch_array($sql2);
				?>
                  <td><input name="buchasn" type="text" class="formularioselect" id="buchasn"  value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                  <td width="20" align="center"><a href="#" onClick="return abre('cortinas_prod.php?pag=buchas','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Pendural G. 
              <input name="penduralg" type="hidden" id="penduralg" value="<?= $res["penduralg"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[penduralg]'"); $res2=mysql_fetch_array($sql2);
				?>
                  <td><input name="penduralgn" type="text" class="formularioselect" id="penduralgn"  value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                  <td width="20" align="center"><a href="#" onClick="return abre('cortinas_prod.php?pag=penduralg','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Pendural P. 
              <input name="penduralp" type="hidden" id="penduralp" value="<?= $res["penduralp"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[penduralp]'"); $res2=mysql_fetch_array($sql2);
				?>
                <td><input name="penduralpn" type="text" class="formularioselect" id="penduralpn"  value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                <td width="20" align="center"><a href="#" onClick="return abre('cortinas_prod.php?pag=penduralp','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
              </tr>
            </table></td>
          </tr>
          
          
          <tr align="center"> 
            <td colspan="2" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='cortinas.php'">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Submit2" type="submit" class="microtxt" value="Continuar">
            <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>">
            <input name="id" type="hidden" id="id3" value="<? print $id; ?>"></td>
          </tr>
        </table>
      </form>    </td>
  </tr>
  <? } ?>
</table>
</body>
</html>
<? include("mensagem.php"); ?>