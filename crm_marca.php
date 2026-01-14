<?php
include("conecta.php");
include("seguranca.php");
$bd=new set_bd;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="CRM - Ação Marketing";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="salvar"){
	mysql_query("UPDATE clientes SET acao='$facao',autonomia='$autonomia',linha='$linha' WHERE id='$cli'");
	$acao="entrar";
}
$sql=mysql_query("SELECT * FROM clientes WHERE id='$cli'");
$res=mysql_fetch_array($sql);
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
<table width="617" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="591" align="center" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0"></div></td>
        <td width="563" align="right"><div align="left"><span class="chamadas"><span class="titulos">A&ccedil;&atilde;o Marketing </span></span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>

    
          <table width="99%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F7FFE8">
		    <form name="form1" method="post" action="">
            <tr>
              <td width="639" align="left" bgcolor="#FFFFFF"><table width="200" border="0" cellpadding="0" cellspacing="0" class="texto">
                  <tr>
                    <td colspan="2" align="center" class="textoboldbranco">Cadastrar</td>
                  </tr>
                  <tr>
                    <td width="57" class="textobold">Linha:</td>
                    <td width="193"><span class="textobold">
                      <select name="linha" id="linha">
                        <option selected="">Selecione</option>
                        <option value="equipamentos" <?php if($res["linha"]=="equipamentos"){ print "selected"; } ?>>Equipamentos</option>
                        <option value="pdv" <?php if($res["linha"]=="pdv"){ print "selected"; } ?>>PDV+</option>
                        <option value="geral" <?php if($res["linha"]=="geral"){ print "selected"; } ?>>Geral</option>
                      </select><?php print $res["linha"]; ?>
                    </span></td>
                  </tr>
                  <tr>
                    <td colspan="2"><input name="autonomia" type="radio" value="d" <?php if($res["autonomia"]=="d"){ print "checked"; } ?>>
                      Decisor 
                      <input name="autonomia" type="radio" value="i" <?php if($res["autonomia"]=="i"){ print "checked"; } ?>>
                      Influenciador</td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><input name="facao" type="checkbox" id="facao" value="S" <?php if($res["acao"]=="S"){ print "checked"; } ?>> 
                    Fazer A&ccedil;&atilde;o de Marketing 
                    <input name="acao" type="hidden" id="acao" value="salvar">
                    <input name="cli" type="hidden" id="cli" value="<?php echo  $cli; ?>"></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#FFFFFF"><input name="voltar" type="button" class="microtxt" id="voltar" value="Voltar" onClick="history.go(-1)" />
              &nbsp;&nbsp;&nbsp;
                <input name="voltar2" type="submit" class="microtxt" id="voltar2" value="Enviar" onClick="history.go(-1)" /></td>
            </tr>
		    </form>
          </table>
    </td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>