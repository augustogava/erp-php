<?
include("conecta.php");
include("seguranca.php");
?>
<html>
<head>
<title>CyberManager</title>
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
<link href="../../style.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  
    <td align="left" valign="top">
	
	<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
	<? 
	$sql=mysql_query("SELECT * FROM followup WHERE cliente='$cli' ORDER By id DESC");
	if(!mysql_num_rows($sql)){
	?>
	<tr bgcolor="#FFFFFF">
        <td colspan="6" align="center" class="textopretobold">NENHUM DADO ENCONTRADO </td>
    </tr>
		<? }else{ ?>
     
	  
     
		
      <tr class="textoboldbranco">
        <td class="textoboldbranco"><div align="center">Data</div></td>
        <td align="center" class="textoboldbranco"><div align="center">Hora</div></td>
        <td class="textoboldbranco"><div align="center">Tipo</div></td>
        <td class="textoboldbranco"><div align="center">Vendedor</div></td>
        <td class="textoboldbranco"><div align="center">Contato</div></td>
        <td align="center" class="textoboldbranco">T&iacute;tulo</td>
      </tr>
	   <? while($res=mysql_fetch_array($sql)){ ?>
      <a href="#" onClick="return abre('crm_followup_inc.php?idf=<?= $res["id"]; ?>&acao=vis','FollowUp','width=620,height=350,scrollbars=1');">
	  <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
       <td width="53" height="18" align="center"><? print banco2data($res["data"]); ?></td>
        <td width="40" align="center"><? print $res["hora"]; ?></td>
        <td align="center"><? $sql2=mysql_query("SELECT * FROM followup_tipo WHERE id='$res[tipo]'"); $res2=mysql_fetch_array($sql2); print $res2["nome"]; ?></td>
        <td><? $sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[vendedor]'"); $res2=mysql_fetch_array($sql2); print substr($res2["nome"],0,25)."..."; ?></td>
        <td><? $sql2=mysql_query("SELECT * FROM cliente_contato WHERE id='$res[contato]'"); $res2=mysql_fetch_array($sql2); print substr($res2["nome"],0,25)."..."; ?></td>
        <td align="center">&nbsp;<? print $res["titulo"]; ?></td>
      </tr>
	  </a>
	   <? } } ?>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>