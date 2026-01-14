<?
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT * FROM clientes WHERE id='$clid'");
$res=mysql_fetch_array($sql);
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top" class="titulos">Aprova&ccedil;&atilde;o do Financeiro </td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;<span class="textobold">DADOS DO CLIENTE </span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="422" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr>
        <td width="48" bgcolor="#003366" class="textoboldbranco">&nbsp;Cliente</td>
        <td width="213" bgcolor="#FFFFFF" class="texto">&nbsp;<a href="pedidospendentes_his.php?cli=<?= $clid; ?>" class="texto"><? print $res["fantasia"]; ?></a></td>
        <td width="49" bgcolor="#003366" class="textoboldbranco">&nbsp;C&oacute;digo</td>
        <td width="105" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["id"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Email</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["email"]; ?></td>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Fone</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["fone"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Contato</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["contato"]; ?></td>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Cargo</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["cargo"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;CNPJ</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["cnpj"]; ?></td>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;IE</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["ei"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">CPF</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto"><? print $res["cpf"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Endereco</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["endereco"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Bairro</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["bairro"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Cidade</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["cidade"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;CEP</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["cep"]; ?></td>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Estado</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? $sqlc=mysql_query("SELECT * FROM estado WHERE id='$res[estado]'"); $resc=mysql_fetch_array($sqlc); print $resc["nome"]; ?></td>
      </tr>
<? 
$sql=mysql_query("SELECT * FROM cliente_cobranca WHERE cliente='$clid'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
?>
      <tr>
        <td colspan="4" bgcolor="#003366" class="textoboldbranco"><div align="right">Endere&ccedil;o Cobran&ccedil;a</div></td>
        </tr>
      <tr>
        <td height="19" bgcolor="#003366" class="textoboldbranco">&nbsp;Endereco</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["endereco"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Bairro</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["bairro"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Cidade</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["cidade"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;CEP</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["cep"]; ?></td>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Estado</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? $sqlc=mysql_query("SELECT * FROM estado WHERE id='$res[estado]'"); $resc=mysql_fetch_array($sqlc); print $resc["nome"]; ?></td>
      </tr>
<? } ?>
<? 
$sql=mysql_query("SELECT * FROM e_compra WHERE id='$cp'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
		$vd=$res["pedido"];
?>
      <tr>
        <td colspan="4" bgcolor="#003366" class="textoboldbranco"><div align="right">Endere&ccedil;o Entrega </div></td>
        </tr>
      <tr>
        <td height="19" bgcolor="#003366" class="textoboldbranco">&nbsp;Endereco</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["endereco"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Bairro</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["bairro"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Cidade</td>
        <td colspan="3" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["cidade"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;CEP</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["cep"]; ?></td>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Estado</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? $sqlc=mysql_query("SELECT * FROM estado WHERE id='$res[estado]'"); $resc=mysql_fetch_array($sqlc); print $resc["nome"]; ?></td>
      </tr>
<? } ?>
    </table>
    &nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;<span class="textobold">DADOS DO PEDIDO </span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="286" class="texto_preto"><strong>&nbsp;Produto</strong></td>
        <td width="62" align="right">Qtd.</td>
        <td width="70" align="right">Unit&aacute;rio</td>
        <td width="85" align="right">Desconto % </td>
        <td width="85" align="right"><strong style="font-family: Verdana, Arial, Helvetica, sans-serif;" #invalid_attr_id="none">&nbsp;Valor</strong></td>
      </tr>
      <?
		$sql=mysql_query("SELECT * FROM e_compra WHERE id='$cp'");
		$res=mysql_fetch_array($sql);
		$opcao=$res["opcao"];
		  $sql=mysql_query("SELECT * FROM e_itens WHERE compra='$cp'");
    	  $total=0;
		  while($res=mysql_fetch_array($sql)){
		  	$total+=($res["produto_preco"]*$res["qtd"])-($res["produto_preco"]*$res["qtd"])*$res["desconto"]/100;
		  ?>
      <tr bgcolor="#FFFFFF" class="texto">
        <td width="286">&nbsp;<? print $res["produto_nome"]; ?></td>
        <td align="right"><? print banco2valor($res["qtd"]); ?>&nbsp;</td>
        <td align="right">R$ <? print banco2valor($res["produto_preco"]); ?></td>
        <td align="right"><? print banco2valor($res["desconto"]); ?></td>
        <td align="right">R$ <? print banco2valor(($res["produto_preco"]*$res["qtd"])-(($res["produto_preco"]*$res["qtd"])*$res["desconto"]/100)); ?>&nbsp;</td>
      </tr>
      <? 
		  }
		  $frete=0;
		  $total+=total; 
		$pag=mysql_query("SELECT * FROM op_pagamento WHERE id='$opcao'");
		if(mysql_num_rows($pag)){
			$rpag=mysql_fetch_array($pag);
				$desconto=($total*$rpag["desconto"])/100;
				eval("\$total=$total$rpag[operador]$desconto;");
				$opc=$rpag["nome"];
		}
		  ?>
      <tr class="textoboldbranco">
        <td>&nbsp;Total</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right"><strong>R$&nbsp;<? print banco2valor($total); ?>&nbsp;</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='pedidospendentes.php'">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="Submit222" type="button" class="microtxt" value="Ver Pedido" onClick="window.location='vendas.php?acao=alt&id=<?= $vd; ?>'"></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>