<?php
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT prodserv_ordem.prodserv,prodserv_ordem.qtd,prodserv_ordem.data,prodserv.nome,unidades.apelido FROM prodserv,prodserv_ordem,unidades WHERE prodserv.unidade=unidades.id AND prodserv_ordem.id='$id' AND prodserv_ordem.prodserv=prodserv.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$prodserv=$res["prodserv"];
$qtd=$res["qtd"];
$data=banco2data($res["data"]);
$nome=$res["nome"];
$unidade=$res["apelido"];
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Ordem de produ&ccedil;&atilde;o </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="50" height="8"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">DESCRI&Ccedil;&Atilde;O DO PRODUTO</td>
        </tr>
      <tr>
        <td width="103" bgcolor="#003366" class="textoboldbranco">&nbsp;Produto</td>
        <td width="297" bgcolor="#CCCCCC" class="texto">&nbsp;<?php print $nome; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Quantidade</td>
        <td bgcolor="#CCCCCC" class="texto">&nbsp;<?php print banco2valor($qtd)." $unidade"; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Data de emiss&atilde;o</td>
        <td bgcolor="#CCCCCC" class="texto">&nbsp;<?php print $data; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="imagens/dot.gif" width="50" height="8"></td>
  </tr>
  <tr>
    <td valign="top"><table width="594" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td colspan="4" align="center" bgcolor="#003366" class="textoboldbranco">COMPOSI&Ccedil;&Atilde;O DO PRODUTO</td>
        </tr>
<?php
$sql=mysql_query("SELECT prodserv.nome,(prodserv_item.qtd*$qtd) AS qtd,unidades.apelido FROM prodserv_item,prodserv,unidades WHERE prodserv_item.prodserv='$prodserv' AND prodserv_item.item=prodserv.id AND prodserv.unidade=unidades.id ORDER BY prodserv.nome ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
?>
      <tr>
        <td width="85" bgcolor="#003366" class="textoboldbranco">&nbsp;Produto</td>
        <td width="363" bgcolor="#CCCCCC" class="texto">&nbsp;<?php print $res["nome"]; ?></td>
        <td width="38" align="center" bgcolor="#003366" class="textoboldbranco">&nbsp;Qtd</td>
        <td width="103" align="right" bgcolor="#CCCCCC" class="texto"><?php print banco2valor($res["qtd"])." $res[apelido]"; ?>&nbsp; </td>
      </tr>
<?php
	}
}
?>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="imagens/dot.gif" width="50" height="8"></td>
  </tr>
  <tr>
    <td align="center" valign="top"><a href="prodserv_ordem.php"><img src="imagens/c_voltar.gif" width="41" height="12" border="0"></a></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>