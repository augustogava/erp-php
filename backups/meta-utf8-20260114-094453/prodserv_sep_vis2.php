<?
include("conecta.php");
$bd=new set_bd;
$sql=mysql_query("SELECT MAX(prodserv.prazo_entrega) as prazo FROM prodserv,prodserv_sep_list WHERE prodserv_sep_list.est='$id' AND prodserv_sep_list.prodserv=prodserv.id"); $res=mysql_fetch_array($sql);
$prazo=$res["prazo"];

$sql=mysql_query("SELECT prodserv_sep.* FROM prodserv_sep WHERE prodserv_sep.id='$id'");
$res=mysql_fetch_array($sql);

$sqlp=mysql_query("SELECT  cliente_entrega.*,clientes.nome,clientes.id as codigo FROM cliente_entrega,clientes WHERE cliente_entrega.cliente='$res[cliente]' AND clientes.id=cliente_entrega.cliente");
$resp=mysql_fetch_array($sqlp);

?>
<html>
<head>
<title>Cybermanager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--

function imprimir(botao){
	var guarda=botao.src;
	botao.src='imagens/dot.gif';
	window.print();
	botao.src=guarda;
	return false;
}
//-->
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table width="680" border="0" cellpadding="0" cellspacing="0" class="texto">
  
  <tr align="left">
    <td width="110464" colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td class="texto">&nbsp;</td>
      </tr>
      <tr>
        <td class="texto">&nbsp;</td>
      </tr>
      <tr>
        <td class="texto"><strong>Razao Social:</strong> <? print $resp["nome"]; ?></td>
      </tr>
      <tr>
        <td><strong>Endere&ccedil;o:</strong> <? print $resp["endereco"]." ".$resp["numero"]; ?></td>
      </tr>
      <tr>
        <td><strong>Bairro:</strong> <? print $resp["bairro"]; ?></td>
      </tr>
      
      <tr>
        <td><strong>Cidade:</strong> <? print $resp["cidade"]; ?>&nbsp;&nbsp;&nbsp;<strong>UF:</strong>
          <? $bd->pega_nome_bd("estado","nome",$resp["estado"]);  ?></td>
      </tr>
      <tr>
        <td><strong>CEP:</strong> <? print $resp["cep"]; ?></td>
      </tr>
      
    </table>      </td>
  </tr>
  
  
  <tr align="center">
    <td colspan="4"><a href="#"><img src="imagens/imprimir.gif" width="60" id="bot" name="bot" height="14" border="0" onClick="return imprimir(this)"></a></td>
  </tr>
</table>
    
</body>
</html>
