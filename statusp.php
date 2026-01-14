<?php
include("conecta.php");
include("seguranca.php");
$acao = Input::request('acao', '');
$pedido = Input::request('pedido', '');
$cp = Input::request('cp', '');
$err = Input::request('err', '');
$errtent = Input::request('errtent', '');
$acao = verifi($permi, $acao);
if(!empty($acao)){
	$loc="Status Pedido";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="verificar"){
			$sql=mysql_query("SELECT * FROM e_compra WHERE pedido='$pedido'");
			if(mysql_num_rows($sql)){
				$res=mysql_fetch_array($sql);
				$cp=$res["id"];
				header("Location:statusp.php?acao=ver&cp=$cp");
			}else{
				$_SESSION["mensagem"]="Pedido não encontrado!!";
				header("Location:statusp.php?acao=entrar");
				exit;
			}
}elseif($acao=="ver"){
$sql=mysql_query("SELECT MAX(prodserv.prazo_entrega) as prazo FROM prodserv,e_itens WHERE e_itens.compra='$cp' AND e_itens.produto_id=prodserv.id"); $res=mysql_fetch_array($sql);
$prazo=$res["prazo"];

	 $sql=mysql_query("SELECT * FROM e_compra WHERE id='$cp'");
$res=mysql_fetch_array($sql);
	switch($res["sit"]){
		case "A":
		$situ="Aberto";
		break;
		case "E":
		$situ="Aguardando Aprovação Financeira";
		break;
		case "B":
		$situ="Em Produção";
		break;
		case "P":
		$situ="Em Separação";
		break;
		case "F":
		$situ="Aguardando NF";
		break;
		case "FF":
		$situ="Faturado";
		break;
}
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

</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<?php if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><form action="" method="post" name="formid" id="formid" onSubmit="return <?php if($errtent){ print "bloqueia"; }else{ print "verifica"; } ?>(this)">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="2" class="texto">
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td colspan="2" class="titulos"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Status Pedido </div></td>
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
            <td><input name="pedido" type="text" class="formulario" id="pedido" size="15" maxlength="15"></td>
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
    <td align="left" valign="top"><form name="form1" method="post" action="material_sql.php" onSubmit="return verifica(this);">
        <table width="99%"  border="0" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td bgcolor="#FFFFFF"><span class="preto style4"><strong>&nbsp;Status do Pedido
                    <?php echo  $cp; ?>
            </strong></span></td>
          </tr>
        </table>
        <table width="99%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F7FFE8">
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td width="639" align="left" bgcolor="#FFFFFF"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="texto">
                <tr>
                  <td width="23%"><strong>Pedido:</strong><?php print completa($res["id"],10); ?></td>
                  <td width="30%"><strong>Data da Compra:</strong> <?php print banco2data($res["data"]); ?></td>
                  <td width="47%"><strong>Hora da Compra:</strong> <?php print $res["hora"]; ?></td>
                </tr>
                <tr>
                  <td colspan="3"><strong>Previs&atilde;o de Entrega:</strong>
                      <?php echo  $prazo; ?>
            - a contar da data de aprova&ccedil;&atilde;o </td>
                </tr>
                <tr>
                  <td colspan="3"><strong>Em
                        <?php echo  date("d/m/Y"); ?>
            a situa&ccedil;&atilde;o do pedido &eacute;:</strong> <?php print $situ; ?></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                </tr>
              </table>
                <table width="526" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366" class="texto">
                  <tr class="textoboldbranco">
                    <td width="352" align="left" class="menuesq"><strong>&nbsp;Produto</strong></td>
                    <td width="76" align="left" class="menuesq"><strong>&nbsp;Pre&ccedil;o Uni.</strong></td>
                    <td width="38" align="center" class="menuesq"><strong>Qtd</strong></td>
                    <td width="55" align="right" class="menuesq"><strong>Valor&nbsp;</strong></td>
                  </tr>
                  <?php
	  $sql=mysql_query("SELECT * FROM e_itens WHERE compra='$cp' ORDER BY id ASC");
	  if(mysql_num_rows($sql)==0){
	  ?>
                  <tr bgcolor="#FFFFFF" class="texto">
                    <td colspan="4" align="center" class="textobold">NENHUM PEDIDO</td>
                  </tr>
                  <?php
		}else{
	$total=0;
			while($res=mysql_fetch_array($sql)){
				$total+=$res["produto_preco"]*$res["qtd"];
		?>
                  <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                    <td align="left"">&nbsp;<?php print "$res[produto_nome] - $res[medidas]"; ?></td>
                    <td align="left" >&nbsp;R$ <?php print banco2valor($res["produto_preco"]) ?></td>
                    <td align="center" ><span class="texto_preto"><?php print $res["qtd"] ?></span></td>
                    <td align="right" >R$ <?php print banco2valor($res["produto_preco"]*$res["qtd"]) ?>&nbsp;</td>
                  </tr>
                  <?php
	  	}
	  }
	  ?>
                  <tr align="right" bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                    <td colspan="3" align="left""><strong>&nbsp;Total:&nbsp;</strong></td>
                    <td><strong>R$ <?php print banco2valor($total); ?>&nbsp;</strong></td>
                  </tr>
              </table></td>
          </tr>
        </table>
    </form>
      
    </td>
	<?php } ?>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>