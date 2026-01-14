<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#003366" class="textoboldbranco">Hist&oacute;rico de Altera&ccedil;&otilde;es </td>
  </tr>
  <tr>
    <td class="texto">
<? 
include("conecta.php");
$sql=mysql_query("SELECT * FROM cr_itens WHERE id='$id'");
$res=mysql_fetch_array($sql);
print str_replace("\n","<br>",$res["log"]);
?>
&nbsp;</td>
  </tr>
</table>
</body>
</html>
