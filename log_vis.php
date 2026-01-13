<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";

?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {color: #00CC33}
.style2 {color: #FF0000}
.style3 {font-size: 12}
.style4 {font-size: 12px}
-->
</style>
</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onmouseover="this.T_STICKY=true; this.T_TITLE='Status'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Mostra os usuários que estão logados no sistema agora!')"></a><span class="impTextoBold">&nbsp;</span></div></td>
    <td width="563" align="right"><div align="left" class="titulos">Log</div></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="590" border="0" cellpadding="0" cellspacing="0">
  <tr> 
<td>
<form name="form1" method="post" action="log_vis_sql.php">
  <table width="300"  border="0" cellpadding="0" cellspacing="1" bgcolor="#004996" class="texto">
<?
if($pasta=opendir(".")){
  while (false !== ($arquivo = readdir($pasta))) {
		if($arquivo!="." && $arquivo!=".."){
		$ext=extensao($arquivo);
			if($ext=="txt"){
?>
    <tr align="left">
      <td colspan="2" class="textoboldbranco">Selecione o arquivo de Log</td>
      </tr>
    <tr bgcolor="#FFFFFF">
      <td width="25" align="center"><input name="arquivo" type="radio" value="<?= $arquivo; ?>" checked></td>
      <td width="275">&nbsp;<? print $arquivo; 
if( filesize($arquivo) >= 1024 ) {
					 # Size in kilobytes
					 print " " . round( filesize($arquivo) / 1024, 1 ) . " KB<br />\n";
				 } elseif(filesize($arquivo) >= 1048576 ) {
					 # Size in megabytes
					 print " " . round( filesize($arquivo) / 1024 / 1024, 1 ) . " MB<br />\n";
				 } else {
					 # Size in bytes
					 print " (" . filesize($arquivo) . " bytes)<br />\n";
				 } ?></td>
    </tr>
<?
			}
		}
   }
	closedir($pasta);
}
?>
    <tr bgcolor="#FFFFFF">
      <td colspan="2" align="center"><input name="tipo" type="radio" value="dow" checked> 
        Download 
          <input name="tipo" type="radio" value="abrir">
          Abrir</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="2" align="center"><input name="acao" type="hidden" id="acao" value="ir">        <input name="Submit" type="submit" class="treemenu" value="Continuar"></td>
      </tr>
  </table>
</form>
</td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>