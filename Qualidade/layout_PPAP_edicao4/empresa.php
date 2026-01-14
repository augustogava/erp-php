<?php
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)!=0){
	$acao="alt";
	$res=mysql_fetch_array($sql);
}else{
	$acao="inc";
}

$arquivo="$patch/empresa_logo/logo.jpg";
if (file_exists($arquivo)) { 
	$wimg="logo.jpg";
}else{
	$wimg="logo_padrao.jpg";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<style type="text/css">
<!--
.style6 {color: #888888}
.style17 {font-size: 10px}
.style18 {font-weight: bold; color: #888888;}
.style19 {color: #000000; text-decoration: none; border: 1px solid #003366; font-family: Arial, Helvetica, sans-serif;}
.style20 {font-weight: bold; color: #003366; text-decoration: none; font-family: Arial, Helvetica, sans-serif;}
.style21 {color: #003366; text-decoration: none; font-family: Arial, Helvetica, sans-serif;}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="502" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr> 
    <td width="498" align="left" valign="top"><form action="empresa_sql.php" method="post" enctype="multipart/form-data" name="form1">
      <table width="498" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td colspan="3" align="center" bgcolor="#003366" class="textoboldbranco">Informa&ccedil;&otilde;es da Empresa </td>
        </tr>
        <tr>
          <td width="118" class="textobold">Nome Fantasia:</td>
          <td colspan="2"><input name="fantasia" type="text" class="formularioselect" id="fantasia" value="<?php print $res["fantasia"]; ?>" maxlength="30"></td>
        </tr>
        <tr>
          <td class="textobold">Raz&atilde;o Social:</td>
          <td colspan="2"><input name="razao" type="text" class="formularioselect" id="razao" value="<?php print $res["razao"]; ?>" maxlength="150"></td>
        </tr>
        <tr>
          <td class="textobold">Endere&ccedil;o:</td>
          <td colspan="2"><input name="endereco" type="text" class="formularioselect" id="endereco" value="<?php print $res["endereco"]; ?>" maxlength="200"></td>
        </tr>
        <tr>
          <td class="textobold">CNPJ (sem pontos): </td>
          <td colspan="2"><input name="cnpj" type="text" class="formularioselect" id="cnpj" value="<?php print $res["cnpj"]; ?>" maxlength="200"></td>
        </tr>
        <tr>
          <td class="textobold">Cidade:</td>
          <td><input name="cidade" type="text" class="formularioselect" id="cidade" value="<?php print $res["cidade"]; ?>" size="30" maxlength="100"></td>
          <td width="176" rowspan="5" align="center" valign="middle"><a href="#" onClick="return abre('empresa_logo.php?img=<?php print $wimg; ?>','foto','width=10,height=10');">
            <?php if($acao=="alt" and !empty($wimg)){ ?>
            <img src="empresa_logo/gd.php?img=<?php print $wimg; ?>&wid=100" border="0"></a>
            <?php } ?></td>
        </tr>
        <tr>
          <td class="textobold">Estado:</td>
          <td width="192"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
            <select name="estado" class="formulario" id="UF">
              <option value="AC"<?php if($res["estado"]=="AC") print "selected"; ?>>AC</option>
              <option value="AL"<?php if($res["estado"]=="AL") print "selected"; ?>>AL</option>
              <option value="AM"<?php if($res["estado"]=="AM") print "selected"; ?>>AM</option>
              <option value="AP"<?php if($res["estado"]=="AP") print "selected"; ?>>AP</option>
              <option value="BA"<?php if($res["estado"]=="BA") print "selected"; ?>>BA</option>
              <option value="CE"<?php if($res["estado"]=="CE") print "selected"; ?>>CE</option>
              <option value="DF"<?php if($res["estado"]=="DF") print "selected"; ?>>DF</option>
              <option value="ES"<?php if($res["estado"]=="ES") print "selected"; ?>>ES</option>
              <option value="GO"<?php if($res["estado"]=="GO") print "selected"; ?>>GO</option>
              <option value="MA"<?php if($res["estado"]=="MA") print "selected"; ?>>MA</option>
              <option value="MG"<?php if($res["estado"]=="MG") print "selected"; ?>>MG</option>
              <option value="MS"<?php if($res["estado"]=="MS") print "selected"; ?>>MS</option>
              <option value="MT"<?php if($res["estado"]=="MT") print "selected"; ?>>MT</option>
              <option value="PA"<?php if($res["estado"]=="PA") print "selected"; ?>>PA</option>
              <option value="PB"<?php if($res["estado"]=="PB") print "selected"; ?>>PB</option>
              <option value="PE"<?php if($res["estado"]=="PE") print "selected"; ?>>PE</option>
              <option value="PI"<?php if($res["estado"]=="PI") print "selected"; ?>>PI</option>
              <option value="PR"<?php if($res["estado"]=="PR") print "selected"; ?>>PR</option>
              <option value="RJ"<?php if($res["estado"]=="RJ") print "selected"; ?>>RJ</option>
              <option value="RN"<?php if($res["estado"]=="RN") print "selected"; ?>>RN</option>
              <option value="RO"<?php if($res["estado"]=="RO") print "selected"; ?>>RO</option>
              <option value="RR"<?php if($res["estado"]=="RR") print "selected"; ?>>RR</option>
              <option value="RS"<?php if($res["estado"]=="RS") print "selected"; ?>>RS</option>
              <option value="SC"<?php if($res["estado"]=="SC") print "selected"; ?>>SC</option>
              <option value="SE"<?php if($res["estado"]=="SE") print "selected"; ?>>SE</option>
              <option value="SP"<?php if($res["estado"]=="SP" or empty($res["estado"])) print "selected"; ?>>SP</option>
              <option value="TO"<?php if($res["estado"]=="TO") print "selected"; ?>>TO</option>
            </select>
          </font></td>
        </tr>
        <tr>
          <td class="textobold">Pa&iacute;s:</td>
          <td><input name="pais" type="text" class="formularioselect" id="pais" value="<?php print $res["pais"]; ?>" maxlength="50"></td>
        </tr>
        <tr>
          <td class="textobold">CEP:</td>
          <td><input name="cep" type="text" class="formulario" id="cep" value="<?php print $res["cep"]; ?>" size="10" maxlength="9" onKeyUp="mcep(this)" onKeyPress="return validanum(this, event)">            </td>
        </tr>
        <tr>
          <td class="textobold">Logotipo:</td>
          <td><input name="foto" type="file" class="formularioselect" id="foto"></td>
        </tr>
        <tr>
          <td class="textobold">Telefone:</td>
          <td><input name="tel" type="text" class="formulario" id="tel" value="<?php print $res["tel"]; ?>" size="20" maxlength="15"></td>
          <td rowspan="5" class="textobold style17"><span class="style18">Obs.: Nomear a imagem como &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;logo.jpg. Tamanho 63x35 </span><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style6">pixels.<br>
          </span></strong><span class="style6">Esta imagem ser&aacute; exibida nos relat&oacute;rios. </span></td>
        </tr>
        <tr>
          <td class="textobold">Fax:</td>
          <td class="style17"><input name="fax" type="text" class="formulario" id="fax" value="<?php print $res["fax"]; ?>" size="20" maxlength="15"></td>
        </tr>
        <tr>
          <td class="textobold">&nbsp;</td>
          <td class="style17">&nbsp;</td>
        </tr>
        <tr>
          <td class="textobold">Data 4&ordm; Edi&ccedil;&atilde;o: </td>
          <td class="style17"><input name="data" type="text" class="formulario" id="data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($res["data"]); ?>" size="10" maxlength="10"></td>
        </tr>
        <tr>
          <td class="textobold"><span class="textobold style17">
            <input name="acao" type="hidden" id="acao" value="<?php print $acao; ?>">
          </span></td>
          <td class="style17">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="textobold"><span class="style20">
            <input name="button12222" type="submit" class="microtxt" value="Continuar">
          </span></td>
          </tr>
      </table>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>