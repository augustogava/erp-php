<?php
include("conecta.php");
include("seguranca.php");
//Ultimo acesso
$wcli=$_SESSION["login_codigo"];
$whjd=date("Y-m-d");
$whjh=hora();
$sql=mysql_query("SELECT * FROM acessos WHERE usuario='$wcli' AND data='$whjd'");
if(mysql_num_rows($sql)==0){
	$sql=mysql_query("INSERT INTO acessos (usuario,data,hora) VALUES ('$wcli','$whjd','$whjh')");
}else{
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("UPDATE acessos SET hora='$whjh' WHERE id='$id'");
}
//ultimo acesso
include_once( 'TreeMenuXL.php' );
  $sql=mysql_query("SELECT niveis.menus,niveis.submenus FROM cliente_login,niveis WHERE cliente_login.cliente='$wcli' AND niveis.id=cliente_login.nivel");
  $res=mysql_fetch_array($sql);
  $menus=explode(",",$res["menus"]);
  $submenus=explode(",",$res["submenus"]); 
  //menu dinamico
  $menu00  = new HTML_TreeMenuXL();
  $nodeProperties = array("icon"=>"folder.gif");
  if($_SESSION["login_c1"]=="cyber"){
	  $sql=mysql_query("SELECT * FROM menus ORDER BY posicao ASC");
  }else{
	  $sql=mysql_query("SELECT * FROM menus WHERE sit='A' ORDER BY posicao ASC");  	
  }
  $count=0;
  $arrcont=0;
  while($res=mysql_fetch_array($sql)){
  	if(in_array($res["id"],$menus) or $res["sit"]=="F" or $_SESSION["login_c1"]=="cyber"){
		$wurl=explode("\"",$res["url"]);
		$_SESSION["login_menus"][$arrcont]=$wurl[0];
		$arrcont++;
		$node[$count] = new HTML_TreeNodeXL($res["texto"], $res["url"], $nodeProperties);
		$wmenu=$res["id"];
		$sql2=mysql_query("SELECT * FROM submenus WHERE menu=$wmenu ORDER BY posicao ASC");
		while($res2=mysql_fetch_array($sql2)){
			if(in_array($res2["id"],$submenus) or $res["sit"]=="F" or $_SESSION["login_c1"]=="cyber"){
				$wurl=explode("\"",$res2["url"]);
				$_SESSION["login_menus"][$arrcont]=$wurl[0];
				$arrcont++;
				$node[$count]->addItem(new HTML_TreeNodeXL($res2["texto"],$res2["url"], $nodeProperties));
			}
		}
		$menu00->addItem($node[$count]);
		$count++;
	}
  }
  //para niveis mais baixos
  //$nz = &$node0->addItem(new HTML_TreeNodeXL("sexo", "#link1", $nodeProperties));
  //$nz = &$nz->addItem(new HTML_TreeNodeXL("Nested Folder", "#link2", $nodeProperties));
  //$nz = &$nz->addItem(new HTML_TreeNodeXL("Deeper ...", "#link3", $nodeProperties));
  //$nz = &$nz->addItem(new HTML_TreeNodeXL("... and Deeper", "#link4", $nodeProperties));
 //menu dinamico
?>
<script src="TreeMenu.js" language="JavaScript" type="text/javascript"></script>
<script>
function statuss(){
window.status = "Cyber Manager 3.0";
setTimeout("statuss()", 1);
}
</script>
<html>
<head>
<title>Cyber Manager 3.0</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #003366;
	text-decoration: none;
}
a:visited {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #003366;
	text-decoration: none;
}
a:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #003366;
	text-decoration: underline;
}
a:active {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FFFFFF;
	text-decoration: none;
	background-color: #003366;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="statuss()">
<table width="770" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#000000">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"> 
      <table width="770" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="70" colspan="2" valign="top" bgcolor="#FFFFFF"><img src="imagens/top.gif" width="770" height="70"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="15" colspan="2" valign="top"><img src="imagens/dot.gif" width="200" height="15"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="160" height="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><img src="imagens/dot.gif" width="50" height="15"></td>
              </tr>
              <tr> 
                <td class="textobold"> &nbsp;Menu</td>
              </tr>
              <tr> 
                <td><img src="imagens/dot.gif" width="50" height="5"></td>
              </tr>
              <tr> 
                <td> 
                  <?php  // Menu 2.2
        $menuProperties = array("images"=>"TMimages", "defaultClass"=>'auto',
                                "autostyles"=>array("treemenu", "treemenu", "treemenu") );
        $example022 = new HTML_TreeMenu_DHTMLXL($menu00, $menuProperties);
        $example022->printMenu();
      ?>
                </td>
              </tr>
            </table></td>
          <td width="610" height="100%" align="left" valign="top"><iframe name="corpo" frameborder="0" align="left" valign="top" scrolling="auto" height="100%" width="100%" src="corpo.php"></iframe></td>
        </tr>
        <tr> 
          <td height="20" colspan="2" background="imagens/rodape.gif" bgcolor="#FFFFFF"><table width="770" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="291" class="rodape">&nbsp;&nbsp;<? print $_SESSION["login_nome"]; ?> 
                  - <? print $_SESSION["login_cargo"]; ?></td>
                <td width="177" align="center" class="rodape"><? print $_SESSION["login_nivel_nome"]; ?></td>
                <td width="201" align="right" class="rodape">Online a:</td>
                <td width="101" align="center" valign="middle"> <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="101" height="18">
                    <param name="movie" value="swf/contador.swf">
                    <param name=quality value=high>
                    <param name="wmode" value="transparent">
                    <param name="SCALE" value="exactfit">
                    <embed src="swf/contador.swf" width="101" height="18" scale="exactfit" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent"></embed> 
                  </object></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>