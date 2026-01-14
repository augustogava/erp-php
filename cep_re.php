<?php
include("conecta.php");
if(empty($acao)) $acao="entrar";
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
.style1 {font-size: 14px}
-->
</style>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Frete</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="center" valign="top"><?php 
$sel=mysql_query("SELECT DISTINCT (regiao) FROM `frete");
$linhas=mysql_num_rows($sel);
?>
      <span class="paginacao2">Sedex</span>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        
        <tr class="textoboldbranco">
          <td width="88" align="center">&nbsp;Peso(kg)</td> 
          
<?php 
$sel=mysql_query("SELECT DISTINCT (estado) FROM cep");
while($selr=mysql_fetch_array($sel)){
?>
<td align="center" class="textoboldbranco"><?php $sql1=mysql_query("SELECT * FROM estado WHERE id='$selr[estado]'"); $res1=mysql_fetch_array($sql1); print $res1["nome"]; ?></td>
<?php } ?>
        </tr>
        <?php
			  $sql=mysql_query("SELECT * FROM cep WHERE estado='27' and tipo='sedex' ORDER BY id ASC") or erp_db_fail();
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="3" align="center" class="textobold">NENHUM CEP ENCONTRADO          </td>
        </tr>
        <?php
			  }else{
				while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="right"><?php print $res["peso_in"]; ?> a <?php print $res["peso_fi"]; ?></td>
<?php 
$sel=mysql_query("SELECT DISTINCT (estado) FROM cep");
while($selr=mysql_fetch_array($sel)){
	 $sql2=mysql_query("SELECT * FROM cep WHERE estado='$selr[estado]' AND peso_in<='$res[peso_in]' AND peso_fi>='$res[peso_fi]' and tipo='sedex'");
	$res2=mysql_fetch_array($sql2);
?>
          <td align="right">
		  <?php 
		   print banco2valor($res2["valor"]); 
		   ?>          </td> 
<?php } ?>
        </tr>
<?php } } ?>
      </table>    </td>
  </tr>
  <tr>
    <td align="center" valign="top"><?php 
$sel=mysql_query("SELECT DISTINCT (regiao) FROM `frete");
$linhas=mysql_num_rows($sel);
?>
      <span class="paginacao2">Pac</span>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="88" align="center">&nbsp;Peso(kg)</td>
          <?php 
$sel=mysql_query("SELECT DISTINCT (estado) FROM cep");
while($selr=mysql_fetch_array($sel)){
?>
          <td align="center" class="textoboldbranco"><?php $sql1=mysql_query("SELECT * FROM estado WHERE id='$selr[estado]'"); $res1=mysql_fetch_array($sql1); print $res1["nome"]; ?></td>
          <?php } ?>
        </tr>
        <?php
			  $sql=mysql_query("SELECT * FROM cep WHERE estado='27' and tipo='pac' ORDER BY id ASC") or erp_db_fail();
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF">
          <td colspan="3" align="center" class="textobold">NENHUM CEP ENCONTRADO </td>
        </tr>
        <?php
			  }else{
				while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="right"><?php print $res["peso_in"]; ?> a <?php print $res["peso_fi"]; ?></td>
          <?php 
$sel=mysql_query("SELECT DISTINCT (estado) FROM cep");
while($selr=mysql_fetch_array($sel)){
	 $sql2=mysql_query("SELECT * FROM cep WHERE estado='$selr[estado]' AND peso_in<='$res[peso_in]' AND peso_fi>='$res[peso_fi]' and tipo='pac'");
	$res2=mysql_fetch_array($sql2);
?>
          <td align="right"><?php 
		   print banco2valor($res2["valor"]); 
		   ?>
          </td>
          <?php } ?>
        </tr>
        <?php } } ?>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>