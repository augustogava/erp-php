<?
include("conecta.php");
include("seguranca.php");

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
<link href="../../style.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  
    <td align="left" valign="top">
	
	<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
	<? 
	$sql=mysql_query("SELECT * FROM vendas WHERE cliente='$cli' ORDER By id DESC");
	if(!mysql_num_rows($sql)){
	?>
	   <tr bgcolor="#FFFFFF">
        <td colspan="5" align="center" class="textopretobold">NENHUM DADO ENCONTRADO </td>
        </tr>
	<? }else{ ?>
      

   <? 
   while($res=mysql_fetch_array($sql)){
   	$sql2=mysql_query("SELECT * FROM e_compra WHERE pedido='$res[id]' ORDER By id DESC");
	$res2=mysql_fetch_array($sql2);
	switch($res2["sit"]){
		case "A":
		$situ="Aberto";
		break;
		case "E":
		$situ="Aguardando Aprovação Financeira";
		break;
		case "B":
		$situ="Em Produção";
		break;
		case "P":
		$situ="Em Separação";
		break;
		case "F":
		$situ="Aguardando NF";
		break;
		case "FF":
		$situ="Faturado";
		break;
		default:
		$situ="Aberto";
		break;
}
 ?>
<a href="vendas.php?acao=alt&id=<?= $res["id"]; ?>" target="_parent">
      <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
       <td width="94" height="18" align="center"><? print banco2data($res["emissao"]); ?></td>
        <td width="59" align="center"><? print $res["id"]; ?></td>
        <td width="507"><? $sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[vendedor]'"); $res2=mysql_fetch_array($sql2); print substr($res2["nome"],0,25)."..."; ?></td>
        <td width="119" align="center"><? $sql2=mysql_query("SELECT SUM(qtd*unitario)-SUM((qtd*unitario)*desconto/100 ) as total FROM vendas_list WHERE venda='$res[id]'"); $res2=mysql_fetch_array($sql2); print banco2valor($res2["total"]); ?></td>
        <td width="190" align="center"><? print $situ; ?></td>
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