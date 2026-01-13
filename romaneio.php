<?
include("conecta.php");
include("seguranca.php");
//Para os próximos Prog.:
//Boa sorte, isso aqui está muito complexo, muita gente mexeu e muitas ideias foram vindas e tiradas.. então sem nenhuma Regra e padrão
$bd=new set_bd;
if(empty($acao)) $acao="entrar";
$where="WHERE prodserv_sep.sit='P' AND vendas.id=prodserv_sep.pedido AND prodserv_sep.cliente=clientes.id AND prodserv_sep.status='2' ";
if($acao=="incluir"){
	$hj=date("Y-m-d");
	$sql=mysql_query("SELECT * FROM romaneio WHERE data='$hj'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
		$id_ro=$res["id"];
	}else{
		mysql_query("INSERT INTO romaneio (data) VALUES('$hj')");
		$sqla=mysql_query("SELECT MAX(id) as id FROM romaneio");
		$res=mysql_fetch_array($sqla);
		$id_ro=$res["id"];
	}
	foreach($sel as $key=>$valor){
		//Inlcuir nos Itens do Romaneio, atualizar o status da ordem de separacao para Coletado
		mysql_query("INSERT INTO romaneio_itens (romaneio,separacao) VALUES('$id_ro','$valor')");
		mysql_query("UPDATE prodserv_sep SET status='3' WHERE id='$valor'");
		$sel=mysql_query("SELECT * FROM prodserv_sep WHERE id='$valor'");
		$rsel=mysql_fetch_array($sel);
		$cp=$rsel["compra"];
		$pedido=$rsel["pedido"];
		$id=$rsel["id"];
		//GERAR NF
			$sql=mysql_query("SELECT * FROM prodserv_sep WHERE compra='$cp'");
		$res=mysql_fetch_array($sql); 
			$cli=$res["cliente"];
		$sqlp=mysql_query("SELECT id FROM vendas WHERE id='$res[pedido]'");
		$resp=mysql_fetch_array($sqlp);
			$pedido=$resp["id"];
		$sqlc=mysql_query("SELECT * FROM e_compra WHERE id='$cp'");
		$resc=mysql_fetch_array($sqlc);
		$pagamento=$resc["pagamento"];
		$sqls=mysql_query("SELECT * FROM prodserv_sep_list WHERE est='$id' and sit='5'");
		while($ress=mysql_fetch_array($sqls)){
			$sqle=mysql_query("SELECT SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE prodserv='$ress[prodserv]'");
			$rese=mysql_fetch_array($sqle);
			if($rese["qtdd"]<=0){ 
				//$passar="n"; 
			}
		}
		if(!$passar=="n"){
			//
			//
			//se for boleto
			//
			//
			$sql=mysql_query("SELECT * FROM prodserv_ordem WHERE compra='$cp' AND sit='A'");
			$sqla=mysql_query("UPDATE e_compra SET sit='F' WHERE id='$cp'");
	//		if(!mysql_num_rows($sql)){
			if($pagamento=="boleto"){
					$sqlb=mysql_query("UPDATE prodserv_sep SET sit='S' WHERE id='$id'");
				//------------- Tirar estoque Total --------------
							$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$pedido'") or die("Naun foi");
							while($res=mysql_fetch_array($sql2)){
								if(!empty($res["produto"])){
										$produto=$res["produto"];
										$pro=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
										$pror=mysql_fetch_array($pro);
									if(!($pror["tipo"]=="SM")){
										$qtd=$res["qtd"];
										$total=banco2valor($qtd*$res["unitario"]);
										$total=valor2banco($total);
										$unita=$res["unitario"];
											$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt FROM prodserv_est WHERE prodserv='$produto'") or die("Nao foi");
											$res1=mysql_fetch_array($sql1);
										if($res1["qtdt"]>0 and empty($pror["porta"]) and empty($pror["cortina"])){
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,origem,tipomov) VALUES('$produto','$hj','$qtd','$unita','2','6')");
										}
									}else{
										$dado=explode("X",$res["medidas"]);
										$altura=$dado[0];
										$largura=$dado[1];
										$qtdit=$altura*$largura;
										$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$produto','$hj','$qtdit','2','6')");
	
									}
								}
						}
			//
			//
			//se for faturamento
			//
			//
			}else{
					$sqlc=mysql_query("select * from vendas WHERE pedido='$cp'"); $resc=mysql_fetch_array($sqlc); $natureza=$resc["natureza"];
					$sql=mysql_query("UPDATE prodserv_sep SET sit='S' WHERE id='$id'");
					//AQUI GERA A NF --------=========>>>
									$sql=mysql_query("SELECT MAX(numero) AS numero FROM nf");
									$res=mysql_fetch_array($sql);
										$numero=$res[numero]+1;
									$sql=mysql_query("INSERT INTO nf(numero,pedido,compra,cliente,cliente_tipo,es,emissao,natureza,cfop,fatura,vis) VALUES('$numero','$pedido','$cp','$cli','C','S','$hj','$natureza','','','S')") or die("nao foi");
										$sql=mysql_query("SELECT MAX(id) AS idn FROM nf");
										$res=mysql_fetch_array($sql);
			
										$pro=mysql_query("SELECT * FROM e_itens WHERE compra='$cp' and produto_id<>0") or die("Erro 1");
										$i=1;
											while($resp=mysql_fetch_array($pro)){
												$pro2=mysql_query("SELECT * FROM prodserv WHERE id='$resp[produto_id]'") or die("primeiro");
													$resp2=mysql_fetch_array($pro2);
												$sql=mysql_query("INSERT INTO nf_prod(nota,prodserv,codigo,unitario,descricao,qtd) VALUES('$res[idn]','$resp[produto_id]','$resp2[codprod]','$resp[produto_preco]','$resp2[desc_curta]','$resp[qtd]')") or die("segundo");
											}
				}
					/*
			}else{
				$_SESSION["mensagem"]="Exite itens na ordem de produção!";
				header("Location:prodserv_ordem.php");
					exit;
			}*/
		}else{
			$_SESSION["mensagem"]="Exite produtos aguardando compras nessa ordem!";
			header("Location:prodserv_oc.php");
			exit;
		}
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
<table width="600" border="0" cellpadding="0" cellspacing="0">


  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Romaneio</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
 <? if($acao=="entrar"){ ?>
  <tr>
    <td width="584" align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="romaneio.php?acao=add"><span class="textobold">Incluir Ordens de Separa&ccedil;&atilde;o no Romaneio de Hoje</span></a> <br>
      <table width="350" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="109">N&uacute;mero</td>
            <td width="506">Data</td>
            <td width="15">&nbsp;</td>
        </tr>
        <?
			//print "SELECT prodserv_sep.pedido,prodserv_sep.id,vendas.emissao,prodserv_sep.cliente as codigo,clientes.nome,vendas.previsao,prodserv_sep.status,vendas.vendedor FROM prodserv_sep,clientes,vendas $where ORDER BY prodserv_sep.pedido ASC";
			  $sql=mysql_query("SELECT * FROM romaneio ORDER By data DESC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="3" align="center" class="textobold">NENHUM REGISTRO ENCONTRADO          </td>
        </tr>
        <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td>&nbsp;<? print $res["id"]; ?></td>
            <td><? print banco2data($res["data"]); ?></td>
            <td align="center"><a href="#" onClick="MM_openBrWindow('romaneio_vis.php?id=<?= $res[id]; ?>','','scrollbars=yes,width=700,height=500');"><img src="imagens/icon14_imp.gif" width="15" height="15" border="0"></a></td>
        </tr>
        <?
			  	}
			  }
			  ?>
      </table>    </td></tr>
  <? }else{ ?>
  <form name="form1" method="post" action="">
  <tr>
    <td align="center" valign="top">
      <table width="600" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="59">&nbsp;Pedido</td>
          <td width="74">Data</td>
          <td width="255">&nbsp;&nbsp;Cliente </td>
          <td width="154">Vendedor</td>
          <td width="65">Previs&atilde;o</td>
          <td width="62">Status</td>
          <td width="23">&nbsp;</td>
        </tr>
        <?
			//print "SELECT prodserv_sep.pedido,prodserv_sep.id,vendas.emissao,prodserv_sep.cliente as codigo,clientes.nome,vendas.previsao,prodserv_sep.status,vendas.vendedor FROM prodserv_sep,clientes,vendas $where ORDER BY prodserv_sep.pedido ASC";
			  $sql=mysql_query("SELECT prodserv_sep.pedido,prodserv_sep.id,vendas.emissao,prodserv_sep.cliente as codigo,clientes.nome,vendas.previsao,prodserv_sep.status,vendas.vendedor FROM prodserv_sep,clientes,vendas $where ORDER BY prodserv_sep.pedido ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF">
          <td colspan="7" align="center" class="textobold">NENHUM REGISTRO ENCONTRADO </td>
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
					}
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td>&nbsp;<? print $res["pedido"]; ?></td>
          <td><? print banco2data($res["emissao"]); ?></td>
          <td>&nbsp;<a href="crm_infg.php?cli=<? print $res["codigo"]; ?>" class="texto"><? print $res["codigo"]." ".$res["nome"]; ?></a></td>
          <td align="left"><? print $res2["nome"]; ?></td>
          <td align="left"><? print banco2data($res["previsao"]); ?></td>
          <td align="left"><? print $st; ?></td>
          <td width="23" align="center"><input type="checkbox" name="sel[]" value="<?= $res["id"]; ?>"></td>
        </tr>
        <?
			  	}
			  }
			  ?>
      </table>
        <p>
          <input name="acao" type="hidden" id="acao" value="incluir">
          <input name="Submit" type="submit" class="microtxt" value="Incluir">
        </p>    </td>
  </tr>   </form>
  <? } ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<? include("mensagem.php"); ?>