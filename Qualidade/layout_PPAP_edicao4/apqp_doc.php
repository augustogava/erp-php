<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$id=Input::request("id");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$iduser=$_SESSION["login_codigo"];
//Verificação
$_SESSION["modulo"]="documentos";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='documentos'");
if(mysql_num_rows($sqlm)){
	$resm=mysql_fetch_array($sqlm);
	if($resm["funcionario"]=="S" or empty($resm["funcionario"])){
		$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}else{
		$sql2=mysql_query("SELECT * FROM clientes WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}
	$_SESSION["mensagem"]="O usuario $res2[nome] está alterando este módulo!";
	header("Location:apqp_menu.php");
	exit;
}
// - - -FIM- - - 
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM apqp_doc WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
if(empty($res["forma"]) or $res["forma"]=="P"){
	$clica="1";
}else{
	$clica="2";
	$res["original"]="";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
<!--
function verifica(cad){
	if(cad.descr.value==''){
		alert('Informe a descrição');
		cad.descr.focus();
		return false;
	}
	if(cad.forma.value==''){
		alert('Informe a Forma');
		cad.forma.focus();
		return false;
	}
	if(cad.tipo.value==''){
		alert('Informe o Tipo');
		cad.tipo.focus();
		return false;
	}
	if(cad.origem.value==''){
		alert('Informe a Origem');
		cad.origem.focus();
		return false;
	}
	return true;
}
function clica(num){
	if(num=='2'){
		frmdoc.local.disabled=true;
		frmdoc.arquivo.disabled=false;
	}else{
		frmdoc.local.disabled=false;
		frmdoc.arquivo.disabled=true;
	}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_documentos.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Documentos'; this.T_DELAY=10; this.T_WIDTH=300;  return escape('Este modulo armazena os documentos que foram desenvolvidos fora da APQP.<br><br><strong>Cadastro de documentos</strong><br><strong>Descrição - </strong>a que se refere o documento<br><strong>Forma - </strong>tipo do documento papel ou arquivo<br><strong>Local - </strong>descreva o lugar onde o documento esta arquivado<br><strong>Arquivo - </strong>caminho onde o arquivo está salvo<br><strong>Responsável - </strong>responsável pelo documento<br><strong>Origem - </strong>origem do documento, Empresa que emitiu.<br><strong>OBS - </strong>algo importante a ser lembrado.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1">APQP - Documentos <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="600"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="594"><table width="594" border="0" cellpadding="0" cellspacing="0">
      <?php if($acao=="entrar"){ ?>
      <tr>
        <td align="left" valign="top"><table width="594" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><a href="apqp_doc.php?acao=inc" class="textobold">Incluir documento</a> </td>
            </tr>
          </table>
            <table width="594" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
              <tr class="textoboldbranco">
                <td width="138">&nbsp;Descri&ccedil;&atilde;o</td>
                <td width="44">&nbsp;Forma</td>
                <td width="114">&nbsp;Local / Arquivo </td>
                <td width="86">&nbsp;Respons&aacute;vel</td>
                <td width="63">&nbsp;Tipo</td>
                <td width="56">&nbsp;Origem</td>
                <td width="22" align="center">Obs</td>
                <td width="20" align="center">&nbsp;</td>
                <td width="20" align="center">&nbsp;</td>
                <td width="20" align="center">&nbsp;</td>
              </tr>
              <?php
$sql=mysql_query("SELECT * FROM apqp_doc WHERE peca='$pc' ORDER BY descr ASC");
if(mysql_num_rows($sql)==0){
?>
              <tr align="center" bgcolor="#FFFFFF" class="texto">
                <td colspan="10" align="center" class="textopretobold">nenhum documento encontrado</td>
              </tr>
              <?php
}else{
	while($res=mysql_fetch_array($sql)){
		if($res["forma"]=="P"){ 
			$down="#";
		}else{
			$down="apqp_docdown.php?id=$res[id]";
		}
?>
              <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                <td width="138" class="textopreto">&nbsp;<?php print $res["descr"]; ?> </td>
                <td width="44" class="textopreto">&nbsp;
                    <?php if($res["forma"]=="P"){ print "Papel"; }else{ print "Arq."; }?></td>
                <td class="textopreto">&nbsp;<?php print $res["original"]; ?></td>
                <td width="86" class="textopreto">&nbsp;<?php print $res["resp"]; ?></td>
                <td width="63" class="textopreto">&nbsp;<?php print $res["tipo"]; ?></td>
                <td width="56" class="textopreto">&nbsp;<?php print $res["origem"]; ?></td>
                <td width="22" align="center" class="textopreto"><a href="#"  onClick="return abre('apqp_docobs.php?id=<?php print $res["id"]; ?>','obs','width=320,height=200,scrollbars=1');"><img src="imagens/icon14_visualizar.gif" alt="Observa&ccedil;&otilde;es" width="14" height="14" border="0"></a></td>
                <td width="20" align="center"><a href="<?php print $down; ?>" class="textobold"><img src="imagens/icon_14_down.gif" alt="Download" width="14" height="14" border="0"></a></td>
                <td width="20" align="center"><a href="apqp_doc.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir este documento?','apqp_doc_sql.php?acao=exc&id=<?php print $res["id"]; ?>');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?php
	}
}
?>
          </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><img src="imagens/dot.gif" width="200" height="10"></td>
      </tr>
      <tr>
        <td align="center" valign="top"><input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php'">
            <img src="imagens/dot.gif" width="20" height="5"></td>
      </tr>
      <?php }else{ ?>
      <tr>
        <td align="left" valign="top"><form action="apqp_doc_sql.php" method="post" enctype="multipart/form-data" name="frmdoc" onSubmit="return verifica(this)">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco"><?php if($acao=="alt"){ print "Alterar"; }else{ print "Incluir"; } ?>
&nbsp;Documento</td>
              </tr>
              <tr>
                <td width="87" class="textobold">Descri&ccedil;&atilde;o</td>
                <td><input name="descr" type="text" class="formularioselect" id="descr" value="<?php print $res["descr"]; ?>" maxlength="100"></td>
              </tr>
              <tr>
                <td class="textobold">Forma</td>
                <td class="texto"><input name="forma" type="radio" value="P" <?php if(empty($res["forma"]) or $res["forma"]=="P") print "checked"; ?> onClick="clica('1');">
              papel
                <input name="forma" type="radio" value="A" <?php if($res["forma"]=="A") print "checked"; ?> onClick="clica('2');">
              arquivo</td>
              </tr>
              <tr>
                <td class="textobold">Local</td>
                <td><input name="local" type="text" class="formularioselect" id="local" value="<?php print $res["original"]; ?>" maxlength="255"></td>
              </tr>
              <tr>
                <td class="textobold">Arquivo</td>
                <td><input name="arquivo" type="file" class="formularioselect" id="arquivo2"></td>
              </tr>
              <tr>
                <td class="textobold">Respons&aacute;vel</td>
                <td><input name="resp" type="text" class="formularioselect" id="resp" value="<?php print $res["resp"]; ?>" maxlength="50"></td>
              </tr>
              <tr>
                <td class="textobold">Tipo</td>
                <td><input name="tipo" type="text" class="formularioselect" id="tipo" value="<?php print $res["tipo"]; ?>" maxlength="50"></td>
              </tr>
              <tr>
                <td class="textobold">Origem</td>
                <td><input name="origem" type="text" class="formularioselect" id="local" value="<?php print $res["origem"]; ?>" maxlength="50"></td>
              </tr>
              <tr>
                <td class="textobold">Obs</td>
                <td><input name="obs" type="text" class="formularioselect" id="local4" value="<?php print $res["obs"]; ?>" maxlength="255"></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="textobold"><input name="id" type="hidden" id="id" value="<?php print $id; ?>">
                    <input name="acao" type="hidden" id="acao" value="<?php print $acao; ?>">
                    <input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_doc.php'">
                    <img src="imagens/dot.gif" width="20" height="8">
                    <input name="Submit" type="submit" class="microtxt" value="Continuar"></td>
              </tr>
            </table>
            <script> clica('<?php print $clica; ?>'); </script>
        </form></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>