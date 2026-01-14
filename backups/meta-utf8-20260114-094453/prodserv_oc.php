<?
include("conecta.php");
include("seguranca.php");
if($buscar){
	unset($wp);
}
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Estoque Mínimo";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
$busc="WHERE 1";
if(!empty($item)){
	$busc.=" AND id='$item' ";
}
if($acao=="venda"){
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO compras (emissao) VALUES ('$hj')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM compras");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("INSERT INTO compras_list (compra,produto,qtd) VALUES ('$id','$produto','1')");
	header("Location:compras.php?acao=alt&id=$id");
	exit;
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.bde.value!='' || cad.bate.value!=''){
		if(!verifica_data(cad.bde.value)){
			alert('Período incorreto');
			cad.bde.focus();
			return false;
		}
		if(!verifica_data(cad.bate.value)){
			alert('Período incorreto');
			cad.bate.focus();
			return false;
		}
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Relat&oacute;rios</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="imagens/dot.gif" width="100" height="5"></td>
  </tr>
  <tr><td><form name="form1" method="post" action="" onSubmit="return verifica(this);">
    <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr>
        <td bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
            </tr>
            <tr class="textobold">
              <td width="63">&nbsp;Produto:</td>
              <td width="217"><input name="nome" type="text" class="formularioselect" id="nome3" size="7" maxlength="50" readonly></td>
              <td width="20" align="center"><a href="#" onClick="return abre('prodserv_bus2.php','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
            </tr>
            <tr class="textobold">
              <td colspan="3"><img src="imagens/dot.gif" width="100" height="5"></td>
            </tr>
            <tr class="textobold">
              <td colspan="3" align="center"><input name="Submit2" type="submit" class="microtxt" value="Buscar">
              <input name="buscar" type="hidden" id="buscar" value="true">
                <input name="item" type="hidden" id="item"></td>
            </tr>
            <tr class="textobold">
              <td colspan="3" align="center"><img src="imagens/dot.gif" width="100" height="5"></td>
            </tr>
        </table></td>
      </tr>
    </table>
  </form></td></tr>
  <tr>
    <td align="left" valign="top"><table width="519" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="53">C&oacute;digo</td>
        <td width="255">&nbsp;Produto</td>
        <td width="139">Saldo Dispon&iacute;vel </td>
        <td width="124">Saldo </td>
        <td width="124">Estoque M&iacute;nimo </td>
        <td width="17" align="center">&nbsp;</td>
      </tr>
      <?
$sql=mysql_query("SELECT * FROM prodserv $busc ORDER BY id ASC");
if(!mysql_num_rows($sql)){
?>
      <tr bgcolor="#FFFFFF" class="texto">
        <td colspan="6" align="center" class="textobold">NENHUM PRODUTO </td>
      </tr>
      <?
}else{
	//BLOCO PAGINACAO
	$results_tot=mysql_num_rows($sql); //total de registros encontrados
	$maxpag=15; //numero maximo de resultados por pagina
	if($results_tot>$maxpag){
		$wpaginar=true;
		if(!isset($wp)){
			$param=0;
			$temp=0;
			$wp=0;
		}else{
			$temp = $wp;
			$passo1 = $temp - 1;
			$passo2 = $passo1*$maxpag;
			$param  = $passo2;				
		}
		$sql=mysql_query("SELECT * FROM prodserv $busc ORDER BY id ASC");
		$results_parc=mysql_num_rows($sql);
		$result_div=$results_tot/$maxpag;
		$n_inteiro=(int)$result_div;
		if($n_inteiro<$result_div){
			$n_paginas=$n_inteiro+1;
		}else{
			$n_paginas=$result_div;
		}
		$pg_atual=$param/$maxpag+1;
		$reg_inicial=$param+1;
		$pg_anterior=$pg_atual-1;
		$pg_proxima=$pg_atual+1;
		$reg_final=$param;
	}
	// BLOCO PAGINACAO
	while($res=mysql_fetch_array($sql)){
		$reg_final++; // PAGINACAO conta quantos registros imprimiu

		$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt, SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE prodserv='$res[id]'");
		$res1=mysql_fetch_array($sql1);
			if(((($res["min"]==0) and ($res1["qtdd"]<0)) or (($res["min"]>"0") and ($res["min"]<$res1["qtdt"]))) and !($res["tipo"]=="PL")){
?>
      <tr bgcolor="#FFFFFF" class="texto">
        <td width="53">&nbsp;<? print $res["codprod"]; ?></td>
        <td width="255">&nbsp;<? print $res["nome"]; ?></td>
        <td width="139">&nbsp;<? print $res1["qtdd"] ?></td>
        <td width="124"><? print $res1["qtdt"] ?></td>
        <td width="124">&nbsp;<? print $res["min"]; ?></td>
        <td width="17" align="center"><a href="prodserv_oc.php?acao=venda&produto=<?= $res["id"]; ?>"><img src="imagens/icon14_dollar.gif" alt="Gerar Venda" width="14" height="14" border="0"></a></td>
      </tr>
      <?
			}
	}
}
?>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top"><? if($wpaginar) { ?>
    <? } ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>