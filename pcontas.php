<?php
include("conecta.php");
include("seguranca.php");
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">	
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Plano de Contas </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
	    </tr>
  <tr> 
    <td align="left" valign="top"><table width="350" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="center"><a href="pconta_inc.php" class="textobold">INCLUIR 
            CONTA</a></td>
        </tr>
        <tr> 
          <td align="center" bgcolor="#003366" class="textoboldbranco">Plano de 
            Contas </td>
        </tr>
        <tr> 
          <td class="texto"> <table width="350" border="0" cellspacing="0" cellpadding="0">
              <?php 
			  $sql=mysql_query("SELECT * FROM pcontas WHERE idpai=0 ORDER BY codigo ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr> 
                <td colspan="4" align="center" class="textobold">NENHUMA CONTA 
                  CADASTRADA</td>
              </tr>
              <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
					$res["descricao"]=strtoupper($res["descricao"]);
			  ?>
              <tr> 
                <td colspan="4"><img src="imagens/dot.gif" width="100" height="8"></td>
              </tr>
              <tr onMouseover="changeto('#CCCCCC')" onMouseout="changeback('')"> 
                <td><span class="textobold"><?php print $res["codigo"]; ?> <?php print $res["descricao"]; ?></span></td>
                <td width="16" align="center"><a href="pcontasub_inc.php?idpai=<?php print $res["id"]; ?>"><img src="imagens/icon_14_add2.gif" alt="Incluir Subconta" width="14" height="16" border="0"></a></td>
                <td width="16" align="center"><a href="pconta_inc.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="16" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta conta e suas subcontas?','pconta_inc_sql.php?acao=exc&id=<?php print $res["id"]; ?>');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?php
			  		$sqls=mysql_query("SELECT * FROM pcontas WHERE idpai='$res[id]' ORDER BY codigo ASC");
					while($ress=mysql_fetch_array($sqls)){
			  ?>
              <tr onMouseover="changeto('#CCCCCC')" onMouseout="changeback('')"> 
                <td><img src="imagens/dot.gif" width="25" height="5"><span class="textobold"><?php print $ress["codigo"]; ?></span> 
                  <span class="texto"><?php print $ress["descricao"]; ?> </span></td>
                <td width="16" align="center">&nbsp;</td>
                <td width="16" align="center"><a href="pcontasub_inc.php?acao=alt&id=<?php print $ress["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="16" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta subconta?','pcontasub_inc_sql.php?acao=exc&id=<?php print $ress["id"]; ?>');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?php
			  		}
				}
			  }
			  ?>
            </table></td>
        </tr>
        <tr> 
          <td class="textobold"><img src="imagens/dot.gif" width="100" height="8"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>