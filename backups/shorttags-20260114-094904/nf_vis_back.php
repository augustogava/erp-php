<?
include("conecta.php");
if(!isset($nf)) exit;
$hj=date("Y-m-d");
if($acao=="imp"){
	$sql=mysql_query("UPDATE vendas SET faturamento='1' WHERE id='$id'");
	$sql=mysql_query("UPDATE e_compra SET sit='F' WHERE id='$cp'");
//------------- Tirar estoque Total --------------
					$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$id'") or die("Naun foi");
					while($res=mysql_fetch_array($sql2)){
						if(!empty($res["produto"])){
							print $produto=$res["produto"];
								$pro=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
								$pror=mysql_fetch_array($pro);
							if(!($pror["tipo"]=="PL")){
								$qtd=$res["qtd"];
								$total=banco2valor($qtd*$res["unitario"]);
								$total=valor2banco($total);
								$unita=$res["unitario"];
									$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt FROM prodserv_est WHERE prodserv='$produto'") or die("Nao foi");
									$res1=mysql_fetch_array($sql1);
								if($res1["qtdt"]>0){
									$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,origem,tipomov) VALUES('$produto','$hj','$qtd','$unita','2','6')");
								}
							}
						}
					}
//------------- cabo Estoque --------------
		if($sql){
			$_SESSION["mensagem"]="Está em Faturamento!";
			$sql=mysql_query("UPDATE nf SET impresso='1' WHERE id='$nf'");
			print "<script>opener.location='nf.php';window.close();</script>";
			
		}else{
			$_SESSION["mensagem"]="Não pode ser imprimido!";
			$acao="inc";
		}
}
$sql=mysql_query("SELECT * FROM nf WHERE id='$nf'");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
if($res["cliente_tipo"]=="C"){
	$res["cliente_tipo"]="clientes";
}else{
	$res["cliente_tipo"]="fornecedores";
}

$sql2=mysql_query("SELECT fantasia,estado FROM $res[cliente_tipo] WHERE id='$res[cliente]'");
$res2=mysql_fetch_array($sql2);
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script language="JavaScript">
function imprimir(botao,id,cp,nf){
	var guarda=botao.src;
	botao.src='imagens/dot.gif';
	window.print();
	botao.src=guarda;
	if(confirm('Foi impresso corretamente')){
		window.location='nf_vis.php?acao=imp&id=' + id + '&cp=' + cp + '&nf=' + nf;
	}
	return false;
}
windowWidth=680;
windowHeight=500;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="textobold">
    <td colspan="5" class="titulos">NOTA FISCAL DE SAIDA </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="textobold">
    <td colspan="11"><img src="imagens/dot.gif" width="20" height="5"></td>
  </tr>
  <tr class="textobold">
    <td colspan="5">Remetente / Destinat&aacute;rio</td>
    <td width="5">&nbsp;</td>
    <td width="82">&nbsp;</td>
    <td width="69">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td width="74">&nbsp;</td>
  </tr>
  <tr class="textobold">
    <td colspan="7"><input name="nome" type="text" class="formularioselect" id="nome3" size="1" value="<? print $res2["fantasia"]; ?>" readonly></td>
    <td colspan="2" align="right">N&ordm;</td>
    <td colspan="2"><input name="numero" type="text" class="formularioselect" id="numero2" size="1" maxlength="6" value="<? print completa($res["numero"],6); ?>" readonly></td>
  </tr>
  <tr class="textobold">
    <td width="108">Opera&ccedil;&atilde;o</td>
    <td width="6">&nbsp;</td>
    <td width="84">&nbsp;</td>
    <td>&nbsp;</td>
    <td>Natureza</td>
    <td width="5">&nbsp;</td>
    <td width="82">&nbsp;</td>
    <td width="69">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="71">CFOP</td>
    <td width="74">&nbsp;</td>
  </tr>
  <tr class="textobold">
    <?
$sqlo=mysql_query("SELECT nome FROM opertab WHERE id='$res[operacao]'");
if(mysql_num_rows($sqlo)){
	$reso=mysql_fetch_array($sqlo);
}
?>
    <td colspan="3"><input type="text" name="operacao" class="formularioselect" id="operacao2" value="<? print $reso["nome"]; ?>" readonly>
    </td>
    <td>&nbsp;</td>
    <td colspan="4"><input name="natureza" type="text" class="formularioselect" id="natureza2" size="1" maxlength="100" value="<? print $res["natureza"]; ?>" readonly></td>
    <td width="5">&nbsp;</td>
    <td colspan="2"><input name="cfop" type="text" class="formularioselect" id="cfop2" size="1" maxlength="5" value="<? print $res["cfop"]; ?>" readonly></td>
  </tr>
  <tr align="right" class="textobold">
    <td colspan="11"><table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr class="textobold">
          <td width="84">Emiss&atilde;o</td>
          <td width="5">&nbsp;</td>
          <td width="90">Data de Entrada </td>
          <td width="5">&nbsp;</td>
          <td width="107">Hora de sa&iacute;da </td>
        </tr>
        <tr class="textobold">
          <td><input name="emissao" type="text" class="formularioselect" id="emissao2" size="1" maxlength="10" value="<? print banco2data($res["emissao"]); ?>" readonly></td>
          <td width="5">&nbsp;</td>
          <td><input name="dtes" type="text" class="formularioselect" id="dtes2" size="1" maxlength="10" value="<? print banco2data($res["dtes"]); ?>" readonly></td>
          <td width="5">&nbsp;</td>
          <td><input name="hs" type="text" class="formularioselect" id="hs2" size="1" maxlength="8" value="<? print $res["hs"]; ?>" readonly></td>
        </tr>
    </table></td>
  </tr>
  <?
$sqlp=mysql_query("SELECT * FROM nf_prod WHERE nota='$nf'");
if(mysql_num_rows($sqlp)){
?>
  <tr class="textobold">
    <td width="108">PRODUTOS</td>
    <td width="6">&nbsp;</td>
    <td width="84">&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td width="130">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="82">&nbsp;</td>
    <td width="69">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td width="74">&nbsp;</td>
  </tr>
  <tr class="textobold">
    <td colspan="11"><table width="640" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="22">cod</td>
          <td width="103">Descri&ccedil;&atilde;o</td>
          <td width="33">Unid.</td>
          <td width="56">Cl. Fiscal </td>
          <td width="51">Sit. Trib. </td>
          <td width="41">Qtd</td>
          <td width="48">Valor</td>
          <td width="38">ICMS</td>
          <td width="34">IPI</td>
          <td width="62">ICMS Sub.</td>
          <td width="38">Base</td>
          <td width="38">IR</td>
        </tr>
        <? 
while($resp=mysql_fetch_array($sqlp)){
?>
        <tr bgcolor="#FFFFFF" class="textobold">
          <td><input name="prodserv[]" type="text" class="formularioselectsemborda" id="prodserv[]" size="1" maxlength="6" value="<? print $resp["prodserv"]; ?>" readonly></td>
          <td width="103"><input name="pdescricao[]" type="text" class="formularioselectsemborda" id="pdescricao[]" size="1" maxlength="100" value="<? print $resp["descricao"]; ?>" readonly></td>
          <td width="33"><input name="punidade[]" type="text" class="formularioselectsemborda" id="punidade[]" size="1" maxlength="5" value="<? print $resp["unidade"]; ?>" readonly></td>
          <td width="56"><input name="pclafis[]" type="text" class="formularioselectsemborda" id="pclafis[]" size="1" maxlength="5" value="<? print $resp["clafis"]; ?>" readonly></td>
          <td width="51"><input name="psitri[]" type="text" class="formularioselectsemborda" id="psitri[]" size="1" maxlength="5" value="<? print $resp["sitri"]; ?>" readonly></td>
          <td width="41"><input name="pqtd[]" type="text" class="formularioselectsemborda" id="pqtd[]" size="1" value="<? print banco2valor($resp["qtd"]); ?>" readonly></td>
          <td width="48"><input name="punitario[]" type="text" class="formularioselectsemborda" id="punitario[]" size="1" value="<? print banco2valor($resp["unitario"]); ?>" readonly></td>
          <td width="38"><input name="picms[]" type="text" class="formularioselectsemborda" id="picms[]" size="1" value="<? print banco2valor($resp["icms"]); ?>" readonly></td>
          <td width="34"><input name="pipi[]" type="text" class="formularioselectsemborda" id="pipi[]" size="1" value="<? print banco2valor($resp["ipi"]); ?>" readonly></td>
          <td width="62"><input name="picmss[]" type="text" class="formularioselectsemborda" id="picmss[]" size="1" value="<? print banco2valor($resp["icmss"]); ?>" readonly></td>
          <td width="38"><input name="pbase[]" type="text" class="formularioselectsemborda" id="pbase[]" size="1" value="<? print banco2valor($resp["base"]); ?>" readonly></td>
          <td width="38"><input name="pir[]" type="text" class="formularioselectsemborda" id="pir[]" size="1" value="<? print banco2valor($resp["ir"]); ?>" readonly></td>
        </tr>
        <? } ?>
    </table></td>
  </tr>
  <? } ?>
  <tr class="textobold">
    <td width="108">SERVI&Ccedil;OS</td>
    <td width="6">&nbsp;</td>
    <td width="84">&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td width="130">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="82">&nbsp;</td>
    <td width="69">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td width="74">&nbsp;</td>
  </tr>
  <tr class="textobold">
    <td colspan="8" valign="top"><textarea name="servicos" rows="7" wrap="VIRTUAL" class="formularioselect" id="textarea" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["servicos"]; ?></textarea></td>
    <td colspan="3" valign="top"><table width="140"  border="0" align="right" cellpadding="0" cellspacing="0">
        <tr class="textobold">
          <td colspan="3">&nbsp;I.M</td>
        </tr>
        <tr class="textobold">
          <td colspan="3"><input name="im" type="text" class="formularioselect" id="im2" size="1" maxlength="20" value="<? print $res["im"]; ?>" readonly></td>
        </tr>
        <tr class="textobold">
          <td width="43%">&nbsp;%</td>
          <td width="12%">&nbsp;</td>
          <td width="45%">Val ISS </td>
        </tr>
        <tr class="textobold">
          <td><input name="issper" type="text" class="formularioselect" id="issper2" size="1" value="<? print banco2valor($res["issper"]); ?>" readonly></td>
          <td>&nbsp;</td>
          <td><input name="issval" type="text" class="formularioselect" id="issval2" size="1" value="<? print banco2valor($res["issval"]); ?>" readonly></td>
        </tr>
        <tr class="textobold">
          <td colspan="3">&nbsp;Total Servi&ccedil;os </td>
        </tr>
        <tr class="textobold">
          <td colspan="3"><input name="servicosval" type="text" class="formularioselect" id="servicosval2" size="1" value="<? print banco2valor($res["servicosval"]); ?>" readonly></td>
        </tr>
    </table></td>
  </tr>
  <tr class="textobold">
    <td colspan="4">C&aacute;lculo do Imposto</td>
    <td width="130">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="82">&nbsp;</td>
    <td width="69">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td width="74">&nbsp;</td>
  </tr>
  <tr class="textobold">
    <td width="108">Base ICMS </td>
    <td width="6">&nbsp;</td>
    <td width="84">Val ICMS </td>
    <td width="6">&nbsp;</td>
    <td width="130">Base ICMS subst </td>
    <td width="5">&nbsp;</td>
    <td colspan="2">Val ICMS subst </td>
    <td width="5">&nbsp;</td>
    <td colspan="2">Total Produtos </td>
  </tr>
  <tr class="textobold">
    <td width="108"><input name="baseicms" type="text" class="formularioselect" id="baseicms2" size="1" value="<? print banco2valor($res["baseicms"]); ?>" readonly></td>
    <td width="6">&nbsp;</td>
    <td width="84"><input name="valicms" type="text" class="formularioselect" id="valicms2" size="1" value="<? print banco2valor($res["valicms"]); ?>" readonly></td>
    <td width="6">&nbsp;</td>
    <td width="130"><input name="baseicmss" type="text" class="formularioselect" id="baseicmss2" size="1" value="<? print banco2valor($res["baseicmss"]); ?>" readonly></td>
    <td width="5">&nbsp;</td>
    <td colspan="2"><input name="valicmss" type="text" class="formularioselect" id="valicmss2" size="1" value="<? print banco2valor($res["valicmss"]); ?>" readonly></td>
    <td width="5">&nbsp;</td>
    <td colspan="2"><input name="produtos" type="text" class="formularioselect" id="produtos2" size="1" value="<? print banco2valor($res["produtos"]); ?>" readonly></td>
  </tr>
  <tr class="textobold">
    <td width="108">Frete</td>
    <td width="6">&nbsp;</td>
    <td width="84">Seguro</td>
    <td width="6">&nbsp;</td>
    <td width="130">Outras despesas </td>
    <td width="5">&nbsp;</td>
    <td colspan="2">Valor IPI </td>
    <td width="5">&nbsp;</td>
    <td colspan="2">Total da Nota </td>
  </tr>
  <tr class="textobold">
    <td width="108"><input name="frete" type="text" class="formularioselect" id="frete2" size="1" value="<? print banco2valor($res["frete"]); ?>" readonly></td>
    <td width="6">&nbsp;</td>
    <td width="84"><input name="seguro" type="text" class="formularioselect" id="seguro2" size="1" value="<? print banco2valor($res["seguro"]); ?>" readonly></td>
    <td width="6">&nbsp;</td>
    <td width="130"><input name="outros" type="text" class="formularioselect" id="outros2" size="1" value="<? print banco2valor($res["outros"]); ?>" readonly></td>
    <td width="5">&nbsp;</td>
    <td colspan="2"><input name="ipi" type="text" class="formularioselect" id="ipi2" size="1" value="<? print banco2valor($res["ipi"]); ?>" readonly></td>
    <td width="5">&nbsp;</td>
    <td colspan="2"><input name="total" type="text" class="formularioselect" id="total2" size="1" value="<? print banco2valor($res["total"]); ?>" readonly></td>
  </tr>
  <tr class="textobold">
    <td colspan="3" valign="bottom">Transportadora</td>
    <td width="6">&nbsp;</td>
    <td width="130" rowspan="2" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr>
          <td align="center" class="textoboldbranco">Frete por conta </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" class="textobold"><input name="fretepor" type="radio" value="1" <? if($res["fretepor"]=="1") print "checked";?>>
            1- remetente
              <br>
              <input name="fretepor" type="radio" value="2" <? if($res["fretepor"]=="2") print "checked"; ?>>
            2- destinat&aacute;rio </td>
        </tr>
    </table></td>
    <td width="5">&nbsp;</td>
    <td colspan="5" rowspan="2" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="textobold">
          <td width="27%">Placa</td>
          <td width="2%">&nbsp;</td>
          <td width="19%">UF</td>
          <td width="2%">&nbsp;</td>
          <td width="50%">CNPJ</td>
        </tr>
        <tr class="textobold">
          <td><input name="placa" type="text" class="formularioselect" id="placa2" size="1" maxlength="7" value="<? print $res["placa"]; ?>" readonly></td>
          <td>&nbsp;</td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
            <input type="text" name="placauf" class="formularioselect" id="placauf" value="<? print $res["placauf"]; ?>" readonly>
          </font></td>
          <td>&nbsp;</td>
          <td><input name="tcnpj" type="text" class="formularioselect" id="tcnpj2" size="1" maxlength="20" value="<? print $res["tcnpj"]; ?>" readonly></td>
        </tr>
    </table></td>
  </tr>
  <tr class="textobold">
    <td colspan="3" valign="top"><input name="transp" type="text" class="formularioselect" id="transp2" size="1" maxlength="100" value="<? print $res["transp"]; ?>" readonly></td>
    <td width="6">&nbsp;</td>
    <td width="5">&nbsp;</td>
  </tr>
  <tr class="textobold">
    <td colspan="3">Endere&ccedil;o</td>
    <td width="6">&nbsp;</td>
    <td colspan="4" rowspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="textobold">
          <td width="77%">Cidade</td>
          <td width="3%">&nbsp;</td>
          <td width="20%">UF</td>
        </tr>
        <tr class="textobold">
          <td><input name="tcid" type="text" class="formularioselect" id="tcid2" size="1" maxlength="30" value="<? print $res["tcid"]; ?>" readonly></td>
          <td>&nbsp;</td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
            <input type="text" name="tuf" class="formularioselect" id="tuf2" value="<? print $res["tuf"]; ?>" readonly>
          </font></td>
        </tr>
    </table></td>
    <td width="5">&nbsp;</td>
    <td colspan="2">I.E</td>
  </tr>
  <tr class="textobold">
    <td colspan="3"><input name="tend" type="text" class="formularioselect" id="tend2" size="1" maxlength="50" value="<? print $res["tend"]; ?>" readonly></td>
    <td width="6">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td colspan="2"><input name="tie" type="text" class="formularioselect" id="tie2" size="1" maxlength="20" value="<? print $res["tie"]; ?>" readonly></td>
  </tr>
  <tr class="textobold">
    <td width="108">Qtd</td>
    <td width="6">&nbsp;</td>
    <td width="84">Esp&eacute;cie</td>
    <td width="6">&nbsp;</td>
    <td width="130">Marca</td>
    <td width="5">&nbsp;</td>
    <td width="82">N&uacute;mero</td>
    <td colspan="4" rowspan="2" valign="middle"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr class="textobold">
          <td width="6">&nbsp;</td>
          <td width="104">Peso Bruto </td>
          <td width="5">&nbsp;</td>
          <td width="81">Peso L&iacute;quido </td>
        </tr>
        <tr class="textobold">
          <td width="6">&nbsp;</td>
          <td><input name="pbruto" type="text" class="formularioselect" id="pbruto2" size="1" value="<? print banco2valor($res["pbruto"]); ?>" readonly></td>
          <td width="5">&nbsp;</td>
          <td><input name="pliquido" type="text" class="formularioselect" id="pliquido2" size="1" value="<? print banco2valor($res["pliquido"]); ?>" readonly></td>
        </tr>
    </table></td>
  </tr>
  <tr class="textobold">
    <td><input name="qtd" type="text" class="formularioselect" id="qtd2" size="1" value="<? print banco2valor($res["qtd"]); ?>" readonly></td>
    <td>&nbsp;</td>
    <td><input name="especie" type="text" class="formularioselect" id="especie2" size="1" maxlength="20" value="<? print $res["especie"]; ?>" readonly></td>
    <td>&nbsp;</td>
    <td><input name="marca" type="text" class="formularioselect" id="marca2" size="1" maxlength="20" value="<? print $res["marca"]; ?>" readonly></td>
    <td>&nbsp;</td>
    <td><input name="tnum" type="text" class="formularioselect" id="tnum2" size="1" value="<? print banco2valor($res["tnum"]); ?>" readonly></td>
  </tr>
  <tr class="textobold">
    <td colspan="11">DADOS ADICIONAIS </td>
  </tr>
  <tr class="textobold">
    <td colspan="11"><textarea name="adicionais" rows="7" wrap="VIRTUAL" class="formularioselect" id="textarea2" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["adicionais"]; ?></textarea></td>
  </tr>
  <tr class="textobold">
    <td colspan="11">&nbsp;</td>
  </tr>
  <tr class="textobold">
    <td colspan="11" align="center"><a href="#"><img src="imagens/imprimir.gif" width="60" id="bot" name="bot" height="14" border="0" onClick="return imprimir(this,'<?= $res["pedido"]; ?>','<?= $res["compra"]; ?>','<?= $res["id"]; ?>')"></a></td>
  </tr>
</table>
</body>
</html>