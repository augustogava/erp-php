]<?
include("conecta.php");
include("seguranca.php");
$bd=new set_bd;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Status Pedido";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
$sql=mysql_query("SELECT * FROM cliente_entrega WHERE cliente='$cli'");
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
    <td align="center" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0"></div></td>
        <td width="563" align="right"><div align="left"><span class="chamadas"><span class="titulos">Log&iacute;stica</span></span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>

        <table width="99%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F7FFE8">
          <tr>
            <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td class="menu">Endere&ccedil;o Entrega</td>
              </tr>
              <tr>
                <td><strong>Endere&ccedil;o:</strong> <? print $res["endereco"]." ".$res["numero"]; ?></td>
              </tr>
              <tr>
                <td><strong>Bairro:</strong> <? print $res["bairro"]; ?></td>
              </tr>
              <tr>
                <td><strong>CEP:</strong> <? print $res["cep"]; ?></td>
              </tr>
              <tr>
                <td><strong>Cidade:</strong> <? print $res["cidade"]; ?></td>
              </tr>
              <tr>
                <td><strong>Estado:</strong> <? $bd->pega_nome_bd("estado","nome",$res["estado"]);  ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td class="menu">Endere&ccedil;o Instala&ccedil;&atilde;o</td>
              </tr>
              <tr>
                <td><strong>Endere&ccedil;o:</strong> <? print $res["endereco_ins"]; ?></td>
              </tr>
              <tr>
                <td><strong>Bairro:</strong> <? print $res["bairro_ins"]; ?></td>
              </tr>
              <tr>
                <td><strong>CEP:</strong> <? print $res["cep_ins"]; ?></td>
              </tr>
              <tr>
                <td><strong>Cidade:</strong> <? print $res["cidade_ins"]; ?></td>
              </tr>
              <tr>
                <td><strong>Estado:</strong> <? $bd->pega_nome_bd("estado","nome",$res["estado_ins"]); ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td width="639" align="left" bgcolor="#FFFFFF">
			
			<table width="600" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366" class="texto">
			<?
			$sql=mysql_query("SELECT * FROM e_compra WHERE cliente='$cli' ORDER By id DESC");
			if(!mysql_num_rows($sql)){
			?>
				 <tr bgcolor="#FFFFFF" class="texto">
                    <td colspan="8" align="center" class="textobold">NENHUM PEDIDO</td>
                  </tr>
			<? }else{ ?>	  
                  <tr class="textoboldbranco">
                    <td width="40" align="center" class="menuesq">Pedido</td>
                    <td width="70" align="center" class="menuesq"><strong>Data</strong></td>
                    <td width="64" align="center" class="menuesq">Situa&ccedil;&atilde;o</td>
                    <td width="64" align="center" class="menuesq">Previs&atilde;o</td>
                    <td width="134" align="left" class="menuesq"><strong>Transportadora</strong></td>
                    <td width="72" align="center" class="menuesq"><strong>N. Coleta </strong></td>
                    <td width="72" align="left" class="menuesq">Data Nf </td>
                    <td width="75" align="left" class="menuesq"><strong>Nota Fiscal </strong></td>
                  </tr>
				<? 
				while($res=mysql_fetch_array($sql)){
					$sqlp=mysql_query("SELECT * FROM prodserv_sep WHERE compra='$res[id]'");
					$resp=mysql_fetch_array($sqlp);
					if(mysql_num_rows($sqlp)){
						//venda
						$sql2=mysql_query("SELECT * FROM vendas WHERE id='$resp[pedido]'");
						$res2=mysql_fetch_array($sql2);
						//Nota Fiscal
						$sql3=mysql_query("SELECT * FROM nf WHERE pedido='$resp[pedido]'");
						$res3=mysql_fetch_array($sql3);
						$st=0;
						switch($resp["status"]){
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
                    <td align="center"><span class="texto_preto"><? print $res["pedido"] ?></span></td>
                    <td align="center">&nbsp;<? print banco2data($resp["emissao"]); ?></td>
                    <td align="center"><span class="texto_preto"><? print $st; ?></span></td>
                    <td align="center"><span class="texto_preto"><? print banco2data($resp["previsao"]); ?> </span></td>
                    <td align="left" > &nbsp;<span class="texto_preto"><? $bd->pega_nome_bd("transportadora","nome",$res2["transportadora"],$idc="id"); ?></span></td>
                    <td align="center"><span class="texto_preto"><? print $resp["coleta"]; ?></span></td>
                    <td align="left" ><span class="texto_preto"><? print banco2data($res3["emissao"]); ?></span></td>
                    <td align="left" >&nbsp;<span class="texto_preto"><? print $res3["numero"]; ?></span>&nbsp;</td>
                  </tr>
				  <? } } } ?>
              </table>			    </td>
          </tr>
        </table>
   
          <br>
          <input name="voltar" type="button" class="microtxt" id="voltar" value="Voltar" onClick="history.go(-1)" />
    </p>    </td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>