<?
include("conecta.php");
include("seguranca.php");
$qtecnico="vendas@cyberhosting.com.br"; //quem recebe o workflow de criacao no whm
if(!empty($data)){
$data=data2banco($data);
$busca="AND e_compra.data='$data'";

}

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
	$sql=mysql_query("SELECT * FROM e_compra WHERE id='$id'"); $res=mysql_fetch_array($sql);
	if($res["tipo"]=="Interno"){ 
		$pedido=$res["pedido"]; 
		$sql2=mysql_query("DELETE FROM vendas WHERE id='$pedido'");
		$sql3=mysql_query("DELETE FROM vendas_list WHERE venda='$pedido'");
	}
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Pedidos Pendentes </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
	    </tr>
  <tr>
    <td align="left" valign="top" class="titulos"><form name="form1" method="post" action="">
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#003366">
          <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
        </tr>
        <tr class="textobold">
          <td width="55">&nbsp;Data:</td>
          <td>
            <input name="data" type="text" class="formularioselect" id="data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
        </tr>
        <tr class="textobold">
          <td colspan="2" align="center"><input name="Submit2" type="submit" class="microtxt" value="Buscar">
          <input name="buscar" type="hidden" id="buscar5" value="true">
          </td>
        </tr>
      </table>
    </form>      </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="670" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="75" align="center">Compra</td>
        <td width="75" align="center">Pedido</td>
        <td width="77" align="center">Tipo</td>
        <td width="180">&nbsp;Cliente</td>
        <td width="65" align="center">Data</td>
        <td colspan="2">&nbsp;Pagamento </td>
        <td width="20" align="center">&nbsp;</td>
        <td width="20" align="center">&nbsp;</td>
        <td width="20" align="center">&nbsp;</td>
      </tr>
      <?
	  $sql=mysql_query("SELECT *,e_compra.id AS id,e_compra.tipo as tipo FROM e_compra,clientes WHERE clientes.id = e_compra.cliente AND e_compra.sit='E' $busca ORDER BY e_compra.tipo, e_compra.id");
	  if(mysql_num_rows($sql)==0){
	  ?>
	  <tr bgcolor="#FFFFFF" class="texto">
        <td colspan="10" align="center" class="textobold">NENHUM PEDIDO PENDENTE </td>
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
					case "trans":
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
        <td align="center""><? print completa($res["pedido"],10); ?></td>
        <td align="center""><? print $res["tipo"]; ?></td>
        <td width="180">&nbsp;<? print $res["nome"]; ?></td>
        <td align="center" ><? print banco2data($res["dtabre"]); ?></td>
        <td width="32" align="center"><img src="imagens/<? print $img; ?>" alt="<? print $alt; ?>"></td>
        <td width="95">&nbsp;<? print $texto; ?></td>
        <td width="20" align="center"><a href="pedidospendentes_v.php?cp=<? print $res["id"]; ?>&clid=<? print $res["cliente"]; ?>"><img src="imagens/icon14_visualizar.gif" alt="Detalhes" width="14" height="14" border="0"></a></td>
        <td width="20" align="center"><a href="<? print $desce; ?>"><img src="imagens/icon14_baixar.gif" alt="Baixa" width="16" height="16" border="0"></a></td>
        <td width="20" align="center"><a href="#" onClick="return pergunta('Confirma o cancelamento deste pedido?','pedidospendentes.php?acao=canc&id=<? print $res["id"]; ?>');"><img src="imagens/icon14_cancelar.gif" alt="Cancelar Pedido" width="16" height="16" border="0"></a></td>
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