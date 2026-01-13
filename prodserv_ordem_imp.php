<?
include("conecta.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Ordem Separação Imp.";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="imp"){
	$sql=mysql_query("UPDATE prodserv_sep_list,prodserv_ordem SET prodserv_sep_list.sit='2' WHERE prodserv_sep_list.pedido='$pedido' AND prodserv_sep_list.prodserv=$id");
	if($sql){
		$_SESSION["mensagem"]="Baixa com Sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="Não pode ser dado Baixa!";
	}
			print "<script>opener.location='prodserv_ordem.php';window.close();</script>";

}
$sql=mysql_query("SELECT * FROM prodserv_ordem WHERE id='$id'");
$res=mysql_fetch_array($sql);
$sql2=mysql_query("SELECT * FROM e_compra WHERE id='$res[compra]'");
	$sql3=mysql_query("SELECT * FROM prodserv WHERE id='$res[prodserv]'");
$res2=mysql_fetch_array($sql2);
	$res3=mysql_fetch_array($sql3);
?>
<html>
<head>
<title>Ordem Produ&ccedil;&atilde;o</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--

function imprimir(botao,id,id2){
	var guarda=botao.src;
	botao.src='imagens/dot.gif';
	window.print();
	botao.src=guarda;
	window.location='prodserv_ordem_imp.php?acao=imp&pedido='+id+'&id='+id2;
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
-->
</style></head>

<body>
<table width="700" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td colspan="4" align="center" class="titulos"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="27%" align="center"><img src="imagens/logoesi.gif" width="52" height="53"></td>
        <td width="73%" align="left" class="titulos">Ordem de Produ&ccedil;&atilde;o </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="titulos">&nbsp;</td>
  </tr>
  <tr>
    <td width="187" align="left"><strong>Pedido: </strong><?= $res["compra"]; ?></td>
    <td width="183"><strong>Data:</strong> <?= banco2data($res2["data"]); ?></td>
    <td width="159"><strong>Hora:</strong> <?= $res2["hora"]; ?></td>
    <td width="171"><strong>Previs&atilde;o Entrega:</strong><? if(!empty($res["previsao"])){ print $res3["prazo_entrega"]; } ?> Dias </td>
  </tr>
  <tr>
    <td colspan="4" align="right"><hr class="texto"></td>
  </tr>
  <tr align="left">
    <td colspan="4">
	<? if(empty($res3["porta"]) and empty($res3["cortina"]) and empty($res3["cortina_not"])){ ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="61">&nbsp;C&oacute;digo</td>
        <td width="212"> Descri&ccedil;&atilde;o </td>
        <td width="75" align="left">Tamanho</td>
        <td width="38" align="left">Qtde</td>
        <td width="38" align="left">Un</td>
        <td width="134" align="left">Material</td>
        <td width="134" align="left">Fixa&ccedil;&atilde;o</td>
      </tr>

      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $res3["codprod"]; ?></td>
        <td>&nbsp;<? print $res3["nome"]; ?></td>
        <td align="left">&nbsp;<? print $res["tamanho"]; ?></td>
        <td width="38" align="left"> &nbsp;<? print $res["qtd"]; ?></td>
        <td width="38" align="left">&nbsp;<? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$res3[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?></td>
        <td width="134" align="left">&nbsp;<? print $res["material"]; ?></td>
        <td width="134" align="left">&nbsp;<? print $res["fixacao"]; ?></td>
      </tr>
    </table>
	<? }else if(!empty($res3["porta"])){ ?><br>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="50">&nbsp;Qtd</td>
        <td width="390"> Produto </td>
        <td width="121" align="left">Unidade</td>
        <td width="61" align="left">Altura</td>
        <td width="72" align="left">Largura</td>
        </tr>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $res["qtd"]; ?></td>
        <td>&nbsp;<? print $res3["nome"]; ?></td>
        <td align="left">&nbsp;
          <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$res3[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?></td>
        <td width="61" align="left">&nbsp;<? $dado=explode("X",$res["tamanho"]);
		$altura=$dado[0];
		$largura=$dado[1]; print banco2valor($altura); ?></td>
        <td width="72" align="left">&nbsp;<? print banco2valor($largura); ?></td>
        </tr>
    </table>
    <br>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="51"> Qtd </td>
        <td width="83">&nbsp;Unidade</td>
        <td width="114" align="left">C&oacute;digo</td>
        <td width="347" align="left">Descri&ccedil;&atilde;o</td>
        <td width="99" align="center">Qtd utilizada </td>
        </tr>
		<? 
		//Porta, calculo
		$dado=explode("X",$res["tamanho"]);
		$altura=$dado[0];
		$largura=$dado[1];
			$sqlp=mysql_query("SELECT * FROM portasp WHERE id='$res3[porta]'");
			$resp=mysql_fetch_array($sqlp);
				$porta=$res3[porta];
				$csid=$resp["pvc_superior"];
				$ciid=$resp["pvc_inferior"];
				$crid=$resp["pvc_cristal"];
			
			$sqlp2=mysql_query("SELECT * FROM perfil WHERE id='$resp[perfil]'");
			$resp2=mysql_fetch_array($sqlp2);
				$perfilid=$resp2["perfil"];

				$cs=pvccs($porta,$largura,$altura);
				$ci=pvcci($porta,$largura,$altura);
				$cr=pvccr($porta,$largura,$altura);
				$perfil=perfil($resp["perfil"],$largura,$altura);
		//
		$sqli=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$res[prodserv]'"); while($resi=mysql_fetch_array($sqli)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$resi[item]'"); $resp=mysql_fetch_array($sqlp);
		 ?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $resi["qtd"]*$res["qtd"]; ?></td>
        <td>&nbsp;
          <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
        <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
        <td width="347" align="left">&nbsp;<? print $resp["nome"]; ?></td>
        <td width="99" align="center"> ___________</td>
        </tr>
		<?
		} if(!empty($cs)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$csid'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $cs*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
			<td width="347" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="99" align="center">___________</td>
		</tr>
		<?
		} if(!empty($ci)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$ciid'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $ci*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
			<td width="347" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="99" align="center">___________</td>
		</tr>
	<?
		} if(!empty($cr)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$crid'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $cr*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
			<td width="347" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="99" align="center">___________</td>
		</tr>
		<?
		} if(!empty($perfil)){
	
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$perfilid'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $perfil*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
			<td width="347" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="99" align="center">___________</td>
		</tr>
		<? } ?>
    </table>
	<? }else if(!empty($res3["cortina"])){ ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="49">&nbsp;Qtd</td>
        <td width="391"> Produto </td>
        <td width="121" align="left">Unidade</td>
        <td width="61" align="left">Altura</td>
        <td width="72" align="left">Largura</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $res["qtd"]; ?></td>
        <td>&nbsp;<? print $res3["nome"]; ?></td>
        <td align="left">&nbsp;
            <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$res3[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?></td>
        <td width="61" align="left">&nbsp;
            <? $dado=explode("X",$res["tamanho"]);
		$altura=$dado[0];
		$largura=$dado[1]; print banco2valor($altura); ?></td>
        <td width="72" align="left">&nbsp;<? print banco2valor($largura); ?></td>
      </tr>
    </table>
	<br>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="51"> Qtd </td>
        <td width="82">&nbsp;Unidade</td>
        <td width="114" align="left">C&oacute;digo</td>
        <td width="346" align="left">Descri&ccedil;&atilde;o</td>
        <td width="101" align="center">Qtd utilizada</td>
        </tr>
		<? 
		//Porta, calculo
		$dado=explode("X",$res["tamanho"]);
		$altura=$dado[0];
		$largura=$dado[1];
			$sqlp=mysql_query("SELECT * FROM cortinas WHERE id='$res3[cortina]'");
			$resp=mysql_fetch_array($sqlp);
				$cortina=$res3[cortina];
				//Ids do prodserv de cada item
				$trilho=$resp["trilho"];
				$pvc=$resp["pvc"];
				$arrebites=$resp["arrebites"];
				$parafusos=$resp["parafusos"];
				$buchas=$resp["buchas"];
				$penduralg=$resp["penduralg"];
				$penduralp=$resp["penduralp"];
			
				$a=cortinas($largura,$altura);
		//
		$sqli=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$res[prodserv]'"); while($resi=mysql_fetch_array($sqli)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$resi[item]'"); $resp=mysql_fetch_array($sqlp);
		 ?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $resi["qtd"]*$res["qtd"]; ?></td>
        <td>&nbsp;
          <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
        <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
        <td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
        <td width="101" align="center">&nbsp;____________</td>
        </tr>
		<?
		} if(!empty($trilho)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$trilho'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $a["trilho"]*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
			<td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="101" align="center">____________</td>
		</tr>
		<?
		} if(!empty($pvc)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$pvc'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $a["pvc"]*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<?  print $resp["codprod"]; ?></td>
			<td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="101" align="center">____________</td>
		</tr>
		<?
		} if(!empty($arrebites)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$arrebites'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $a["arrebites"]*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
			<td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="101" align="center">____________</td>
		</tr>
		<?
		} if(!empty($parafusos)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$parafusos'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $a["parafusos"]*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
			<td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="101" align="center">____________</td>
		</tr>
			<?
		} if(!empty($buchas)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$buchas'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $a["buchas"]*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"];  ?></td>
			<td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="101" align="center">____________</td>
		</tr>
			<?
		} if(!empty($penduralg)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$penduralg'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $a["penduralg"]*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"];  ?></td>
			<td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="101" align="center">____________</td>
		</tr>
		<?
		} if(!empty($penduralp)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$penduralp'"); $resp=mysql_fetch_array($sqlp);
		?>
		
		 <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
		   <td>&nbsp;<? print $a["penduralp"]*$res["qtd"]; ?></td>
			<td>&nbsp;
			  <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?> </td>
			<td align="left">&nbsp;<? print $resp["codprod"];  ?></td>
			<td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
			<td width="101" align="center">____________</td>
		</tr>
		<? } ?>
    </table>
	<? }else if(!empty($res3["cortina_not"])){ ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="49">&nbsp;Qtd</td>
        <td width="391"> Produto </td>
        <td width="121" align="left">Unidade</td>
        <td width="61" align="left">Altura</td>
        <td width="72" align="left">Largura</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $res["qtd"]; ?></td>
        <td>&nbsp;<? print $res3["nome"]; ?></td>
        <td align="left">&nbsp;
            <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$res3[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?></td>
        <td width="61" align="left">&nbsp;
            <? $dado=explode("X",$res["tamanho"]);
		$altura=$dado[0];
		$largura=$dado[1]; print banco2valor($altura); ?></td>
        <td width="72" align="left">&nbsp;<? print banco2valor($largura); ?></td>
      </tr>
    </table>
    <br>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr class="textoboldbranco">
        <td width="51"> Qtd </td>
        <td width="82">&nbsp;Unidade</td>
        <td width="114" align="left">C&oacute;digo</td>
        <td width="346" align="left">Descri&ccedil;&atilde;o</td>
        <td width="101" align="center">Qtd utilizada</td>
      </tr>
      <? 
		//Porta, calculo
		$dado=explode("X",$res["tamanho"]);
		$altura=$dado[0];
		$largura=$dado[1];
			$sqlp=mysql_query("SELECT * FROM cortinas_not WHERE id='$res3[cortina_not]'");
			$resp=mysql_fetch_array($sqlp);
				$cortina=$res3[cortina];
				//Ids do prodserv de cada item
				$tubo=$resp["tubo"];
				$perfil1=$resp["perfil1"];
				$perfil2=$resp["perfil2"];
			
		//
		$sqli=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$res[prodserv]'"); while($resi=mysql_fetch_array($sqli)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$resi[item]'"); $resp=mysql_fetch_array($sqlp);
		 ?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $resi["qtd"]*$res["qtd"]; ?></td>
        <td>&nbsp;
            <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>        </td>
        <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
        <td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
        <td width="101" align="center">&nbsp;____________</td>
      </tr>
      <?
		} if(!empty($tubo)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$tubo'"); $resp=mysql_fetch_array($sqlp);
		?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $largura*$res["qtd"]; ?></td>
        <td>&nbsp;
            <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>        </td>
        <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
        <td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
        <td width="101" align="center">____________</td>
      </tr>
      <?
		} if(!empty($perfil1)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$perfil1'"); $resp=mysql_fetch_array($sqlp);
		?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $largura*$res["qtd"]; ?></td>
        <td>&nbsp;
            <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>        </td>
        <td align="left">&nbsp;
            <?  print $resp["codprod"]; ?></td>
        <td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
        <td width="101" align="center">____________</td>
      </tr>
      <?
		} if(!empty($perfil2)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$perfil2'"); $resp=mysql_fetch_array($sqlp);
		?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td>&nbsp;<? print $largura*$res["qtd"]; ?></td>
        <td>&nbsp;
            <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>        </td>
        <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
        <td width="346" align="left">&nbsp;<? print $resp["nome"]; ?></td>
        <td width="101" align="center">____________</td>
      </tr>
      <?
		} if(!empty($parafusos)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$parafusos'"); $resp=mysql_fetch_array($sqlp);
		?>

      <?
		} if(!empty($buchas)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$buchas'"); $resp=mysql_fetch_array($sqlp);
		?>

      <?
		} if(!empty($penduralg)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$penduralg'"); $resp=mysql_fetch_array($sqlp);
		?>

      <?
		} if(!empty($penduralp)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$penduralp'"); $resp=mysql_fetch_array($sqlp);
		?>

      <? } ?>
    </table>
    <? } ?></td>
  </tr>
  <tr align="center">
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Obs: <?= $res["obs"]; ?> </td>
  </tr>
  <tr align="center">
    <td colspan="4"><a href="#"><img src="imagens/imprimir.gif" width="60" id="bot" name="bot" height="14" border="0" onClick="return imprimir(this,'<?= $res["pedido"]; ?>','<?= $res["prodserv"]; ?>')"></a></td>
  </tr>
</table>
</body>
</html>
