<?php
include("conecta.php");
$hj=date("Y-m-d");

$acao = Input::request('acao', '');
$usu = Input::request('usu', '');
$nome = Input::request('nome', '');
$msg = Input::request('msg', '');
if(empty($usu)){
print "<script>window.close();</script>";
}
if($acao=="mandar"){
	$sql=mysql_query("INSERT INTO msg (user,msg,enviado,data) VALUES('$usu','$msg','N','$hj')");
	print "<script>window.alert('Mensagem enviada!');window.close();</script>";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="textobold style1">Enviar Mensagem </td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="texto">
        <tr>
          <td>Mensagem Para usu&aacute;rio
              <?php echo  $nome; ?>
              :</td>
          <td><input name="usu" type="hidden" id="usu" value="<?php echo  $usu; ?>">
            <input name="acao" type="hidden" id="acao" value="mandar"></td>
        </tr>
        <tr>
          <td><input name="msg" type="text" class="formularioselect" id="msg"></td>
          <td align="center"><input name="Submit" type="submit" class="texto" value="Enviar"></td>
        </tr>
      </table>
    </form>      </td>
  </tr>
  <tr>
    <td align="center">&nbsp;      </td>
  </tr>
</table>
</body>
</html>
