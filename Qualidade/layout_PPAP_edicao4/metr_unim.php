<?php
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Metrologia - Unid de Medida";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM unidades WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe a Unidade');
		cad.nome.focus();
		return false;
	}
	if(cad.apelido.value==''){
		alert('Informe o Apelido');
		cad.apelido.focus();
		return false;
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="591" border="0" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver=""><span class="impTextoBold">&nbsp;</span></div></td>
                <td width="564" align="right"><div align="left" class="style1">Unidades de Medida </div></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
</table>
<table width="594" border="0" cellpadding="0" cellspacing="0">
<?php if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center"><a href="metr_unim.php?acao=inc" class="textobold">Incluir uma Unidade de Medida </a></div></td>
        </tr>
      </table>
      <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr class="textoboldbranco"> 
          <td width="210"> &nbsp;&nbsp;Unidade&nbsp;de Medida </td>
          <td width="50">&nbsp;Apelido</td>
          <td width="16">&nbsp;</td>
          <td width="19">&nbsp;</td>
        </tr>
        <?php
			  $sql1=mysql_query("select * from unidades order by nome asc");
			  if(mysql_num_rows($sql1)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="4" align="center" class="textobold">NENHUMA UNIDADE CADASTRADA</td>
        </tr>
        <?php
			  }else{
			  	while($res=mysql_fetch_array($sql1)){
			  ?>
        <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td width="113" height="18">&nbsp;<?php print $res["nome"]; ?></td>
          <td height="18">&nbsp;<?php print $res["apelido"]; ?></td>
          <td width="16" height="18" align="center"><a href="metr_unim.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="19" height="18" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta Unidade?','metr_unim_sql.php?acao=exc&id=<?php print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
        </tr>
        <?php
			  	}
			  }
			  ?>
      </table>
      <img src="imagens/spacer.gif" width="46" height="20"><br>
      <table width="51%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center">
            <p>
              <input name="Voltar" type="submit" class="microtxt" id="Voltar" onClick="window.location='mana_metr.php';" value="Voltar">
                <br>
              </p>
            </div></td>
        </tr>
      </table>      </td>
  </tr>
  <?php }else{ ?>
  <tr>
    <td align="left" valign="top">
      <form name="form1" method="post" action="metr_unim_sql.php" onSubmit="return verifica(this);">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="51%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td><table width="300" border="0" cellpadding="0" cellspacing="3">
              <tr bgcolor="#003366">
                <td colspan="2" align="center" class="textoboldbranco"><?php if($acao=="inc"){ print"Incluir Unidade"; }else{ print"Alterar Unidade";} ?>                </td>
              </tr>
              <tr>
                <td width="39" class="textobold">&nbsp;Nome</td>
                <td width="258" class="textobold"><input name="nome" type="text" class="formularioselect" id="nome" value="<?php print $res["nome"]; ?>" size="45" maxlength="50"></td>
              </tr>
              <tr>
                <td class="textobold">&nbsp;Apelido</td>
                <td class="textobold"><input name="apelido" type="text" class="formulario" id="nome" value="<?php print $res["apelido"]; ?>"size="10" maxlength="4"></td>
              </tr>

            </table></td>
          </tr>
        </table>
          <img src="imagens/spacer.gif" width="46" height="20"><table width="304" border="0" cellpadding="0" cellspacing="0">

            <tr align="center">
              <td width="298" class="textobold"><input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.location='metr_unim.php'">
  &nbsp;&nbsp;&nbsp;
                  <input name="Submit" type="submit" class="microtxt" value="Continuar">
                  <input name="acao" type="hidden" id="acao" value="<?php if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>">
                  <input name="id" type="hidden" id="id3" value="<?php print $id; ?>">
                </td>
            </tr>
          </table></td>
      </tr>
    </table>
    </form></td>
	<?php } ?>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>