<?php
include("conecta.php");
include("seguranca.php");

$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Status Pedido";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>

</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0"></div></td>
        <td width="563" align="right"><div align="left"><span class="chamadas"><span class="titulos">Produ&ccedil;&atilde;o</span></span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
    <table width="592" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
<?php
			$sql=mysql_query("SELECT * FROM prodserv_ordem WHERE cliente='$cli'"); 
			if(!mysql_num_rows($sql)){
			
	
		?>
		    <tr class="textoboldbranco">
        <td colspan="5" align="center">N&atilde;o Existe nenhuma ordem de produ&ccedil;&atilde;o </td>
        </tr>
	  <?php }else{ ?>
      <tr class="textoboldbranco">
        <td width="55" align="left">&nbsp;&nbsp;Compra</td>
        <td width="50" align="left">Pedido</td>
        <td width="368">&nbsp;Produto</td>
        <td width="49" align="center">&nbsp;Qtd</td>
        <td width="21" align="center">&nbsp;</td>
        </tr>
	  <?php
	  
	  while($res=mysql_fetch_array($sql)){
	  $reg_final++; // PAGINACAO conta quantos registros imprimiu
		$sql2=mysql_query("SELECT nome FROM prodserv WHERE id='$res[prodserv]'");
		$res2=mysql_fetch_array($sql2);
		if($res["sit"]=="A"){
			$walt="prodserv_ordem.php?acao=baixa&id=$res[idd]&ped=$res[pedido]";
		}else{
			$walt="#\" onclick=\"return mensagem('Esta Ordem de Produção já foi finalizada');";
		}
		?>
      <tr bgcolor="#FFFFFF" class="texto">
        <td align="left"><?php print $res["compra"]; ?></td>
        <td align="left"><?php print $res["pedido"]; ?></td>
        <td width="368">&nbsp;<?php print $res2["nome"]; ?></td>
        <td align="center"><?php print banco2valor($res["qtd"]); ?></td>
        <td width="21" align="center"><a href="#" onClick="window.open('prodserv_ordem_imp.php?id=<?php print $res["id"]; ?>','','scrollbars=yes,width=700,height=500');"><img src="imagens/icon14_imp.gif" alt="Visualizar" width="15" height="15" border="0"></a></td>
        </tr>
      <?php } } ?>
</table>
      
    <br>
    <input name="voltar" type="button" class="microtxt" id="voltar" value="Voltar" onClick="history.go(-1)" /></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>