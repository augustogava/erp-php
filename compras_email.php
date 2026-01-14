<?php
include("conecta.php");
$acao=Input::request("acao");
$compra=Input::request("compra");
$email=Input::request("email");
$fornecedor=Input::request("fornecedor");
$id=Input::request("id");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Compras Mandar Email";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="enviar"){
	$lines=file("http://www.e-sinalizacao.com.br/cybermanager/compras_imp_for.php?id=$compra");
	foreach($lines as $line){
		$msg.=$line;
	}
	mail("$email","Ordem de Compra","$msg","From:E-sinalização<manager@e-sinalizacao.com.br>\nContent-type: text/html\n");
	print "<script>window.alert('Enviado com sucesso!');window.close();</script>";
}
$sql=mysql_query("SELECT * FROM fornecedores WHERE id='$fornecedor'");
$res=mysql_fetch_array($sql);
?>
<html>
<head>
<title>Untitled Document</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
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
<form name="form1" method="post" action="">
<table width="700" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="700" align="center" class="titulos"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="27%" align="center"><img src="imagens/logoesi.gif" width="52" height="53"></td>
        <td width="73%" align="left" class="titulos">Enviar Email para fornecedor </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulos">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulos">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulos">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulos">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulos">

<table width="386" border="0" align="left" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="40" rowspan="2"><div align="center">
          
            <input name="email" type="radio" value="<?php print $res["email"]; ?>">
          
        </div></td>
        <td width="61">Contato:</td>
        <td width="285">&nbsp;<?php print $res["contato"]; ?></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>&nbsp;<?php print $res["email"]; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="2"><div align="center">
          <input name="email" type="radio" value="<?php print $res["email2"]; ?>">
        </div></td>
        <td width="61">Contato:</td>
        <td width="285">&nbsp;<?php print $res["contato2"]; ?></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>&nbsp;<?php print $res["email2"]; ?></td>
      </tr>
      <tr>
        <td><div align="center"></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="2"><div align="center">
          <input name="email" type="radio" value="<?php print $res["email3"]; ?>">
        </div></td>
        <td width="61">Contato:</td>
        <td width="285">&nbsp;<?php print $res["contato3"]; ?></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>&nbsp;<?php print $res["email3"]; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulos"><input name="acao" type="hidden" id="acao" value="enviar">      <input name="compra" type="hidden" id="compra" value="<?php echo  $id; ?>">      <input type="submit" name="Submit" value="Enviar"></td>
  </tr>
</table>
</form>
</body>
</html>
