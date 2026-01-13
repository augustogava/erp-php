<?
include("conecta.php");
include("seguranca.php");
$bd=new set_bd;
if(empty($acao)) $acao="entrar";
$where="WHERE prodserv_sep.sit='P' AND vendas.id=prodserv_sep.pedido AND prodserv_sep.cliente=clientes.id ";
if(!empty($bde)){
		$bde=data2banco($bde);
		$where.="AND vendas.emissao>='$bde' ";
		$bde=banco2data($bde);
		if(!empty($bate)){
			$bate=data2banco($bate);
			$where.="AND vendas.emissao<='$bate' ";
			$bate=banco2data($bate);
		}
}
if(!empty($pedido)){
	$where.="AND prodserv_sep.pedido='$pedido' ";
}
if(!empty($status)){
	$where.="AND prodserv_sep.status='$status' ";
}
if(!empty($produto)){
	$where.="AND prodserv_sep.cliente like '%$produto%' ";
}
if(!empty($produto)){
	$where.="AND prodserv_sep.pedido like '%$pedido%' ";
}
if(!empty($razao)){
	$where.="AND clientes.nome like '%$razao%' ";
}

if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM prodserv_sep WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	// PEdido
	$sql2=mysql_query("SELECT * FROM vendas WHERE id='$pedido'");
	$res2=mysql_fetch_array($sql2);
}else if($acao=="alterar"){
	$previsao=data2banco($previsao);
	mysql_query("UPDATE prodserv_sep SET previsao='$previsao',coleta='$coleta',motorista='$motorista',placa='$placa',obs='$obs',status='$status' WHERE id='$id'");
	mysql_query("UPDATE vendas SET transportadora='$transportadora' WHERE id='$pedido'");
	$_SESSION["mensagem"]="Pedido de venda alterado com sucesso!";
	header("Location:prodserv_sep.php");
	exit;
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
<script>
<!--
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o Material');
		cad.nome.focus();
		return false;
	}
	return true;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">


  <tr>
    <td width="10" rowspan="3" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Separa&ccedil;&atilde;o</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
 <? if($acao=="entrar"){ ?>
  <tr>
    <td width="584" align="left" valign="top"><form name="form2" method="post" action="">
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#003366">
          <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Per&iacute;odo:</td>
          <td><input name="bde" type="text" class="formulario" id="bde2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= $bde; ?>" size="7" maxlength="10">
            &nbsp;&agrave;&nbsp;
            <input name="bate" type="text" class="formulario" id="bate2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= $bate; ?>" size="7" maxlength="10"></td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Pedido:</td>
          <td><input name="pedido" type="text" class="formulario" id="pedido" size="10" maxlength="10">
            &nbsp; &nbsp;&nbsp;&nbsp;</td>
        </tr>
        
        <tr class="textobold">
          <td width="106">&nbsp;Cod. Cliente :</td>
          <td width="164"><input name="produto" type="text" class="formulario" id="produto" size="10" maxlength="10">            &nbsp; &nbsp;&nbsp;&nbsp;</td></tr>
        <tr class="textobold">
          <td>&nbsp;Raz&atilde;o Social:</td>
          <td><input name="razao" type="text" class="formulario" id="razao" size="25"></td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Status: </td>
          <td><select name="status" id="status">
            <option value="">Selecione</option>
            <option value="1" <? if($res["status"]=="1") print "selected"; ?>>Aguardando Compras</option>
            <option value="4" <? if($res["status"]=="4") print "selected"; ?>>Em Separa&ccedil;&atilde;o</option>
            <option value="5" <? if($res["status"]=="5") print "selected"; ?>>Em Produ&ccedil;&atilde;o</option>
            <option value="6" <? if($res["status"]=="6") print "selected"; ?>>Agendado Entrega MKR</option>
            <option value="7" <? if($res["status"]=="7") print "selected"; ?>>Aguardando Transportadora</option>
            <option value="2" <? if($res["status"]=="2") print "selected"; ?>>Aguardando Correio</option>
            <option value="3" <? if($res["status"]=="3") print "selected"; ?>>Coletado</option>
            <option value="8" <? if($res["status"]=="8") print "selected"; ?>>Entregue</option>
          </select></td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;</td>
          <td><input name="Submit2" type="submit" class="microtxt" value="Buscar">
            <input name="buscar" type="hidden" id="buscar" value="true"></td>
        </tr>
      </table>
    </form>
      <br>  
      <table width="700" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="56">&nbsp;Pedido</td>
          <td width="70">Data</td>
          <td width="243"> &nbsp;&nbsp;Cliente </td>
          <td width="147">Vendedor</td>
          <td width="62">Previs&atilde;o</td>
          <td width="55">Status</td>
          <td width="18">&nbsp;</td>
          <td width="18">&nbsp;</td>
          <td width="21">&nbsp;</td>
        </tr>
        <?
			//print "SELECT prodserv_sep.pedido,prodserv_sep.id,vendas.emissao,prodserv_sep.cliente as codigo,clientes.nome,vendas.previsao,prodserv_sep.status,vendas.vendedor FROM prodserv_sep,clientes,vendas $where ORDER BY prodserv_sep.pedido ASC";
			  $sql=mysql_query("SELECT prodserv_sep.pedido,prodserv_sep.id,vendas.emissao,prodserv_sep.cliente as codigo,clientes.nome,vendas.previsao,prodserv_sep.status,vendas.vendedor,prodserv_sep.compra FROM prodserv_sep,clientes,vendas $where ORDER BY prodserv_sep.pedido ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="9" align="center" class="textobold">NENHUM REGISTRO ENCONTRADO          </td>
        </tr>
        <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
					$sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[vendedor]'");
					$res2=mysql_fetch_array($sql2);
					$st="";
					switch($res["status"]){
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
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td>&nbsp;<? print $res["pedido"]; ?></td>
          <td><? print banco2data($res["emissao"]); ?></td>
          <td>&nbsp;<a href="crm_infg.php?cli=<? print $res["codigo"]; ?>" class="texto"><? print $res["codigo"]." ".$res["nome"]; ?></a></td>
          <td align="left"><? print $res2["nome"]; ?></td>
          <td align="left"><? print banco2data($res["previsao"]); ?></td>
          <td align="left"><? print $st; ?></td>
          <td align="center"><a href="#" onClick="MM_openBrWindow('prodserv_sep_vis.php?id=<?= $res[id]; ?>','','scrollbars=yes,width=700,height=500');"><img src="imagens/icon14_imp.gif" width="15" height="15" border="0"></a></td>
          <td width="18" align="center"><a href="prodserv_sep.php?acao=alt&id=<?= $res[id]; ?>&pedido=<?= $res[pedido]; ?>&cp=<?= $res[compra]; ?>"><img src="imagens/icon14_alterar.gif" alt="Baixar" width="14" height="14" border="0"></a></td>
          <td width="21" align="center"><? if($res["status"]=="7" or $res["status"]=="9" or $res["status"]=="3" or $res["status"]=="8"){ ?><a href="prodserv_sep_sql.php?acao=baixa&id=<?= $res[id]; ?>&pedido=<?= $res[pedido]; ?>&cp=<?= $res[compra]; ?>"><img src="imagens/icon14_baixar.gif" alt="Baixar" width="16" height="16" border="0"></a><? } ?></td>
        </tr>
        <?
			  	}
			  }
			  ?>
      </table>    </td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="">
      <table width="350" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#003366">
          <td colspan="2" align="center" class="textoboldbranco">Alterar</td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Situa&ccedil;&atilde;o:</td>
          <td><select name="status" id="status">
		<option value="">Selecione</option>
		<option value="1" <? if($res["status"]=="1") print "selected"; ?>>Aguardando Compras</option>
		<option value="4" <? if($res["status"]=="4") print "selected"; ?>>Em Separação</option>
		<option value="5" <? if($res["status"]=="5") print "selected"; ?>>Em Produção</option>
		<option value="6" <? if($res["status"]=="6") print "selected"; ?>>Agendado Entrega MKR</option>
		<option value="7" <? if($res["status"]=="7") print "selected"; ?>>Aguardando Transportadora</option>
		<option value="2" <? if($res["status"]=="2") print "selected"; ?>>Aguardando Correio</option>
		<option value="9" <? if($res["status"]=="9") print "selected"; ?>>Aguardando Cliente</option>
		<option value="3" <? if($res["status"]=="3") print "selected"; ?>>Coletado</option>
		<option value="8" <? if($res["status"]=="8") print "selected"; ?>>Entregue</option>
                      </select>          </td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Previs&atilde;o:</td>
          <td><input name="previsao" type="text" class="formulario" id="previsao" value="<? print banco2data($res["previsao"]); ?>" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="10" maxlength="15">
            &nbsp; &nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Transportadora:
            <input name="transportadora" type="hidden" id="transportadora" value="<? print $res2["transportadora"]; ?>"></td>
          <td><input name="transp" type="text" class="formulario" id="transp" size="" readonly="" maxlength="30" value="<? $bd->pega_nome_bd("transportadora","nome",$res2["transportadora"],$idc="id"); ?>">
            <a href="#" onClick="return abre('vendas_trans.php','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" width="14" height="14" border="0"></a>            </td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;N&ordm; Coleta: </td>
          <td><input name="coleta" type="text" class="formulario" id="coleta" value="<? print $res["coleta"]; ?>" size="10" maxlength="10">
            &nbsp; &nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Motorista:</td>
          <td><input name="motorista" type="text" class="formulario" id="motorista" value="<? print $res["motorista"]; ?>" size="30">
            &nbsp; &nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Placa:</td>
          <td><input name="placa" type="text" class="formulario" id="placa" value="<? print $res["placa"]; ?>" size="10" maxlength="10">
            &nbsp; &nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td width="104">&nbsp;Obs:</td>
          <td width="246"><textarea name="obs" class="formularioselect" id="obs"><? print $res["obs"]; ?></textarea>         </td>
        </tr>
        <tr class="textobold">
          <td colspan="2" align="center"><input name="Submit22" type="submit" class="microtxt" value="Salvar">
              <input name="acao" type="hidden" id="acao" value="alterar">
              <input name="id" type="hidden" id="id" value="<? print $id; ?>">
            <input name="pedido" type="hidden" id="pedido" value="<? print $res["pedido"]; ?>"></td>
        </tr>
      </table>
        </form>    </td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <? } ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<? include("mensagem.php"); ?>