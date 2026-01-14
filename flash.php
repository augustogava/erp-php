<?php
include("conecta.php");
//include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Flash";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	if(!empty($alun)){
		$ext=end(explode(".",$_FILES["alun"]["name"]));
		if($ext=="swf"){
			$arquivo="$patch/flash/fla.swf";
			copy($alun, "$arquivo");
			print "<script>window.alert('Alterado com sucesso!');</script>";
		}else{
			print "<script>window.alert('Deve ser Arquivo .SWF');</script>";
		}
	}
}
?>

<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">FLASH</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center" class="textobold">Alterar Flash</div></td>
        </tr>
      </table>
        
          <table width="400" border="0" cellpadding="0" cellspacing="0" class="textopreto">
		  <form action="" method="post" enctype="multipart/form-data" name="form1">
            <tr>
              <td width="85" class="textobold">Atual</td>
              <td width="315">
			  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="300">
                <param name="movie" value="flash/fla.swf">
                <param name="quality" value="high">
                <embed src="flash/fla.swf" width="300" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
              </object>
			  </td>
            </tr>
            <tr>
              <td class="textobold">Alterar</td>
              <td><input name="alun" type="file" id="alun"></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><input name="acao" type="hidden" id="acao" value="alt">
              <input name="Submit" type="submit" class="microtxt" value="Enviar"></td>
            </tr>
			     </form>
          </table>
 
        </td>
  </tr>

</table>
</body>
</html>