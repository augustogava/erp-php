<?
include("conecta.php");
$bd=new set_bd;
$sql=mysql_query("SELECT * FROM compras WHERE id='$id'");
$res=mysql_fetch_array($sql);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="http://www.e-sinalizacao.com.br/cybermanager/style.css" rel="stylesheet" type="text/css">
<script>
<!--

function imprimir(botao,id){
	var guarda=botao.src;
	botao.src='imagens/dot.gif';
	window.print();
	botao.src=guarda;
	window.location='prodserv_ordem_imp.php?acao=imp&id=' +id;
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
.style1 {	font-size: 14px;
	font-weight: bold;
}
-->
</style></head>

<body>
<table width="700" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="700" align="center" class="titulos"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="27%" align="center"><img src="http://www.e-sinalizacao.com.br/cybermanager/imagens/logoesi.gif" width="52" height="53"></td>
          <td width="73%" align="left" class="titulos">Ordem de Compra </td>
        </tr>
    </table></td>
  </tr>
  <tr align="left">
    <td class="textoboldbranco"><table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr class="texto">
          <td width="32%" align="left"><strong>Data:</strong>
              <?= banco2data($res["emissao"]); ?></td>
          <td width="40%"><strong>Previs&atilde;o Entrega: </strong>
              <?= $prazo; ?></td>
          <td width="28%"><strong>N&uacute;mero:
                <?= $res["id"]; ?>
          </strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left"><hr class="texto">
        <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td><strong>Fornecedor:</strong> </td>
            <td width="234"><? $sql3=mysql_query("SELECT * FROM fornecedores WHERE id='$res[fornecedor]'"); $res3=mysql_fetch_array($sql3); print $res3["nome"]; ?></td>
            <td width="150">&nbsp;</td>
            <td width="202">&nbsp;</td>
          </tr>
          <tr>
            <td width="114"><strong>Endere&ccedil;o:</strong></td>
            <td colspan="3"><? print $res3["endereco"]; ?> - <? print $res3["bairro"]; ?> - <? print $res3["cep"]; ?> - <? print $res3["estado"]; ?> - <? print $res3["cidade"]; ?> </td>
          </tr>
          <tr>
            <td><strong>CNPJ:</strong></td>
            <td><? print $res3["cnpj"]; ?></td>
            <td><strong>IE: <? print $res3["ie"]; ?></strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>Contato:</strong></td>
            <td><? print $res3["contato"]; ?></td>
            <td><strong>Tel: </strong><? print $res3["fone"]; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><strong>Respons&aacute;vel pela compra:</strong> <strong>
              <?= $res["responsavel"]; ?>
            </strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr align="left">
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="84">&nbsp;C&oacute;digo</td>
          <td width="354"> Descri&ccedil;&atilde;o </td>
          <td width="43" align="left">Qtd</td>
          <td width="63" align="center">Unit&aacute;rio</td>
          <td width="63" align="center">IPI</td>
          <td width="86" align="center">Total</td>
        </tr>
        <? 
$sql2=mysql_query("SELECT * FROM compras_list WHERE compra='$id'"); 
	if(!mysql_num_rows($sql2)){
?>
        <tr bgcolor="#FFFFFF">
          <td colspan="6" align="center" class="textobold">NENHUM PRODUTO ENCONTRADO </td>
        </tr>
        <? }else{  while($res2=mysql_fetch_array($sql2)){ 
				$tot+=($res2["qtd"]*$res2["unitario"])+(($res2["qtd"]*$res2["unitario"])*($res2["ipi"]/100));
				$totdesc+=($res2["qtd"]*$res2["unitario"])*($res2["ipi"]/100);
				$totpro+=($res2["qtd"]*$res2["unitario"]);
 ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td>&nbsp;
              <? $sql3=mysql_query("SELECT * FROM prodserv WHERE id='$res2[produto]'"); $res3=mysql_fetch_array($sql3); print $res3["codprod"]; ?></td>
          <td>&nbsp;<? print $res3["nome"]; ?></td>
          <td align="left">&nbsp;<? print $res2["qtd"]; ?></td>
          <td width="63" align="center"> &nbsp;<? print banco2valor($res2["unitario"]); ?></td>
          <td width="63" align="center"><? print banco2valor($res2["ipi"]); ?></td>
          <td width="86" align="left">&nbsp;
              <?= banco2valor(($res2["qtd"]*$res2["unitario"])+(($res2["qtd"]*$res2["unitario"])*($res2["ipi"]/100))); ?></td>
        </tr>
        <? } } ?>
    </table></td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="left"><strong>Obs:
          <?= $res["obs"]; ?>
    </strong></td>
  </tr>
  <tr align="center">
    <td align="right"><table width="150"  border="0" cellpadding="0" cellspacing="0" class="texto">
        <tr>
          <td width="30%" align="right" class="textobold">Frete:
              <?= banco2valor($res["frete"]); ?></td>
        </tr>
        <tr>
          <td align="right" class="textobold">Despesas:
              <?= banco2valor($res["despesas"]); ?></td>
        </tr>
        <tr>
          <td align="right" class="textobold">Total:
              <?= banco2valor($tot+$res["despesas"]+$res["frete"]); ?></td>
        </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td align="left"><span class="style1">Dados Para Faturamento </span></td>
  </tr>
  <? $fat=mysql_query("SELECT * FROM empresa WHERE id='$res[faturamento]'"); $fatr=mysql_fetch_array($fat); ?>
  <tr align="center">
    <td align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
        <tr>
          <td width="93"><strong> Nome Empresa: </strong></td>
          <td width="154"><?= $fatr["nome"]; ?></td>
          <td width="55"><strong>CNPJ:</strong> </td>
          <td width="120"><?= $fatr["cnpj"]; ?></td>
          <td width="54"><strong>IE:</strong> </td>
          <td width="124"><?= $fatr["ie"]; ?></td>
        </tr>
        <tr>
          <td><strong>Contato:</strong> </td>
          <td><?= $fatr["contato"]; ?></td>
          <td><strong>Telefone:</strong> </td>
          <td><?= $fatr["tel"]; ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Endere&ccedil;o:</strong> </td>
          <td><?= $fatr["end_fat"]; ?></td>
          <td><strong>Bairro:</strong> </td>
          <td><?= $fatr["bairro_fat"]; ?></td>
          <td><strong>CEP:</strong> </td>
          <td><?= $fatr["cep_fat"]; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><strong>Cidade: </strong> </td>
          <td><? $bd->pega_nome_bd("cidade","nome",$fatr["cidade_fat"]); ?></td>
          <td><strong>Estado:</strong> </td>
          <td><? $bd->pega_nome_bd("estado","nome",$fatr["estado_fat"]); ?></td>
        </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td align="left"><span class="style1">Dados Para Entrega</span></td>
  </tr>
  <tr align="center">
    <td align="left">
      <table width="267" border="0" cellpadding="0" cellspacing="0" class="texto">
        <?
$ent=mysql_query("SELECT * FROM empresa WHERE id='$res[dentrega]'"); $entr=mysql_fetch_array($ent);
$n=$res["dentregan"]; 
?>
        <tr>
          <td width="105"><strong> Nome Empresa: </strong> </td>
          <td width="162"><?= eval("print \$entr[nome];"); ?></td>
        </tr>
        <tr>
          <td><strong>Local de entrega: </strong> </td>
          <td><?= eval("print \$entr[apelido_ent$n];"); ?></td>
        </tr>
        <tr>
          <td><img src="../layout/layout_menu/spacer.gif" width="1" height="5"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Endere&ccedil;o:</strong> </td>
          <td><?= eval("print \$entr[end_$n];"); ?></td>
        </tr>
        <tr>
          <td><strong>Bairro</strong> </td>
          <td><?= eval("print \$entr[bairro_$n];"); ?></td>
        </tr>
        <tr>
          <td><strong>CEP:</strong> </td>
          <td><?= eval("print \$entr[cep_$n];"); ?></td>
        </tr>
        <tr>
          <td><strong>Cidade:</strong> </td>
          <td><? $a=eval("\$entr[cidade_$n];"); $bd->pega_nome_bd("cidade","nome",$a); ?></td>
        </tr>
        <tr>
          <td><strong>Estado:</strong> </td>
          <td><? $a=eval("\$entr[estado_$n];"); $bd->pega_nome_bd("estado","nome",$b);  ?></td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td><a href="#"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="compras_email.php?id=<?= $id; ?>&fornecedor=<?= $res["fornecedor"]; ?>"></a></td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
