<?php
include("conecta.php");

$sql=mysql_query("SELECT * FROM vendas_orcamento WHERE id='$id'");
$res=mysql_fetch_array($sql);
$sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[cliente]'");
$res3=mysql_fetch_array($sql2);
$sql4=mysql_query("SELECT * FROM cliente_contato WHERE id='$res[contato]'");
$res4=mysql_fetch_array($sql4);
?>
<html>
<head>
<title>Untitled Document</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
.style1 {
	font-size: 14px;
	font-weight: bold;
}
.style2 {font-size: 24px}
.style3 {color: #FFFFFF}
.style5 {font-size: 12px}
-->
</style></head>

<body>
<table width="650" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="700" align="center" class="titulos"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="27%" align="center"><img src="http://www.e-sinalizacao.com.br/cybermanager/imagens/logoesi.gif" width="52" height="53"></td>
          <td width="73%" align="center" class="titulos style2">PROPOSTA COMERCIAL </td>
        </tr>
    </table></td>
  </tr>
  <tr align="left">
    <td class="textoboldbranco"><table width="600" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr class="texto">
          <td width="36%" height="23" align="left"><span class="style3"><strong>N&ordm; Proposta:</strong>
              <?php echo  $res["cod"]; ?>
          </span></td>
          <td width="40%"><span class="style3"><strong>Data Proposta : </strong>
              <?php echo  banco2data($res["emissao"]); ?>
          </span></td>
          <td width="24%"><span class="style3"><strong>Validade:
                <?php echo  "10 Dias"; ?>
          </strong></span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><hr width="600" class="texto">
        <table width="600"  border="0" align="center" cellpadding="2" cellspacing="0" class="texto">
          <tr>
            <td><strong>Raz&atilde;o Social :</strong></td>
            <td colspan="2"><?php print $res3["nome"]; ?></td>
          </tr>
          <tr>
            <td width="152"><strong>Nome do Contato:</strong></td>
            <td colspan="2"><?php print $res4["nome"]; ?></td>
          </tr>
          <tr>
            <td><strong>Tel. do contato: </strong></td>
            <td width="129"><?php print $res3["fone"]; ?></td>
            <td width="197"><strong>Fax: <?php print $res3["fax"]; ?></strong></td>
          </tr>
          <tr>
            <td><strong>E-mail do Contato: </strong></td>
            <td><?php print $res3["email"]; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </table></td>
  </tr>
  <tr align="left">
    <td><?php 
$sql2=mysql_query("SELECT v.* FROM vendas_orcamento_list as v,prodserv as p WHERE v.orcamento='$id' and v.produto=p.id AND p.tipo<>'SM' AND p.tipo<>'PL' order by p.codprod ASC"); 
  while($res2=mysql_fetch_array($sql2)){ 
		$sql3=mysql_query("SELECT * FROM prodserv WHERE id='$res2[produto]'"); 
			$res3=mysql_fetch_array($sql3);
		$sql4=mysql_query("SELECT * FROM unidades WHERE id='$res3[unidade]'"); 
			$res4=mysql_fetch_array($sql4);
				$tot+=($res2["qtd"]*$res2["unitario"]);
				$prods+=$res2["qtd"]*$res2["unitario"];
				$descs+=$res2["qtd"]*$res2["unitario"]*$res2["desconto"]/100;
		$sqlm=mysql_query("SELECT * FROM material WHERE id='$res2[material]'");
		$resm=mysql_fetch_array($sqlm);
 ?>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#003366">
          <tr class="textoboldbranco">
            <td width="35" align="left">Qtd</td>
            <td width="35" align="left">Un</td>
            <td width="64">Emb.</td>
            <td width="444"> Produto </td>
            <td width="51" align="center">Unit</td>
            <td width="57" align="center">Total</td>
          </tr>
          <tr bgcolor="#FFFFFF" class="texto">
            <td align="left">&nbsp;<?php print $res2["qtd"]; ?></td>
            <td align="left">&nbsp;<?php print $res4["apelido"]; ?></td>
            <td>&nbsp;<?php print $res3["embalagem"]; ?></td>
            <td><table width="94%" border="0" cellspacing="00">
                <tr>
                  <td width="12%" align="center"><img src=<?php if(!empty($res3["foto"])){ ?>http://www.e-sinalizacao.com.br/cybermanager/foto/gd.php?img=<?php print $res3["foto"]; ?>&wid=90<?php }else{ print "imagens/semFoto.jpg"; }; ?>></td>
                  <td width="88%" class="texto"><?php print $res3["nome"]; ?></td>
                </tr>
            </table></td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;<?php print banco2valor($res2["unitario"]); ?></td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;
                <?php echo  banco2valor(($res2["qtd"]*$res2["unitario"])-($res2["qtd"]*$res2["unitario"]*$res2["desconto"]/100)); ?></td>
          </tr>
          <tr bgcolor="#FFFFFF" class="texto">
            <td colspan="6" align="left">&nbsp;<?php print $res3["espec"]; ?></td>
          </tr>
      </table>
      <br>
        <?php } ?></td>
  </tr>
  <tr align="center">
    <td align="left"><?php 
	$sqlp=mysql_query("SELECT vendas_orcamento_list.*, COUNT(*) AS tot FROM vendas_orcamento_list,vendas_orcamento,prodserv WHERE vendas_orcamento_list.produto=prodserv.id AND (prodserv.tipo='SM' OR prodserv.tipo='PL') AND vendas_orcamento_list.orcamento=vendas_orcamento.id AND vendas_orcamento_list.orcamento='$id' GROUP BY produto ORDER BY tot DESC");
	while($resp=mysql_fetch_array($sqlp)){
		if($resp["tot"]<=1){
				$sql3=mysql_query("SELECT * FROM prodserv WHERE id='$resp[produto]'"); 
					$res3=mysql_fetch_array($sql3);
				$sql4=mysql_query("SELECT * FROM unidades WHERE id='$res3[unidade]'"); 
					$res4=mysql_fetch_array($sql4);
						$tot+=($resp["qtd"]*$resp["unitario"]);
						$prods+=$resp["qtd"]*$resp["unitario"];
						$descs+=$resp["qtd"]*$resp["unitario"]*$resp["desconto"]/100;
		 ?>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#003366">
          <tr class="textoboldbranco">
            <td width="42" align="left">Qtd</td>
            <td width="55" align="center">Largura</td>
            <td width="66" align="center">Altura</td>
            <td width="43" align="left">Un</td>
            <td width="173"> Produto </td>
            <td width="174">Local Instala&ccedil;&atilde;o </td>
            <td width="64" align="center">Unit</td>
            <td width="67" align="center">Total</td>
          </tr>
          <tr bgcolor="#FFFFFF" class="texto">
            <td align="left">&nbsp;<?php print $resp["qtd"]; ?></td>
            <td align="center"><?php print banco2valor($resp["largura"]); ?></td>
            <td align="center"><?php print banco2valor($resp["altura"]); ?></td>
            <td align="left">&nbsp;<?php print $res4["apelido"]; ?></td>
            <td><?php print $res3["nome"]; ?></td>
            <td><?php print $resp["local"]; ?></td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;<?php print banco2valor($resp["unitario"]); ?></td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;
                <?php echo  banco2valor(($resp["qtd"]*$resp["unitario"])-($resp["qtd"]*$resp["unitario"]*$resp["desconto"]/100)); ?></td>
          </tr>
          <tr bgcolor="#FFFFFF" class="texto">
            <td colspan="8" align="left">&nbsp;
                <table width="100%" border="0" cellspacing="00">
                  <tr>
                    <td width="12%" align="center"><img src=<?php if(!empty($res3["foto"])){ ?>http://www.e-sinalizacao.com.br/cybermanager/foto/gd.php?img=<?php print $res3["foto"]; ?>&wid=50<?php }else{ print "imagens/semFoto.jpg"; }; ?>></td>
                    <td width="88%" class="texto"><?php print $res3["espec"]; ?></td>
                  </tr>
              </table></td>
          </tr>
      </table>
      <br>
        <?php }else{  ?>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#003366">
          <tr class="textoboldbranco">
            <td width="42" align="left">Qtd</td>
            <td width="55" align="center">Largura</td>
            <td width="66" align="center">Altura</td>
            <td width="43" align="left">Un</td>
            <td width="173"> Produto </td>
            <td width="174">Local Instala&ccedil;&atilde;o </td>
            <td width="64" align="center">Unit</td>
            <td width="67" align="center">Total</td>
          </tr>
          <?php
			  $sqll=mysql_query("SELECT vendas_orcamento_list.* FROM vendas_orcamento_list,vendas_orcamento WHERE vendas_orcamento_list.produto='$resp[produto]' AND vendas_orcamento_list.orcamento=vendas_orcamento.id AND vendas_orcamento.id='$id'");
			  while($resl=mysql_fetch_array($sqll)){
				$sql3=mysql_query("SELECT * FROM prodserv WHERE id='$resl[produto]'"); 
					$res3=mysql_fetch_array($sql3);
				$sql4=mysql_query("SELECT * FROM unidades WHERE id='$res3[unidade]'"); 
					$res4=mysql_fetch_array($sql4);
						$tot+=($resl["qtd"]*$resl["unitario"]);
						$prods+=$resl["qtd"]*$resl["unitario"];
						$descs+=$resl["qtd"]*$resl["unitario"]*$resl["desconto"]/100;
			?>
          <tr bgcolor="#FFFFFF" class="texto">
            <td align="left">&nbsp;<?php print $resl["qtd"]; ?></td>
            <td align="center"><?php print banco2valor($resl["largura"]); ?></td>
            <td align="center"><?php print banco2valor($resl["altura"]); ?></td>
            <td align="left">&nbsp;<?php print $res4["apelido"]; ?></td>
            <td><?php print $res3["nome"]; ?></td>
            <td><?php print $resl["local"]; ?></td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;<?php print banco2valor($resl["unitario"]); ?></td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;
                <?php echo  banco2valor(($resl["qtd"]*$resl["unitario"])-($resl["qtd"]*$resl["unitario"]*$resl["desconto"]/100)); ?></td>
          </tr>
          <?php } ?>
          <tr bgcolor="#FFFFFF" class="texto">
            <td colspan="8" align="left">&nbsp;
                <table width="100%" border="0" cellspacing="00">
                  <tr>
                    <td width="12%" align="center"><img src=<?php if(!empty($res3["foto"])){ ?>http://www.e-sinalizacao.com.br/cybermanager/foto/gd.php?img=<?php print $res3["foto"]; ?>&wid=50<?php }else{ print "imagens/semFoto.jpg"; }; ?>></td>
                    <td width="88%" class="texto"><?php print $res3["espec"]; ?></td>
                  </tr>
              </table></td>
          </tr>
      </table>
      <br>
        <?php }
		 }
		   ?>
    </td>
  </tr>
  <tr align="center">
    <td align="right">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="right"><table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr align="center" class="textoboldbranco">
        <td width="120">Produtos</td>
        <?php if($res["frete"]=="3" or $res["frete"]=="4"){ ?>
        <td width="120">Frete</td>
        <?php } ?>
        <?php if(!empty($descs)){ ?>
        <td width="120">Descontos</td>
        <?php } ?>
        <td width="120">Total</td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF" class="textobold">
        <td width="120"><?php echo  banco2valor($prods); ?></td>
        <?php if($res["frete"]=="3" or $res["frete"]=="4"){ ?>
        <td width="120"><?php print banco2valor($res["frete_val"]); $tot+=$res["frete_val"];  ?></td>
        <?php } ?>
        <?php if(!empty($descs)){ ?>
        <td width="120"><?php echo  banco2valor($descs); ?></td>
        <?php } ?>
        <td width="120"><?php echo  banco2valor($tot-$descs); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;</td>
  </tr>
  
  <?php $fat=mysql_query("SELECT * FROM empresa WHERE id='$res[faturamento]'"); $fatr=mysql_fetch_array($fat); ?>
  
  <tr align="center">
    <td align="left">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="left"><span class="style1">Condi&ccedil;&otilde;es de Pagamento </span></td>
  </tr>
  <tr align="center">
    <td align="left"><table width="650" border="0" align="right" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td><table width="100%" border="0" cellpadding="3" cellspacing="0" class="texto">
            <tr>
              <td width="116"><strong> Prazo de Pagamento: </strong> </td>
              <td width="194"><?php $sql2=mysql_query("SELECT * FROM parcelamentos WHERE id='$res[p_pag]'"); $res2=mysql_fetch_array($sql2); print $res2["descricao"]; ?></td>
              <td width="322" rowspan="5" align="center" valign="top"><table width="85%" border="1" cellpadding="0" cellspacing="0" bordercolor="#003063">
                  <tr>
                    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" class="textobold style5">Proposta aceita conforme Termo<br>
                            Compromisso em Anexo </td>
                        </tr>
                        <tr>
                          <td class="texto">&nbsp;</td>
                        </tr>
                        <tr>
                          <td class="texto">Nome: _______________________________</td>
                        </tr>
                        <tr>
                          <td class="texto">Assinatura: ___________________________</td>
                        </tr>
                        <tr>
                          <td class="texto">Data: ____/____/____ </td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><strong>Instala&ccedil;&atilde;o</strong> : </td>
              <td><?php if($res["instalacao"]=="1"){ print "Por conta do Cliente"; }else{ print "Por conta da MKR"; } ?></td>
            </tr>
            <tr>
              <td><strong>Disponibilidade: </strong><img src="../layout/layout_menu/spacer.gif" width="1" height="5"></td>
              <td><?php if($res["p_entrega"]=="1"){ print "3 Dias uteis"; }else if($res["p_entrega"]=="2"){ print "7 Dias uteis"; }else if($res["p_entrega"]=="3"){ print "15 Dias uteis"; }else if($res["p_entrega"]=="5"){ print "5 Dias uteis"; }else{ print "30 Dias uteis"; } ?></td>
            </tr>
            <tr>
              <td><strong>Frete:</strong></td>
              <td><?php if($res["frete"]=="1"){ print "FOB - Indicar Transportadora"; }else if($res["frete"]=="3"){ print "FOB - Por Sedex"; }else if($res["frete"]=="4"){ print "FOB - Por PAC"; }else if($res["frete"]=="5"){  print "Cliente Retira"; }else{ print "CIF - Por conta da MKR"; } ?></td>
            </tr>
            <tr>
              <td><strong>Garantia:</strong></td>
              <td>1 ano contra defeito de fabrica&ccedil;&atilde;o </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Colocamo-nos a disposi&ccedil;&atilde;o para maiores esclarecimentos. </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Antecipadamente Grato, </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php $sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[vendedor]'"); $res2=mysql_fetch_array($sql2); ?>
      <tr>
        <td><?php echo  $res2["nome"]; ?></td>
      </tr>
      <tr>
        <td><a href="mailto:<?php echo  $res2["email"]; ?>">
          <?php echo  $res2["email"]; ?>
        </a></td>
      </tr>
      <tr>
        <td><?php echo  $res2["fone"]; ?>
            <?php echo  $res2["fax"]; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"> Rua Boraceia, 174 Barra Funda - S&atilde;o Paulo-SP Tel./Fax:(0xx11) 3392-6599 </td>
      </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td><a href="#"><img src="imagens/imprimir.gif" width="60" id="bot" name="bot" height="14" border="0" onClick="return imprimir(this)"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="vendas_email.php?id=<?php echo  $id; ?>&cliente=<?php echo  $res["cliente"]; ?>"><img src="imagens/c_email.gif" width="55" id="email" height="14" border="0"></a></td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
