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
	$sql=mysql_query("SELECT * FROM vendas_orcamento WHERE cliente='$cli' AND sit<>'1' ORDER by emissao DESC,id DESC");
	if(!mysql_num_rows($sql)){
	?>
	 <tr bgcolor="#FFFFFF">
        <td colspan="6" align="center" class="textopretobold">NENHUM DADO ENCONTRADO</td>
        </tr>
		
    
<? }else{ ?>
      

   <? while($res=mysql_fetch_array($sql)){ 
   		$sql3=mysql_query("SELECT SUM(qtd*unitario) as valor FROM vendas_orcamento_list WHERE orcamento='$res[id]'");
		$res3=mysql_fetch_array($sql3);
   switch($res["motivo"]){
		case 1:
			$motivo="Concorrência";
			break;
		case 2:
			$motivo="Investimento futuro";
			break;
		case 3:
			$motivo="Prazo";
			break;
		case 4:
			$motivo="Qualidade";
			break;
		case 5:
			$motivo="Outros";
			break;
	}
   ?>
   <a href="vendas_orc.php?acao=alt&id=<?= $res["id"]; ?>" target="_parent">
      <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td width="64" height="18" align="center"><? print banco2data($res["emissao"]); ?></td>
        <td width="65" align="center"><? print $res["id"]; ?></td>
        <td width="472"><? $sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[vendedor]'"); $res2=mysql_fetch_array($sql2); print substr($res2["nome"],0,25)."..."; ?></td>	
        <td width="80" align="center"><? print banco2valor($res3["valor"]); ?></td>
        <td width="180" align="center"><? $sql2=mysql_query("SELECT * FROM cliente_contato WHERE id='$res[contato]'"); $res2=mysql_fetch_array($sql2); print $res2["nome"]; ?></td>
        <td width="111" align="center"><? if($res["sit"]=="0"){ print "pendente"; }elseif($res["sit"]=="1"){ print "Fechado"; }else if($res["sit"]=="2"){ print "Cancelado<br>($motivo)"; } ?></td>
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