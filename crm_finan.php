<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$cli=Input::request("cli");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Status Pedido";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
$sql=mysql_query("SELECT * FROM e_compra WHERE cliente='$cli' ORDER BY data DESC");
$res=mysql_fetch_array($sql);
$ultima=banco2data($res["data"]);

$sql2=mysql_query("SELECT SUM(e_itens.qtd*e_itens.produto_preco) as total FROM e_compra,e_itens WHERE e_compra.id=e_itens.compra AND e_compra.cliente='$cli'");
$res2=mysql_fetch_array($sql2);
$valor=banco2valor($res2["total"]);


$sql3=mysql_query("SELECT SUM(e_itens.qtd*e_itens.produto_preco) as total FROM e_compra,e_itens WHERE e_compra.id=e_itens.compra AND e_compra.cliente='$cli' AND (e_compra.sit='A' or e_compra.sit='E')");
$res3=mysql_fetch_array($sql3);
$aberto=banco2valor($res3["total"]);

$sql4=mysql_query("SELECT * FROM clientes WHERE id='$cli'");
$res4=mysql_fetch_array($sql4);

$sql5=mysql_query("SELECT * FROM cliente_cobranca  WHERE cliente='$cli'");
$res5=mysql_fetch_array($sql5);

$sql6=mysql_query("SELECT max(serasa) as serasa FROM e_compra WHERE cliente='$cli'");
$res6=mysql_fetch_array($sql6);
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
        <td width="563" align="right"><div align="left"><span class="chamadas"><span class="titulos">Financeiro</span></span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td><table width="99%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F7FFE8" class="textopreto">
                
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="textopreto">
                      <tr>
                        <td><span class="menu">Endere&ccedil;o Cliente </span></td>
                      </tr>
                      <tr>
                        <td><strong>Nome</strong>:<?php print $res4["nome"]; ?></td>
                      </tr>
                      <tr>
                        <td><strong>Endere&ccedil;o:</strong> <?php print $res4["endereco"]; ?><strong> Compl.:</strong> <?php print $res4["complemento"]; ?></td>
                      </tr>
                      <tr>
                        <td><strong>CEP: </strong><?php print $res4["cep"]; ?></td>
                      </tr>
                      <tr>
                        <td><strong>Cidade:</strong> <?php print $res4["cidade"]; ?> <strong>UF:</strong> <?php print $res4["estado"]; ?></td>
                      </tr>
                      <tr>
                        <td><strong>Telefone:</strong>&nbsp;<?php print $res4["ddd"]." ".$res4["fone"]; ?></td>
                      </tr>
                      <tr>
                        <td><strong>Contato:</strong> <?php print $res4["contato"]; ?></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><span class="menu">Endere&ccedil;o Cobran&ccedil;a </span></td>
                </tr>
                
                <tr>
                  <td bgcolor="#FFFFFF"><strong>Endere&ccedil;o:</strong> <?php print $res5["endereco"]; ?><strong> Compl.:</strong> <?php print $res5["numero"]; ?></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><strong>CEP: </strong><?php print $res5["cep"]; ?></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><strong>Cidade:</strong> <?php print $res5["cidade"]; ?> <strong>UF:</strong> <?php print $res5["estado"]; ?></td>
                </tr>
                
                <tr>
                  <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" bgcolor="#FFFFFF" class="menu">Resumo</td>
                </tr>
                <tr>
                  <td width="639" align="left" bgcolor="#FFFFFF"><strong>Data da &ugrave;ltima Compra:</strong> <?php print $ultima; ?></td>
                </tr>
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><div><strong>Ultima pesquisa no Serasa:</strong> <?php print banco2data($res6["serasa"]); ?></div></td>
                </tr>
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><div><strong>Valor Acumulado de Compras:</strong> <?php print $valor; ?></div></td>
                </tr>
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><div><strong>Valor em Aberto:</strong> <?php print $aberto; ?></div></td>
                </tr>
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><div><strong>Prazo m&eacute;dio de pagamento:</strong> <?php print $prazo; ?></div></td>
                </tr>
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><strong>Media de Atraso:</strong> <?php print $media; ?></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <br>
        <input name="voltar" type="button" class="microtxt" id="voltar" value="Voltar" onClick="history.go(-1)" />
        <p></p>
      <p></p></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>