<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$id=Input::request("id");
$idpai=Input::request("idpai");
if(empty($acao)) $acao="inc";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM pcontas WHERE id='$id'");
	if(mysql_num_rows($sql)!=0){
		$res=mysql_fetch_array($sql);
	}
}elseif($acao=="inc"){
	$sql=mysql_query("SELECT * FROM pcontas WHERE id='$idpai'");
	if(mysql_num_rows($sql)!=0){
		$res=mysql_fetch_array($sql);
		$res["descricao"]="";
		$res["tipo"]="";
	}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.descricao.value==''){
		alert('Informe a descrição da subconta');
		cad.descricao.focus();
		return false;
	}
	if(cad.codigo.value==''){
		alert('Informe o código da subconta');
		cad.codigo.focus();
		return false;
	}
	if(cad.tipo[cad.tipo.selectedIndex].value==''){
		alert('Informe o tipo de subconta');
		cad.tipo.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Subconta</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
	    </tr>
  <tr> 
    <td align="left" valign="top"><form name="form1" method="post" action="pcontasub_inc_sql.php" onSubmit="return verifica(this);">
        <table width="300" border="0" cellspacing="1" cellpadding="0">
          <tr> 
            <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco"><?php if($acao=="inc"){ print "Incluir Subconta"; }else{ print "Alterar Subconta"; } ?></td>
          </tr>
          <tr> 
            <td width="56" class="textobold">Subconta:</td>
            <td width="241"><input name="descricao" type="text" class="formularioselect" id="descricao" value="<?php print $res["descricao"]; ?>" maxlength="50"></td>
          </tr>
          <tr> 
            <td class="textobold">C&oacute;digo:</td>
            <td><input name="codigo" type="text" class="formulario" id="codigo" value="<?php print $res["codigo"]; ?>" size="15" maxlength="10"></td>
          </tr>
          <tr> 
            <td class="textobold">Tipo:</td>
            <td>
			<select name="tipo" class="formularioselect" id="tipo">
				<option value="" <?php if(empty($res["tipo"])) print "selected"; ?>>Selecione</option>
				<?php
				$sqlc=mysql_query("SELECT * FROM pcontas_tipo ORDER BY tipo ASC");
				while($resc=mysql_fetch_array($sqlc)){
				?>
				<option value="<?php print $resc["id"]; ?>" <?php if($res["tipo"]==$resc["id"]) print "selected"; ?>><?php print $resc["tipo"]; ?></option>
				<?php
				}
				?>
			</select></td>
          </tr>
          <tr> 
            <td colspan="2" align="center">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='pcontas.php'">
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input name="Submit2" type="submit" class="microtxt" value="Continuar">
       <input name="acao" type="hidden" id="acao2" value="<?php if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">
            	<input name="id" type="hidden" id="id" value="<?php print $id; ?>">
	            <input name="idpai" type="hidden" id="idpai" value="<?php print $idpai; ?>"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>