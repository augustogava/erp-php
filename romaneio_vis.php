<?
include("conecta.php");
$bd=new set_bd;
$sql=mysql_query("SELECT * FROM romaneio WHERE id='$id'");
$res=mysql_fetch_array($sql);
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
  <tr>
    <td colspan="2" align="center" class="titulos"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="27%" align="center"><img src="imagens/logoesi.gif" width="52" height="53"></td>
        <td width="73%" align="left" class="titulos">MKR Comercial Ltda. </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="titulos">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><strong>Romaneio N&ordm;  </strong>
        <?= $res["id"]; ?></td>
    <td width="183">&nbsp;</td>
  </tr>
  <tr>
    <td width="187" align="left"><strong>Entrega de Correspond&ecirc;ncia </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" class="textobold">Ag&ecirc;ncia Sedex </td>
  </tr>
  <tr>
    <td colspan="2" align="left" class="textobold">Ag. General Flores&nbsp;&nbsp;&nbsp;&nbsp; Tel: 3225 9919 </td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" class="textobold">Data: </td>
  </tr>
  <tr align="left">
    <td colspan="2"><table width="500" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="308">&nbsp;Cliente</td>
        <td width="97"> CEP </td>
        <td width="91" align="left">Forma Envio </td>
        </tr>
      <?
			  $sql=mysql_query("SELECT clientes.id as cod,clientes.nome,vendas.frete_tp FROM romaneio_itens,prodserv_sep,vendas,clientes WHERE romaneio_itens.romaneio='$res[id]' AND romaneio_itens.separacao=prodserv_sep.id AND vendas.id=prodserv_sep.pedido AND vendas.cliente=clientes.id");
			  if(mysql_num_rows($sql)==0){
			  ?>
      <tr bgcolor="#FFFFFF">
        <td colspan="3" align="center" bgcolor="#FFFFFF" class="textobold">NENHUM TEXTO ENCONTRADO </td>
      </tr>
      <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
					$ent=mysql_query("SELECT cep FROM cliente_entrega WHERE cliente='$res[cod]'");
					$rent=mysql_fetch_array($ent);
					$frm="";
				switch($res["frete_tp"]){
					case "1":
						$frm="Sedex";
						break;
					case "2":
						$frm="PAC";
						break;
					case "3":
						$frm="Sedex 10";
						break;
				}
			  ?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $res["cod"]." ".$res["nome"]; ?></td>
        <td ><? print $rent["cep"]; ?></td>
        <td align="left">&nbsp;<? print $frm; ?></td>
        </tr>
      <?
			  	}
			  }
			  ?>
    </table></td>
  </tr>
  <tr align="center">
    <td colspan="2">&nbsp;</td>
  </tr>

  
  <tr align="center">
    <td colspan="2"><a href="#"><img src="imagens/imprimir.gif" width="60" id="bot" name="bot" height="14" border="0" onClick="return imprimir(this)"></a></td>
  </tr>
</table>
    
</body>
</html>
