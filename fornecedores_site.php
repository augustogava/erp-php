<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Fornecedores Site";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="exc"){
$sql=mysql_query("DELETE FROM proposta WHERE id='$id'");
	$sql=mysql_query("DELETE FROM proposta_itens WHERE proposta='$id'");
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
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
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
            <tr>
              <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
              <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Fornecedores</div></td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        
        <tr>
          <td><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco">
                <td width="57" align="center">C&oacute;d</td>
                <td width="185">&nbsp;Raz&atilde;o</td>
                <td width="306">Fantasia</td>
                <td width="19">&nbsp;</td>
                <td width="21">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM proposta ORDER BY id DESC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr class="texto">
                <td colspan="5" align="center" bgcolor="#FFFFFF" class="textobold">NENHUM FORNECEDOR ENCONTRADO </td>
              </tr>
              <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                <td align="center" ><? print $res["id"]; ?></td>
                <td >&nbsp;<? print $res["razao"]; ?></td>
                <td ><? print $res["fantasia"]; ?></td>
                <td align="center" ><a href="fornecedores_site_list.php?p=<?= $res["id"]; ?>"><img src="imagens/icon14_box.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td align="center" ><a href="#" onClick="pergunta('Deseja excluir fornecedor?','fornecedores_site.php?id=<?= $res[id]; ?>&acao=exc');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?
			  	}
			  }
			  ?>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>