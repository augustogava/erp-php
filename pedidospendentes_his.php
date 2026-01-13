<?
include("conecta.php");
include("seguranca.php");
$qtecnico="vendaspecocyberhosting.com.br"; //quem recebe o workflow de criacao no whm
if($acao=="envmail"){
	$sql=mysql_query("SELECT clientes.email FROM clientes,e_compra WHERE e_compra.id='$id' AND e_compra.cliente=clientes.id");
	$res=mysql_fetch_array($sql);
	$email=$res["email"];
	$sql=mysql_query("UPDATE e_compra SET whmail=1 WHERE id='$id'");
	$sql=mysql_query("SELECT * FROM e_itens WHERE compra='$id'");
	$compra=completa($id,10);
	$msg="<br>Pedido: <b>$compra</b><br><br>";
	while($res=mysql_fetch_array($sql)){
		$msg.="Criar o dominio <b>$res[dominio]</b> utilizando o plano <b>$res[produto_nome]</b><br>";
	}
	$msg.="<br>O endereço de email para contato deverá ser <b>$email</b><br><br>Após criar no WHM entre no CyberManager vá até pedidos pendentes e dê baixa no pedido nº <b>$compra</b><br><br><b>$_SESSION[login_nome]</b>";
	mail($qtecnico,"CyberHosting - Criar Domínios","$msg","From: manager@cyberhosting.com.br\nContent-type: text/html\n");
	$_SESSION["mensagem"]="O WorkFlow do pedido $compra foi enviado";
}elseif($acao=="canc"){
	$sql1=mysql_query("DELETE FROM e_compra WHERE id='$id'");
	$sql2=mysql_query("DELETE FROM e_itens WHERE compra='$id'");
	if($sql1 and $sql2){
		$_SESSION["mensagem"]="Pedido cancelado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O pedido não pôde ser cancelado!";
	}
}
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
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Pedidos Pendentes </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
	    </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="78" align="left">Pedido</td>
        <td width="77">&nbsp;N&uacute;mero NF </td>
        <td width="80" align="center">Emiss&atilde;o NF </td>
        <td width="101">Vencimento NF </td>
        <td width="91">Liquida&ccedil;&atilde;o NF </td>
        <td width="139">Prazo de Pagamento </td>
        <td width="20" align="center">&nbsp;</td>
        </tr>
      <?
	  $sql=mysql_query("select nf.* from vendas,nf WHERE nf.pedido=vendas.id AND vendas.cliente='$cli'");
	  if(mysql_num_rows($sql)==0){
	  ?>
	  <tr bgcolor="#FFFFFF" class="texto">
        <td colspan="7" align="center" class="textobold">NENHUM PEDIDO PENDENTE </td>
      </tr>
	  <?
		}else{
			while($res=mysql_fetch_array($sql)){
				$desce="pedidospendentes_baixa.php?cp=$res[id]&clid=$res[cliente]";
				switch($res["pagamento"]){
					case "faturamento":
						$texto="Faturamento";
						$img="icon14_dollar.gif";
						$alt="Faturamento";
						$ft=true;
						break;
					case "boleto":
						$texto="Boleto";
						$img="icon14_boleto.gif";
						$alt="Boleto";
						break;
					case "ccvisa":
						$texto="Cartão de Crédito";
						$img="icon14_visa.jpg";					
						$alt="Visa";
						break;
					case "ccmaster":
						$texto="Cartão de Crédito";
						$img="icon14_master.jpg";
						$alt="Master Card";
						break;
					case "ccamerican":
						$texto="Cartão de Crédito";
						$img="icon14_amex.jpg";				
						$alt="American Express";
						break;
					case "ccdiners":
						$texto="Cartão de Crédito";
						$img="icon14_cdiners.jpg";					
						$alt="Diners Club International";
						break;
					case "tbb":
						$texto="Transferência";
						$img="icon14_bbb.jpg";					
						$alt="Transferência Banco do Brasil";
						break;
					case "tbradesco":
						$texto="Transferência";
						$img="icon14_bradesco.jpg";					
						$alt="Transferência Bradesco";
						break;
					case "titau":
						$texto="Transferência";
						$img="icon14_itau.jpg";					
						$alt="Transferência Itaú";
						break;
					case "tunibanco":
						$texto="Transferência";
						$img="icon14_unibanco2.jpg";					
						$alt="Transferência Unibanco";
						break;
				}
		?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td align="center""><? print completa($res["id"],10); ?></td>
        <td width="77" align="center">&nbsp;<? print $res["fantasia"]; ?></td>
        <td align="center" ><? print banco2data($res["dtabre"]); ?></td>
        <td align="center"><? print banco2data($res["dtabre"]); ?></td>
        <td align="center"><? print banco2data($res["dtabre"]); ?></td>
        <td align="center"><? print banco2data($res["dtabre"]); ?></td>
        <td width="20" align="center"><a href="pedidospendentes_v.php?cp=<? print $res["id"]; ?>&clid=<? print $res["cliente"]; ?>"><img src="imagens/icon14_visualizar.gif" alt="Detalhes" width="14" height="14" border="0"></a></td>
        </tr>
	  <?
	  	}
	  }
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>