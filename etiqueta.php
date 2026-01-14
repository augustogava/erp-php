<?php
include("conecta.php");
include("seguranca.php");
$bd=new set_bd();
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Status Pedido";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="verificar"){
			$sql=mysql_query("SELECT * FROM e_compra WHERE pedido='$pedidon'");
			if(mysql_num_rows($sql)){
				$res=mysql_fetch_array($sql);
				$cp=$res["id"];
				header("Location:etiqueta.php?acao=ver&cp=$cp");
			}else{
				$_SESSION["mensagem"]="Pedido não encontrado!!";
				header("Location:etiqueta.php?acao=entrar");
				exit;
			}
}elseif($acao=="ver"){
	 $sql=mysql_query("SELECT cliente_entrega.*,clientes.nome,e_compra.pedido as ped FROM e_compra,cliente_entrega,clientes WHERE e_compra.id='$cp' AND e_compra.cliente=cliente_entrega.cliente AND clientes.id=cliente_entrega.cliente");
	$resp=mysql_fetch_array($sql);
	$nfa=mysql_query("SELECT numero FROM nf WHERE pedido='$resp[ped]'");
	$rnf=mysql_fetch_array($nfa);
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<style type="text/css">
<!--
.style2 {font-size: 10}
.style4 {font-size: 18}
.style5 {font-size: 10px}
.style6 {font-size: 18px}
-->
</style>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<?php if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><form action="" method="post" name="formid" id="formid">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="2" class="texto">
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td colspan="2" class="titulos"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Etiqueta</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
          </tr>
          <?php if($err){ ?>

          <tr>
            <td colspan="2" class="texto_azul"><strong><font color="#FF0000">Pedido n&atilde;o encontrado, digite novamente!</font></strong></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="27">&nbsp;</td>
            <td width="422" class="texto_preto">Coloque o n&uacute;mero do  pedido:</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pedidon" type="text" class="formulario" id="pedidon" size="15" maxlength="15"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
              <input name="acao" type="hidden" id="acao" value="verificar">
            </td>
            
          </tr>
          <tr align="center">
            <td colspan="2">
              <input name="Submit" type="submit" class="texto" value="Continuar"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <?php }else{ ?>
  <tr>
    <td align="left" valign="top">
        <table width="99%"  border="0" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td bgcolor="#FFFFFF"><span class="preto style4"><strong>Etiqueta do Pedido <?php echo  $cp; ?>
            </strong></span></td>
          </tr>
        </table>
        <table width="99%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F7FFE8">
          
          <tr>
            <td width="639" align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
              
              <tr>
                <td class="texto style2">&nbsp;</td>
              </tr>
              <tr>
                <td class="texto style2">&nbsp;</td>
              </tr>
              <tr>
                <td class="texto style2"><span class="style5"><strong>Razao Social:</strong> <?php print $resp["nome"]; ?></span></td>
              </tr>
              <tr>
                <td><span class="style5"><strong>Endere&ccedil;o:</strong> <?php print $resp["endereco"]." ".$resp["numero"]; ?></span></td>
              </tr>
              <tr>
                <td><span class="style5"><strong>Bairro:</strong> <?php print $resp["bairro"]; ?></span></td>
              </tr>
              <tr>
                <td><span class="style5"><strong>Cidade:</strong> <?php print $resp["cidade"]; ?>&nbsp;&nbsp;&nbsp;<strong>UF:</strong>
                    <?php $bd->pega_nome_bd("estado","nome",$resp["estado"]);  ?>
                </span></td>
              </tr>
              <tr>
                <td><span class="style5"><strong>CEP:</strong> <?php print $resp["cep"]; ?></span></td>
              </tr>
              <tr>
                <td><span class="style5"><strong>NF:</strong> <?php print $rnf["numero"]; ?></span></td>
              </tr>
            </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
                <tr>
                  <td class="texto">&nbsp;</td>
                </tr>
                <tr>
                  <td class="texto">&nbsp;</td>
                </tr>
                <tr>
                  <td class="texto">&nbsp;</td>
                </tr>
                <tr>
                  <td class="texto">&nbsp;</td>
                </tr>
                <tr>
                  <td class="texto">&nbsp;</td>
                </tr>
                <tr>
                  <td class="texto style4"><span class="style6"><strong>Razao Social:</strong> <?php print $resp["nome"]; ?></span></td>
                </tr>
                <tr>
                  <td><span class="style6"><strong>Endere&ccedil;o:</strong> <?php print $resp["endereco"]." ".$resp["numero"]; ?></span></td>
                </tr>
                <tr>
                  <td><span class="style6"><strong>Bairro:</strong> <?php print $resp["bairro"]; ?></span></td>
                </tr>
                <tr>
                  <td><span class="style6"><strong>Cidade:</strong> <?php print $resp["cidade"]; ?>&nbsp;&nbsp;&nbsp;<strong>UF:</strong>
                  <?php $bd->pega_nome_bd("estado","nome",$resp["estado"]);  ?>
                  </span></td>
                </tr>
                <tr>
                  <td><span class="style6"><strong>CEP:</strong> <?php print $resp["cep"]; ?></span></td>
                </tr>
                <tr>
                  <td><span class="style6"><strong>NF:</strong><?php print $rnf["numero"]; ?></span></td>
                </tr>
              </table></td>
          </tr>
        </table>
    </td>
	<?php } ?>
</tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>