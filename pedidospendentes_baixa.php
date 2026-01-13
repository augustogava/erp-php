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
<script src="mascaras.js"></script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
 <tr>
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Aprova&ccedil;&atilde;o Financeiro </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
	    </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="textobold">&nbsp;DADOS DO CLIENTE </span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="400" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr>
        <td width="48" bgcolor="#003366" class="textoboldbranco">&nbsp;Cliente</td>
        <td width="225" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["fantasia"]; ?></td>
        <td width="44" bgcolor="#003366" class="textoboldbranco">&nbsp;C&oacute;digo</td>
        <td width="76" bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["id"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Email</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["email"]; ?></td>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Fone</td>
        <td bgcolor="#FFFFFF" class="texto">&nbsp;<? print $res["fone"]; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="textobold">&nbsp;DADOS DO PEDIDO </td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="297" class="texto_preto"><strong>&nbsp;Produto</strong></td>
        <td width="37" align="right">Qtd.</td>
        <td width="71" align="right">Unit&aacute;rio</td>
        <td width="90" align="right">Desconto % </td>
        <td width="93" align="right"><strong style="font-family: Verdana, Arial, Helvetica, sans-serif;" #invalid_attr_id="none">&nbsp;Valor</strong></td>
      </tr>
      <?
		$sql=mysql_query("SELECT * FROM e_compra WHERE id='$cp'");
		$res=mysql_fetch_array($sql);
		$vd=$res["pedido"];
		$sqlpe=mysql_query("SELECT parcelamentos.descricao,parcelamentos.parcelas,parcelamentos.intervalo FROM vendas,parcelamentos WHERE vendas.id='$res[pedido]' AND parcelamentos.id=vendas.parcelamento");
		$respe=mysql_fetch_array($sqlpe);
		
		$opcao=$res["opcao"];

		  $sql=mysql_query("SELECT * FROM e_itens WHERE compra='$cp'");
    	  $sqlscr=mysql_query("SELECT * FROM e_itens WHERE compra='$cp'");
		  $total=0;
		  while($res=mysql_fetch_array($sql)){
		  	$total+=($res["produto_preco"]*$res["qtd"])-($res["produto_preco"]*$res["qtd"])*$res["desconto"]/100;
		  ?>
      <tr bgcolor="#FFFFFF" class="texto">
        <td width="297">&nbsp;<? print $res["produto_nome"]; if($res["tipo"]=="M2"){ print " $res[material] - $res[medidas] - $res[fixacao] - $res[texto]"; } ?></td>
        <td align="right"><? print banco2valor($res["qtd"]); ?>&nbsp;</td>
        <td align="right">R$ <? print banco2valor($res["produto_preco"]); ?></td>
        <td align="right"><? print banco2valor($res["desconto"]); ?>&nbsp;</td>
        <td align="right">R$ <? print banco2valor(($res["produto_preco"]*$res["qtd"])-(($res["produto_preco"]*$res["qtd"])*$res["desconto"]/100)); ?>&nbsp;</td>
      </tr>
      <? 
		  }
		  $frete=0;
		  $total+=total; 
		  ?>
<? 
if(!empty($opcao)){
		$pag=mysql_query("SELECT * FROM op_pagamento WHERE id='$opcao'");
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
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="textobold">DADOS DO PAGAMENTO </td>
	<? $sql=mysql_query("SELECT * FROM e_compra WHERE id='$cp'");
	$res=mysql_fetch_array($sql);
	$cc=false;
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
			$cc=true;
			break;
		case "ccmaster":
			$texto="Cartão de Crédito";
			$img="icon14_master.jpg";
			$alt="Master Card";
			$cc=true;
			break;
		case "ccamerican":
			$texto="Cartão de Crédito";
			$img="icon14_amex.jpg";				
			$alt="American Express";
			$cc=true;
			break;
		case "ccdiners":
			$texto="Cartão de Crédito";
			$img="icon14_cdiners.jpg";					
			$alt="Diners Club International";
			$cc=true;
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
		case "trans":
					$texto="Transferência";
					$img="icon14_bradesco.jpg";					
					$alt="Transferência Bradesco";
					break;
	}
	?>
<script>
function verifica(cad){
	if(cad.ehbol.value=='Boleto'){
		if(!verifica_data(cad.venc.value)){
			alert('Data incorreta');
			cad.venc.focus();
			return false;
		}
	}
	<? if($cc){ ?>
	if(cad.cc_sit[cad.cc_sit.selectedIndex].value==0){
		alert('Informe a situação do Cartão');
		cad.cc_sit.focus();
		return false;
	}
	for(i=0;i<cad.status.length;i++){
		if(cad.status[i].checked){
			status=cad.status[i].value;
			break;
		}		
	}
	if(status=='A'){
		if(!confirm('Confirma cartão APROVADO?')){
			return false;
		}
	}else if(status=='R'){
		if(!confirm('Confirma cartão REPROVADO?')){
			return false;
		}	
	}
	<? } ?>
	return true;
}
</script>
  </tr>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="pedidospendentes_baixa_sql.php" onSubmit="return verifica(this)">
      <table width="594" border="0" cellspacing="0" cellpadding="0">
		<tr>
          <td><table width="350" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
		  <? if($res["tipo"]=="E-commerce"){ ?>
            <tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;Natureza</td>
              <td bgcolor="#FFFFFF" class="texto"><select name="natureza" class="formularioselect" id="natureza">
                <option value="" <? if(empty($res["natureza"])) print "selected"; ?>>Selecione</option>
                <?
				$sql=mysql_query("SELECT * FROM natureza ORDER BY nome ASC");
				while($res1=mysql_fetch_array($sql)){
				?>
                <option value="<? print $res1["id"]; ?>" ><? print $res1["nome"]; ?></option>
                <? } ?>
              </select></td>
            </tr>
			<? } ?>
            <tr bgcolor="#C6DBEF">
              <td width="120" bgcolor="#003366" class="textoboldbranco">&nbsp;Forma pg </td>
              <td width="177" bgcolor="#FFFFFF" class="texto"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="19%" align="center"><img src="imagens/<? print $img; ?>" alt="<? print $alt; ?>"></td>
                  <td width="81%" class="texto">&nbsp;<? print $texto; ?>
                    <input name="cp" type="hidden" id="cp" value="<? print $cp; ?>">
                    <input name="cc" type="hidden" id="cc2" value="<? if($cc){ print "true"; }else{ print "false"; } ?>">
                    <input name="ft" type="hidden" id="ft" value="<? if($ft){ print "true"; }else{ print "false"; } ?>"> 
                    <input name="ehbol" type="hidden" id="ehbol" value="<? if(($alt=="Boleto") or ($alt=="trans") or ($alt=="Transferência Bradesco")){ print "true"; }else{ print "false"; }  ?>">
                    <input name="opc" type="hidden" id="opc" value="<?= $opcao; ?>"></td>
                </tr>
              </table></td>
            </tr>
			<tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco"> &nbsp;Data Consulta SERASA </td>
              <td bgcolor="#FFFFFF" class="texto"><input name="serasa" type="text" class="formulario" id="serasa" size="7" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
            </tr>
			<tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco"> &nbsp;Pesquisado POR  </td>
              <td bgcolor="#FFFFFF" class="texto"><input name="por" type="text" class="formularioselect" id="por" size="7" maxlength="10"></td>
            </tr>
<? if($alt=="Faturamento"){ ?> 
            <tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;Op&ccedil;&atilde;o Pagamento </td>
              <td bgcolor="#FFFFFF" class="texto">&nbsp;<?  if(empty($opc)){ print $respe["descricao"]; }else{ print $opc; } ?>                </td>
            </tr>
<? } ?>
<? 
if($ft){ 
for($i=1;$i<=$respe["parcelas"]; $i++){
$venci=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+($respe["intervalo"]*$i),date("Y")));
?>
            <tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;Data de Vencimento</td>
              <td bgcolor="#FFFFFF" class="texto"><input name="venc<?= $i; ?>" type="text" class="formulario" id="venc" size="7" maxlength="10" onKeyPress="return validanum(this, event)" value="<? print banco2data($venci); ?> " onKeyUp="mdata(this)">                </td>
            </tr>
<? } } ?>
          </table></td>
        </tr>
		<? if($cc){ ?>
		<tr>
    		<td align="left" valign="top">&nbsp;</td>
  		</tr>
        <tr>
          <td><span class="textobold">DADOS DO CART&Atilde;O </span></td>
        </tr>
        <tr>
          <td><table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
		  
		  
            <tr bgcolor="#C6DBEF">
              <td width="120" bgcolor="#003366" class="textoboldbranco">N&uacute;mero</td>
              <td width="177" bgcolor="#FFFFFF" class="texto"><span class="texto"><? print base64_decode($res["cc_num"]); ?></span></td>
            </tr>
			
            <tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco">C&oacute;digo de seguran&ccedil;a </td>
              <td bgcolor="#FFFFFF" class="texto"><span class="texto"><? print base64_decode( $res["cc_cod"]); ?></span></td>
            </tr>
            <tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco">Nome</td>
              <td bgcolor="#FFFFFF" class="texto"><span class="texto"><? print base64_decode($res["cc_nome"]); ?></span></td>
            </tr>
            <tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco">Validade</td>
              <td bgcolor="#FFFFFF" class="texto"><span class="texto"><? print base64_decode($res["cc_mes"])."/20".base64_decode($res["cc_ano"]); ?>
              </span></td>
            </tr>
            <tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco">Verifica&ccedil;&atilde;o</td>
              <td bgcolor="#FFFFFF" class="texto"><select name="cc_sit" class="formularioselectsemborda" id="cc_sit">
                  <option value="0">Selecione</option>
                  <option value="1">Cart&atilde;o recusado</option>
                  <option value="2">Cart&atilde;o vencido</option>
                  <option value="3">Limite insuficiente</option>
              </select></td>
            </tr>
            <tr bgcolor="#C6DBEF">
              <td bgcolor="#003366" class="textoboldbranco">Status</td>
              <td bgcolor="#FFFFFF" class="texto"><input name="status" type="radio" value="A">
                Aprovado
                <input name="status" type="radio" value="R" checked>
                Reprovado</td>
            </tr>
          </table>            </td>
        </tr>
		<? } ?>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">
            <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='pedidospendentes.php'">
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="Submit222" type="button" class="microtxt" value="Ver Pedido" onClick="window.location='vendas.php?acao=alt&id=<?= $vd; ?>'">         
<img src="imagens/dot.gif" width="20" height="1">
            <input name="Submit2" type="submit" class="microtxt" value="Continuar"></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>