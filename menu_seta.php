<?php
include("conecta.php");
//include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="marcar"){
	$wmenu="";
	$wsubmenu="";
	if(!empty($menu)){
		foreach($menu as $menus){
			$wmenu.="$menus,";
		}
	}
	if(!empty($submenu)){
		foreach($submenu as $submenus){
			$wsubmenu.="$submenus,";
		}	
	}
	$sql=mysql_query("UPDATE niveis SET menus='$wmenu',submenus='$wsubmenu' WHERE id='$nivel'");
	if($sql){
		$_SESSION["mensagem"]="Restrições setadas com sucesso";
	}else{
		$_SESSION["mensagem"]="As restrições não puderam ser setadas";
	}
	$acao="entrar";
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
<!--

function verifica(cad){
	if(cad.nivel[cad.nivel.selectedIndex].value==''){
		alert('Selecione um nível');
		return false;
	}
	return true;
}
//-->
</script>
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Permiss&atilde;o</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <?php if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="350" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco">N&iacute;vel 
              de Acesso</td>
          </tr>
          <tr> 
            <td width="255"><select name="nivel" class="formularioselect" id="nivel">
                <option value="" selected>Selecione</option>
				<?php 
				$sql=mysql_query("SELECT * FROM niveis ORDER BY nome ASC");
				while($res=mysql_fetch_array($sql)){
				?>
				<option value="<?php print $res["id"]; ?>"><?php print $res["nome"]; ?></option>
				<?php } ?>
              </select></td>
            <td width="95" align="center"><input name="imageField" type="image" src="imagens/c_continuar.gif" border="0">
              <input name="acao" type="hidden" id="acao" value="cont"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <?php }elseif($acao=="cont"){ ?>
  <tr>
    <td align="left" valign="top"><form name="form2" method="post" action="">
        <table width="350" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" bgcolor="#003366" class="textoboldbranco">Permiss&otilde;es 
              de Menu</td>
          </tr>
          <tr>
            <td class="texto">
			<?php
			$sql=mysql_query("SELECT * FROM niveis WHERE id='$nivel'");
			$res=mysql_fetch_array($sql);
			$wmenus=explode(",",$res["menus"]);
			$wsubmenus=explode(",",$res["submenus"]);
			$sql=mysql_query("SELECT * FROM menus WHERE sit='A' ORDER BY posicao ASC");
			while($res=mysql_fetch_array($sql)){
				$menu=$res["id"];
			?><img src="imagens/folder.gif" width="20" height="20">
              <input type="checkbox" name="menu[]" value="<?php print $res["id"]; ?>" <?php if(in_array($res["id"],$wmenus))print "checked"; ?>>
              <?php print $res["texto"];?><br>
			  <?php
			  $sql2=mysql_query("SELECT * FROM submenus WHERE menu='$menu' ORDER BY posicao ASC");
			  while($res2=mysql_fetch_array($sql2)){
			  ?>
              <img src="imagens/dot.gif" width="20" height="6"> <img src="imagens/folder.gif" width="20" height="20">
              <input type="checkbox" name="submenu[]" value="<?php print $res2["id"]; ?>" <?php if(in_array($res2["id"],$wsubmenus))print "checked"; ?>>
              <?php print $res2["texto"]; ?><br>
		    <?php } } ?>			</td>
          </tr>
          <tr>
            <td align="center">
              <input name="Submit22" type="button" class="microtxt" value="Cancelar" onClick="window.location='menu_seta.php'">
           <img src="imagens/dot.gif" width="20" height="5">
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              
              <input name="acao" type="hidden" id="acao" value="marcar">
            <input name="nivel" type="hidden" id="nivel" value="<?php print $nivel; ?>"></td></tr>
        </table>
      </form></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>