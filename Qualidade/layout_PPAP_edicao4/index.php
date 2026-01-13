<?php
include("conecta.php");
include("seguranca.php");
//Ultimo acesso
$wcli=$_SESSION["login_codigo"];
$whjd=date("Y-m-d");
$whjh=hora();
$funcionario=$_SESSION["login_funcionario"];
$ip=$_SERVER['REMOTE_ADDR'];
	$sql=mysql_query("INSERT INTO acessos (usuario,tipo,data,hora,ip) VALUES ('$wcli','$funcionario','$whjd','$whjh','$ip')");
//acessos
include_once( 'TreeMenuXL.php' );
	if($_SESSION["login_funcionario"]=="S"){	
		$var="funcionario";
	}else{
		$var="cliente";
	}
  $sql=mysql_query("SELECT niveis.menus,niveis.submenus FROM cliente_login,niveis WHERE cliente_login.".$var."='$wcli' AND niveis.id=cliente_login.nivel");
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
window.status = "Cyber Manager 4.0";
setTimeout("statuss()", 1);
}
</script>
<html>
<head>
<title>Qualitymanager 4.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
.style1 {font-size: 10px}
.style4 {
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="statuss()">
<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#003366">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"> 
      <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#FFFFFF">
          <td width="5%" height="25" valign="middle" background="imagens/fundo_top.gif" bgcolor="#F8F7EF" class="textoboldbranco"><img src="imagens/novo.gif" width="168" height="25"></td>
          <td align="left" valign="middle" background="imagens/fundo_top.gif" class="fundo_top"><div align="right">
            <table width="600" border="0" align="left" cellpadding="1" cellspacing="1">
              <tr>
                <td width="86"><div align="center"><a href="http://www.tickets.cybermanager.com.br" target="_blank"><img src="imagens/menu/ticket.jpg" width="86" height="21" border="0"></a></div></td>
                <td width="87"><div align="center"><a href="http://www.forum.cybermanager.com.br" target="_blank"><img src="imagens/menu/forum.jpg" width="87" height="21" border="0"></a></div></td>
                <td width="86"><div align="center"><a href="#" onClick="MM_openBrWindow('http://www.cyber1.com.br/downloads/index.html','','width=522,height=150')"><img src="imagens/menu/downloads.jpg" width="86" height="21" border="0"></a></div></td>
                <td width="89"><div align="center"><a href="#" onClick="MM_openBrWindow('www.cyber1.com.br/upgrades/index.html','','width=522,height=225')"><img src="imagens/menu/upgrades.jpg" width="89" height="21" border="0"></a></div></td>
                <td width="89"><div align="center"><a href="#" onClick="MM_openBrWindow('about.html','','width=400,height=301')"><img src="imagens/menu/about.jpg" width="89" height="21" border="0"></a></div></td>
                <td width="89"><div align="center"><a href="#" onClick="MM_openBrWindow('manual/man_index.html','','width=680,height=551')"><img src="imagens/menu/manual.jpg" width="89" height="21" border="0"></a></div></td>
                <td width="10"><iframe frameborder="0" align="left" valign="top" scrolling="auto" height="1" width="1" src="online.php"></iframe></td>
              </tr>
            </table>
            </div></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="168" height="100%" valign="top" bgcolor="#F8F7EF"><iframe name="esquerdo" frameborder="0" align="left" valign="top" scrolling="auto" height="100%" width="100%" src="esquerdo.php"></iframe></td>
          <td width="829" height="100%" align="left" valign="top"><iframe name="corpo" frameborder="0" align="left" valign="top" scrolling="auto" height="100%" width="100%" src="corpo.php"></iframe></td>
        </tr>
        <tr> 
          <td height="25" colspan="2">
		  <table width="100%"  border="0" cellpadding="2" cellspacing="0" background="imagens/fundo_top.gif">
		  <tr class="branco" background="imagens/fundo_top.gif">
			<td width="34%" ><span><? print $_SESSION["login_nome"]; ?> - <? print $_SESSION["login_cargo"]; ?></span></td>
			<td width="30%"><span><? print $_SESSION["login_nivel_nome"]; ?></span></td>
			<td width="36%"><div align="right">Online a:
			      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="101" height="18">
                      <param name="movie" value="swf/contador.swf">
                      <param name=quality value=high>
                      <param name="wmode" value="transparent">
                      <param name="SCALE" value="exactfit">
                      <embed src="swf/contador.swf" width="101" height="18" scale="exactfit" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent"></embed>
                  </object>
			      </span></div></td>
		  </tr>
		</table>

		  </td>
        </tr>
      </table>      </td>
  </tr>
</table>
</body>
</html>