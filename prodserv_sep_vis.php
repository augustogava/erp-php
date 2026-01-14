<?php
include("conecta.php");
$bd=new set_bd;
$sql=mysql_query("SELECT MAX(prodserv.prazo_entrega) as prazo FROM prodserv,prodserv_sep_list WHERE prodserv_sep_list.est='$id' AND prodserv_sep_list.prodserv=prodserv.id"); $res=mysql_fetch_array($sql);
$prazo=$res["prazo"];

$sql=mysql_query("SELECT prodserv_sep.*,clientes.nome,transportadora.nome as nome_trans,transportadora.telefone as tel_trans,transportadora.id as cod_trans FROM prodserv_sep,vendas,clientes,transportadora WHERE prodserv_sep.id='$id' AND prodserv_sep.pedido=vendas.id AND vendas.vendedor=clientes.id AND vendas.transportadora=transportadora.id ");
$res=mysql_fetch_array($sql);
$nome_trans=$res["nome_trans"];
$tel_trans=$res["tel_trans"];
$cod_trans=$res["cod_trans"];

$sqlp=mysql_query("SELECT  cliente_entrega.*,clientes.nome,clientes.id as codigo FROM cliente_entrega,clientes WHERE cliente_entrega.cliente='$res[cliente]' AND clientes.id=cliente_entrega.cliente");
$resp=mysql_fetch_array($sqlp);

?>
<html>
<head>
<title>Cybermanager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
    <td colspan="4" align="center" class="titulos"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="27%" align="center"><img src="imagens/logoesi.gif" width="52" height="53"></td>
        <td width="73%" align="left" class="titulos">Romaneio de Separa&ccedil;&atilde;o / Entrega </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="titulos">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><strong>Pedido: </strong>
        <?php echo  $res["pedido"]; ?></td>
    <td width="183"><strong>Data:</strong>
        <?php echo  banco2data($res["emissao"]); ?></td>
    <td width="164"><strong>Vendedor:</strong>
        <?php echo  $res["nome"]; ?></td>
    <td width="166"><strong>Previs&atilde;o:</strong>
        <?php echo  $prazo; ?>
      Dias </td>
  </tr>
  <tr>
    <td width="187" align="left"><strong>C&oacute;digo Cliente: </strong>
      <?php echo  $resp["codigo"]; ?>    </td>
    <td colspan="3"><strong>Nome:  </strong>
      <?php echo  $resp["nome"]; ?>   </td>
  </tr>
  <tr>
    <td colspan="4" align="right">&nbsp;</td>
  </tr>
  <tr align="left">
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="81">&nbsp;C&oacute;digo</td>
        <td width="457"> Descri&ccedil;&atilde;o </td>
        <td width="44" align="left">Qtd</td>
        <td width="113" align="left">Localiza&ccedil;&atilde;o</td>
        </tr>
      <?php
			  $sql=mysql_query("SELECT * FROM prodserv_sep_list WHERE est='$id' ORDER BY pedido ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
      <tr bgcolor="#FFFFFF">
        <td colspan="4" align="center" bgcolor="#FFFFFF" class="textobold">NENHUM TEXTO ENCONTRADO </td>
      </tr>
      <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
				switch($res["sit"]){
						case "1":
							$st="Aguardando Compras";
							break;
						case "2":
							$st="Aguardando Correio";
							break;
						case "3":
							$st="Coletado";
							break;
						case "4":
							$st="Em Separação";
							break;
						case "5":
							$st="Em Produ&ccedil;&atilde;o";
							break;
						case "6":
							$st="Agendado Entrega MKR";
							break;
						case "7":
							$st="Aguardando Transportadora";
							break;
						case "8":
							$st="Entregue";
							break;
						case "9":
							$st="Aguardando Cliente";
							break;
				}
$prod=$res["prodserv"]; $sql2=mysql_query("SELECT * FROM prodserv WHERE id='$prod'"); $res2=mysql_fetch_array($sql2); $cod=$res2["codprod"]; $descricao=$res2["nome"];
			  ?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<?php print $cod; ?></td>
        <td ><?php print $descricao; ?></td>
        <td align="left">&nbsp;<?php print $res["qtd"]; ?></td>
        <td width="113" align="left"> &nbsp;<?php print $res2["corredor"]." - ".$res2["prateleira"]." - ".$res2["posi"]; ?></td>
        </tr>
      <?php
			  	}
			  }
			  ?>
    </table></td>
  </tr>
  <tr align="center">
    <td colspan="4">&nbsp;</td>
  </tr>
<?php 
$sql2=mysql_query("SELECT * FROM e_compra WHERE id='$res[compra]'");
$res2=mysql_fetch_array($sql2);
?>
  <tr align="left">
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td class="menu">Endere&ccedil;o Entrega</td>
      </tr>
      <tr>
        <td><strong>Endere&ccedil;o:</strong> <?php print $resp["endereco"]." ".$resp["numero"]; ?></td>
      </tr>
      <tr>
        <td><strong>Bairro:</strong> <?php print $resp["bairro"]; ?></td>
      </tr>
      <tr>
        <td><strong>CEP:</strong> <?php print $resp["cep"]; ?></td>
      </tr>
      <tr>
        <td><strong>Cidade:</strong> <?php print $resp["cidade"]; ?></td>
      </tr>
      <tr>
        <td><strong>Estado:</strong>
            <?php $bd->pega_nome_bd("estado","nome",$resp["estado"]);  ?></td>
      </tr>
      
    </table>      </td>
  </tr>
  <tr align="left">
    <td colspan="4"><strong>Envio: </strong><?php if(empty($res2["forn_nome"])){ print "Pelo correio"; }else{ print "Transportadora $res2[forn_nome] - $res2[forn_tel]"; } ?></td>
  </tr>
  <tr align="center">
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td class="menu">&nbsp;</td>
      </tr>
      <tr>
        <td class="menu">Transportadora</td>
      </tr>
      <tr>
        <td><strong>C&oacute;digo:</strong> &nbsp;<?php print $cod_trans; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Nome:</strong> <?php print $nome_trans; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tel:</strong> <?php print $tel_trans; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Transportadora que coletou &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A mesma: [&nbsp;&nbsp;&nbsp;] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outra:_____________________________________________</strong></td>
      </tr>
      <tr>
        <td><strong>Data   Coleta</strong>: ___________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>No. Coleta:</strong>&nbsp;________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Hora Coleta:</strong>&nbsp;___________&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Nome Motorista:</strong>&nbsp; _________________________________________________   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Placa Ve&iacute;culo:</strong> __________&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  
  <tr align="center">
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="4" align="left"><strong>Assinatura   da   Coleta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   Assinatura do Empregador</strong></td>
  </tr>
  <tr align="center">
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="4"><a href="#"><img src="imagens/imprimir.gif" width="60" id="bot" name="bot" height="14" border="0" onClick="return imprimir(this)"></a></td>
  </tr>
</table>
    
</body>
</html>
